<?php
require_once "controller.php";
$con=new controller();

if($_POST['text']!==""){
  $con->proses($_POST['text']);
}

//require_once "hasil.php";

 ?>
