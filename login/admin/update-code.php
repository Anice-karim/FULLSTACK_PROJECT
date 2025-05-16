<?php
include('../security.php'); 

//Update A Admin Profile
 if(isset($_POST['updatebtn'])){
    $id=$_POST['edit_id'];
    $username = $_POST['edit_username'];
    $email= $_POST['edit_email'];
    $password=md5($_POST['edit_password']);
    
    $query ="UPDATE register SET name='$username',email='$email',password='$password'WHERE id='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Updated";
        header('Location:register.php');
    }else{
        $_SESSION['status']="Your Data is NOT Updated";
        header('Location:register.php');
    }
 }
//Update A health profissionnals

 if (isset($_POST['updatebtn_hp'])) {
    $id = $_POST['edit_id'];
    $inpe = $_POST['inpe_edit'];
    $fname = $_POST['name1_edit'];
    $lname = $_POST['name2_edit'];
    $email = $_POST['edit_email'];
    $new_password = $_POST['edit_password'];
    $type = $_POST['type_edit'];
    $spec = $_POST['edit_spec'];

    // Get current password from database
    $result = mysqli_query($connection, "SELECT password FROM health_professionals WHERE id = '$id'");
    $row = mysqli_fetch_assoc($result);
    $current_password = $row['password'];

    // Only update password if it's changed
    if (md5($new_password) !== $current_password) {
        $password = md5($new_password);
    } else {
        $password = $current_password; // unchanged
    }

    $query = "UPDATE health_professionals 
              SET inpe='$inpe',
                  f_name_hp='$fname',
                  name='$lname',
                  email='$email',
                  password='$password',
                  type='$type',
                  specialty='$spec'
              WHERE id='$id'";

    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Your Data is Updated";
        header('Location: register_Hp.php');
    } else {
        $_SESSION['status'] = "Your Data is NOT Updated";
        header('Location: register_Hp.php');
    }
}
//Update Health Facilitie Profile
 if(isset($_POST['updatebtn_etab'])){
    $id=$_POST['edit_id'];
    $inpe = $_POST['inpe_edit'];
    $name = $_POST['name_edit'];
    $type = $_POST['type_edit'];
    $pub= $_POST['prv-pub_edit'];
    $password=md5($_POST['edit_password']);
    $type=$_POST['type_edit'];
    $email = $_POST['edit_email'];
    $tele = $_POST['edit_tele'];

    $query ="UPDATE etablissement SET inpe_etab='$inpe'
                                    ,name='$name'
                                    ,type_etab='$type'
                                    ,email='$email'
                                    ,pub_prv_etab='$pub'
                                    ,tele_etab='$tele'
                                    ,password='$password'
                                    ,type_etab='$type'
                                     WHERE id='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Updated";
        header('Location:register_etab.php');
    }else{
        $_SESSION['status']="Your Data is NOT Updated";
        header('Location:register_etab.php');
    }
 }
 //Update Insurrance Company
 if(isset($_POST['updatebtn_assu'])){
    $id=$_POST['edit_id'];
    $patente = $_POST['patente_edit'];
    $name=$_POST['name_edit'];
    $pub= $_POST['prv-pub-edit'];
    $email= $_POST['email_edit'];
    $tel= $_POST['tel_edit'];
    $password=md5($_POST['edit_password']);

    $query ="UPDATE assurance SET patente_assu='$patente'
                                    ,name='$name'
                                    ,prv_pub_assu='$pub'
                                    ,tele_assu='$tel'
                                    ,email='$email'
                                    ,password='$password'
                                     WHERE id='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Updated";
        header('Location:register_assu.php');
    }else{
        $_SESSION['status']="Your Data is NOT Updated";
        header('Location:register_assu.php');
    }
 }

?>