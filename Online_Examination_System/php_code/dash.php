<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>DASHBOARD </title>
<link  rel="stylesheet" href="../css/bootstrap.min.css"/>
 <link  rel="stylesheet" href="../css/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="../css/main.css">
 <link  rel="stylesheet" href="../css/font.css">
 <script src="../js/jquery.js" type="text/javascript"></script>

  <script src="../js/bootstrap.min.js"  type="text/javascript"></script>

<script>
$(function () {
    $(document).on( 'scroll', function(){
        console.log('scroll top : ' + $(window).scrollTop());
        if($(window).scrollTop()>=$(".logo").height())
        {
             $(".navbar").addClass("navbar-fixed-top");
        }

        if($(window).scrollTop()<$(".logo").height())
        {
             $(".navbar").removeClass("navbar-fixed-top");
        }
    });
});</script>
</head>

<body  style="background:#eee;">
<div class="header">
<div class="row">
<div class="col-lg-6">
<span class="logo">Exam</span></div>

<?php
include_once 'dbConnection.php';
  session_start();

  if($_SESSION["name"]!= 'Admin') {
  header("Location: error.html");
  exit;
}
 

$email=$_SESSION['email'];
  if(!(isset($_SESSION['email']))){
header("location:index.php");

}
else
{
$name = $_SESSION['name'];

//include_once 'dbConnection.php';
echo '<span class="pull-right top title1" ><span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Hello,</span> <a href="account.php" class="log log1">'.$name.'</a>&nbsp;|&nbsp;<a href="logout.php?q=account.php" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Signout</button></a></span>';
}?>

</div></div>
<!-- admin start-->

<!--navigation menu-->
<nav class="navbar navbar-default title1">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dash.php?q=0"><b>Dashboard</b></a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if(@$_GET['q']==0) echo'class="active"'; ?>><a href="dash.php?q=0">Home<span class="sr-only">(current)</span></a></li>
        <li <?php if(@$_GET['q']==1) echo'class="active"'; ?>><a href="dash.php?q=1">User</a></li>
		<li <?php if(@$_GET['q']==2) echo'class="active"'; ?>><a href="dash.php?q=2">Quiz Result</a></li>
		
        <li class="dropdown <?php if(@$_GET['q']==4 || @$_GET['q']==5) echo'active"'; ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quiz<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="dash.php?q=4">Add Quiz</a></li>
            <li><a href="dash.php?q=5">Remove Quiz</a></li>
          </ul>
        </li>
      </ul>
          </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!--navigation menu closed-->
<div class="container"><!--container start-->
<div class="row">
<div class="col-md-12">
<!--home start-->

<?php if(@$_GET['q']==0) {

$result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');
echo  '<div class="panel"><table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td><td></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	$title = $row['title'];
	$total = $row['total'];
	$sahi = $row['sahi'];
    $time = $row['time'];
	$eid = $row['eid'];
$q12=mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND email='$email'" )or die('Error98');
$rowcount=mysqli_num_rows($q12);	
if($rowcount == 0){
	echo '<tr><td>'.$c++.'</td><td>'.$title.'</td><td>'.$total.'</td><td>'.$sahi*$total.'</td><td>'.$time.'&nbsp;min</td>
	</tr>';
}
else
{
echo '<tr style="color:#99cc32"><td>'.$c++.'</td><td>'.$title.'&nbsp;<span title="This quiz is already solve by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td><td>'.$total.'</td><td>'.$sahi*$total.'</td><td>'.$time.'&nbsp;min</td>
	<td><b><a href="update.php?q=quizre&step=25&eid='.$eid.'&n=1&t='.$total.'" class="pull-right btn sub1" style="margin:0px;background:red"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Restart</b></span></a></b></td></tr>';
}
}
$c=0;
echo '</table></div>';

}

//ranking start
if(@$_GET['q']== 2) 
{
 

$c = 1;

$query = mysqli_query($con, "SELECT * FROM history ORDER BY score DESC ") or die('Error004');
  echo  "<div class='panel title'>
<table class='table table-striped title1' >";
  echo '<tr style="color:#99cc32"><td><b>Sl. No</b></td><td><b>Name</b></td><td><b>College_Name</b></td><td><b>Email</b></td><td><b>Title</b></td><td><b>Score</b></td><td><b>Max Marks</b></td></tr>';
while($row=mysqli_fetch_array($query) )
{
$email=$row['email'];
$score=$row['score'];
$sahi=$row['sahi'];
$wrong = $row['wrong'];
$eid = $row['eid'];
$total = $sahi+$wrong;

$q12=mysqli_query($con,"SELECT * FROM user WHERE email='$email' " )or die('Error231');
while($row=mysqli_fetch_array($q12) )
{
$name=$row['name'];

$usn=$row['college'];

$sql = mysqli_query($con,"SELECT title FROM quiz WHERE quiz.eid = '$eid' " )or die('Error004');
while($row=mysqli_fetch_array($sql) )
{
$title = $row['title'];

echo '<tr><td>'.$c.'</td><td>'.$name.'</td><td>'.$usn.'</td><td>' . $email . '</td><td>'. $title . '</td><td>' . $score . '</td><td>'  . $total . '</td>';
$c++;
}
}
}
}
echo '</table></div>';
?>


