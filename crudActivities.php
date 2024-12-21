<?php

session_start(); 

$servername = "localhost";
$username = "root";
$password = "020903";
$dbname = "management";

$stdId = "";

$idEst ="";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$editable = "";
$button ="";

$activity_data = [
    'description' => '',
    'topic' => '',
    'start_date' => '',
    'end_date' => ''
];


$userId = $_POST['user-id'];
$subId = $_POST['subject-id'];
$id_stu = '';


if(isset($_POST['btnAct'])){
    $button.="<input type='submit' class='btn' id='btnAddAct' name='btnAddAct' value='Add'>";
}

if(isset($_POST['btnAddAct'])){
    $userId = $_POST['user-id'];
    $subId = $_POST['subject-id'];
    
    $desc = $_POST['desc'];
    $topic = $_POST['topic'];
    $start = $_POST['start'];
    $end = $_POST['end'];


    $sql = "INSERT INTO activities (id_sub, description, topic, start_date, end_date) 
            VALUES ($subId, '$desc' ,'$topic', '$start', '$end')";

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

    $actId = $_POST['act-id'];
    $sql = "SELECT * FROM activities WHERE id_act='$actId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $activity_data = $result->fetch_assoc();
    }
}

if(isset($_POST['btn-modify'])){
    $editable = "";
    $button.="<input type='submit' class='btn' id='btnAddStu' name='btnUpdStu' value='Update'>";

    $actId = $_POST['act-id'];

    $idEst = " <div class='input-box'>
                   <input type='hidden' name='act-id' value='$actId'>
                </div>";

    $sql = "SELECT * FROM activities WHERE id_act='$actId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $activity_data = $result->fetch_assoc();
    }
}

if(isset($_POST['btnUpdStu'])){

    $userId = $_POST['user-id'];
    $subId = $_POST['subject-id'];

    $desc = $_POST['desc'];
    $topic = $_POST['topic'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    $actId = $_POST['act-id'];

    $sql = "UPDATE activities SET description='$desc', topic='$topic', start_date='$start',
    end_date='$end' WHERE id_act = $actId";

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
    $editable = "";
    $button.="<input type='submit' class='btn' id='btnAddStu' name='btnDelStu' value='Delete'>";

    $actId = $_POST['act-id'];

    $idEst = " <div class='input-box'>
                   <input type='hidden' name='act-id' value='$actId'>
                </div>";

    $sql = "SELECT * FROM activities WHERE id_act='$actId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $activity_data = $result->fetch_assoc();
    }
}

if(isset($_POST['btnDelStu'])){

    $actId = $_POST['act-id'];

    $sql = "DELETE FROM activities WHERE id_act='$actId'";

    if ($conn->query($sql) == TRUE) {
        echo "<script>alert('Actividad eliminada correctamente!');</script>";
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
               <h1>Activities</h1>
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
                        <input type="text" placeholder="Acticity Description" name="desc" value="<?php echo($activity_data['description']); ?>" required <?php echo($editable)?>>
                        <i class='bx bx-book'></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Topic" name="topic" value="<?php echo($activity_data['topic']); ?>" required <?php echo($editable)?>>
                        <i class='bx bxs-school' ></i>
                    </div>
                    <div class="input-box">
                        <input type="date" placeholder="Start Date" name="start" value="<?php echo($activity_data['start_date']); ?>" required <?php echo($editable)?>>
                    </div>
                    <div class="input-box">
                        <input type="date" placeholder="End date" name="end" value="<?php echo($activity_data['end_date']); ?>" required <?php echo($editable)?>>
                    </div>

                    <?php echo ($button);  ?>

                </form>
                </div>

            </nav>

        </div>
</body>
</html>