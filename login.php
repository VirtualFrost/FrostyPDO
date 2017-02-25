<?php
    session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "pdologin";
    $message = "";
    try
    {
        $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(isset($_POST["login"]))
        {
            if(empty($_POST["username"]) || empty($_POST["password"]))
            {
                $message = '<label>All fields are required</label>';
            }
            else
            {
                $query = "SELECT * FROM users WHERE username = :username AND password = :password";
                $statement = $connect->prepare($query);
                $statement->execute(
                    array(
                        'username'     =>     $_POST["username"],
                        'password'     =>     $_POST["password"]
                    )
                );
                $count = $statement->rowCount();
                if($count > 0)
                {
                    $_SESSION["username"] = $_POST["username"];
                    header("location:index.php");
                }
                else
                {
                    $message = '<label>Wrong Data</label>';
                }
            }
        }
    }
    catch(PDOException $error)
    {
        $message = $error->getMessage();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="A custom Login panel made with PDO.">
        <meta name="author" content="VirtualFrost">

        <title>VirtualFrost PDO Login Page</title>
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <!-- Bootstrap 3.3.7 JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- FontAwesome Fonts -->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Custom Styling -->
        <link href="style.css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Username" name="username" type="text">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password">
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        </label>
                                    </div>
                                    <button type="submit" name="login" class="btn btn-success btn-lg btn-block">Sign In</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
