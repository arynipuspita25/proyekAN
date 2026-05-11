<?php
    include "service/database.php";
    session_start();

    $register_message = "";

    if(isset($_SESSION["is_login"])) {
        header("location: dashboard.php");
    }

    if(isset($_POST["register"])){
        $username = $_POST["username"];
        $password = $_POST["password"];

        $hash_password = hash("sha256", $password);

        try {
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hash_password')";

             if($db->query($sql)) {
                 $register_message = "daftar akun berhasil, silahkan login";
             }else {
                 $register_message = "daftar akun gagal, silahkan coba lagi";
             }
        }catch (mysqli_sql_exception) {
            $register_message = "username sudah digunakan";

        }
        $db->close();

        
    }
?>

 

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: linear-gradient(135deg, #f4efe9, #e8dfd8);
    height: 100vh;

    display: flex;
    justify-content: center;
    align-items: center;
}

.register-container {
    display: flex;
    justify-content: center;
    width: 100%;
}

.register-card {
    width: 420px;
    background-color: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
}
.register-header {
    background-color: #1d3b0b;
    text-align: center;
    padding: 25px;
}

.register-header h3 {
    color: white;
    font-size: 24px;
    letter-spacing: 1px;
}

.register-form {
    padding: 30px;
}

.register-form input {
    width: 100%;
    padding: 14px;
    border-radius: 25px;
    border: 1px solid #ddd;
    margin-top: 12px;
    outline: none;
    transition: 0.3s;
}

.register-form input:focus {
    border-color: #1d3b0b;
    box-shadow: 0 0 0 2px rgba(31,77,28,0.1);
}

.register-form button {
    margin-top: 20px;
    width: 100%;
    padding: 14px;
    border-radius: 25px;
    border: none;
    background-color: #1f4d1c;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.register-form button:hover {
    background-color: #163a14;
}
.back-login {
    margin-top: 15px;
    text-align: center;
    font-size: 14px;
    color: #555;
}

.back-login a {
    display: inline-block;
    margin-top: 8px;
    padding: 6px 12px;
    border-radius: 15px;
    background-color: transparent;
    border: 1px solid #1f4d1c;
    transition: 0.3s;
}

.back-login a:hover {
    background-color: #1f4d1c;
    color: white;
}
</style>
</html>