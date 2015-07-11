<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>STU</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
	
<?php

/** DELETE a row from MySQL-sever based on "$id" from index page **/
$id = $_GET[id];

$dbh = mysqli_connect('192.168.0.102', 'test', 'test123', 'd_stu')
    or die ("Error: Can't connect to MySQL-server.");
$query = "DELETE FROM Students WHERE ID=$id LIMIT 1;";
mysqli_query($dbh, $query)
    or die ("Error: Can't execute the query.");
echo "<strong>DELETED</strong><br/>";

header("Location: index.php");

?>
	
<br/>	

<form action="index.php">
    <input type="submit" value="Show the list">
</form>

	
	
	
	
	
	
</body>
</html>
