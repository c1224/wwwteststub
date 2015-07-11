<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>STU</title>
    <link rel="stylesheet" href="style.css">
    
    <style>
        
        body {
            background-image: url("images/dcl.jpeg");
			background-repeat: no-repeat;
			background-attachment: fixed;
		    background-size: cover;
		}
    
    </style>
    
    
</head>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
    $('.table0 tr .delete-cell').click(function(){
        window.location = $(this).data('href');
        return false;
    });
});
</script>

<body>

<div class="header">

hello

<form action="index.php">
    <input type="submit" value="reload">
</form>

</div>

<div class="output">	
<?php
/** Connection to MySQL-server and saving data in objects **/
$dbh = mysqli_connect('192.168.0.102', 'test', 'test123', 'd_stu')
    or die ("Error: Can't connect to MySQL-server.");
$query = "SELECT ID, first_name, last_name, gender, age, group_, faculty FROM Students ORDER BY id DESC;";
$result = mysqli_query($dbh, $query)
    or die ("Error: Can't execute the query.");

class Student
{
    public $id;
    public $firstname;
    public $lastname;
    public $gender;
    public $age;
    public $group;
    public $faculty;
}

$Students = array();
while ($row = mysqli_fetch_assoc($result)) {
    
    $s = new Student;
	
	foreach ($row as $pos => $value) {
	    switch ($pos) {
			case ID: $s->id = $value;
			case first_name: $s->firstname = $value;
			case last_name: $s->lastname = $value;
			case gender: $s->gender = $value;
			case age: $s->age = $value;
			case group_: $s->group = $value;
			case faculty: $s->faculty = $value;
		}	
    }
    $Students[] = $s;
}
mysqli_close($dbh);

$i = 0;
/** Printing previously set objects **/

$parameters = get_class_vars('Student');

echo '<table class="table0" align=center cellspacing="0" border="0" cellpadding="10">';
foreach ($Students as $s) {

    $i++;
	if ($i%2 == 0) {echo '<tr class="scorerow1">';}
	else {echo '<tr class="scorerow2">';}
	echo '<td><strong>'.$s->firstname.'</strong></td>';
	echo '<td><strong>'.$s->lastname.'</strong></td>';
    echo '<td class="centered-cell">'.$s->gender.'</td>';
    if ($s->age <= 0) {echo '<td></td>';}
    else echo '<td class="centered-cell">'.$s->age.'</td>';
    echo '<td class="centered-cell">'.$s->group.'</td>';
    echo '<td>'.$s->faculty.'</td>';
    
    foreach (array_keys($parameters) as $parameter) {
	    $regexp = '/\'/';
	    $s->$parameter = (preg_replace($regexp,'\\\'',$s->$parameter));
	}
	
	$line_to_onlick = "div_show_modify('$s->id','$s->firstname','$s->lastname','$s->gender','$s->age','$s->group','$s->faculty')";
    echo '<td class="mod-cell" onclick="'.$line_to_onlick.'"><u>MODIFY</u></td>';
    echo '<td class="delete-cell" data-href="deleted.php?id='.$s->id.'"><u>DELETE</u></td></tr>';
}
echo '</table>';
?>	
<br/>
</div>

<script = "JavaScript">
function div_show_add() {
document.getElementById('bg-shade').style.display = "block";
document.getElementById('add-form').style.display = "block";
}
function div_show_modify(id,f_name,l_name,gender,age,group,faculty) {
document.getElementById('bg-shade').style.display = "block";
document.getElementById('modify-form').style.display = "block";

    document.getElementById("id-m").action = "modified.php?id="+id;
    document.getElementById("firstname-m").value = f_name;
	document.getElementById("lastname-m").value = l_name;
	if (gender == "M") {
		document.getElementById("gender-m-m").checked = true;
	}
	else if (gender == "F") {
		document.getElementById("gender-m-f").checked = true;
	}
	else {
		document.getElementById("gender-m-m").checked = false;
		document.getElementById("gender-m-f").checked = false;
	}
	if (age != 0) {
		document.getElementById("age-m").value = age;
	}
	else {
		document.getElementById("age-m").value = "";
	}
	document.getElementById("group-m").value = group;
	document.getElementById("faculty-m").value = faculty;
	
}
function div_hide(divID) {
	document.getElementById('bg-shade').style.display = "none";
	document.getElementById(divID).style.display = "none";
}
</script>

<div class="addbutton" onclick="div_show_add()">
	<p>ADD</p>
</div>

<div class="confirmbutton" onclick="">
</div>

<div id="bg-shade">
</div>

<div id="add-form">



<form class="form" action="added.php" method="post">
	<h1>ADD STUDENT</h1>
    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="firstname" placeholder="First Name"><br/>
    <label for="lastname">Last Name:</label> 
    <input type="text" id="lastname" name="lastname" placeholder="Last Name"><br/>
    <label for="gender">Gender:</label>
    Male <input id="gender" name="gender" type="radio" value="M">
    Female <input id="gender" name="gender" type="radio" value="F"><br/>
    <label for="age">Age:</label>
    <input type="text" id="age" name= "age" placeholder="Age"><br/>
    <label for="group">Group:</label>
    <input type="text" id="group" name="group" placeholder="Group"><br/>
    <label for="faculty">Faculty:</label>
    <input type="text" id="faculty" name="faculty" placeholder="Faculty"><br/>
     <div class="submitbutton" onclick="this.parentNode.submit();"> <p>SUBMIT</p> </div>
</form>

<div class="cancelbutton" onclick=div_hide("add-form")>
<p>CANCEL</p>
</div>

</div>

<div id="modify-form">



<form class="form" id="id-m" method="post">
	<h1>MODIFY STUDENT</h1>
    <label for="firstname">First Name:</label>
    <input type="text" id="firstname-m" name="firstname" placeholder="First Name"><br/>
    <label for="lastname">Last Name:</label> 
    <input type="text" id="lastname-m" name=" lastname" placeholder="Last Name"><br/>
    <label for="gender">Gender:</label>
    Male <input id="gender-m-m" name="gender" type="radio" value="M">
    Female <input id="gender-m-f" name="gender" type="radio" value="F"><br/>
    <label for="age">Age:</label>
    <input type="text" id="age-m" name= " age" placeholder="Age"><br/>
    <label for="group">Group:</label>
    <input type="text" id="group-m" name=" group" placeholder="Group"><br/>
    <label for="faculty">Faculty:</label>
    <input type="text" id="faculty-m" name=" faculty" placeholder="Faculty"><br/>
    <div name="mysubmitbutton" id="mysubmitbutton" class="submitbutton" onClick="this.parentNode.submit();"> <p>SUBMIT</p> </div>
</form>

<div class="cancelbutton" onclick=div_hide("modify-form")>
<p>CANCEL</p>
</div>
</div>

<div id="added-mech">




</div>


</body>
</html>
