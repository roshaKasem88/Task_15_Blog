<?php

require 'dbClass.php';
require 'validatorOOP.php';

$id= $_GET['id'];

$db = new Database;

# Fetch Old Data
$sql = "select * from articales where id=$id";
$result =$db -> DoQuery($sql);

$oldData=mysqli_fetch_assoc($result);


if($_SERVER["REQUEST_METHOD"] == "POST"){


    $validate = new validator;

    $title    = $validate->clean($_POST['title']);
    $content  = $validate->clean($_POST['content']);


     $error=[];

     # Validate Tiltle

     if(!$validate->validate($title,'empty')){
         $error['title'] = "* Title Required";

     }elseif($validate->validate($title,'int')){
        $error['title'] = "* Title Must be String";
     }

     # Validate Content
     if(!$validate->Validate($content,'empty')){
        $error['content'] = "* Content Required";

    }
    elseif(! $validate->validate($content,'size')){
        $error['content'] = "* Content Must be >= 50 ch";

    }

     # Validate Image

        if(!$validate -> validate($_FILES['image']['name'],'empty')){
        $ImageTmp   =  $_FILES['image']['tmp_name'];
        $ImageName  =  $_FILES['image']['name'];
        $ImageSize  =  $_FILES['image']['size'];
        $ImageType  =  $_FILES['image']['type']; 
    
        $TypeArray = explode('/',$ImageType);

            if(! $validate-> validate($ImageName,'empty')){
                $error['image'] = "* Image Required";

            }elseif(! $validate-> validate($TypeArray[1],'extension')){
                $error['image'] = "* Invalid Image Extension";
            }

        }
     
     

              
        

     if(count($error)>0){
         foreach($error as $key => $value){
             echo $key.'-->'.$value.'<br>';
         }
     }else{

        if(! $validate -> validate($_FILES['image']['name'],'empty')){

                $ImageName=rand(1,20).time().'.'.$TypeArray[1];
                $des='./uploads/'.$imageName;
                if(move_uploaded_file($ImageTmp,$des)){
                    unlink('./uploads/'.$_POST['oldImage']);
                    }
                    else{ 
                        $ImageName = $_POST['oldImage'];

                    }

                    $sql2="insert into articales set title =$title , content = $content , image = $ImageName where id=$id";
                    $op2=$db->DoQuery($sql2);
                        
                        
                        if($op2){
                            echo "Data Inserted";
                            header("Location: index.php");
                        }
                        else{
                            echo "Error Inserting Data";

                        }
        }   
        
     }


}


require './layouts/header.php'
?>

<body>

<div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Dashboard</h1>
                



                <div class="container">
                    <form action="edit.php?id=<?phpecho $id;?>" method="post"
                        enctype="multipart/form-data">
                        
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title" class="form-control" id="exampleInputName"
                                aria-describedby="" placeholder=""
                                value="<?php echo $oldData['title'];?>">
                        </div>


                   

                        <div class="form-group">
                            <label for="exampleInputPassword1">Content</label>
                            <textarea name="content" class="form-control" ><?php echo $oldData['content'];?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Image </label>
                            <input type="file" name="image">
                            <br>
                            <img src="./uploads/<?php echo $oldData['image'];?>" width="70 px">
                            <br>
                            <input type="hidden" value="<?php $oldData['image'];?>" name="oldImage" >
                        </div>


                        <button type="submit" class="btn btn-primary">Save</button>
                    
                    </form>
                </div>

            
                              





            </div>
        </main>
    </div>



</body>
</html>