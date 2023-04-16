<center><html style="background-color: #330072;">
    <img src="https://students.wlu.ca/common/images/homepage/spotlights/reusable/golden-hawks-logo.jpg" alt="LaurierLogo" width="400" height="400">
    <head>
        <title>Page Title</title>
    </head>
    <body style="color: #f2a900;">

    <h1>Laurier Grade Database</h1><br>

    <form action="InputGrades.php" method="POST">
        <select name="courseID" id="courseID">
        <option selected="selected">Choose Course Code</option>

        <?php
        //This section gets all unique course IDs and sets them to the dropdown list

            session_start();
#region
            $serverName = "localhost";
            $username = "root";
            $password = "Janetchew1";
#endregion
        
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = new mysqli($serverName,$username,$password,"StudentGradesDB");
            if ($conn->connect_error){
                die("Connection Failed: " . $conn->connect_error);
            }
            $conn->set_charset("utf8mb4");
        
            // Retrieve all the student IDs for this course
            $sql = "SELECT DISTINCT CourseID FROM CourseTable";
            $result = $conn->query($sql);

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<option value='".$row["CourseID"]."'>".$row["CourseID"]."</option>";
                }
                //echo "</select><br><br>";
            } else {
                echo "Invalid Course Code.";
            }
            

        ?>
        </select>
        <input type="submit" value="Submit">
    </form>
</html>
</center>

<?php
#region
    $serverName = "localhost";
    $username = "root";
    $password = "Janetchew1";
#endregion

    // This section calculates the students final grade and outputs the final table
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try{
        $conn = new mysqli($serverName,$username,$password,"StudentGradesDB");
        if ($conn->connect_error){
            die("Connection Failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");


        //Grab all the grades for this course
        $sql = "SELECT 
            NameTable.StudentID, 
            NameTable.StudentName, 
            CourseTable.CourseID,

            ROUND((CourseTable.Test1*0.2 + CourseTable.Test2*0.2 + CourseTable.Test3*0.2) + (CourseTable.Exam * 0.4), 1) AS Final_Grade

        FROM 
            NameTable 
        JOIN 
            CourseTable
        ON 
            NameTable.StudentID = CourseTable.StudentID";

        $result = $conn->query($sql);

        if($result->num_rows > 0){
            foreach($result as $val){

                if($result->num_rows > 0){
                    echo "<center><table style='border-collapse: collapse;'>";
                    echo "<tr><th style='border: 1px solid black; padding: 5px;'>Student Name</th><th style='border: 1px solid black; padding: 5px;'>Student ID</th><th style='border: 1px solid black; padding: 5px;'>Course ID</th><th style='border: 1px solid black; padding: 5px; white-space: normal;'>Final grade (test 1,2,3-3x20%, final exam 40%)</th></tr>";                    
                    foreach($result as $val){
                        echo "<tr><td style='border: 1px solid black; padding: 5px;'>" . $val["StudentName"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["StudentID"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["CourseID"] . "</td><td style='border: 1px solid black; padding: 5px;'>" . $val["Final_Grade"] . "</td></tr>";
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
    $conn->close();
    
?>







