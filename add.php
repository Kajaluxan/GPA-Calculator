<?php

session_start();
include('connect.php');
$user_id = $_SESSION['user_id'];

if (isset($_POST['savebutton'])) {
    $sem_no = intval($_POST['semester']);
    $subjects = [];

    // Collect subject data
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'course_name') !== false) {
            $index = filter_var($key, FILTER_SANITIZE_NUMBER_INT);
            $subjects[$index]['name'] = $conn->real_escape_string($value);
        }
        if (strpos($key, 'result') !== false) {
            $index = filter_var($key, FILTER_SANITIZE_NUMBER_INT);
            $subjects[$index]['grade'] = $conn->real_escape_string($value);
        }
        if (strpos($key, 'credits') !== false) {
            $index = filter_var($key, FILTER_SANITIZE_NUMBER_INT);
            $subjects[$index]['credits'] = intval($value);
        }
    }

    // Insert subjects into the database
    $errors = [];
    foreach ($subjects as $subject) {
        if (isset($subject['name'], $subject['grade'], $subject['credits'])) {
            $name = $subject['name'];
            $grade = $subject['grade'];
            $credits = $subject['credits'];

            $insertQuery = "INSERT INTO course (sem, course_name, result, credits, user_id) 
                            VALUES ('$sem_no', '$name', '$grade', '$credits', '$user_id')";
            
            if (!$conn->query($insertQuery)) {
                $errors[] = "Error inserting subject: " . $conn->error;
            }
        }
    }

    // Now calculate the GPA for the semester
    $grade_points = [
        'A+' => 4.0, 'A' => 4.0, 'A-' => 3.7,
        'B+' => 3.3, 'B' => 3.0, 'B-' => 2.7,
        'C+' => 2.3, 'C' => 2.0, 'C-' => 1.7,
        'D+' => 1.3, 'D' => 1.0, 'F' => 0.0
    ];

    // Get all the subjects for the current semester
    $gpa_total_points = 0;
    $gpa_total_credits = 0;
    $selectQuery = "SELECT result, credits FROM course WHERE sem = '$sem_no' AND user_id = '$user_id'";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $grade = strtoupper($row['result']);
            $credits = (int) $row['credits'];

            if (isset($grade_points[$grade])) {
                $gpa_total_points += $grade_points[$grade] * $credits;
                $gpa_total_credits += $credits;
            }
        }
    }

    // Calculate the GPA
    if ($gpa_total_credits > 0) {
        $gpa = $gpa_total_points / $gpa_total_credits;
        $gpa1 = number_format($gpa, 2, '.', '');
        // Insert GPA into the semester table
        $insertSemsterQuery = "INSERT INTO semster (sem_id, gpa, tot_cre, user_id) 
                               VALUES ('$sem_no', '$gpa1', '$gpa_total_credits', '$user_id')";
        if ($conn->query($insertSemsterQuery)) {
            
            // Now calculate the CGPA (cumulative GPA)
            // Retrieve all the GPA records from the semester table for the user
            $cgpa_total_points = 0;
            $cgpa_total_credits = 0;
            $selectGpaQuery = "SELECT gpa, tot_cre FROM semster WHERE user_id = '$user_id'";
            $gpaResult = $conn->query($selectGpaQuery);

            if ($gpaResult->num_rows > 0) {
                while ($row = $gpaResult->fetch_assoc()) {
                    $cgpa_total_points += $row['gpa'] * $row['tot_cre'];
                    $cgpa_total_credits += $row['tot_cre'];
                }
            }

            // Calculate the CGPA
            if ($cgpa_total_credits > 0) {
                $cgpa = $cgpa_total_points / $cgpa_total_credits;
                $cgpa1 = number_format($cgpa, 2, '.', '');
            } else {
                $cgpa = 0.00;
            }

            // Update the user's CGPA (you can store this in the user's table or wherever appropriate)
            $updateCgpaQuery = "UPDATE users SET cgpa = '$cgpa1' WHERE id = '$user_id'";
            if ($conn->query($updateCgpaQuery)) {
                header("Location: home.php?result_added=true");
                exit();  // Stop further execution
            } else {
                $errors[] = "Error updating CGPA: " . $conn->error;
            }

        } else {
            $errors[] = "Error inserting GPA: " . $conn->error;
        }
    } else {
        $errors[] = "No credits found for GPA calculation.";
    }

}
?>
