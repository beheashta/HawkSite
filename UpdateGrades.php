<html style="background-color: #330072;">
</html>

<?php
#region
    $serverName = "localhost";
    $username = "root";
    $password = "Janetchew1";
#endregion

    session_start();
    //$courseID = $_POST['CourseID'];
    $studentID = $_POST["studentID"];
    $test1 = $_POST["test1Grade"];
    $test2 = $_POST["test2Grade"];
    $test3 = $_POST["test3Grade"];
    $exam = $_POST["examGrade"];

    
    //This section will update the student grade in the course table with the inputted values
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try{
        $conn = new mysqli($serverName,$username,$password,"StudentGradesDB");
        if ($conn->connect_error){
            die("Connection Failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");

        $course = $_SESSION["courseID"];

        $sql = $conn->prepare("UPDATE CourseTable
        SET Test1 = COALESCE(NULLIF(?, ''), Test1),
            Test2 = COALESCE(NULLIF(?, ''), Test2),
            Test3 = COALESCE(NULLIF(?, ''), Test3),
            Exam = COALESCE(NULLIF(?, ''), Exam)
        WHERE StudentID = ? AND CourseID = ?");
        $sql->bind_param("ssssss", $test1, $test2, $test3, $exam, $studentID, $course);
        $sql->execute();

        $result = $sql->get_result();


        // $sql = "SELECT TestCourseTable.StudentID, TestCourseTable.CourseID, TestCourseTable.Test1,
        //  TestCourseTable.Test2, TestCourseTable.Test3, TestCourseTable.Exam, TestNameTable.StudentName FROM TestCourseTable
        //  INNER JOIN TestNameTable ON TestCourseTable.StudentID=TestNameTable.StudentID WHERE CourseID='$course'";


        // $result = $conn->query($sql);

        // if($result->num_rows > 0){
        //     foreach($result as $val){

        //         if($result->num_rows > 0){
        //             echo "<table style='border-collapse: collapse;'>";
        //             echo "<tr><th style='border: 1px solid black; padding: 5px;'>Student Name</th><th style='border: 1px solid black; padding: 5px;'>Student ID</th><th style='border: 1px solid black; padding: 5px;'>Course ID</th><th style='border: 1px solid black; padding: 5px;'>Test 1</th><th style='border: 1px solid black; padding: 5px;'>Test 2</th><th style='border: 1px solid black; padding: 5px;'>Test 3</th><th style='border: 1px solid black; padding: 5px;'>Exam</th></tr>";
        //             foreach($result as $val){
        //                 echo "<tr><td style='border: 1px solid black; padding: 5px;'>" . $val["StudentName"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["StudentID"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["CourseID"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["Test1"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["Test2"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["Test3"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["Exam"] . "</td></tr>";
        //             }
        //             echo "</table>";
        //         } else {
        //             echo "DUD";
        //         }
        //     }
        // }
        // else{
        //     echo "DUD";
        // }

        
    }
    catch(Exception $e){
        error_log($e->getMessage());
    }
    $conn->close();


    if (isset($_SESSION['courseID'])) {
        $courseID = $_SESSION['courseID'];
        // Pass the CourseID back to the original PHP file
        echo '<form id="originalForm" action="InputGrades.php" method="POST">';
        echo "<input type='hidden' name='courseID' value='$courseID'>";
        echo '</form>';
        echo '<script>document.getElementById("originalForm").submit();</script>';
    }

?>

<!-- <html>
    <form action="GetFormData.php"></form>
</html> -->