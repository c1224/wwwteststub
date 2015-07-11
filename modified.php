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

/** MODIFY a row in MySQL db based on data from modify.php **/
$id = $_GET[id];

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$group = $_POST['group'];
$faculty = $_POST['faculty'];

$regexp = '/\'/';
$firstname = (preg_replace($regexp,'\\\'',$firstname));
$lastname = (preg_replace($regexp,'\\\'',$lastname));
$age = (preg_replace($regexp,'\\\'',$age));
$group = (preg_replace($regexp,'\\\'',$group));
$faculty = (preg_replace($regexp,'\\\'',$faculty));


$dbh = mysqli_connect('192.168.0.102', 'test', 'test123', 'd_stu')
    or die ("Error: Can't connect to MySQL-server.");
$query = "UPDATE Students SET first_name='$firstname',last_name='$lastname',".
         "gender='$gender',age='$age',group_='$group',faculty='$faculty' ".
         "WHERE ID=$id;";
$result = mysqli_query($dbh, $query)
    or die ("Error: Can't execute the query.");
mysqli_close($dbh);

echo "Thank you.<br/>";
echo "Student <b>$firstname</b> <b>$lastname</b> has been modified.<br/>";

header("Location: index.php");

?>	

<form action="index.php">
    <input type="submit" value="Show the list">
</form>
	
	
</body>
</html>
