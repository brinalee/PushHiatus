<?php

require 'app_auth.php';

$friendId=$_GET["friendId"];
//$userId=$_GET["userId"];
$userid = $facebook->getUser();

$connect = mysql_connect("brinaleecom.ipagemysql.com", "brinakoko", "kingkoko");
if (!$connect)
{
        die('Could not connect: ' . mysql_error());
}

mysql_select_db("push_hiatus1", $connect);

$sql="INSERT INTO AlreadyReplied (friendid, userid)
VALUES
('$friendId', '$user')";

$result = mysql_query($sql);

mysql_close($connect);
?>