<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="Posts.css">
    <title>Posts Page</title>
</head>

<body>
    <div class="posts-container">
        <h1>Posts Page</h1>
        <ul id="postLists">
            <?php

            require 'config.php';

            //echo '<pre>';
            // print_r($_SESSION); //checking that the user exist 

            if (!isset($_SESSION['id'])) {
                header("Location: Login.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8"; // Data Source Name
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]; // $options sets PDO to throw exceptions on errors.

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) { // Check if the PDO connection is successful
                    $sql = "SELECT * FROM `posts` WHERE user_id = :id"; // SQL query to select posts for the logged-in user
                    $statement = $pdo->prepare($sql);
                    $statement->execute([':id' => $_SESSION['id']]); // galing sa Login session 

                    $lists = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($lists as $list) {
                        echo '<li><a href="Post.php?id=' . $list['id'] . '">' . $list['title'] . '</li>';
                    }
                }
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
            }
            ?>
        </ul>
        <!-- Logout Button -->
        <form action="Logout.php" method="POST" id="logout">
            <button type="submit">Logout</button>
        </form>
    </div>
</body>

</html>