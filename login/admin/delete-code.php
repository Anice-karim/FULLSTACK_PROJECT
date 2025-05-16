<?php
include('../security.php'); 

//Delete A Admin Profile
 if(isset($_POST['delete_btn'])){
    $id =$_POST['delete_id'];
    $query="DELETE  FROM register WHERE id='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Deleted";
        header('Location:register.php');
    }else{
        $_SESSION['status']="Your Data is NOT Deleted";
        header('Location:register.php');
    }

 }
//Delete A health profissionnals

 if(isset($_POST['delete_btn_hp'])){
    $id =$_POST['delete_hp'];
    
    $delete_invitations_query = "DELETE FROM invitations WHERE id_Hp = '$id'";
    $delete_employe_query     = "DELETE FROM employe WHERE id_Hp = '$id'";
    $delete_hp_query          = "DELETE FROM health_professionals WHERE id = '$id'";
    
    //all or nothing
    mysqli_begin_transaction($connection);


    try {
        mysqli_query($connection, $delete_invitations_query);
        mysqli_query($connection, $delete_employe_query);
        mysqli_query($connection, $delete_hp_query);
        mysqli_commit($connection);//Yes, go ahead and apply all the changes.
        
        $_SESSION['success'] = "Health professional and related records deleted successfully.";
    } catch (Exception $e) {
        // Rollback in case of error
        mysqli_rollback($connection);//cancels all previous deletions
        $_SESSION['status'] = "Error during deletion: " . $e->getMessage();
    }
    header('Location:register_Hp.php');  

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