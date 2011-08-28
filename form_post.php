<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<title>Push Hiatus</title>
		<link rel="shortcut icon" href="images/favicon.ico" >
		<link href="css/pushhiatus_layout.css" rel="stylesheet" type="text/css" />

	</head>
	<body>
		
<div id="fb-root"></div>
<div id="hello"></div>
<script src="https://connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
</script>

		<?php
			$userid = $_POST['userid'];
			$reason = $_POST['reason'];
			$day = $_POST['day'];
			$month = $_POST['month'];
			$month = $_POST['year'];
			$message = $_POST['message'];
			
			echo "UserID:". $userid ."<br />";
			echo "Reason:". $reason ."<br />";
			echo "Date:". $day . $month . $year . "<br />";
			echo "Message:". $message ."<br />";
			echo "Thank you for using PushHiatus!";
			
			$connect = mysql_connect("brinaleecom.ipagemysql.com", "brinakoko", "kingkoko");
			if (!$connect)
 			{
  				die('Could not connect: ' . mysql_error());
  			}

			mysql_select_db("push_hiatus1", $connect);

			$sql="INSERT INTO Data (userid, reason, month, day, year, message, enable)
			VALUES
			('$_POST[userid]', '$_POST[reason]','$_POST[month]','$_POST[day]','$_POST[year]','$_POST[message]', '1')";

			if (!mysql_query($sql,$connect))
 			{
  				die('Error: ' . mysql_error());
  			}
			
			echo "\nThank you for using PushHiatus for all your auto-reply needs.";

			mysql_close($connect);
		
		?>
	</body>
</html>