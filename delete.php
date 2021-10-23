<?php 

require 'dbClass.php';

require 'validatorOOP.php';


$id = $_GET['id'];

$validate = new validator;
$db = new Database;

if($validate -> validate($id,'int')){

    // code ...... 
  $sql = "delete from articales where id = $id";
  $result  = $db -> DoQuery($sql);

  
  
  if($result){
      $Message = "Raw removed";
  }else{
      $Message = "Error Try Again";
  }

}else{

    $Message = "Invalid Id";

}


$_SESSION['Message'] = [$Message];

header("Location: index.php");




?>