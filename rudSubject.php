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

$subject_data = [
    'id_sub' => '',
    'sub_name' => '',
    'id_user' => '',
    'school' => '',
    'grade' => '',
    'speciality' => ''
];

$editable = "";
$button = "";

if(isset($_POST['btn-consult'])){
    $editable.="readonly";
    $button.="<input type='submit' class='btn' id='btnAddSubj' style='display:none'>";

    $idSubj = $_POST['subject-id'];
    $sql = "SELECT * FROM subjects WHERE id_sub='$idSubj'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $subject_data = $result->fetch_assoc();
    }
}

if(isset($_POST['btn-modify'])){
    $editable.="";
    $button.="<input type='submit' class='btn' name='btn-upd-sub' value='Update'>";

    $idSubj = $_POST['subject-id'];
    $sql = "SELECT * FROM subjects WHERE id_sub='$idSubj'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $subject_data = $result->fetch_assoc();
    }
}

if(isset($_POST['btn-upd-sub'])){
    $idSubj = $_POST['subject-id'];
    $userId = $_POST['user-id'];
    $sub_name = $_POST['subj-name'];
    $school = $_POST['school'];
    $grade = $_POST['grade'];
    $speciality = $_POST['speciality'];

    $sql = "UPDATE subjects SET sub_name='$sub_name', school='$school', grade='$grade', 
    speciality='$speciality' WHERE id_sub='$idSubj' ";

    if ($conn->query($sql) == TRUE) {
        echo "<script>alert('Datos actualizados correctamente!');</script>";
        echo "<form id='redirectForm' action='mainview.php' method='post' style='display: none;'>
                <input type='hidden' name='user-id' value='$userId'>
              </form>
              <script> document.getElementById('redirectForm').submit(); </script>";
    } else {
        echo "<script>alert('Error al actualizar los datos: " . $conn->error . "');</script>";
    }
}

if(isset($_POST['btn-delete'])){
    $editable.="readonly";
    $button.="<input type='submit' class='btn' name='btn-del-sub' value='Delete' 
    style='background: rgba(192, 93, 93, 0.93);'>";

    $idSubj = $_POST['subject-id'];
    $sql = "SELECT * FROM subjects WHERE id_sub='$idSubj'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $subject_data = $result->fetch_assoc();
    }
}


if(isset($_POST['btn-del-sub'])){
    $id = $_POST['subject-id'];
    $userId = $_POST['user-id'];

    $sql = "DELETE FROM subjects WHERE id_sub='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Materia eliminada correctamente!');</script>";
        echo "<form id='redirectForm' action='mainview.php' method='post' style='display: none;'>
                <input type='hidden' name='user-id' value='$userId'>
              </form>
              <script> document.getElementById('redirectForm').submit(); </script>";
    } else {
        echo "<script>alert('Error al eliminar el usuario: " . $conn->error . "');</script>";
    }
}


$conn->close(); // Cerrar conexion final
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>RUDSUBJECT</title>
    <link rel="stylesheet" href="rudSubject.css">
</head>
<body>
        <div class="form-container">    

            <nav class="cont-subj">
               <h1>SUBJECTS</h1>
                <form action="mainview.php" method="post">
                    <input type='hidden' name='subject-id' value="<?php echo($subject_data['id_sub']); ?>">
                    <input type='hidden' name='user-id' value="<?php echo($subject_data['id_user']); ?>">
                    <input type="submit" id="btnSubj" class="btnSub" value="<-- Go Back">
                </form>
                
                <br> <br>

                <div class="add-sub">
                <form action="" method="post">

                    <div class="input-box">
                        <input type="hidden" name="subject-id" value="<?php echo($subject_data['id_sub']); ?>">
                    </div>

                    <div class="input-box">
                        <input type="hidden" name="user-id" value="<?php echo($subject_data['id_user']); ?>">
                    </div>

                    <div class="input-box">
                        <input type="text" placeholder="Subject Name" name="subj-name" value="<?php echo($subject_data['sub_name']); ?>" required <?php echo($editable)?>>
                        <i class='bx bx-book list-icon'></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="School Name" name="school" value="<?php echo($subject_data['school']); ?>" required <?php echo($editable)?>>
                        <i class='bx bxs-school list-icon' ></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="School Grade" name="grade" value="<?php echo($subject_data['grade']); ?>" required <?php echo($editable)?>>
                        <i class='bx bx-rename list-icon' ></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Speciality" name="speciality" value="<?php echo($subject_data['speciality']); ?>" required <?php echo($editable)?>>
                        <i class='bx bxs-award list-icon'></i>
                    </div>

                    <?php echo $button; ?>

                </form>
                </div>

            </nav>

        </div>
</body>
</html>