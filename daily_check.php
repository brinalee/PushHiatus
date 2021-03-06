<!DOCTYPE html>
    
    <html xmlns:fb="http://www.facebook.com/2008/fbml">
    <script type="text/javascript" src="javascript/main.js"></script>
    <script type="text/javascript" src="javascript/runEachUser.js"></script>
    
<div id="fb-root"></div>
<script src="https://connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>


<script type="text/javascript">

        FB.init({ 
            appId: '229062487116940', 
            cookie: true, 
            xfbml: true, 
            status: true });
            


	function insertIntoAlreadyRepliedTable(friendId,userId) {
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
		xmlhttp.open("GET","insertIntoAlreadyReplied.php?friendId="+friendId+"&userId="+userId,true);
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
	
	
	function checkAlreadyReplied(id) {
		if(listOfAlreadyReplied.length != 0) {
			var i=0;
			for (i=0; i<listOfAlreadyReplied.length; i++) {
				if (listOfAlreadyReplied[i] == id) {
					return true;
				}
			}
		}
		return false;
	}
	
	function runEachUser(userId,endM,endD,message) {
		var currentUser = "/"+userId+"/inbox";
		alert(currentUser);
		FB.api(currentUser , function(response) {
			if( !response || response.error )
		        {
				alert("error");
			}
			var endMonth = endM;
			var endDay = endD;
			var myId = userId;
			var stopLoop = true;
			var i=0;
			
			var listOfIds = new Array();
			var listId = 0;
			while(stopLoop) {
				if(getDay(response.data[i].updated_time) == endDay && getMonth(response.data[i].updated_time) == endMonth) {
					if (response.data[i].to.data.length == 2) {
						var j = 0;                                        
						if(response.data[i].to.data[j].id != myId && checkAlreadyReplied(response.data[i].to.data[j].id) == false) {
						    listOfIds[listId] = response.data[i].to.data[j].id;
						    listId++;
						}
						else if(checkAlreadyReplied(response.data[i].to.data[j+1].id) == false) {
						    listOfIds[listId] = response.data[i].to.data[j+1].id;
						    listId++;
						}
					}
					else if(response.data[i].from.id == myId) {    
						if(response.data[i].comments != undefined && response.data[i].comments.data[response.data[i].comments.data.length-1].from.id != myId
						    && checkAlreadyReplied(response.data[i].comments.data[response.data[i].comments.data.length-1].from.id) == false) {
						    listOfIds[listId] = response.data[i].comments.data[response.data[i].comments.data.length-1].from.id;
						    listId++;
						}
					}
					else {
						if (checkAlreadyReplied(response.data[i].from.id) == false) {
							listOfIds[listId] = response.data[i].from.id;
							listId++;						
						}
					}
				    
				}
				else {
					listOfAlreadyReplied.length = 0;
					stopLoop = false;
				}
				i++;
			}
    			
			//filtering the duplicates if any
			var nonDupListIds = new Array();
			var cur=0;
			if (listOfIds.length > 1) {
				var sorted_arr = listOfIds.sort();
				var i=0;
				for (i=0; i< sorted_arr.length-1; i++) {
					if ((sorted_arr[i] != sorted_arr[i+1])) {
						nonDupListIds[cur] = sorted_arr[i];
						cur++;
						if(i+1 == sorted_arr.length-1) {
						    nonDupListIds[cur] = sorted_arr[i+1];
						    cur++;
						}
					}
					else if (sorted_arr[i] == sorted_arr[i+1] && i+1==sorted_arr.length-1) {
						nonDupListIds[cur] = sorted_arr[i];
						cur++;				
					}
				}
			}
			else if (listOfIds.length == 1) {
				nonDupListIds[cur] = listOfIds[cur];
			}
			
			//posting to walls and saving into db
			var i=0;
			for (i=0; i < nonDupListIds.length; i++) {
				var body = message;
				var currentFriend = "/"+nonDupListIds[i]+"/feed";
	    
				FB.api(currentFriend, 'post', {message:body}, function(response) {
					if(!response || response.error) {
						alert('Error occured');
					}
				});
				insertIntoAlreadyRepliedTable(nonDupListIds[i],userId);
			}
		});        
	}
</script>
  
    
<?php

    function dateCheck($today, $end) {
    
    $today_ts = strtotime($today);
    
    $end_ts = strtotime($end);
    
    $diff = $end_ts - $today_ts;
    
    if( $diff >= 0 )
	return true;
    else
	return false;
    }

    // Connecting to database
    $connect = mysql_connect("brinaleecom.ipagemysql.com", "brinakoko", "kingkoko");
    mysql_select_db("push_hiatus1", $connect);
    
    $sql = "SELECT userid, month , day, year, message from Data where enable = 1";
    $result = mysql_query($sql);
    
    
    $currentDate = getdate();
    
    print_r( $currentDate );
    
    $userId = "";
    $endMonth = "";
    $endDay = "";
    $endYear = "";
    $message = "";
    
    
    while($row = mysql_fetch_array($result))
    {
        $userId = $row['userid'];
		$endDate = "" . $row['year'] . "-" . $row['month'] . "-". $row['day'];
		$todayDate = "" . $currentDate['year'] . "-" . $currentDate['mon'] . "-" . $currentDate['mday'];
        $message = $row['message'];
	
        if( dateCheck( $todayDate, $endDate) )
        {
	    
			//getting a list of already replied
			$sql1 = "SELECT friendid from AlreadyReplied where userId=".$userId;
			$result1 = mysql_query($sql1);
			$listOfAlreadyReplied = array();
			echo '<script type="text/javascript">';
			echo "var listOfAlreadyReplied = new Array();";		    
			while ($row = mysql_fetch_array($result1)) {
			array_push($listOfAlreadyReplied, $row['friendid']);
			//echo $row['friendid'];
			$eachId = $row['friendid'];
			
			echo "listOfAlreadyReplied.push( $eachId );";
	    }
	    echo "</script>";
	    
	    //TODO: need to put back -1
	    $currentDay = $currentDate['mday'];
	    $currentMonth = $currentDate['mon'];
	    echo "<script language=javascript>runEachUser(\"$userId\",\"$currentMonth\",\"$currentDay\",\"$message\");</script>";
	}
	else
	{
		$sql = "DELETE FROM Data WHERE userid=". $userId;
	    mysql_query($sql);
	    $sqlARDelete = "DELETE FROM AlreadyReplied WHERE userid=". $userId;
	    mysql_query($sqlARDelete);
	}
        
    }
			
    mysql_close($connect);

    
?>

</html>