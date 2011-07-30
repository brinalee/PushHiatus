<?php
	require 'app_auth.php';
	require 'getdate.php';

?>

<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<title>Push Hiatus</title>
		<link rel="shortcut icon" href="images/favicon.ico" >
		<link href="css/pushhiatus_layout.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
		<!--

function validateForm()
{
	var reason = document.forms["mainForm"]["reason"].value;
	var date = document.forms["mainForm"]["date"].value;
	var message = document.forms["mainForm"]["message"].value;
	var flag = true;
	
	if ( reason == null || reason == "Please select a reason..." )
	{
		document.getElementById("reason").style.borderColor="red";
		document.getElementById("errorReason").style.display = "block";
		flag = false;
	}
	else
	{
		document.getElementById("reason").style.borderColor= "#000";
		document.getElementById("errorReason").style.display = "none";
	}
	
	if ( date == null || date == "" )
  	{
  		document.getElementById("date").style.borderColor="red";
  		document.getElementById("errorDate").style.display = "block";
  		flag = false;
  	}
  	else
  	{		
  		document.getElementById("date").style.borderColor= "#000";
		document.getElementById("errorDate").style.display = "none";
  	}
  	
  	if ( message == null || message == "" )
  	{
  		document.getElementById("message").style.borderColor="red";
  		document.getElementById("errorMessage").style.display = "block";
		flag = false;
  	}
  	else
  	{		
  		document.getElementById("message").style.borderColor= "#000";
		document.getElementById("errorMessage").style.display = "none";
  	}


	if(flag)
	{
  		return true;
  	}
  	else
  	{
  		return false;
  	}
  	return true;
}

		//-->
		</script>
	</head>
	<body>
		
