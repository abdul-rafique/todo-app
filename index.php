<?php
    // Database connection
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "todo-app";

    $db_conn = mysqli_connect($db_host, $db_username, $db_password, $db_name) or die();

    if(mysqli_connect_error()){
        echo "<script>console.log('Database connection failed.')</script>";
    }

    echo "<script>console.log('Databse connected successfully.')</script>";

    // Adding todos to DB
    if(isset($_POST["submit"])){
        $todo = $_POST["todo"];
        $insQuery = "INSERT INTO tasks (body) VALUES ('$todo')";

        if(!empty($todo)){
            $insert = mysqli_query($db_conn, $insQuery);
            unset($todo);
            
            $reloadPage = $_SERVER["PHP_SELF"];
            
            header("Location: $reloadPage");
        }
        else{
            echo "<script>alert('Please write a task todo.')</script>";
        }
    }

    // Deleting todo from database
    if(isset($_GET["id"])){
        $id = $_GET["id"];

        $delQuery = "DELETE FROM tasks WHERE id = $id";

        $delete = mysqli_query($db_conn, $delQuery);

        $reloadPage = $_SERVER["PHP_SELF"];

        header("Location: $reloadPage");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Todo App</h1>
        <div class="form-wrap">
            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <div class="input-group">
                    <input type="text" name="todo" id="todo-input" class="form-control">
                    <button type="submit" name="submit" class="btn-add">Add Task</button>
                </div>
            </form>
        </div>
        <?php
            $selQuery = "SELECT * FROM tasks";
            $select = mysqli_query($db_conn, $selQuery);
            
            if(mysqli_num_rows($select) > 0){
                ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tasks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $a = 0;
                                    while($row = mysqli_fetch_assoc($select)){
                            ?>
                                    <tr>
                                        <td><?php echo $a += 1; ?></td>
                                        <td><?php echo $row["body"]; ?></td>
                                        <td>
                                            <a class="btn-del" href="index.php?id=<?php echo $row["id"] ?>">X</a>
                                        </td>
                                    </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
        <?php
            }

            else{
                echo "<div class='no-data'>
                    <img src='no-data.svg' alt='No Data Found' width='300' />
                    <h3>No Data Found</h3>
                </div>";
            }
        ?>
        <p class="copyright">Made with &#128151; by Abdul Rafique</p>
    </div>
</body>
</html>