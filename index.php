<html>
<head>
<title> Emory Math CS Planner </title>
</head>
<body>
<br/>

Welcome to the Emory Mathematics & Computer Science degree planner!<br/>

<?php
$conn =
mysqli_connect("localhost","cs377","cs377_s17", "mathcsDB"); 
if ( ! mysqli_select_db ($conn, "mathcsDB") )
{
 printf("Error: %s\n", mysqli_error($conn) );
 exit(1);
}
$query = 'SELECT degree.majorminor,degree.field,degree.degID FROM degree WHERE degree.majorminor="BA" OR degree.majorminor="BS" ORDER BY degree.majorminor,degree.field';
if ( ! ( $result = mysqli_query($conn, $query)) )
{
printf("Error: %s\n", mysqli_error($conn));
exit(1);
}
echo "Please select your primary major:<br/>";
$action = "course-planner.php";
echo "<form action='".$action."' method='post'>";
echo "<select name='major1'>";

while ($row =  mysqli_fetch_array($result) )
{
   echo "<option value='" . htmlspecialchars($row[2]) . "' >".htmlspecialchars($row[0] . " in " . $row[1])."</option>";
}
echo "</select>";
$query2 = 'SELECT degree.majorminor,degree.field,degree.degID FROM degree ORDER BY degree.majorminor,degree.field';
if ( ! ( $result2 = mysqli_query($conn, $query2)) )
{
printf("Error: %s\n", mysqli_error($conn));
exit(1);
}
echo "<br/>Please select your secondary major or minor (if any):<br/>";
echo "<form action='' method='post'>";
echo "<select name='major2'>";
echo "<option value='' >".htmlspecialchars( " ")."</option>";
while ($row2 =  mysqli_fetch_array($result2) )
{
   echo "<option value='" . htmlspecialchars($row2[2]) . "' >".htmlspecialchars($row2[0] . " in " . $row2[1])."</option>";
}
echo "</select>";

$query3 = 'SELECT courseNum,title FROM course';
if ( ! ( $result3 = mysqli_query($conn, $query3)) )
{
printf("Error: %s\n", mysqli_error($conn));
exit(1);
}
echo "<br/><br/>Please select classes that you have completed/expect to complete this current semester: <br/>";
echo "<form action='' method='post'>";
while ($row3 =  mysqli_fetch_array($result3) )
{
   echo "<input type='checkbox' name='class_list[]' value='" . htmlspecialchars($row3[0]) . "'> " . htmlspecialchars($row3[0] . " - " . $row3[1]) . "<br/>";
}

echo "<br/>Please select the current semester and year: <br/>";
echo "<form action='' method='post'>";
echo "<select name='sem'>";
echo "<option value='F' >".htmlspecialchars("Fall")."</option>";
echo "<option value='S' >".htmlspecialchars("Spring")."</option>";
echo "</select>";
echo "<form action='' method='post'>";
echo "<select name='year'>";
echo "<option value='2013' >".htmlspecialchars("2013")."</option>";
echo "<option value='2014' >".htmlspecialchars("2014")."</option>";
echo "<option value='2015' >".htmlspecialchars("2015")."</option>";
echo "<option value='2016' >".htmlspecialchars("2016")."</option>";
echo "<option value='2017' >".htmlspecialchars("2017")."</option>";
echo "<option value='2018' >".htmlspecialchars("2018")."</option>";
echo "</select>";

echo "<br/>Please select the desired graduation date: <br/>";
echo "<form action='' method='post'>";
echo "<select name='sem2'>";
echo "<option value='F' >".htmlspecialchars("Fall")."</option>";
echo "<option value='S' >".htmlspecialchars("Spring")."</option>";
echo "</select>";
echo "<form action='' method='post'>";
echo "<select name='year2'>";
echo "<option value='2015' >".htmlspecialchars("2015")."</option>";
echo "<option value='2016' >".htmlspecialchars("2016")."</option>";
echo "<option value='2017' >".htmlspecialchars("2017")."</option>";
echo "<option value='2018' >".htmlspecialchars("2018")."</option>";
echo "<option value='2019' >".htmlspecialchars("2019")."</option>";
echo "<option value='2020' >".htmlspecialchars("2020")."</option>";
echo "</select>";

echo "<br/><br/><br/><input type='submit'>";
echo "<br/>";
$m1 = "-1";
$m1 = $_POST["major1"];
$m2 = $_POST["major2"];

$s1 = $_POST["sem"];
$y1 = $_POST["year"];
$s2 = $_POST["sem2"];
$y2 = $_POST["year2"];

if($y1 > $y2){
 $action = "index.php";
 echo "Invalid Graduation Date. Please re-enter your information.";
}
else if($y1 === $y2 AND $s1==="F" AND $s2==="S"){
  $action = "index.php";
  echo "Invalid Graduation Date. Please re-enter your information.";
}

?><br/><br/>
</body>
</html>


