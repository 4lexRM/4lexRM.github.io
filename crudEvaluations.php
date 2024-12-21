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
    'num_ev' => '',
    'topic_ev' => '',
    'date_ev' => ''
];


$userId = $_POST['user-id'];
$subId = $_POST['subject-id'];
$id_stu = '';


if(isset($_POST['btnEva'])){
    $button.="<input type='submit' class='btn' id='btnAddAct' name='btnAddEv' value='Add'>";
}

if(isset($_POST['btnAddEv'])){
    $userId = $_POST['user-id'];
    $subId = $_POST['subject-id'];
    
    $num = $_POST['eva-num'];
    $topic = $_POST['topicEva'];
    $date = $_POST['date'];


    $sql = "INSERT INTO evaluations (id_sub, num_ev, topic_ev, date_ev) 
            VALUES ($subId, '$num' ,'$topic', '$date')";

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

    $evId = $_POST['ev-id'];
    $sql = "SELECT * FROM evaluations WHERE id_ev='$evId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $activity_data = $result->fetch_assoc();
    }
}

if(isset($_POST['btn-modify'])){
    $editable = "";
    $button.="<input type='submit' class='btn' id='btnAddStu' name='btnUpdEv' value='Update'>";

    $evId = $_POST['ev-id'];

    $idEst = " <div class='input-box'>
                   <input type='hidden' name='ev-id' value='$evId'>
                </div>";

    $sql = "SELECT * FROM evaluations WHERE id_ev='$evId'";
    $result = $conn->query($sql);
            
    if ($result->num_rows > 0) {
        $activity_data = $result->fetch_assoc();
    }
}

if(isset($_POST['btnUpdEv'])){

    $userId = $_POST['user-id'];
    $subId = $_POST['subject-id'];

    $num = $_POST['eva-num'];
    $topic = $_POST['topicEva'];
    $date = $_POST['date'];


    $evId = $_POST['ev-id'];

    $sql = "UPDATE evaluations SET num_ev='$num', topic_ev='$topic', date_ev='$date' WHERE id_ev = $evId";

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
    $button.="<input type='submit' class='btn' id='btnAddStu' name='btnDelEv' value='Delete'>";

    $evId = $_POST['ev-id'];

    $idEst = " <div class='input-box'>
                   <input type='hidden' name='ev-id' value='$evId'>
                </div>";

    $sql = "SELECT * FROM evaluations WHERE id_ev='$evId'";
    $result = $conn->query($sql);
            
    if ($result->num_rows > 0) {
        $activity_data = $result->fetch_assoc();
    }
}

if(isset($_POST['btnDelEv'])){

    $evId = $_POST['ev-id'];

    $sql = "DELETE FROM evaluations WHERE id_ev='$evId'";

    if ($conn->query($sql) == TRUE) {
        echo "<script>alert('Evaluacion eliminada correctamente!');</script>";
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
    <title>CRUDEVAL</title>
    <link rel="stylesheet" href="rudSubject.css">
</head>
<body>
        <div class="form-container">    

            <nav class="cont-subj">
               <h1>Evaluations</h1>
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
                        <input type="text" placeholder="Evaluation Number" name="eva-num" value="<?php echo($activity_data['num_ev']); ?>" required <?php echo($editable)?>>
                        <i class='bx bx-book'></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Topic to Evaluate" name="topicEva" value="<?php echo($activity_data['topic_ev']); ?>" required <?php echo($editable)?>>
                        <i class='bx bxs-school' ></i>
                    </div>
                    <div class="input-box">
                        <input type="date" placeholder="Evaluation Date" name="date" value="<?php echo($activity_data['date_ev']); ?>" required <?php echo($editable)?>>
                    </div>


                    <?php echo ($button);  ?>

                </form>
                </div>

            </nav>

        </div>
</body>
</html>