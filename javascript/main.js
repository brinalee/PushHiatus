function validateForm()
{
	var reason = document.forms["mainForm"]["reason"].value;
	var date = document.forms["mainForm"]["date"].value;
	var message = document.forms["mainForm"]["message"].value;
	
	if ( reason == null || reason == "" )
	{
		alert("Reason must be filled out");
		return false;
	}
	
	if ( date == null || date == "" )
  	{
  		alert("Date must be filled out");
  		return false;
  	}
  	if ( message == null || message == "" )
  	{
  		alert("Message must be filled out");
  		return false;
  	}
  	return true;
}