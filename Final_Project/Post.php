<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Post.css">
    <title>Post Page</title>
</head>

<body>
    <div class="post-container">
        <h1>POST PAGE</h1>
        <div id="postDetails">
            <?php
            require 'config.php';

            if (!isset($_SESSION['id'])) {
                header("Location: Login.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                    $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    if (isset($_GET['id'])) { // Check if the 'id' parameter is set in the URL
                        $id = $_GET['id'];  // Get the 'id' parameter from the URL

                        $sql = "SELECT * FROM `posts` WHERE id = :id";
                        $statement = $pdo->prepare($sql);
                        $statement->execute([':id' => $id]);

                        $post = $statement->fetch(PDO::FETCH_ASSOC);

                        if ($post) {
                            echo '<h3 class="title">Title: ' . $post['title'] . '</h3>';
                            echo '<p class="post-body">Body: ' . $post['body'] . '</p>';
                        } else {
                            echo "$id is not found in the Posts!";
                        }
                    } else {
                        echo "No post ID provided!";
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>

            <!-- Back to Posts Page Link (PHP) -->
            <a href="Posts.php" id="back">Back to Posts Page</a>
        </div>
    </div>
</body>

</html>