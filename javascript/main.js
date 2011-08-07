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