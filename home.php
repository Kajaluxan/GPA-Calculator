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
                <div class="cgpa-circle" id="cgpaValue">0.0</div>
            </div>
        </div>

        <div class="semester-grid" id="semesterGrid">
            <!-- Semester cards will be added here -->
            <div class="add-semester" onclick="location.href='addresult.php'">
                <div class="plus-icon">+</div>
            </div>
        </div>
    </div>

    <!-- Modal for semester details -->
    <div id="semesterModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle"></h2>
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Grade</th>
                        <th>Credits</th>
                    </tr>
                </thead>
                <tbody id="modalBody">
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>