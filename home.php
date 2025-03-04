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
                    if (isset($_SESSION['email'])) {
                        $email = $_SESSION['email'];
                        $query = mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.email='$email'");
                        while ($row = mysqli_fetch_array($query)) {
                            echo $row['firstName'] . ' ' . $row['lastName'];
                        }
                    }
                    ?>
                </h2>
            </div>
            <div class="cgpa-card">
                <span style="font-weight: bold;"><h2>CGPA</h2></span>
                <div class="cgpa-circle" id="cgpaValue">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $query = mysqli_query($conn, "SELECT cgpa FROM `users` WHERE users.id='$user_id'");
                        while ($row = mysqli_fetch_array($query)) {
                            echo $row['cgpa'] ;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="semester-grid" id="semesterGrid">
            <?php

                $user_id = $_SESSION['user_id'] ?? null;

                if ($user_id) {
                    $semesters_query = mysqli_query($conn, "SELECT sem_id, gpa FROM semster WHERE user_id='$user_id' ORDER BY sem_id ASC");

                    while ($semester = mysqli_fetch_array($semesters_query)) {
                        $sem_id = $semester['sem_id'];
                        $gpa = $semester['gpa'];
                        echo "<div class='semester-card'>
                                <h2>Semester $sem_id</h2>
                                <p>GPA: $gpa</p>
                              </div>";
                    }
                }
            ?>
            <div class="add-semester" onclick="window.location.href='addresult.php';">
                <div class="plus-icon">+</div>
            </div>
            
        </div>

    </div>


</body>
</html>
