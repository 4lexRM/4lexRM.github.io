<?php

session_start(); 

$servername = "localhost";
$username = "root";
$password = "020903";
$dbname = "management";

$stdId = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$editable = "";
$button ="";


$idEst ="";
$student_data = [
    'id_stu' => '',
    'id_sub' => '',
    'fullname' => '',
    'numc' => '',
    'contact' => '',
    'address' => '',
    'final_q' => ''
];


$userId = $_POST['user-id'];
$subId = $_POST['subject-id'];
$id_stu = '';


if(isset($_POST['btnStud'])){
    $button.="<input type='submit' class='btn' id='btnAddStu' name='btnAddStu' style='' value='Add'>";
}

if(isset($_POST['btnAddStu'])){
    $userId = $_POST['user-id'];
    $subId = $_POST['subject-id'];
    $name = $_POST['stu-name'];
    $nc = $_POST['numC'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $ql = $_POST['finalQ'];

    $sql = "INSERT INTO student (id_sub, fullname, numc, contact, address, final_q) 
            VALUES ($subId ,'$name', $nc, '$contact', '$address', '$ql')";

    if ($conn->query($sql) == TRUE) {
        echo "<script>alert('Registro Exitoso!');</script>";
        echo "<form id='redirectForm' action='subjectControl.php' method='post' style='display: none;'>
                <input type='hidden' name='user-id' value='$userId '>
                <input type='hidden' name='subject-id' value='$subId '>
              </form>
              <script> document.getElementById('redirectForm').submit(); </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if(isset($_POST['btn-consult'])){
    $editable = "readonly";
    $button.="<input type='submit' class='btn' id='btnAddStu' name='btnAddStu' style='display:none'";
    $stuId = $_POST['student-id'];
    $sql = "SELECT * FROM student WHERE id_stu='$stuId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student_data = $result->fetch_assoc();
    }
}

if(isset($_POST['btn-modify'])){
    $button.="<input type='submit' class='btn' name='btnUpdStu' value='Update'>";
    $editable = "";
    $stuId= $_POST['student-id'];
    $idEst = " <div class='input-box'>
                        <input type='hidden' name='student-id' value='$stuId'>
                </div>";

    $stuId = $_POST['student-id'];
    $sql = "SELECT * FROM student WHERE id_stu='$stuId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student_data = $result->fetch_assoc();
    }

}

if(isset($_POST['btnUpdStu'])){

    $userId = $_POST['user-id'];
    $subId = $_POST['subject-id'];

    $name = $_POST['stu-name'];
    $nc = $_POST['numC'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $ql = $_POST['finalQ'];

    $stuId = $_POST['student-id'];

    $sql = "UPDATE student SET fullname='$name', numc=$nc, contact='$contact',
    address='$address',final_q=$ql WHERE id_stu = $stuId";

    if ($conn->query($sql) == TRUE) {
        echo "<script>alert('Datos actualizados correctamente!');</script>";
       echo "<form id='redirectForm' action='subjectControl.php' method='post' style='display: none;'>
                <input type='hidden' name='user-id' value='$userId '>
                <input type='hidden' name='subject-id' value='$subId '>
              </form>
              <script> document.getElementById('redirectForm').submit(); </script>";
    } else {
        echo "<script>alert('Error al actualizar los datos: " . $conn->error . "');</script>";
    }
}


if(isset($_POST['btn-delete'])){

    $button.="<input type='submit' class='btn' name='btnDelStu' value='Delete'>";
    $editable = "";


    $stuId = $_POST['student-id'];
    
    $idEst = " <div class='input-box'>
                        <input type='hidden' name='student-id' value='$stuId'>
                </div>";

  
    $sql = "SELECT * FROM student WHERE id_stu='$stuId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student_data = $result->fetch_assoc();
    }
}

if(isset($_POST['btnDelStu'])){

    $stuId = $_POST['student-id'];

    $sql = "DELETE FROM student WHERE id_stu='$stuId'";

    if ($conn->query($sql) == TRUE) {
        echo "<script>alert('Estudiante eliminado correctamente!');</script>";
        echo "<form id='redirectForm' action='subjectControl.php' method='post' style='display: none;'>
        <input type='hidden' name='user-id' value='$userId '>
        <input type='hidden' name='subject-id' value='$subId '>
      </form>
      <script> document.getElementById('redirectForm').submit(); </script>";
    } else {
        echo "<script>alert('Error al eliminar el usuario: " . $conn->error . "');</script>";
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
    <title>RUDSUBJECT</title>
    <link rel="stylesheet" href="rudSubject.css">
</head>
<body>
        <div class="form-container">    

            <nav class="cont-subj">
               <h1>Students</h1>
                <form action="subjectControl.php" method="post">
                    <input type='hidden' name='user-id' value="<?php echo($userId) ?>">
                    <input type='hidden' name='subject-id' value="<?php echo($subId) ?>">
                    <input type="submit" id="btnSubj" class="btnSub" value="<-- Go Back">
                </form>
                
                <br> <br>

                <div class="add-sub">
                <form action="" method="post">

                    <div class="input-box">
                        <input type="hidden" name="subject-id" value="<?php echo($subId) ?>">
                    </div>

                    <div class="input-box">
                        <input type="hidden" name="user-id" value="<?php echo($userId) ?>">
                    </div>

                    <?php echo ($idEst) ?>

                    <div class="input-box">
                        <input type="text" placeholder="Student Name" name="stu-name" value="<?php echo($student_data['fullname']); ?>" required <?php echo($editable)?>>
                        <i class='bx bx-book list-icon'></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Control Number" name="numC" value="<?php echo($student_data['numc']); ?>" required <?php echo($editable)?>>
                        <i class='bx bxs-school list-icon' ></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Contact" name="contact" value="<?php echo($student_data['contact']); ?>" required <?php echo($editable)?>>
                        <i class='bx bx-rename list-icon' ></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Address" name="address" value="<?php echo($student_data['address']); ?>" required <?php echo($editable)?>>
                        <i class='bx bxs-award list-icon'></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Final Qualification" name="finalQ" value="<?php echo($student_data['final_q']); ?>" required <?php echo($editable)?>>
                        <i class='bx bxs-award list-icon'></i>
                    </div>

                    <?php echo $button;  ?>

                </form>
                </div>

            </nav>

        </div>
</body>
</html>