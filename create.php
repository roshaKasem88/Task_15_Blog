<?php

require 'dbClass.php';
require 'validatorOOP.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $validate = new validator;

    $title    = $validate->clean($_POST['title']);
    $content  = $validate->clean($_POST['content']);


     # Image Details ..... 
     $ImageTmp   =  $_FILES['image']['tmp_name'];
     $ImageName  =  $_FILES['image']['name'];
     $ImageSize  =  $_FILES['image']['size'];
     $ImageType  =  $_FILES['image']['type']; 
 
     $TypeArray = explode('/',$ImageType);


     $error=[];

    
     # Validate Tiltle

     if(!$validate->Validate($title,'empty')){
        $error['title'] = "* Title Required";

    }elseif($validate->Validate($title,'int')){
       $error['title'] = "* Title Must be String";
    }

     # Validate Content
     if(!$validate->validate($content,'empty')){
        $error['content'] = "* Content Required";
        
    }elseif(! $validate->validate($content,'size')){
        $error['content'] = "* Content Must be > 50 ch";
        

    }

     # Validate Image

     if(! $validate-> validate($ImageName,'empty')){
        $error['image'] = "* Image Required";
         
     }elseif(! $validate-> validate($TypeArray[1],'extension')){
        $error['image'] = "* Invalid Image Extension";
        
     }


     if(count($error)>0){
         foreach($error as $key => $value){
             echo $key.'-->'.$value.'<br>';
         }
     }else{
         $imageName=rand(1,20).time().'.'.$TypeArray[1];
         $des='./uploads/'.$imageName;
         if(move_uploaded_file($ImageTmp,$des)){

                $db = new Database;
                $sql="insert into articales (title,content,image) values ('$title','$content','$imageName')";
                $result=$db->DoQuery($sql);
                   
                    if($result){
                        echo "Data Inserted";
                        header("Location: index.php");
                    }
                    else{
                        echo "Error Inserting Data";

                    }
            }
            else{ 
            echo "Error Uploading Image";

            }
        
     }


}


require './layouts/header.php'
?>

<body>

<div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Blog Task_15</h1>
                



                <div class="container">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post"
                        enctype="multipart/form-data">



                        <div class="form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title" class="form-control" id="exampleInputName"
                                aria-describedby="" placeholder="Enter Title">
                        </div>


                   

                        <div class="form-group">
                            <label for="exampleInputPassword1">Content</label>
                            <textarea name="content" class="form-control" ></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Image </label>
                            <input type="file" name="image">
                        </div>


                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>







            </div>
        </main>
    </div>



</body>
</html>