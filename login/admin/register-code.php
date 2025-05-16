<?php
include('../security.php'); 

//Add A Admin Profile
if(isset($_POST['registerbtn']))
 {
    $username = $_POST['username'];
    $email= $_POST['email'];
    $password= md5($_POST['password']);
    $cpassword= md5($_POST['confirmpassword']);
   

    if($password === $cpassword){
        $query ="INSERT INTO register (name,email,password) VALUES('$username','$email','$password')";
        $query_run = mysqli_query($connection , $query);
        if($query_run){
            $_SESSION['success']="Admin Profile Added";
            header('Location:register.php');
        }else{
            $_SESSION['status']="Admin Profile Not Added";
            header('Location:register.php');
        }
    }else{
        $_SESSION['status']="Password and Confirm password does not match";
        header('Location:register.php');
    }
   
 }
//Add A health profissionnals
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
    
    if($password === $cpassword){
        $query ="INSERT INTO health_professionals 
                    (inpe,f_name_hp,name,type,specialty,email,password)
                     VALUES('$inpe','$fname','$lname','$dsg','$spec','$email','$password')";
        $query_run = mysqli_query($connection , $query);
        if($query_run){
            //echo "Saved";
            $_SESSION['success']="A Health Profile Added";
            header('Location:register_Hp.php');
        }else{
            //echo "Not Saved";
            $_SESSION['status']="A Health Profile Not Added";
            header('Location:register_Hp.php');
        }
    }else{
        $_SESSION['status']="Password and Confirm password does not match";
        header('Location:register_Hp.php');
    }

    
 }

//Add Health Facilitie Profile
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
        $query ="INSERT INTO etablissement 
                        (inpe_etab,name,pub_prv_etab,type_etab,tele_etab,email,password) 
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

 //Add Insurrance Company
 if(isset($_POST['registerbtn_assu']))
 {
    $patente = $_POST['patente'];
    $name=$_POST['name'];
    $pub= $_POST['prv-pub'];
    $email= $_POST['email'];
    $tel= $_POST['tel'];
    $password=md5( $_POST['password']);
    $cpassword= md5($_POST['confirmpassword']);
    

    if($password === $cpassword){
        $query = "INSERT INTO assurance
        (patente_assu, name, prv_pub_assu, tele_assu, email,password)
        VALUES ('$patente', '$name', '$pub', '$tel', '$email','$password')";
        $query_run = mysqli_query($connection , $query);
        if($query_run){
            //echo "Saved";
            $_SESSION['success']="A Health Profile Added";
            header('Location:register_assu.php');
        }else{
            //echo "Not Saved";
            $_SESSION['status']="A Health Profile Not Added";
            header('Location:register_assu.php');
        }
    }else{
        $_SESSION['status']="Password and Confirm password does not match";
        header('Location:register_assu.php');
    }

    
 }
?>