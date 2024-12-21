<?php
$loginError = '';

if (isset($_POST["btn-reg"])) {
    $cnn = new mysqli("localhost", "root", "020903", "management");

    // Verificar conexión
    if ($cnn->connect_error) {
        echo "<script>alert('Conexión fallida: $cnn->connect_error');</script>";
    } else {
        echo "<script>alert('Conexión exitosa');</script>";
    }

    $username = $_POST["username"];
    $fullname = $_POST["fullname"];
    $contact = $_POST["contact"];
    $address = $_POST["address"];
    $password = $_POST["password"];

    // Verificar si el username ya existe
    $checkUser = $cnn->query("SELECT * FROM user WHERE username='$username'");
    if ($checkUser->num_rows > 0) {
        echo "<script>alert('El nombre de usuario ya existe. Por favor, elija otro.');</script>";
    } else {
        $sql = "INSERT INTO user (username, fullname, contact, address, password) VALUES ('$username', '$fullname', '$contact', '$address', '$password')";

        if ($cnn->query($sql) == TRUE) {
            echo "<script>alert('Registro exitoso');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $cnn->error;
        }
    }

    $cnn->close();
    header("Location:index.php");
}

if (isset($_POST["btn-login"])) {
    $cnn = new mysqli("localhost", "root", "020903", "management");
    if ($cnn->connect_error) {
        echo "<script>alert('Conexión fallida: $cnn->connect_error');</script>";
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = $cnn->query("SELECT id FROM user WHERE username='$username' AND password='$password'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['id'];
        echo "<form id='redirectForm' action='mainview.php' method='post' style='display: none;'>
                <input type='hidden' name='user-id' value='$userId'>
              </form>
              <script> document.getElementById('redirectForm').submit(); </script>";
    } else {
        $loginError.= "Credenciales invalidas";
    }
    

    $cnn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="login.js"></script>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="form-box login">
            <form action="" method="post">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" placeholder="username" name="username" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="password" name="password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <?php if (!empty($loginError)): ?>
                    <p style="color: red; padding-bottom: 20px;"><?php echo $loginError; ?></p>
                <?php endif; ?>
                <button type="submit" class="btn" name="btn-login">Login</button>
            </form>
        </div>

        <div class="form-box register">
            <form action="" method="post">
                <h1>Registration</h1>
                <div class="input-box">
                    <input type="text" placeholder="username" name="username" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="fullname" name="fullname" required>
                    <i class='bx bxs-rename'></i>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="contact" name="contact" required>
                    <i class='bx bxs-contact'></i>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="address" name="address" required>
                    <i class='bx bxs-direction-left'></i>
                </div>
                <div class="input-box">
                    <input type="password" id="pss" placeholder="password (max 8 chars)" name="password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" class="btn" name="btn-reg">Register</button>
            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-right">
                <h1>Hello, welcome!</h1>
                <p>Don't have an account?</p>
                <button class="btn register-btn">Register</button>
            </div>
            <div class="toggle-panel toggle-left">
                <h1>Hello, back!</h1>
                <p>Already have an account?</p>
                <button class="btn login-btn">Login</button>
            </div>
        </div>
    </div>
</body>
</html>
