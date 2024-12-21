<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "020903";
$dbname = "management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_data = [
    'id' => '',
    'username' => '',
    'fullname' => '',
    'contact' => '',
    'address' => '',
    'password' => ''
];

$subject_data = [
    'id_sub' => '',
    'sub_name' => '',
    'id_user' => '',
    'school' => '',
    'grade' => '',
    'speciality' => ''
];

// Modificar datos del usuario
if (isset($_POST["btn-upd"])) {

    $id = $_POST['user-id'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    $sql = "UPDATE user SET username='$username', fullname='$fullname', contact='$contact', 
    address='$address', password='$password' WHERE id='$id'";

    if ($conn->query($sql) == TRUE) {
        echo "<script>alert('Datos actualizados correctamente');</script>";
    } else {
        echo "<script>alert('Error al actualizar los datos: " . $conn->error . "');</script>";
    }
}

// Eliminar usuario
if (isset($_POST["btn-del"])) {
    $id = $_POST['user-id'];

    $sql = "DELETE FROM user WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Usuario eliminado correctamente'); 
                window.location.href = 'index.php'; 
            </script>";
    } else {
        echo "<script>alert('Error al eliminar el usuario: " . $conn->error . "');</script>";
    }
}

//Agregar materia
if (isset($_POST['btn-add'])) {
    $id = $_POST['user-id'];
    $subjName = $_POST["subj-name"];
    $school = $_POST["school"];
    $grade = $_POST["grade"];
    $spec = $_POST["speciality"];

    $sql = "INSERT INTO subjects (sub_name, id_user, school, grade, speciality) 
            VALUES ('$subjName', $id, '$school', '$grade', '$spec')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registro exitoso');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if (isset($_POST['user-id'])) {
    $id = $_POST['user-id'];
    $sql = "SELECT * FROM user WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
    }


    $sql_subjects = "SELECT * FROM subjects WHERE id_user='$id'";
    $result_subjects = $conn->query($sql_subjects);

    $allSubjects = "";
    while ($subject = $result_subjects->fetch_assoc()) {
        $subject_id = $subject['id_sub'];
        $subject_name = $subject['sub_name'];

        $allSubjects.= "
            <div class='subject-item'>
              <form action='subjectControl.php' method='post' style='display:inline;'> 
                <input type='hidden' name='subject-id' value='$subject_id'> 
                <input type='hidden' name='user-id' value='$id'> 
                <input type='submit' name='btn-wss' value='$subject_name' class='btnSj'> 
              </form>
              
                <form action='rudSubject.php' method='post' style='display:inline;'>
                    <input type='hidden' name='subject-id' value='$subject_id'>
                    <input type='hidden' name='user-id' value='$id'>
                    <input type='submit' name='btn-consult' value='Consult' class='btn-small'>
                </form>
                <form action='rudSubject.php' method='post' style='display:inline;'>
                    <input type='hidden' name='subject-id' value='$subject_id'>
                    <input type='hidden' name='user-id' value='$id'>
                    <input type='submit' name='btn-modify' value='Update' class='btn-small'>
                </form>
                <form action='rudSubject.php' method='post' style='display:inline;'>
                    <input type='hidden' name='subject-id' value='$subject_id'>
                    <input type='hidden' name='user-id' value='$id'>
                    <input type='submit' name='btn-delete' value='Delete' class='btn-small'>
                </form>
            </div>";
        }

}

$conn->close(); // Cerrar conexión final
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Materias</title>
    <link rel="stylesheet" href="mainview.css">
</head>
<body>

    <div class="container">
        <nav class="ops">
            <ul class="list">

                <li class="list-item">
                    <div class="list-button list-button-click">
                        <i class='bx bxs-user-account list-icon'></i>
                        <a href="#" class="nav-link">Account</a>
                        <i class='bx bxs-right-arrow list-arrow'></i>
                    </div>

                    <div class="list-show">
                        <ul>
                            <li class="list-inside">
                                <a href="?action=consult" class="nav-link nav-link-inside" id="consultAcc">Consult</a>
                            </li>
                            <li class="list-inside">
                                <a href="?action=update" class="nav-link nav-link-inside" id="updateAcc">Update</a>
                            </li>
                            <li class="list-inside">
                                <a href="?action=delete" class="nav-link nav-link-inside" id="deleteAcc">Delete</a>
                            </li>
                            <li class="list-inside">
                                <a href="?action=logout" class="nav-link nav-link-inside" id="logout">Log out</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="list-item">
                    <div class="list-button">
                        <i class='bx bx-book list-icon'></i>
                        <a href="#" class="nav-link" id="subjects">Subjects</a>
                    </div>
                </li>

            </ul>
        </nav>

        <div class="form-container">
            <nav class="form-box">
                <form action="" method="post">
                    <h1>Account</h1>
                    <div class="input-box">
                        <input type="hidden" name="user-id" value="<?php echo($user_data['id']); ?>">
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="username" name="username" value="<?php echo($user_data['username']); ?>" required>
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="fullname" name="fullname" value="<?php echo($user_data['fullname']); ?>" required>
                        <i class='bx bxs-rename'></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="contact" name="contact" value="<?php echo($user_data['contact']); ?>" required>
                        <i class='bx bxs-contact'></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="address" name="address" value="<?php echo($user_data['address']); ?>" required>
                        <i class='bx bxs-direction-left'></i>
                    </div>
                    <div class="input-box">
                        <input type="text" id="pss" placeholder="password (max 8 chars)" name="password" value="<?php echo($user_data['password']); ?>" required>
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    <input type="submit" class="btn" id="btnAcc" name="" value="">
                </form>
            </nav>

            <nav class="cont-subj">
               <h1>SUBJECTS</h1>

                <input type="button" id="btnSubj" class="btnSub" value="Add Subject +">

                <br> <br>
                <br> <br>

                <div class="add-sub">
                <form action="" method="post">

                    <div class="input-box">
                        <input type="hidden" name="user-id" value="<?php echo($user_data['id']); ?>">
                    </div>

                    <div class="input-box">
                        <input type="text" placeholder="Subject Name" name="subj-name" value="<?php echo($subject_data['sub_name']); ?>" required>
                        <i class='bx bx-book list-icon'></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="School Name" name="school" value="<?php echo($subject_data['school']); ?>" required>
                        <i class='bx bxs-school list-icon' ></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="School Grade" name="grade" value="<?php echo($subject_data['grade']); ?>" required>
                        <i class='bx bx-rename list-icon' ></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Speciality" name="speciality" value="<?php echo($subject_data['speciality']); ?>" required>
                        <i class='bx bxs-award list-icon'></i>
                    </div>

                    <input type="submit" class="btn" id="btnAddSubj" name="btn-add" value="Add Subject">

                </form>
                </div>

                <div class="subjects">
                    <?php  echo $allSubjects; ?>
                </div>
            </nav>

        </div>

    </div>

    <script src="mainview.js"></script>

</body>
</html>