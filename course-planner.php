<html>
<head>
<title> Emory Math CS Planner </title>
</head>
<body>
<br/>

<?php
$conn =
mysqli_connect("localhost","cs377","cs377_s17", "mathcsDB"); 
if ( ! mysqli_select_db ($conn, "mathcsDB") )
{
 printf("Error: %s\n", mysqli_error($conn) );
 exit(1);
}
$s1 = $_POST["sem"];
$y1 = $_POST["year"];
$s2 = $_POST["sem2"];
$y2 = $_POST["year2"];

if(($y1 > $y2) OR ($y1 === $y2 AND $s1 === "F" AND $s2 === "S")){
 $message =  "Invalid Graduation Date. Please go back re-enter your information.";
 echo "$message";
 exit();
}
if(!isset($_POST["major1"])){
 echo "error message";
 header('Location:index.php');
}

 $m1 = $_POST["major1"];
 $m2 = $_POST["major2"];

$classes = $_POST['class_list'];
 if($m2 !== ""){
  $query1 = "SELECT course.courseNum FROM degree,course WHERE degree.degID = ".$m1." AND (course.courseNum IN (SELECT hasReq.cNum FROM hasReq WHERE degree.degID = hasReq.dID)
OR course.courseNum IN (SELECT elecBucket.cNum FROM hasElec,elecBucket WHERE degree.degID = hasElec.dID AND hasElec.elecID = elecBucket.elecID)) UNION ALL SELECT course.courseNum FROM degree,course WHERE degree.degID = ".$m2." AND (course.courseNum IN (SELECT hasReq.cNum FROM hasReq WHERE degree.degID = hasReq.dID)
OR course.courseNum IN (SELECT elecBucket.cNum FROM hasElec,elecBucket WHERE degree.degID = hasElec.dID AND hasElec.elecID = elecBucket.elecID))";
 }
 else{
  $query1 = "SELECT course.courseNum FROM degree,course WHERE degree.degID = ".$m1." AND (course.courseNum IN (SELECT hasReq.cNum FROM hasReq WHERE degree.degID = hasReq.dID)
OR course.courseNum IN (SELECT elecBucket.cNum FROM hasElec,elecBucket WHERE degree.degID = hasElec.dID AND hasElec.elecID = elecBucket.elecID)) ORDER BY course.courseNum";
 }
 if ( ! ( $result1 = mysqli_query($conn, $query1)) ){
  printf("Error: %s\n", mysqli_error($conn));
  exit(1);
 }
 $classesNeeded = mysqli_num_rows($result1);
$semCount = 2*($y2-$y1)+1;
if($s1==="F"){
 if($s2==="S"){
  $semCount = $semCount-2;
 }
 else{
  $semCount = $semCount-1;
 }
}
else{
 if($s2==="S"){
  $semCount = $semCount-1;
 }
}
$classesPossible = $semCount*4;
if($classesPossible < $classesNeeded){
 echo "Unfortunately you need $classesNeeded more classes, but can only feasibly take $classesPossible more classes (at a rate of 4 math & CS classes per semester).<br/>";
 exit();
}
else{
 echo "Congratulations! You need $classesNeeded more classes, but have the capacity to take $classesPossible more classes (at a rate of 4 math & CS classes per semester).<br/>";
}

$query2 = "SELECT course.courseNum FROM course WHERE course.courseNUM IN (SELECT course.courseNum FROM degree,course WHERE degree.degID = '6' AND (course.courseNum IN (SELECT hasReq.cNum FROM hasReq WHERE degree.degID = hasReq.dID) OR course.courseNum IN (SELECT elecBucket.cNum FROM hasElec,elecBucket WHERE degree.degID = hasElec.dID AND hasElec.elecID = elecBucket.elecID)) ORDER BY course.courseNum) AND course.courseNum NOT IN (SELECT hasPrereq.num FROM hasPrereq)";
 if ( ! ( $result2 = mysqli_query($conn, $query2)) ){
  printf("Error: %s\n", mysqli_error($conn));
  exit(1);
 }

$i=0;
while ( $row2 = mysqli_fetch_assoc( $result2 ) ){
 foreach ($row2 as $key2 => $value2) {
 $array2[$i] = $value2;
 $i++;
 }
}

$i=0;
while ( $row1 = mysqli_fetch_assoc( $result1 ) ){
 foreach ($row1 as $key1 => $value1) {
 $array1[$i] = $value1;
 $i++;
 }
}

echo "<br/> Here are your course suggestions: <br/>";
$i = 0;
$size = sizeof($array1);
$j = 0;

while(strpos($array1[$j],"MATH") === FALSE){
 $j++;
}

while($classesNeeded > 0){
 if($s1 === "F"){
  $s1 = "S";
  $y1 = $y1 + 1;
 }
 else{
  $s1 = "F";
  
 }
 if($s1 === "S"){echo "Spring $y1<br/>";}
 else{echo "Fall $y1<br/>";}
 if($i >= $size-1){$i = $j+1;}
 else if($j >= $size-1){$j = $i+1;}
 echo "      *".$array1[$i++]."<br/>";
if($i >= $size-1){$i = $j+1;}
 else if($j >= $size-1){$j = $i+1;}
 echo "      *".$array1[$i++]."<br/>";
if($i >= $size-1){$i = $j+1;}
 else if($j >= $size-1){$j = $i+1;}
 echo "      *".$array1[$j++]."<br/>";
if($i >= $size-1){$i = $j+1;}
 else if($j >= $size-1){$j = $i+1;}
 echo "      *".$array1[$j++]."<br/>";
 $classesNeeded = $classesNeeded - 4;
 echo "<br/>";
}

?>
