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

    // Insert subjects into database
    $errors = [];
    foreach ($subjects as $subject) {
        if (isset($subject['name'], $subject['grade'], $subject['credits'])) {
            $name = $subject['name'];
            $grade = $subject['grade'];
            $credits = $subject['credits'];

            $insertQuery = "INSERT INTO course (sem, course_name, result, credits,user_id) 
                            VALUES ('$sem_no', '$name', '$grade', '$credits','$user_id')";
            
            if (!$conn->query($insertQuery)) {
                $errors[] = "Error inserting subject: " . $conn->error;
            }
        }
    }

    // If errors, display them; otherwise, show pop-up and redirect
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
        echo "<script>
                alert('Register Successful!');
                window.location.href = 'home.php';
              </script>";
        exit();
    }
}
?>
