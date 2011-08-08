<html>
<div id="fb-root"></div>
<div id="hello"></div>
<script src="https://connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
	FB.init({
		appId  : '229062487116940',
		status : true, // check login status
		cookie : true, // enable cookies to allow the server to access the session
		xfbml  : true, // parse XFBML
		channelURL : 'http://www.appybyte.com/pushhiatus', // channel.html file
		oauth  : true // enable OAuth 2.0
	});

	FB.api('/me', function(response) {
		alert(response);
		var userID = response.id;
		alert("i'm here");
		alert(response.id);
		document.getElementById('hello').innerHTML = "<?php $userid ="+ userID +"?>";
	}
    });
</script>
	<body>
		<?php
			$reason = $_POST['reason'];
			$day = $_POST['day'];
			$month = $_POST['month'];
			$message = $_POST['message'];
			
			echo "UserID:". $userid ."<br />";
			echo "Reason:". $reason ."<br />";
			echo "Date:". $date ."<br />";
			echo "Message:". $message ."<br />";
			echo "Thank you for using PushHiatus!";
			
			$connect = mysql_connect("brinaleecom.ipagemysql.com", "brinakoko", "kingkoko");
			if (!$connect)
 			{
  				die('Could not connect: ' . mysql_error());
  			}

			mysql_select_db("push_hiatus1", $connect);

			$sql="INSERT INTO Data (userid, reason, month, day, message, enable)
			VALUES
			('$userid', '$_POST[reason]','$_POST[month]','$_POST[day]','$_POST[message]', '1')";

			if (!mysql_query($sql,$connect))
 			{
  				die('Error: ' . mysql_error());
  			}
			echo "1 record added";

			mysql_close($connect);
			
			
		?>
	</body>
</html>