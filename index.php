<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<title>Push Hiatus</title>
		<link rel="shortcut icon" href="images/favicon.ico" >
		<link href="css/pushhiatus_layout.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="javascript/main.js"></script>
		<script src="https://connect.facebook.net/en_US/all.js" type="text/javascript"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript">
		


		
			function alreadyCustomer(userId) {
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
						var reply = xmlhttp.responseText;
			
						alert(xmlhttp.responseText);
						if(reply == 1)
						{
							var showDate = document.createElement('p');
							showDate.innerHTML = "You already have PushHiatus running."
							document.body.appendChild(showDate);
						}
						else
						{
							// Display form for a new customer
							displayForm(userId);
						}
					}
				}
			    xmlhttp.open("GET","alreadyCustomer.php?userId="+userId,true);
			    xmlhttp.send();
			}
		
		    $(document).ready(function () {
		
				FB.init({ 
					appId: '229062487116940', 
					cookie: true, 
					xfbml: true, 
					status: true });
					
			
				FB.getLoginStatus(function (response) {
					if (response.session)
					{
						var uid = response.session.uid;
						alert(uid);
						alreadyCustomer(uid);
					}
					else
					{
						document.getElementById('hello').innerHTML = "<a href=\"https://www.facebook.com/dialog/oauth?client_id=229062487116940&redirect_uri=http://www.appybyte.com/pushhiatus&scope=read_mailbox,read_stream,publish_stream,offline_access&response_type=token&response_type=token\" target=\"_top\">Login with Facebook</a>";
					}
				});
		
		    });
			
function displayForm(userId)
{
	// H1
	var phTitle = document.createElement('h1');
	phTitle.innerHTML = "PushHiatus";
	document.body.appendChild(phTitle);
	
	// Form
	var mainForm = document.createElement('form');
	mainForm.setAttribute( "name", "mainForm");
	mainForm.setAttribute( "action", "form_post.php");
	mainForm.setAttribute( "method", "post");
	mainForm.setAttribute( "onsubmit", "return;");
	document.body.appendChild(mainForm);
	
	
	//User id
	var idSelect = document.createElement('select');
	idSelect.style.display="none";
	idSelect.setAttribute("id","userid");
	idSelect.setAttribute("name","userid");
	var option6 = document.createElement('option');

	option6.innerHTML = userId;
	idSelect.appendChild(option6);
	mainForm.appendChild(idSelect);
	
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
	
	var wrapperDate = document.createElement('div');
	wrapperDate.setAttribute("class","wrapperDate");
	
	var monthInput = document.createElement('input');
	monthInput.setAttribute("id","month");
	monthInput.setAttribute("class","text date");
	monthInput.setAttribute("type","text");
	monthInput.setAttribute("name","month");
	monthInput.setAttribute("placeholder","m");
	formPair2.appendChild(monthInput);
	var br4 = document.createElement('br');
	wrapperDate.appendChild(br4);
	
	var dayInput = document.createElement('input');
	dayInput.setAttribute("id","day");
	dayInput.setAttribute("class","text date");
	dayInput.setAttribute("type","text");
	dayInput.setAttribute("name","day");
	dayInput.setAttribute("placeholder","d");
	formPair2.appendChild(dayInput);
	var br7 = document.createElement('br');
	wrapperDate.appendChild(br7);
	
	//To Fix. Not correct.
	var yearInput = document.createElement('input');
	yearInput.setAttribute("id","year");
	yearInput.setAttribute("class","text date");
	yearInput.setAttribute("type","text");
	yearInput.setAttribute("name","year");
	yearInput.setAttribute("placeholder","y");
	formPair2.appendChild(yearInput);
	var br8 = document.createElement('br');
	wrapperDate.appendChild(br8);
	
	formPair2.appendChild(wrapperDate);

	
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
}

		</script> 	


	</head>
	<body>
		
<div id="fb-root"></div>
<div id="hello"></div>
	</body>

</html>