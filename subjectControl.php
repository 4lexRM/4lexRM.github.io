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


$idUser = $_POST['user-id'];
$idSubj = $_POST['subject-id'];


    //Students
    $sql_students = "SELECT * FROM student WHERE id_sub='$idSubj'";
    $result_students = $conn->query($sql_students);

    $allStudents = "";
    $allEvaluations = "";
    while ($student = $result_students->fetch_assoc()) {
        $idStu = $student['id_stu'];
        $name = $student['fullname'];
        $nc = $student['numc'];
        $contact= $student['contact'];
        $addres = $student['address'];
        $ql = $student['final_q'];

        $allStudents.= "
            <tr>
                <td>$name</td>
                <td>$nc</td>
                <td>$contact</td>
                <td> $addres</td>
                <td>$ql</td>
                <td>
                <form action='crudStudents.php' method='post' style='display:inline;'>
                    <input type='hidden' name='subject-id' value='$idSubj'>
                    <input type='hidden' name='user-id' value='$idUser'>
                    <input type='hidden' name='student-id' value='$idStu'>
                    <input type='submit' name='btn-consult' value='Consult' class='btn-small'>
                </form>
                </td>
                <td>
                <form action='crudStudents.php' method='post' style='display:inline;'>
                    <input type='hidden' name='subject-id' value='$idSubj'>
                    <input type='hidden' name='user-id' value='$idUser'>
                    <input type='hidden' name='student-id' value='$idStu'>
                    <input type='submit' name='btn-modify' value='Update' class='btn-small'>
                </form>
                </td>
                <td>
                <form action='crudStudents.php' method='post' style='display:inline;'>
                    <input type='hidden' name='subject-id' value='$idSubj'>
                    <input type='hidden' name='user-id' value='$idUser'>
                    <input type='hidden' name='student-id' value='$idStu'>
                    <input type='submit' name='btn-delete' value='Delete' class='btn-small'>
                </form>
                </td>
            </tr>";
        }

    //Activities
    $sql_students = "SELECT * FROM activities WHERE id_sub='$idSubj'";
    $result_students = $conn->query($sql_students);

    $allActivities = "";
    while ($student = $result_students->fetch_assoc()) {

        $idAct = $student['id_act'];
        $desc = $student['description'];
        $topic = $student['topic'];
        $start= $student['start_date'];
        $end = $student['end_date'];

        $allActivities.= "
            <tr>
                <td>$desc</td>
                <td>$topic</td>
                <td> $start</td>
                <td>$end</td>
                <td>
                <form action='crudActivities.php' method='post' style='display:inline;'>
                    <input type='hidden' name='subject-id' value='$idSubj'>
                    <input type='hidden' name='user-id' value='$idUser'>
                    <input type='hidden' name='act-id' value='$idAct'>
                    <input type='submit' name='btn-consult' value='Consult' class='btn-small'>
                </form>
                </td>
                <td>
                <form action='crudActivities.php' method='post' style='display:inline;'>
                    <input type='hidden' name='subject-id' value='$idSubj'>
                    <input type='hidden' name='user-id' value='$idUser'>
                    <input type='hidden' name='act-id' value='$idAct'>
                    <input type='submit' name='btn-modify' value='Update' class='btn-small'>
                </form>
                </td>
                <td>
                <form action='crudActivities.php' method='post' style='display:inline;'>
                    <input type='hidden' name='subject-id' value='$idSubj'>
                    <input type='hidden' name='user-id' value='$idUser'>
                    <input type='hidden' name='act-id' value='$idAct'>
                    <input type='submit' name='btn-delete' value='Delete' class='btn-small'>
                </form>
                </td>
            </tr>";
        }


         //Activities
    $sql_students = "SELECT * FROM evaluations WHERE id_sub='$idSubj'";
    $result_students = $conn->query($sql_students);


    while ($student = $result_students->fetch_assoc()) {

        $evId = $student['id_ev'];
        $num = $student['num_ev'];
        $topic = $student['topic_ev'];
        $date = $student['date_ev'];


        $allEvaluations.= "
            <tr>
                <td>$num</td>
                <td>$topic</td>
                <td> $date</td>
                <td>
                <form action='crudEvaluations.php' method='post' style='display:inline;'>
                    <input type='hidden' name='subject-id' value='$idSubj'>
                    <input type='hidden' name='user-id' value='$idUser'>
                    <input type='hidden' name='ev-id' value='$evId'>
                    <input type='submit' name='btn-consult' value='Consult' class='btn-small'>
                </form>
                </td>
                <td>
                <form action='crudEvaluations.php' method='post' style='display:inline;'>
                    <input type='hidden' name='subject-id' value='$idSubj'>
                    <input type='hidden' name='user-id' value='$idUser'>
                    <input type='hidden' name='ev-id' value='$evId'>
                    <input type='submit' name='btn-modify' value='Update' class='btn-small'>
                </form>
                </td>
                <td>
                <form action='crudEvaluations.php' method='post' style='display:inline;'>
                    <input type='hidden' name='subject-id' value='$idSubj'>
                    <input type='hidden' name='user-id' value='$idUser'>
                    <input type='hidden' name='ev-id' value='$evId'>
                    <input type='submit' name='btn-delete' value='Delete' class='btn-small'>
                </form>
                </td>
            </tr>";
        }


