<?php
#region
    $serverName = "localhost";
    $username = "root";
    $password = "Janetchew1";
#endregion

    session_start();

    // Grab the courseID from prev page, depends on if this is our first time on this page or not
    if (isset($_SESSION['courseID']) and $_POST['courseID'] == $_SESSION['courseID']){
        $courseID = $_SESSION['courseID'];
        //echo "SESSION";
    }
    else{
        $courseID = $_POST['courseID'];
        $_SESSION['courseID'] = $courseID;
        //echo "POST";
    }

    // This section will query the DB for all students in this section and output as a table
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try{
        $conn = new mysqli($serverName,$username,$password,"StudentGradesDB");
        if ($conn->connect_error){
            die("Connection Failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");
        
        //Grab all the grades for this course
        $sql = $conn->prepare("SELECT CourseTable.StudentID, CourseTable.CourseID, CourseTable.Test1,
        CourseTable.Test2, CourseTable.Test3, CourseTable.Exam, NameTable.StudentName FROM CourseTable
        INNER JOIN NameTable ON CourseTable.StudentID=NameTable.StudentID WHERE CourseID = ?");
        $sql->bind_param("s", $courseID);
        $sql->execute();

        $result = $sql->get_result();
        

        if($result->num_rows > 0){
            foreach($result as $val){

                if($result->num_rows > 0){
                    echo "<center><table style='border-collapse: collapse;'>";
                    echo "<tr><th style='border: 1px solid black; padding: 5px;'>Student Name</th><th style='border: 1px solid black; padding: 5px;'>Student ID</th><th style='border: 1px solid black; padding: 5px;'>Course ID</th><th style='border: 1px solid black; padding: 5px;'>Test 1</th><th style='border: 1px solid black; padding: 5px;'>Test 2</th><th style='border: 1px solid black; padding: 5px;'>Test 3</th><th style='border: 1px solid black; padding: 5px;'>Exam</th></tr>";
                    foreach($result as $val){
                        echo "<tr><td style='border: 1px solid black; padding: 5px;'>" . $val["StudentName"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["StudentID"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["CourseID"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["Test1"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["Test2"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["Test3"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["Exam"] . "</td></tr>";
                    }
                    echo "</table></center>";
                } else {
                    echo "DUD";
                }
            }
        }
        else{
            echo "DUD";
        }
        
    }
    catch(Exception $e){
        error_log($e->getMessage());
    }
    //$conn->close();


?>
<center><html style="background-color: #330072;">
    <head>
        <title>Page Title</title>
    </head>
    <body style="color: #f2a900;">

    <form action="UpdateGrades.php" method="POST">
        <br>
        <br>
        <br>
        <br>
        <br>
        
        <h1>Edit Student Grades</h1>

        <!-- <label>Student ID: </label>
        <input type="text" id="studentID", name="studentID"><br><br> -->

        <select name="studentID" id="studentID" required>
        <option selected="selected">Choose Student ID</option>
            <?php
                session_start();
#region
                $serverName = "localhost";
                $username = "root";
                $password = "Janetchew1";
#endregion
            
                // This section is for the inputing of student id and grades to be edited
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                $conn = new mysqli($serverName,$username,$password,"StudentGradesDB");
                if ($conn->connect_error){
                    die("Connection Failed: " . $conn->connect_error);
                }
                $conn->set_charset("utf8mb4");
            
                // Retrieve all the student IDs for this course
                $sql = $conn->prepare("SELECT CourseTable.StudentID FROM CourseTable
                INNER JOIN NameTable ON CourseTable.StudentID=NameTable.StudentID WHERE CourseID=?");
                $sql->bind_param("s", $courseID);
                $sql->execute();
                
                $result = $sql->get_result();

                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<option value='".$row["StudentID"]."'>".$row["StudentID"]."</option>";
                    }
                    echo "</select><br><br>";
                } else {
                    echo "No students found for this course.";
                }
                echo "<br><br>";
                echo "<label>Test 1: </label>";
                echo "<input type='number' id='test1Grade' min=0 max=100 name='test1Grade'><br><br>";

                echo "<label>Test 2: </label>";
                echo "<input type='number' id='test2Grade' min=0 max=100 name='test2Grade'><br><br>";

                echo "<label>Test 3: </label>";
                echo "<input type='number' id='test3Grade' min=0 max=100 name='test3Grade'><br><br>";

                echo "<label>Exam: </label>";
                echo "<input type='number' id='examGrade' min=0 max=100 name='examGrade'><br><br>";
                
                echo "<input type='hidden' name='courseID' value='$courseID'>";

                echo "<input type='submit' value='Submit'>";
                $conn->close();

            ?>
        
        </select>
    
    </form>
</html>
</center>

<center><html style="background-color: #330072;">
    <head>
        <title>Page Title</title>
    </head>
    <body style="color: #f2a900;">

    <form action="WelcomeForm.php">

        <input type="submit" value="Return">
    </form>

<html>
</center>