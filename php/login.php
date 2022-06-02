<?php
session_start();
if(isset($_SESSION["name"])) header("Location: ../dashboard.php");
function loginUser($email, $password){
    $email = strtolower($email);
    if(($handle = fopen("../storage/users.csv", "r")) !== FALSE) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            while(($data = fgetcsv($handle)) !== FALSE) {
                if($data[1] == $email) {
                    if($data[2] == md5($password)) {
                        $_SESSION["name"] = $data[0];
                        header("Location: ../dashboard.php");
                    } else {
                        header("Location: ../forms/login.html");
                    }
                }
            }
        } else {
            echo "Invalid email address";
        }
        fclose($handle);
    } else {
        echo "Internal error";
    }
}
if(isset($_POST['submit'])){
    $username = $_POST["email"];
    $password = $_POST["password"];
loginUser($username, $password);
} else {
    header("Location: ../forms/login.html");
}
?>