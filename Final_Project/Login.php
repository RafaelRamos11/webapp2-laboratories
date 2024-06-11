<?php
// PHP CODE SYNTAX

require 'config.php'; //the principle of Separation of Concerns

//Database Connection
$dsn = "mysql:host=$host;dbname=$db;charset=UTF8"; // Data Source Name
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]; // $options sets PDO to throw exceptions on errors.

$error_message = ''; // Initialize the error message variable

try {
    $pdo = new PDO($dsn, $user, $password, $options); //PHP Data Object

    //Form Handling
    if ($pdo) {
        // echo "Connected to the $db database successfully";

        if ($_SERVER['REQUEST_METHOD'] === "POST") { // Indicating that the form has been submitted.
            $username = strtolower($_POST['username']); // Get the username from the form and convert to lowercase
            $password = $_POST['password']; // Get the password from the form

            $sql = "SELECT * FROM `users` WHERE username = :username"; // SQL query to select a user with the provided username ":username is a placeholder"
            $statement = $pdo->prepare($sql); // Prepare the SQL query to prevent SQL injection
            $statement->execute(['username' => $username]); // Execute the query with the provided username

            $user = $statement->fetch(PDO::FETCH_ASSOC); // Fetch the user data as an associative array

            if ($user) {
                if ($password === "Secret123") {
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['username'] = $user['username'];
                    header('Location: Posts.php'); // It is the same in the Window.location.href in JS

                    exit;
                } else {
                    $error_message = "Invalid Password!"; // If I input a wrong password it means invalid
                }
            } else {
                $error_message = "$username not found ";
            }
        }
    }
} catch (PDOException $e) {
    $error_message = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="Login.css" />
    <title>Login Page</title>
</head>

<body>
    <div class="container">
        <div class="title">LOGIN FORM</div>
        <form id="form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="field">
                <input type="text" name="username" required />
                <label for="type">Username</label>
            </div>
            <div class="field">
                <input type="password" name="password" required />
                <label for="type">Password</label>
            </div>
            <div class="field">
                <button type="submit">Login</button>
            </div>
        </form>
        <?php if ($error_message) : ?>
            <p id="error-message"><?php echo $error_message; ?></p>
        <?php endif; //it is use to close the 'if' statememt 
        ?>
    </div>
</body>

</html>