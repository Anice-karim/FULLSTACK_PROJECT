<?php
include('../security.php'); 

if (isset($_POST['send_invite_btn'])) {
    $Hp = $_POST['hp_inpe'];
    $etab = $_POST['etab_id'];
    $message = $_POST['message'] ?? null;
   
    
    $query_get_id = "SELECT id_Hp FROM health_professionals WHERE inpe = $Hp"; 
    $result = mysqli_query($connection, $query_get_id);

    if ($result) {
        $Hp1 = mysqli_fetch_assoc($result);
        if ($Hp1) {
            $id = $Hp1['id_Hp']; // the internal user ID
            $status = "pending";
            $sent = "INSERT INTO invitations (id_etab, id_Hp, message, status, created_at) 
                   VALUES ('$etab', '$id', '$message', '$status', NOW())";
            $run=mysqli_query($connection, $sent);
             if ($run) {
                $_SESSION['success'] = "Invitation sent successfully!";
                header('Location:invitation.php');
            } else {
                $_SESSION['status'] = "Failed to send invitation.";
                header('Location:invitation.php');
            }
        }else {
            $_SESSION['status'] = "Health Professionals not found with this INPE.";
            header('Location:invitation.php');

    }
}else {
    $_SESSION['status'] = "Error while fetching user data.";
    $_SESSION['status_code'] = "error";
}
}
if(isset($_POST['delete_invi_btn'])){
    $id =$_POST['delete_invi_id'];
    $query="DELETE  FROM invitations WHERE id='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your invitation is Unsended";
        header('Location:invitation.php');
    }else{
        $_SESSION['status']="Your invitation is NOT Unsended";
        header('Location:invitation.php');
    }

 }























?>