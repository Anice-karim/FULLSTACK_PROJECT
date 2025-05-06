<?php
include('../security.php'); 


if(isset($_POST['registerbtn_Hp']))
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
 if(isset($_POST['registerbtn_etab']))
 {
    $inpe = $_POST['inpe'];
    $name=$_POST['name'];
    $pub= $_POST['prv-pub'];
    $phone= $_POST['phone'];
    $email= $_POST['email'];
    $password=md5( $_POST['password']);
    $cpassword= md5($_POST['confirmpassword']);
    $type=$_POST['type'];
    

    if($password === $cpassword){
        $query ="INSERT INTO etablissement (inpe_etab,name_etab,pub_prv_etab,type_etab,tele_etab,email_etab,password) 
                                    VALUES('$inpe','$name','$pub','$type','$phone','$email','$password')";
        $query_run = mysqli_query($connection , $query);
        if($query_run){
            //echo "Saved";
            $_SESSION['success']="A Profile Added";
            header('Location:register_etab.php');
        }else{
            //echo "Not Saved";
            $_SESSION['status']="A Profile Not Added";
            header('Location:register_etab.php');
        }
    }else{
        $_SESSION['status']="Password and Confirm password does not match";
        header('Location:register_etab.php');
    }   
 }
 if(isset($_POST['delete_btn_etab'])){
    $id =$_POST['delete_etab'];
    $query="DELETE  FROM etablissement WHERE id_etab='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Deleted";
        header('Location:register_etab.php');
    }else{
        $_SESSION['status']="Your Data is NOT Deleted";
        header('Location:register_etab.php');
    }

 }
 if(isset($_POST['updatebtn_etab'])){
    $id=$_POST['edit_id'];
    $inpe = $_POST['inpe_edit'];
    $name = $_POST['name_edit'];
    $type = $_POST['type_edit'];
    $pub= $_POST['prv-pub_edit'];
    $password=md5( $_POST['edit_password']);
    $type=$_POST['type_edit'];
    $email = $_POST['edit_email'];
    $tele = $_POST['edit_tele'];

    $query ="UPDATE etablissement SET inpe_etab='$inpe'
                                    ,name_etab='$name'
                                    ,type_etab='$type'
                                    ,email_etab='$email'
                                    ,pub_prv_etab='$pub'
                                    ,tele_etab='$tele'
                                    ,password='$password'
                                    ,type_etab='$type'
                                     WHERE id_etab='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Updated";
        header('Location:register_etab.php');
    }else{
        $_SESSION['status']="Your Data is NOT Updated";
        header('Location:register_etab.php');
    }
 }


 


?>