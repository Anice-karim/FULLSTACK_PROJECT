<?php
include('security.php');


if(isset($_POST['registerbtn']))
 {
    $inpe = $_POST['inpe'];
    $fname=$_POST['name1'];
    $lname=$_POST['name2'];
    $dsg= $_POST['type'];
    $spec= $_POST['spec'];
    $email= $_POST['email'];
    $password=md5( $_POST['password']);
    $cpassword= md5($_POST['confirmpassword']);
    $rgst=false;
    

    if($password === $cpassword){
        $query ="INSERT INTO health_professionals (inpe,f_name_hp,l_name_hp,type,specialty,email,password,registred) VALUES('$inpe','$fname','$lname','$dsg','$spec','$email','$password','$rgst')";
        $query_run = mysqli_query($connection , $query);
        if($query_run){
            //echo "Saved";
            $_SESSION['success']="A Profile Added";
            header('Location:register_Hp.php');
        }else{
            //echo "Not Saved";
            $_SESSION['status']="A Profile Not Added";
            header('Location:register_Hp.php');
        }
    }else{
        $_SESSION['status']="Password and Confirm password does not match";
        header('Location:register_Hp.php');
    }

    
 }

 if(isset($_POST['updatebtn'])){
    $id=$_POST['edit_id'];
    $inpe = $_POST['inpe_edit'];
    $fname = $_POST['name1_edit'];
    $lname = $_POST['name2_edit'];
    $email= $_POST['edit_email'];
    $password=md5( $_POST['edit_password']);
    $type=$_POST['type_edit'];
    $spec = $_POST['edit_spec'];

    $query ="UPDATE health_professionals SET inpe='$inpe',f_name_hp='$fname',l_name_hp='$lname',email='$email',password='$password',type='$type',specialty='$spec' WHERE id_Hp='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Updated";
        header('Location:register_Hp.php');
    }else{
        $_SESSION['status']="Your Data is NOT Updated";
        header('Location:register_Hp.php');
    }
 }

 if(isset($_POST['delete_btn'])){
    $id =$_POST['delete_hp'];
    $query="DELETE  FROM health_professionals WHERE id_Hp='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Deleted";
        header('Location:register_Hp.php');
    }else{
        $_SESSION['status']="Your Data is NOT Deleted";
        header('Location:register_Hp.php');
    }

 }




 


?>