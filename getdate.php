<html>
	<body>
		<?php
			
			$connect = mysql_connect("brinaleecom.ipagemysql.com", "brinakoko", "kingkoko");
			if (!$connect)
 			{
  				die('Could not connect: ' . mysql_error());
  			}
			
			mysql_select_db("push_hiatus1", $connect);
                        
                        $sql = "SELECT month,day,message from Data where enable = 1 and userId =".$user;
			$result = mysql_query($sql);
			
			/*
                        $sql="INSERT INTO Data (userid, reason, date, message, enable)
			VALUES
			('$userid', '$_POST[reason]','$_POST[date]','$_POST[message]', '1')";
			
			
			if (!mysql_query($sql,$connect))
 			{
  				die('Error: ' . mysql_error());
  			}
			*/
			$endDay = "";
			$endMonth = "";
			$message = "";
			while($row = mysql_fetch_array($result))
			{
				$endMonth =  $row['month'];
				$endDay =  $row['day'];
				$message = $row['message'];
			}
			
			mysql_close($connect);
			
			
			
		?>
	</body>
</html>