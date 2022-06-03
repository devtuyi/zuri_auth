<?php
function resetPassword($email, $password){
    $email = strtolower($email);
    $password = md5($password);
    if(($handle = fopen("../storage/users.csv", "r")) !== FALSE && ($_handle = fopen("../storage/users.temp.csv", "w")) !== FALSE) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            while(($data = fgetcsv($handle)) !== FALSE) {
                if($data[1] == $email) {
                    fputcsv($_handle, [$data[0], $data[1], $password]);
                    $msg = "Password updated";
                } else {
                    fputcsv($_handle, [$data[0], $data[1], $data[2]]);
                }
            }
            if(!isset($msg)) {
                $msg = "User does not exist";
            }
        } else {
            $msg = "Invalid email address";
        }
        fclose($handle);
        fclose($_handle);
        if(@rename("../storage/users.temp.csv", "../storage/users.csv")) {
            $msg = "Internal error";
        }
    } else {
        $msg = "Internal error";
    }
    return $msg;
}
if(isset($_POST['submit'])){
    $email = $_POST["email"];
    $password = $_POST["password"];

    echo resetPassword($email, $password);
} else {
    header("Location: ../forms/resetpassword.html");
}
?>