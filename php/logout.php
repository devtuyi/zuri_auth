<?php
function logout(){
    if(isset($_SESSION["name"])) {
        session_destroy();
    }
    header("Location: ../forms/login.html");
}
logout();
?>