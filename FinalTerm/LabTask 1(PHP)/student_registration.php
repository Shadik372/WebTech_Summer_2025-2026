<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Registration Form</title>
</head>
<body>
    <h2>Student Registration Form</h2>
<?php
$fullName = $username = $email = $phone = $age = $studentID = $website = $dob = "";
$errors = array();
$studentName = "";
$success = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["fullName"])) {
        $errors["fullName"] = "Full Name is required";
    } else {
        $fullName = $_POST["fullName"];
        if (!preg_match("/^[a-zA-Z ]+$/", $fullName)) {
            $errors["fullName"] = "Only letters and spaces allowed";
        } elseif (strlen($fullName) < 3) {
            $errors["fullName"] = "Must be at least 3 characters";
        } elseif (strlen($fullName) > 50) {
            $errors["fullName"] = "Must not exceed 50 characters";
        }
    }



// It ensures the entire string consists of one or more letters (A–Z, a–z) and spaces from start to finish.

if (empty($_POST["username"])) {
        $errors["username"] = "Username is required";
    } else {
        $username = $_POST["username"];
        if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
            $errors["username"] = "Only letters, numbers, and underscore allowed";
        } elseif (strlen($username) < 5 || strlen($username) > 15) {
            $errors["username"] = "Must be between 5 and 15 characters";
        } elseif (!preg_match("/^[a-zA-Z]/", $username)) {
            $errors["username"] = "Must start with a letter";
        }
    }

// It verifies that the username is not empty and starts with a letter and it contains only alphanumeric characters or underscores and it is between 5 and 15 characters long.

if (empty($_POST["email"])) {
        $errors["email"] = "Email is required";
    } else {
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Invalid email format";
        } elseif (!preg_match("/\.(com|org|edu)$/i", $email)) {
            $errors["email"] = "Email must end with .com, .org, or .edu";
        }
    }

// It verifies that if the email is provided and follows a standard email format and ends with a .com, .org, or .edu domain .

if (empty($_POST["phone"])) {
        $errors["phone"] = "Phone Number is required";
    } else {
        $phone = $_POST["phone"];
        if (!ctype_digit($phone)) {
            $errors["phone"] = "Digits only";
        } elseif (substr($phone, 0, 2) != "01") {
            $errors["phone"] = "Must start with 01";
        } elseif (strlen($phone) != 11) {
            $errors["phone"] = "Must be exactly 11 digits";
        }
    }

// It verifies that a required phone number is exactly 11 digits starting with "01" and used  `!ctype_digit` to  confirm every character is a numeric digit.

     if (empty($_POST["age"])) {
        $errors["age"] = "Age is required";
    } else {
        $age = $_POST["age"];
        if (!is_numeric($age)) {
            $errors["age"] = "Age must be numeric";
        } elseif ($age < 18 || $age > 30) {
            $errors["age"] = "Age must be between 18 and 30";
        }
    }
// It verifies that provided age is numeric and it stays between 18 and 30

    $password = $_POST["password"];
    if (empty($password)) {
        $errors["password"] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors["password"] = "Must be at least 8 characters";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $errors["password"] = "Must contain an uppercase letter";
    } elseif (!preg_match("/[0-9]/", $password)) {
        $errors["password"] = "Must contain a digit";
    } elseif (!preg_match("/[@#\$%]/", $password)) {
        $errors["password"] = "Must contain one of @ # \$ %";
    }

// It verifies that a required password is at least 8 characters long and contains at least one uppercase letter, one digit, and one special character.

    $confirmPassword = $_POST["confirmPassword"];
    if (empty($confirmPassword)) {
        $errors["confirmPassword"] = "Confirm Password is required";
    } elseif ($confirmPassword != $password) {
        $errors["confirmPassword"] = "Passwords do not match";
    }
// It matches confirmPassword with password

    if (empty($_POST["studentID"])) {
        $errors["studentID"] = "Student ID is required";
    } else {
        $studentID = $_POST["studentID"];
        if (!preg_match("/^\d{2}-\d{5}-\d{1}$/", $studentID)) {
            $errors["studentID"] = "Format must be XX-XXXXX-X";
        }
    }
// It verifies that  student ID is required and it  follows the exact format XX-XXXXX-X.

if (empty($_POST["website"])) {
        $errors["website"] = "Website is required";
    } else {
        $website = $_POST["website"];
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $errors["website"] = "Invalid URL";
        } elseif (!preg_match("#^https?://#", $website)) {
            $errors["website"] = "Must start with http:// or https://";
        }
    }

// It verifies that website URL is required and formatted with either http:// or https:// .

if (empty($_POST["dob"])) {
        $errors["dob"] = "Date of Birth is required";
    } else {
        $dob = $_POST["dob"];
    }
// It verifies that if  date of birth is provided    

    $studentName = $fullName;

    if (empty($errors)) {
        $success = true;
    }

 // It assigns the full name to a student name variable and sets a success flag if no validation errors were found in the form.

}
?>

<?php if ($success): ?>

    <h3>Registration Successful!</h3>
    Full Name: <?php echo htmlspecialchars($studentName); ?><br>
    Username: <?php echo htmlspecialchars($username); ?><br>
    Student ID: <?php echo htmlspecialchars($studentID); ?><br>
    Email Address: <?php echo htmlspecialchars($email); ?><br>

<?php else: ?>

<form method="post" action="">

    Full Name:
    <input type="text" name="fullName" value="<?php echo htmlspecialchars($fullName); ?>">
    <span style="color:red">* <?php echo $errors["fullName"] ?? ""; ?></span>
    <br><br>

    Username:
    <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
    <span style="color:red">* <?php echo $errors["username"] ?? ""; ?></span>
    <br><br>

    Email:
    <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
    <span style="color:red">* <?php echo $errors["email"] ?? ""; ?></span>
    <br><br>

    Phone Number:
    <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
    <span style="color:red">* <?php echo $errors["phone"] ?? ""; ?></span>
    <br><br>

    Age:
    <input type="text" name="age" value="<?php echo htmlspecialchars($age); ?>">
    <span style="color:red">* <?php echo $errors["age"] ?? ""; ?></span>
    <br><br>

    Password:
    <input type="password" name="password" value="">
    <span style="color:red">* <?php echo $errors["password"] ?? ""; ?></span>
    <br><br>

    Confirm Password:
    <input type="password" name="confirmPassword" value="">
    <span style="color:red">* <?php echo $errors["confirmPassword"] ?? ""; ?></span>
    <br><br>

    Student ID:
    <input type="text" name="studentID" value="<?php echo htmlspecialchars($studentID); ?>">
    <span style="color:red">* <?php echo $errors["studentID"] ?? ""; ?></span>
    <br><br>

    Personal Website:
    <input type="text" name="website" value="<?php echo htmlspecialchars($website); ?>">
    <span style="color:red">* <?php echo $errors["website"] ?? ""; ?></span>
    <br><br>

    Date of Birth:
    <input type="text" name="dob" value="<?php echo htmlspecialchars($dob); ?>">
    <span style="color:red">* <?php echo $errors["dob"] ?? ""; ?></span>
    <br><br>

    <input type="submit" name="submit" value="Register">

</form>
<?php endif; ?>

<!-- 1. It converts special characters into safe HTML entities to prevent Cross-Site Scripting attacks.
2. It is still needed because HTML client-side validation can be easily bypassed, disabled, or manipulated by malicious users.
3. Password Validation: A required password field where it is checking if it is empty and it must happen before checking length or regex patterns -->

</body>
</html>