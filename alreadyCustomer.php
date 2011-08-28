<?php

    $userId = $_GET["userId"];
    
    $connect = mysql_connect("brinaleecom.ipagemysql.com", "brinakoko", "kingkoko");
    
    if (!$connect)
    {
            die('Could not connect: ' . mysql_error());
    }
    
    mysql_select_db("push_hiatus1", $connect);
    
    $sql="SELECT userId from Data where userId='".$userId."'";
    $result = mysql_query($sql);
    
    if( mysql_num_rows($result) > 0 )
    {
        $customerExists = 1;
    }
    else
    {
        $customerExists = 0;
    }
    
    echo $customerExists;
    
    if (!mysql_query($sql,$connect))
    {
        die('Error: ' . mysql_error());
    }
     
    mysql_close($connect);
?>