<div id="fb-root"></div>
<div id="hello"></div>
<script src="https://connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	var printtext= "<p>permissions granted</p>";
	var printtext2= "<p>no permissions</p>";
    $(document).ready(function () {

        FB.init({ 
            appId: '229062487116940', 
            cookie: true, 
            xfbml: true, 
            status: true });
            
				
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
					return arrDateCode[2];	
				}

        FB.getLoginStatus(function (response) {
            if (response.session) {
            	document.getElementById('hello').innerHTML = printtext;
                //$('#AccessToken').val(response.session.access_token);
                var access_token = response.session.access_token;
                
                
        		FB.api('/me/inbox' , function(response) {
  				 var day = getDay(response.data[0].updated_time);
  				 alert(day);
  				 //alert(response.data[0].from.name);
				});
				
				/*
				FB.api(
					{
						method: 'fql.query',
						//query: 'SELECT timestamp FROM unified_thread WHERE unread=1'
						query: 'SELECT created_time FROM message'
						//query: 'SELECT unread_count FROM unified_thread_count WHERE folder="inbox"'
					},
					function (response) {
						
						alert(response.created_time);
					}
					);
				*/
				// H1
				var phTitle = document.createElement('h1');
				phTitle.innerHTML = "PushHiatus";
				document.body.appendChild(phTitle);
				
				// Form
				var mainForm = document.createElement('form');
				mainForm.setAttribute( "name", "mainForm");
				mainForm.setAttribute( "action", "form_post.php");
				mainForm.setAttribute( "method", "post");
				mainForm.setAttribute( "onsubmit", "return validateForm();");
				document.body.appendChild(mainForm);
				
				// First bucket
				var bucket = document.createElement('div');
				bucket.setAttribute("class","bucket");
				mainForm.appendChild(bucket);
				var formPair = document.createElement('div');
				formPair.setAttribute("class","formPair");
				bucket.appendChild(formPair);
				var reasonLabel = document.createElement('label');
				reasonLabel.setAttribute("for","WhyTheHiatus");
				reasonLabel.innerHTML = "Why are you taking a break?";
				formPair.appendChild(reasonLabel);
				var br = document.createElement('br');
				formPair.appendChild(br);
				var spanReq = document.createElement('span');
				spanReq.setAttribute("class","required");
				spanReq.innerHTML = " *";
				reasonLabel.appendChild(spanReq);
				
				
				//Select bar
				var reasonSelect = document.createElement('select');
				reasonSelect.setAttribute("id","reason");
				reasonSelect.setAttribute("name","reason");
				formPair.appendChild(reasonSelect);
				var br2 = document.createElement('br');
				formPair.appendChild(br2);
				var option1 = document.createElement('option');
				option1.innerHTML = "Please select a reason..";
				reasonSelect.appendChild(option1);
				var option2 = document.createElement('option');
				option2.innerHTML = "Vacation";
				reasonSelect.appendChild(option2);
				var option3 = document.createElement('option');
				option3.innerHTML = "Google+";
				reasonSelect.appendChild(option3);
				var option4 = document.createElement('option');
				option4.innerHTML = "FB Break";
				reasonSelect.appendChild(option4);
				var option5 = document.createElement('option');
				option5.innerHTML = "Other";
				reasonSelect.appendChild(option5);
				
				// Reason Error
				var reasonErrorDiv = document.createElement('div');
				reasonErrorDiv.setAttribute("id","errorReason");
				reasonErrorDiv.setAttribute("class","error");
				formPair.appendChild(reasonErrorDiv);
				var reasonErrorTxt = document.createElement('p');
				reasonErrorTxt.innerHTML = "A reason is required.";
				reasonErrorDiv.appendChild(reasonErrorTxt);
				
				
				// Second Bucket
				var bucket2 = document.createElement('div');
				bucket2.setAttribute("class","bucket clear");
				mainForm.appendChild(bucket2);
				var formPair2 = document.createElement('div');
				formPair2.setAttribute("class","formPair");
				bucket2.appendChild(formPair2);
				var dateLabel = document.createElement('label');
				dateLabel.setAttribute("for","WhenComingBack");
				dateLabel.innerHTML = "When are you coming back?";
				formPair2.appendChild(dateLabel);
				var br3 = document.createElement('br');
				formPair2.appendChild(br3);

				var spanReq2 = document.createElement('span');
				spanReq2.setAttribute("class","required");
				spanReq2.innerHTML = " *";
				dateLabel.appendChild(spanReq2);
				//</br> after label
				
				var monthInput = document.createElement('input');
				monthInput.setAttribute("id","month");
				monthInput.setAttribute("class","text");
				monthInput.setAttribute("type","text");
				monthInput.setAttribute("name","month");
				formPair2.appendChild(monthInput);
				var br4 = document.createElement('br');
				formPair2.appendChild(br4);
				
				var dayInput = document.createElement('input');
				dayInput.setAttribute("id","day");
				dayInput.setAttribute("class","text");
				dayInput.setAttribute("type","text");
				dayInput.setAttribute("name","day");
				formPair2.appendChild(dayInput);
				var br7 = document.createElement('br');
				formPair2.appendChild(br7);

				
				var dateErrorDiv = document.createElement('div');
				dateErrorDiv.setAttribute("id","errorDate");
				dateErrorDiv.setAttribute("class","error");
				bucket2.appendChild(dateErrorDiv);
				var dateErrorTxt = document.createElement('p');
				dateErrorTxt.innerHTML = "A date is required to stop messaging to your friends.";
				dateErrorDiv.appendChild(dateErrorTxt);
				
				var bucket3 = document.createElement('div');
				bucket3.setAttribute("class","bucket clear");
				mainForm.appendChild(bucket3);
				
				var formPair3 = document.createElement('div');
				formPair3.setAttribute("class","formPair");
				bucket3.appendChild(formPair3);
				
				var messageLabel = document.createElement('label');
				messageLabel.setAttribute("for","Message");
				messageLabel.innerHTML = "Message";
				formPair3.appendChild(messageLabel);
				var br5 = document.createElement('br');
				formPair3.appendChild(br5);
				
				var spanReq3 = document.createElement('span');
				spanReq3.setAttribute("class","required");
				spanReq3.innerHTML = " *";
				messageLabel.appendChild(spanReq3);
				
				var messageInput = document.createElement('input');
				messageInput.setAttribute("id","message");
				messageInput.setAttribute("class","text");
				messageInput.setAttribute("type","text");
				messageInput.setAttribute("name","message");
				formPair3.appendChild(messageInput);
				var br6 = document.createElement('br');
				formPair3.appendChild(br6);
				
				
				var messageErrorDiv = document.createElement('div');
				messageErrorDiv.setAttribute("id","errorMessage");
				messageErrorDiv.setAttribute("class","error");
				bucket3.appendChild(messageErrorDiv);
				
				var messageErrorTxt = document.createElement('p');
				messageErrorTxt.innerHTML = "A message is required to auto-reply to your friends.";
				messageErrorDiv.appendChild(messageErrorTxt);
				
				var clearDiv = document.createElement('div');
				clearDiv.setAttribute("class","clear");
				mainForm.appendChild(clearDiv);
				
				var submitButton = document.createElement('input');
				submitButton.setAttribute("class","button");
				submitButton.setAttribute("title","Submit");
				submitButton.setAttribute("type","submit");
				submitButton.setAttribute("name","submit");
				submitButton.setAttribute("value","Submit");
				mainForm.appendChild(submitButton);
				
				
            } else {
            	document.getElementById('hello').innerHTML = printtext2;
            	document.getElementById('hello').innerHTML = "<a href=\"https://www.facebook.com/dialog/oauth?client_id=229062487116940&redirect_uri=http://www.appybyte.com/pushhiatus&scope=read_mailbox,read_stream,publish_stream,offline_access&response_type=token&response_type=token\" target=\"_top\">Login with Facebook</a>";
            }
        });

    });
</script> 	

<?php

?>
	</body>

</html>