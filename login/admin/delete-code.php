<?php
include('../security.php'); 

//Delete A Admin Profile
 if(isset($_POST['delete_btn'])){
    $id =$_POST['delete_id'];
    $query="DELETE  FROM register WHERE id='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Data is Deleted";
        header('Location:register.php');
    }else{
        $_SESSION['status']="Data is NOT Deleted";
        header('Location:register.php');
    }

 }
//Delete A health profissionnals

 if(isset($_POST['delete_btn_hp'])){
    $id =$_POST['delete_hp'];
      
    $query= "DELETE FROM health_professionals WHERE id = '$id'";
     $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Health Professionals is Deleted";
        header('Location:register_Hp.php');
    }else{
        $_SESSION['status']="Health Professionals is NOT Deleted";
        header('Location:register_Hp.php');
    }

 }
 //Delete Health Facilitie Profile
 if(isset($_POST['delete_btn_etab'])){
    $id =$_POST['delete_etab'];
    $query="DELETE  FROM etablissement WHERE id='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Deleted";
        header('Location:register_etab.php');
    }else{
        $_SESSION['status']="Your Data is NOT Deleted";
        header('Location:register_etab.php');
    }

 }
  //Delete Insurrance Company
 if(isset($_POST['delete_btn_assu'])){
    $id =$_POST['delete_assu'];
    $query="DELETE  FROM assurance WHERE id='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Deleted";
        header('Location:register_assu.php');
    }else{
        $_SESSION['status']="Your Data is NOT Deleted";
        header('Location:register_assu.php');
    }

 }
?>