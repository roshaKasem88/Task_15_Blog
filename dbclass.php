<?php 

class DataBase{

  var $server     = "localhost";
  var $dbName     = "blog";
  var $user       = "root";
  var $dbPassword = "";
  var $con        = null;


    function __construct(){

        $this->con  =   mysqli_connect($this->server,$this->user,$this->dbPassword,$this->dbName);

        if(!$this->con){
              echo mysqli_connect_error();
        }
        
    }



       function DoQuery($sql){

        $result = mysqli_query($this->con,$sql);
        return $result;

       }




     function __destruct(){
         mysqli_close($this->con);
     }



}



$obj = new DataBase();

// $sql = "insert into departments (title) values ('Software E')";
//  $sql = "select * from departments";
//   $dep = $obj->DoQuery($sql);

//    while($data  = mysqli_fetch_assoc($dep)){


//      echo '* '.$data['title'].'<br>';


//    }




?>