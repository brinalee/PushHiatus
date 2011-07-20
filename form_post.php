<html>
	<body>
		<?php
			require 'app_auth.php';
	
			$userid = $facebook->getUser();
			$reason = $_POST['reason'];
			$date = $_POST['date'];
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

			$sql="INSERT INTO Data (userid, reason, date, message, enable)
			VALUES
			('$userid', '$_POST[reason]','$_POST[date]','$_POST[message]', '1')";

			if (!mysql_query($sql,$connect))
 			{
  				die('Error: ' . mysql_error());
  			}
			echo "1 record added";

			mysql_close($connect);
			
			$result = $facebook->api('/me/feed');
			
			
		?>
	</body>
</html>