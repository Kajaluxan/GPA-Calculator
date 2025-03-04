<?php
session_start();
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Results</title>
    <link rel="stylesheet" href="styleaddsem.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="name-card">
                <h2 id="studentName">
                <?php 
                    if(isset($_SESSION['email'])){
                        $email=$_SESSION['email'];
                        $query=mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.email='$email'");
                        while($row=mysqli_fetch_array($query)){
                            echo $row['firstName'].' '.$row['lastName'];
                        }
                    }
                ?> 
                </h2>
            </div>
            <div class="cgpa-card">
                <span style="font-weight: bold;"><h2>CGPA</h2></span>
                <div class="cgpa-circle" id="cgpaValue">3.44</div>
            </div>
        </div>

        <div class="semester-grid" id="semesterGrid">
            <!-- New Semester Cards will be added here -->
            <div class="add-semester" onclick="addSemester()">
                <div class="plus-icon">+</div>
            </div>
        </div>

    </div>
    <script>
        let semesterCount = 1;
        function addSemester() {
            const grid = document.getElementById('semesterGrid');

            const newSemester = document.createElement('div');
            newSemester.className = 'semester-card large';
            newSemester.innerHTML = `
                <h2>Semester ${semesterCount}</h2>
                <p>GPA: </p>
            `;

            const addButton = document.querySelector('.add-semester');
            grid.insertBefore(newSemester, addButton);
        }

    </script>

    
</body>
</html>

