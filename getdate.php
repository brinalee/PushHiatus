<html>
	<body>
		<?php
			
			$connect = mysql_connect("brinaleecom.ipagemysql.com", "brinakoko", "kingkoko");
			if (!$connect)
 			{
  				die('Could not connect: ' . mysql_error());
  			}

			mysql_select_db("push_hiatus1", $connect);
                        
                        $sql = "SELECT month,day from Data where userId =".$userId;
			/*
                        $sql="INSERT INTO Data (userid, reason, date, message, enable)
			VALUES
			('$userid', '$_POST[reason]','$_POST[date]','$_POST[message]', '1')";
			*/
			
			if (!mysql_query($sql,$connect))
 			{
  				die('Error: ' . mysql_error());
  			}
			
			
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				echo "Month :{$row['month']} <br>".
				"Day : {$row['day']} <br>"; 
			}	 
			mysql_close($connect);
			
			$result = $facebook->api('/me/feed');
			
			
		?>
	</body>
</html>