<?php
    include "service/database.php";
    session_start();

    $login_message = "";

    if(isset($_SESSION["is_login"])) {
        header("location: dashboard.php");
    }

    if(isset($_POST['login'])) {
       $username = $_POST['username'];
       $password = $_POST['password'];
       $hash_password = hash("sha256", $password);

       $sql = "SELECT * FROM users WHERE
        username='$username' AND 
        password='$hash_password'";

       $result = $db->query($sql);

       if($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $_SESSION["username"] = $data["username"];
            $_SESSION["id_user"]  = $data["id_user"];
            $_SESSION["is_login"] = true;

            header("location: dashboard.php");

       }else{
            $login_message = "akun tidak ditemukan";
       }
    }
      $db->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   
</head>
<body>
    
    <div class="login-container"> <!-- TAMBAHAN -->

    <div class="login-left"> <!-- TAMBAHAN -->

        <h3>LOGIN</h3> <!-- UBAH teks -->

        <i><?= $login_message ?></i>

        <form action="login.php" method="POST">
            <input type="text" placeholder="Username" name="username"/>
            <input type="password" placeholder="Password" name="password"/>
            <button type="submit" name="login">Login Now</button>
        </form>

        <p>Not a member? <a href="register.php">Sign Up</a></p> <!-- TAMBAHAN -->

    </div>

    <div class="login-right"></div> <!-- TAMBAHAN -->

</div>
</body>
<style>
    /* ===== RESET ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background-color: #e7e9d0;
    margin: 0;
    height: 100vh;

    display: flex;
    justify-content: center;
    align-items: center;
}

/* ===== LOGIN CONTAINER ===== */
.login-container {
    display: flex;
    width: 900px; /* atau 80% */
    height: auto !important;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
/* ===== LOGIN LEFT (FORM) ===== */
.login-left {
    flex: 1;
    background-color: #e8dfd8;
    padding: 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.login-left h3 {
    font-size: 40px;
    color: #1f4d1c;
    margin-bottom: 20px;
}

.login-left input {
    width: 100%;
    padding: 15px;
    border-radius: 25px;
    border: none;
    margin-top: 10px;
}

.login-left button {
    margin-top: 20px;
    padding: 12px;
    border-radius: 25px;
    border: none;
    background-color: #e0a84d;
    color: white;
    cursor: pointer;
}
.login-left input {
    margin-bottom: 10px;
}
/* ===== LOGIN RIGHT (IMAGE) ===== */
.login-right {
    flex: 1;
    background: url('img/serum.jpeg') center/cover no-repeat;
}
</style>
</html>