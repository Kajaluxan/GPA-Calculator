<?php
session_start();
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Academic Results</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            background-color: #f0f4f9;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            gap: 20px;
        }

        .name-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex: 1;
            height: 120px;
        }

        .name-card h2 {
            font-size: 24px;
            color: #333;
            font-weight: 600;
            line-height: 1.6; 
        }

        .cgpa-card {
            background: white;
            padding: 20px 40px;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            height: 120;
        }

        .cgpa-label {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .cgpa-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #4B9BFF;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 600;
        }

        .semester-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .semester-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.2s;
        }

        .semester-card:hover {
            transform: translateY(-5px);
        }

        .semester-card h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .semester-card p {
            color: #666;
            font-size: 16px;
        }

        .add-semester {
            background: #4B9BFF;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 40px;
            transition: transform 0.2s;
        }

        .add-semester:hover {
            transform: translateY(-5px);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow-y: auto;
        }

        .modal-content {
            background: white;
            margin: 50px auto;
            padding: 40px;
            width: 90%;
            max-width: 800px;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .close-btn {
            position: absolute;
            top: 25px;
            right: 25px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        /* Update modal header */
        .result-header {
            margin-bottom: 40px;
            text-align: center;
        }

        .result-header h2 {
            font-size: 32px;
            color: #4B9BFF;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .result-header p {
            color: #666;
            font-size: 16px;
        }

        /* Update table styles */
        .result-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 40px;
            border-radius: 8px;
            overflow: hidden;
        }

        .result-table thead {
            background-color: #4B9BFF;
        }

        .result-table th {
            padding: 16px 24px;
            text-align: left;
            color: white;
            font-weight: 500;
            font-size: 16px;
        }

        .result-table td {
            padding: 16px 24px;
            font-size: 15px;
            color: #333;
        }

        .result-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .result-table tbody tr:hover {
            background-color: #f0f4f9;
        }

        /* Update summary section */
        .result-summary {
            background-color: #f8f9fa;
            padding: 24px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .result-summary-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .result-summary-label {
            color: #4B9BFF;
            font-weight: 700;
            font-size: 18px;
        }

        .result-summary-value {
            color: #333;
            font-size: 18px;
        }

        /* Simplified grade badge styles */
        .grade-a-plus, .grade-a, .grade-a-minus {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 500;
            display: inline-block;
            width: 40px;
            text-align: center;
        }

        .grade-b-plus, .grade-b, .grade-b-minus {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 500;
            display: inline-block;
            width: 40px;
            text-align: center;
        }

        .grade-c-plus, .grade-c, .grade-c-minus {
            background-color: #fff3e0;
            color: #f57c00;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 500;
            display: inline-block;
            width: 40px;
            text-align: center;
        }

        .grade-d-plus, .grade-d, .grade-d-minus,
        .grade-f {
            background-color: #ffebee;
            color: #c62828;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 500;
            display: inline-block;
            width: 40px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
            }

            .cgpa-card {
                width: 100%;
            }

            .modal-content {
                width: 95%;
                margin: 20px auto;
            }
            
            .result-summary {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="name-card">
                <h2>Hello </h2>
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
                !</h2>
            </div>
            <div class="cgpa-card">
                <span class="cgpa-label">CGPA</span>
                <div class="cgpa-circle" id="cgpaValue">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $query = mysqli_query($conn, "SELECT cgpa FROM `users` WHERE id='$user_id'");
                        while ($row = mysqli_fetch_array($query)) {
                            echo $row['cgpa'];
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
                    $semesters_query = mysqli_query($conn, "SELECT sem_id, gpa FROM semester WHERE user_id='$user_id' ORDER BY sem_id ASC");

                    while ($semester = mysqli_fetch_array($semesters_query)) {
                        $sem_id = $semester['sem_id'];
                        $gpa = $semester['gpa'];
                        echo "<div class='semester-card' onclick=\"openModal('semester$sem_id')\">
                                <h2>Semester $sem_id</h2>
                                <p>GPA: $gpa</p>
                              </div>";

                        echo "<div id='semester$sem_id' class='modal'>
        <div class='modal-content'>
            <span class='close-btn' onclick=\"closeModal('semester$sem_id')\">&times;</span>
            <div class='result-header'>
                <h2>Semester $sem_id Results</h2>
                <p>Your academic performance for this semester</p>
            </div>
            <table class='result-table'>
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Credits</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>";

$results_query = mysqli_query($conn, "SELECT course_name, credits, result FROM course WHERE user_id='$user_id' AND sem='$sem_id'");

$total_credits = 0;
while ($result = mysqli_fetch_array($results_query)) {
    $course_name = $result['course_name'];
    $credits = $result['credits'];
    $grade = strtolower($result['result']);
    $grade_class = str_replace('+', '-plus', str_replace('-', '-minus', $grade));

    $total_credits += $credits;

    echo "<tr>
            <td>$course_name</td>
            <td>$credits</td>
            <td><span class='grade-$grade_class'>$result[result]</span></td>
          </tr>";
}

// Calculate standing based on GPA
$standing = '';
if ($gpa >= 3.5) {
    $standing = 'Excellent';
} elseif ($gpa >= 3.0) {
    $standing = 'Very Good';
} elseif ($gpa >= 2.5) {
    $standing = 'Good';
} else {
    $standing = 'Satisfactory';
}

echo "</tbody>
    </table>
    <div class='result-summary'>
        <div class='result-summary-item'>
            <span class='result-summary-label'>Total Credits:</span>
            <span class='result-summary-value'>$total_credits</span>
        </div>
        <div class='result-summary-item'>
            <span class='result-summary-label'>GPA:</span>
            <span class='result-summary-value'>$gpa</span>
        </div>
        <div class='result-summary-item'>
            <span class='result-summary-label'></span>
            <span class='result-summary-value'></span>
        </div>
    </div>
</div>
</div>";
                    }
                }
            ?>
            <div class="add-semester" onclick="window.location.href='addresult.php';">
                +
            </div>
        </div>
    </div>

    <script>
        // Function to open modal
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        }
        
        // Function to close modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }
        
        // Close modal when clicking outside of modal content
        window.onclick = function(event) {
            const modals = document.getElementsByClassName('modal');
            for (let i = 0; i < modals.length; i++) {
                if (event.target === modals[i]) {
                    modals[i].style.display = "none";
                    document.body.style.overflow = 'auto';
                }
            }
        }
        
        // Add escape key support to close modals
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modals = document.getElementsByClassName('modal');
                for (let i = 0; i < modals.length; i++) {
                    if (modals[i].style.display === 'block') {
                        modals[i].style.display = 'none';
                        document.body.style.overflow = 'auto';
                    }
                }
            }
        });
    </script>
</body>
</html>