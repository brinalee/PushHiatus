<!DOCTYPE html>
    <?php
	require 'app_auth.php';
    ?>
    
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
        
	function runEachUser(userId,endM,endD,message) {
		var currentUser = "/"+userId+"/inbox";
		FB.api(currentUser , function(response) {
                    var endMonth = endM;
                    var endDay = endD;
                    var myId = userId;
                    var stopLoop = true;
                    var i=0;
                    
                    var listOfIds = new Array();
                    var listId = 0;
                    while(stopLoop) {
                            //if month is equal to or not.
                            //TODO: figure out the condition. start, end, current
                            //if end date passed already, turn off enable bit
                            alert(getDay(response.data[i].updated_time) == endDay && getMonth(response.data[i].updated_time) == endMonth);
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
					    alert("here"+listOfIds[listId]);
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
                            var body = message;
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
	}
	
    </script>
  
  
  
  
    
<?php

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
        $endMonth =  $row['month'];
        $endDay =  $row['day'];
        $endYear = $row['year'];
        $message = $row['message'];
	
	/*
        echo "UserId: ".$userId;
	echo "<br>";
	echo "End Month: ".$endMonth;
	echo "<br>";
	echo "End Day: ".$endDay;
	echo "<br>";
	echo $endYear;
	*/
	
        // Check the enable flag
        if( $currentDate['year'] == $endYear )
        {
            if( $currentDate['mon'] == $endMonth )
	    {
                if( $currentDate['mday'] <= $endDay )
                {
		    echo $userId;
		    //TODO: need to put back -1
		    $currentDay = $currentDate['mday'];
		    $currentMonth = $currentDate['mon'];
		    echo "<script language=javascript>runEachUser(\"$userId\",\"$currentMonth\",\"$currentDay\",\"$message\");</script>";
		}
                else
                {
                    $sql="UPDATE Data SET enable='0' WHERE user=". $userId;
                    mysql_query($sql);
                }
            }
	    else if ($currentDate['month'] < $endMonth )
	    {
		echo "<script type=text/javascript>runEachUser(". $userId . ")</script>";
	    }
            else
            {
                $sql="UPDATE Data SET enable='0' WHERE user=". $userId;
                mysql_query($sql);
            }
        }
	else if ( $currentDate['year'] < $endYear )
	{
	    //check updated-times
	}
        else
        {
            $sql="UPDATE Data SET enable='0' WHERE user=". $userId;
            mysql_query($sql);
        }
        
        // If enable flag is okay, check userid's messages
        
    }
			
    mysql_close($connect);

    
?>

</html>