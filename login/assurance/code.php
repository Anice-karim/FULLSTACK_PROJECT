<?php
include('../security.php'); 

if(isset($_POST['registerbtn']))
 {
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $email= $_POST['email'];
    $cin= $_POST['CIN_as'];
    $rib= $_POST['RIB_as'];
    $des= $_POST['designation'];
    $salaire= $_POST['salaire'];
    $password= $_POST['password'];
    $cpassword= $_POST['confirmpassword'];
    $immatr= $_POST['N_immatriculation_assure'];
    $id_assu=$_POST['assu_id'];
    
   

    if($password === $cpassword){
        $query ="INSERT INTO assure (name,prenom_as,email,CIN_as,RIB_as,designation,salaire_as,password,N_immatriculation_assure,id_assurance)
                             VALUES('$name','$last_name','$email','$cin','$rib','$des','$salaire','$password','$immatr','$id_assu')";
        $query_run = mysqli_query($connection , $query);
        if($query_run){
            //echo "Saved";
            $_SESSION['success']="Client Profile Added";
            header('Location:assure_register.php');
        }else{
            //echo "Not Saved";
            $_SESSION['status']="Client Profile Not Added";
            header('Location:assure_register.php');
        }
    }else{
        $_SESSION['status']="Password and Confirm password does not match";
        header('Location:assure_register.php');
    }

    
 }


 if(isset($_POST['registerbtn_beni']))
 {
    $fname = $_POST['name1'];
    $lname = $_POST['name2'];
    $cin= $_POST['cin2'];
    $birth= $_POST['date'];
    $chronic= $_POST['chronic'];
    $chronic2= $_POST['chronic2'];
    $relation= $_POST['relation'];
    $id_as=$_POST['admin_id'];
    
   
        $query ="INSERT INTO beneficiaire (f_name,l_name,cin_ben,chronic,chronic1,id_as,relation,birth)
                             VALUES('$fname','$lname','$cin','$chronic','$chronic2','$id_as','$relation','$birth')";
        $query_run = mysqli_query($connection , $query);
        if($query_run){
            //echo "Saved";
            $_SESSION['success']="A Familly Member added";
            header('Location:assure_register.php');
        }else{
            //echo "Not Saved";
            $_SESSION['status']="A Familly Member Not Added";
            header('Location:assure_register.php');
        }    
 }
 if(isset($_POST['delete_btn_as'])){
    $id =$_POST['delete_id_as'];
    
    $delete_as_query = "DELETE FROM assure WHERE id_as = '$id'";
    $delete_ben_query = "DELETE FROM beneficiaire WHERE id_as = '$id'";
  
    
    //all or nothing
    mysqli_begin_transaction($connection);


    try {
        mysqli_query($connection, $delete_as_query);
        mysqli_query($connection, $delete_ben_query );
        mysqli_commit($connection);//Yes, go ahead and apply all the changes.
        
        $_SESSION['success'] = "Ex-client and related records deleted successfully.";
    } catch (Exception $e) {
        // Rollback in case of error
        mysqli_rollback($connection);//cancels all previous deletions
        $_SESSION['status'] = "Error during deletion: " . $e->getMessage();
    }
    header('Location:assure_register.php');  

 }
?>