<!--home closed-->
<!--users start-->
<?php if(@$_GET['q']==1) {

$result = mysqli_query($con,"SELECT * FROM user") or die('Error');
echo  '<div class="panel"><table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Name</b></td><td><b>Gender</b></td><td><b>College_Name</b></td><td><b>Email</b></td><td><b>Mobile</b></td><td></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	$name = $row['name'];
	$mob = $row['mob'];
	$gender = $row['gender'];
    $email = $row['email'];
	$college = $row['college'];

	echo '<tr><td>'.$c++.'</td><td>'.$name.'</td><td>'.$gender.'</td><td>'.$college.'</td><td>'.$email.'</td><td>'.$mob.'</td>
	<td><a title="Delete User" href="update.php?demail='.$email.'"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></td></tr>';
}
$c=0;
echo '</table></div>';

}?>
<!--user end-->

 

<!--add quiz start-->
<?php
if(@$_GET['q']==4 && !(@$_GET['step']) ) {
echo ' 
<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Quiz Details</b></span><br /><br />
 <div class="col-md-3"></div><div class="col-md-6">   <form class="form-horizontal title1" name="form" action="update.php?q=addquiz"  method="POST">
<fieldset>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="name"></label>  
  <div class="col-md-12">
  <input id="name" name="name" placeholder="Enter Quiz title" class="form-control input-md" type="text">
    
  </div>
</div>



<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="total"></label>  
  <div class="col-md-12">
  <input id="total" name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="right"></label>  
  <div class="col-md-12">
  <input id="right" name="right" placeholder="Enter marks on right answer" class="form-control input-md" min="0" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="wrong"></label>  
  <div class="col-md-12">
  <input id="wrong" name="wrong" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" min="0" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="time"></label>  
  <div class="col-md-12">
  <input id="time" name="time" placeholder="Enter time limit for test in minute" class="form-control input-md" min="1" type="number">
    
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="desc"></label>  
  <div class="col-md-12">
  <textarea rows="5" cols="8" name="desc" class="form-control" placeholder="Write description here..."></textarea>  
  </div>
</div>


<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
  </div>
</div><br/><br/>

</fieldset>
</form></div>';



}
?>
<!--add quiz end-->

<!--add quiz step2 start-->
<?php
if(@$_GET['q']==4 && (@$_GET['step'])==2 ) {
echo ' 
<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Question Details</b></span><br /><br />
 <div class="col-md-3"></div><div class="col-md-6"><form class="form-horizontal title1" name="form" action="update.php?q=addqns&n='.@$_GET['n'].'&eid='.@$_GET['eid'].'&ch=4 "  method="POST">
<fieldset>
';
 
 for($i=1;$i<=@$_GET['n'];$i++)
 {
echo '<b>Question number&nbsp;'.$i.'&nbsp;:</><br /><!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="qns'.$i.' "></label>  
  <div class="col-md-12">
  <textarea rows="3" cols="5" name="qns'.$i.'" class="form-control" placeholder="Write question number '.$i.' here..."></textarea>  
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'1"></label>  
  <div class="col-md-12">
  <input id="'.$i.'1" name="'.$i.'1" placeholder="Enter option a" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'2"></label>  
  <div class="col-md-12">
  <input id="'.$i.'2" name="'.$i.'2" placeholder="Enter option b" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'3"></label>  
  <div class="col-md-12">
  <input id="'.$i.'3" name="'.$i.'3" placeholder="Enter option c" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'4"></label>  
  <div class="col-md-12">
  <input id="'.$i.'4" name="'.$i.'4" placeholder="Enter option d" class="form-control input-md" type="text">
    
  </div>
</div>
<br />
<b>Correct answer</b>:<br />
<select id="ans'.$i.'" name="ans'.$i.'" placeholder="Choose correct answer " class="form-control input-md" >
   <option value="a">Select answer for question '.$i.'</option>
  <option value="a">option a</option>
  <option value="b">option b</option>
  <option value="c">option c</option>
  <option value="d">option d</option> </select><br /><br />'; 
 }
    
echo '<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form></div>';



}
?><!--add quiz step 2 end-->

<!--remove quiz-->
<?php if(@$_GET['q']==5) {

$result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');
echo  '<div class="panel"><table class="table table-striped title1">
<tr><td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td><td></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	$title = $row['title'];
	$total = $row['total'];
	$sahi = $row['sahi'];
    $time = $row['time'];
	$eid = $row['eid'];
	echo '<tr><td>'.$c++.'</td><td>'.$title.'</td><td>'.$total.'</td><td>'.$sahi*$total.'</td><td>'.$time.'&nbsp;min</td>
	<td><b><a href="update.php?q=rmquiz&eid='.$eid.'" class="pull-right btn sub1" style="margin:0px;background:red"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Remove</b></span></a></b></td></tr>';
}
$c=0;
echo '</table></div>';

}
?>


</div>
</div></div>
</body>
</html>