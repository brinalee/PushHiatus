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