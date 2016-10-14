<?php
   if(isset($_FILES['uploadFile'])){
      $errors= array();
      $file_name = $_FILES['uploadFile']['name'];
      $file_size = $_FILES['uploadFile']['size'];
      $file_tmp = $_FILES['uploadFile']['tmp_name'];
      $file_type = $_FILES['uploadFile']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['uploadFile']['name'])));
      
      if(empty($errors)==true) {
         move_uploaded_file($file_tmp,"/var/www/html/uploads/".$file_name);
         echo "Success";
         
         include 'connection.php';
         
         $title = mysqli_real_escape_string($connection, $_POST["title"]);
         $description = mysqli_real_escape_string($connection, $_POST["description"]);
         $file_name = mysqli_real_escape_string($connection, $file_name);
         $type =  pathinfo($file_name, PATHINFO_EXTENSION);
         
         $sql = "INSERT INTO uploads (title, description, date, file, views, type) VALUES ('$title', '$description', NOW(), '$file_name', '0', '$type')";
         
         $result = $connection->query($sql);
         
         $sql = "SELECT COUNT(id) FROM uploads;";

         $result = $connection->query($sql);
         $upload = $result->fetch_assoc();
         $id = $upload["COUNT(id)"];
         
         header('Location: file.php?id='.$id) ;
         
      }else{
         print_r($errors);
      }
   }
?>