$conn->close(); // Cerrar conexión final
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Subject Control</title>
    <link rel="stylesheet" href="subjectControl.css">
</head>
<body>

    <div class="container">
        <nav class="ops">
            <ul class="list">
                <li class="list-item">
                    <div class="list-button">
                        <i class='bx bxs-user-detail list-icon'></i>
                        <a href="#" class="nav-link" id="students">Students</a>
                    </div>
                </li>
                <li class="list-item">
                    <div class="list-button">
                    <i class='bx bx-notepad list-icon'></i>
                        <a href="#" class="nav-link" id="activities">Activities</a>
                    </div>
                </li>
                <li class="list-item">
                    <div class="list-button">
                    <i class='bx bxs-blanket list-icon'></i>
                        <a href="#" class="nav-link" id="evaluations">Evaluations</a>
                    </div>
                </li>

            </ul>
        </nav>

        <div class="form-container"> 

            <nav class="cont cont-Stud">
                <div class="hdd">
                <form action="mainview.php" method="post">
                    <input type='hidden' name='user-id' value="<?php echo($idUser) ?>">
                    <input type="submit" id="btnSubj" class="btnSub" value="<-- Go Back">
                </form>
                <h1>Students</h1>
                </div>
                
                <form action="crudStudents.php" method="post">
                    <input type='hidden' name='subject-id' value='<?php echo($idSubj) ?>'>
                    <input type='hidden' name='user-id' value='<?php echo($idUser) ?>'>
                    <input type="submit" name="btnStud" class="btn" value="Add Student +"> 
                </form>
                
                <br> <br>
                <br> <br>

                <div class="add-Stud">
                    <table border="1">
                        <tr>
                            <th>Student Name</th>
                            <th>Control Number</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Qualification</th>
                            <th>C</th>
                            <th>M</th>
                            <th>D</th>
                        </tr>
                      
                        <?php echo $allStudents;  ?>

                    </table>
                </div>
            </nav>

            <nav class="cont cont-Act">
                <div class="hdd">
                <form action="mainview.php" method="post">
                    <input type='hidden' name='user-id' value="<?php echo($idUser) ?>">
                    <input type="submit" id="btnSubj" class="btnSub" value="<-- Go Back">
                </form>
                <h1>Activitie</h1>
                <form action="crudActivities.php" method="post">
                    <input type='hidden' name='subject-id' value='<?php echo($idSubj) ?>'>
                    <input type='hidden' name='user-id' value='<?php echo($idUser) ?>'>
                    <input type="submit" name="btnAct" class="btn" value="Add Activitie +"> 
                </form>
                
                <br> <br>
                <br> <br>

                <div class="add-Stud">
                    <table border="1">
                        <tr>
                            <th>Activity Desc</th>
                            <th>Topic</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th>C</th>
                            <th>M</th>
                            <th>D</th>
                        </tr>
                      
                        <?php echo $allActivities;  ?>

                    </table>
                </div>
            </nav>

            <nav class="cont cont-Eva">
            <div class="hdd">
            <form action="mainview.php" method="post">
                    <input type='hidden' name='user-id' value="<?php echo($idUser) ?>">
                    <input type="submit" id="btnSubj" class="btnSub" value="<-- Go Back">
                </form>
                <h1>Evaluations</h1>
                <form action="crudEvaluations.php" method="post">
                <input type='hidden' name='subject-id' value='<?php echo($idSubj) ?>'>
                <input type='hidden' name='user-id' value='<?php echo($idUser) ?>'>
                    <input type="submit" name="btnEva" class="btn" value="Add Evaluation +"> 
                </form>
                
                <br> <br>
                <br> <br>

                <div class="add-Eva">
              
                <div class="add-Stud">
                    <table border="1">
                        <tr>
                            <th>Number</th>
                            <th>Topic</th>
                            <th>Date</th>
                            <th>C</th>
                            <th>M</th>
                            <th>D</th>
                        </tr>
                      
                        <?php echo $allEvaluations;  ?>

                    </table>

                </div>
            </nav>

            

        </div>

    </div>

    <script src="subjectControl.js"></script>

</body>
</html>