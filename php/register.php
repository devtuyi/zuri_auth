<?php
session_start();
function registerUser($username, $email, $password){
    $username = ucwords(str_replace(",", "", htmlspecialchars($username)));
    $email = strtolower($email);
    $password = md5($password);
    if(($handle = fopen("../storage/users.csv", "a+")) !== FALSE) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            while(($data = fgetcsv($handle)) !== FALSE) {
                if($data[1] == $email) {
                    $msg = "Email exist";
                }
            }
            if(!isset($msg)) {
                fputcsv($handle, [$username, $email, $password]);
                $msg = "User Successfully registered";
            }
        } else {
            $msg = "Invalid email address";
        }
        fclose($handle);
    } else {
        $msg = "Internal error";
    }
    return $msg;
}
if(isset($_POST['submit'])){
    $username = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
echo registerUser($username, $email, $password);
} else {
    header("Location: ../forms/register.html");
}
?>