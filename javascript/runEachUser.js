<script type="text/javascript">
	function insertIntoAlreadyRepliedTable(friendId) {
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				alert("success");
			}
		}
		//alert(friendId);
		xmlhttp.open("GET","insertIntoAlreadyReplied.php?friendId="+friendId,true);
		xmlhttp.send();
	}

        /* Parse time format*/
        function formatFBTime(fbDate){
                var arrDateTime = fbDate.split("T"); 
                var arrDateCode = arrDateTime[0].split("-");
                var strTimeCode = arrDateTime[1].substring(0,  arrDateTime[1].indexOf("+")); 
                var arrTimeCode = strTimeCode.split(":"); 
                var valid_date = new Date()
                valid_date.setUTCFullYear(arrDateCode[0]);
                valid_date.setUTCMonth(arrDateCode[1] - 1);
                valid_date.setUTCDate(arrDateCode[2]);
                valid_date.setUTCHours(arrTimeCode[0]);
                valid_date.setUTCMinutes(arrTimeCode[1]);
                valid_date.setUTCSeconds(arrTimeCode[2]);
                return valid_date;	
        }
        
        function getDay(fbDate){
                var arrDateTime = fbDate.split("T"); 
                var arrDateCode = arrDateTime[0].split("-");
                if (arrDateCode[2] < 10) {
                        return arrDateCode[2][1];
                }
                return arrDateCode[2];
        }
        
        function getMonth(fbDate){
                var arrDateTime = fbDate.split("T");
                var arrDateCode = arrDateTime[0].split("-");
                if (arrDateCode[1] < 10) {
                        return arrDateCode[1][1];
                }
                return arrDateCode[1]; 
        }
                                
        function runEachUser(userId) {
		var currentUser = "/"+userId+"/inbox";
		FB.api(currentUser , function(response) {
                    var endMonth = "<?php echo $endMonth ?>";
                    var endDay = "<?php echo $endDay ?>";
                    var myId = "<?php echo $user ?>";
                    //alert(endMonth);
                    //alert(endDay);
                    var stopLoop = true;
                    var i=0;
                    
                    var listOfIds = new Array();
                    var listId = 0;
                    
                    while(stopLoop) {
                            //if month is equal to or not.
                            //TODO: figure out the condition. start, end, current
                            //if end date passed already, turn off enable bit
                            //alert(getMonth(response.data[i].updated_time));
                            //alert(getDay(response.data[i].updated_time));
                            if(getDay(response.data[i].updated_time) == endDay && getMonth(response.data[i].updated_time) == endMonth) {
                                    //how to get the ID and make sure
                                    //make sure we check AGAINST alreadyRepliedtable!!!!!
                                    //alert(response.data[i].comments.data[response.data[i].comments.data.length-1].from.id);
                                    if (response.data[i].to.data.length == 2) {
                                            var j = 0;
                                            if(response.data[i].to.data[j].id != myId) {
                                                    listOfIds[listId] = response.data[i].to.data[j].id;
                                            }
                                            else {
                                                    listOfIds[listId] = response.data[i].to.data[j+1].id;								
                                            }
                                            listId++;
                                    }
                                    /*
                                    if(response.data[i].comments.data[response.data[i].comments.data.length-1].from.id != myId) {
                                            listOfIds[listId] = response.data[i].comments.data[response.data[i].comments.data.length-1].from.id;
                                            listId++;
                                    }*/
                            }
                            else {
                                    stopLoop = false;
                            }
                            i++;
                    }
                    
                    /*
                    var i=0;
                    
                    for (i=0; i<listOfIds.length; i++) {
                            alert(listOfIds[i]);
                    }
                    
                    alert(listOfIds.length);
                    */
    
                    alert(listOfIds.length);				
                    //filtering the duplicates if any
                    var nonDupListIds = new Array();
                    var sorted_arr = listOfIds.sort();
                    var i=0;
                    var cur=0;
                    for (i=0; i< sorted_arr.length-1; i++) {
                            if ((sorted_arr[i] != sorted_arr[i+1]) || (sorted_arr[i] == sorted_arr[i+1] && i+1==sorted_arr.length-1)) {
                                    nonDupListIds[cur] = sorted_arr[i];
                                    cur++;
                            }
                    }
                    alert(nonDupListIds.length);
                    
                    //posting to walls and saving into db
                    var i=0;
                    for (i=0; i < nonDupListIds.length; i++) {
                            var body = "<?php echo $message ?>";
                            var currentFriend = "/"+nonDupListIds[i]+"/feed";
                            //var currentId = listOfIds[i];
                            FB.api(currentFriend, 'post', {message:body}, function(response) {
                                    if(!response || response.error) {
                                            alert('Error occured');
                                    }
                            });
                            insertIntoAlreadyRepliedTable(nonDupListIds[i]);
                    }
		});        
        
</script>