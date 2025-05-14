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
                    (inpe,f_name_hp,name,type,specialty,email,password,)
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

//Update A health profissionnals

 if(isset($_POST['updatebtn_hp'])){
    $id=$_POST['edit_id'];
    $inpe = $_POST['inpe_edit'];
    $fname = $_POST['name1_edit'];
    $lname = $_POST['name2_edit'];
    $email= $_POST['edit_email'];
    $password=md5( $_POST['edit_password']);
    $type=$_POST['type_edit'];
    $spec = $_POST['edit_spec'];

    $query ="UPDATE health_professionals 
                    SET inpe='$inpe'
                    ,f_name_hp='$fname'
                    ,name='$lname'
                    ,email='$email'
                    ,password='$password'
                    ,type='$type'
                    ,specialty='$spec'
                     WHERE id_Hp='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Updated";
        header('Location:register_Hp.php');
    }else{
        $_SESSION['status']="Your Data is NOT Updated";
        header('Location:register_Hp.php');
    }
 }

//Delete A health profissionnals

 if(isset($_POST['delete_btn_hp'])){
    $id =$_POST['delete_hp'];
    
    $delete_invitations_query = "DELETE FROM invitations WHERE id_Hp = '$id'";
    $delete_employe_query     = "DELETE FROM employe WHERE id_Hp = '$id'";
    $delete_hp_query          = "DELETE FROM health_professionals WHERE id_Hp = '$id'";
    
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

 //Delete Health Facilitie Profile
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

 //Update Health Facilitie Profile
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
                                    ,name='$name'
                                    ,type_etab='$type'
                                    ,email='$email'
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
        (patente_assu, name, prv_pub_assu, tele_assu, email, password)
        VALUES ('$patente', '$name', '$pub', '$tel', '$email', '$password')";
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

 //Delete Insurrance Company
 if(isset($_POST['delete_btn_assu'])){
    $id =$_POST['delete_assu'];
    $query="DELETE  FROM assurance WHERE id_assu='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Deleted";
        header('Location:register_assu.php');
    }else{
        $_SESSION['status']="Your Data is NOT Deleted";
        header('Location:register_assu.php');
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
    $password=md5( $_POST['edit_password']);

    $query ="UPDATE assurance SET patente_assu='$patente'
                                    ,name='$name'
                                    ,prv_pub_assu='$pub'
                                    ,tele_assu='$tel'
                                    ,email='$email'
                                    ,password='$password'
                                     WHERE id_assu='$id'";
    $query_run=mysqli_query($connection,$query);
    if($query_run){
        $_SESSION['success']="Your Data is Updated";
        header('Location:register_assu.php');
    }else{
        $_SESSION['status']="Your Data is NOT Updated";
        header('Location:register_assu.php');
    }
 }
//Edit profile

if (isset($_POST['edit_btn'])) {
    $message = ""; // Initialize message

    // ✅ Ensure session email is available
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        // ✅ Get current user from DB
        $selectQuery = "SELECT * FROM register WHERE email = '$email'";
        $result = mysqli_query($connection, $selectQuery);
        $user = mysqli_fetch_assoc($result);

        // ✅ Password update
        if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];

            if ($user && md5($currentPassword) === $user['password']) {
                $newPasswordHash = md5($newPassword);

                $updatePassQuery = "UPDATE register SET password = '$newPasswordHash' WHERE email = '$email'";
                $query_run = mysqli_query($connection, $updatePassQuery);

                if ($query_run) {
                    $message .= "✅ Password updated successfully. ";
                } else {
                    $message .= "❌ Error updating password. ";
                }
            } else {
                $message .= "❌ Incorrect current password. ";
            }
        }
       
        // ✅ Profile picture upload
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $filename = time() . '_' . basename($_FILES['profile_pic']['name']);
            $targetPath = $uploadDir . $filename;

            $fileType = mime_content_type($_FILES['profile_pic']['tmp_name']);
            if (strpos($fileType, 'image') === false) {
                $message .= "❌ Only image files are allowed. ";
            } else {
                if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetPath)) {
                    $updatePicQuery = "UPDATE register SET profile_pic = '$filename' WHERE email = '$email'";
                    $query_run = mysqli_query($connection, $updatePicQuery);

                    if ($query_run) {
                        $message .= "✅ Profile picture updated successfully. ";
                    } else {
                        $message .= "❌ Error updating profile picture. ";
                    }
                } else {
                    $message .= "❌ Error uploading the image. ";
                }
            }
        } else {
            $message .= "⚠️ No profile picture uploaded or error occurred. ";
        }

    } else {
        $message .= "⚠️ Session expired. Please log in again.";
    }

    $_SESSION['message'] = $message;
    header('Location: profile_edit.php');
    exit();
}

?>