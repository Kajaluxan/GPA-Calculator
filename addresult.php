<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Semester Result</title>
    <link rel="stylesheet" href="styleaddres.css">
</head>

<body>
    <div class="container">
        <h1>Add Semester Result</h1>
        <form method="post" id="resultForm" action="add.php">

            <!-- Semester Dropdown (Fixed name attribute) -->
            <div class="form-group">
                <label for="semester">Semester</label>
                <select id="semester" name="semester" required>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4">Semester 4</option>
                    <option value="5">Semester 5</option>
                    <option value="6">Semester 6</option>
                    <option value="7">Semester 7</option>
                    <option value="8">Semester 8</option>
                </select>
            </div>

            <!-- Subjects Section -->
            <div id="subjects">
                <!-- Subjects will be added here dynamically -->
            </div>

            <!-- Form Buttons -->
            <div class="actions">
                <button type="button" class="button button-outline" onclick="addSubject()">Add Subject</button>
                <button type="submit" id="savebutton" name="savebutton" class="button">Save Results</button>
            </div>

        </form>
        <a href="home.php" class="back-link">← Back to Results</a>
    </div>

    <script>
        let subjectCount = 0;

        // Function to add a subject form dynamically
        function addSubject() {
            subjectCount++;
            const subjectsDiv = document.getElementById('subjects');
            const subject = document.createElement('div');
            subject.className = 'subject';
            subject.innerHTML = `
                <div class="form-group">
                    <label>Subject ${subjectCount}</label>
                    <input type="text" name="course_name${subjectCount}" placeholder="Enter Course Name" required>
                </div>
                <div class="form-group">
                    <label>Grade</label>
                    <select name="result${subjectCount}" required>
                        <option value="A+">A+</option>
                        <option value="A">A</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B">B</option>
                        <option value="B-">B-</option>
                        <option value="C+">C+</option>
                        <option value="C">C</option>
                        <option value="C-">C-</option>
                        <option value="D">D</option>
                        <option value="F">F</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Credits</label>
                    <input type="number" name="credits${subjectCount}" min="1" max="6" value="2" required>
                </div>
            `;
            subjectsDiv.appendChild(subject);
        }

        // Automatically add the first subject field when the page loads
        window.onload = addSubject;
        
    </script>

</body>

</html>
