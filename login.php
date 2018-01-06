<!doctype html>
<html lang="en">
  <head>
    <title>Login ke system</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body>
        <?php
        session_start();
        if(!empty($_POST["username"]))
        {
            include_once("database_class.php");
            include_once("account_DAO.php");
            $connection = new Database();
            $accountDAO = new account_DAO($connection->getConnection());
            $username = $_POST["username"];
            $password = $_POST["password"];
            $hashed_password = hash("sha256",$password);
            $status = $accountDAO->login($username,$hashed_password);
            if(!$status)
            {
                echo "Login details incorrect";
            }
            else
            {
                $direction = $_GET["redirposition"];
                header("location: $direction");
            }
        }
        else
        {?>
        <div class="container">
                <form method="post">
                    <div class="form-group">
                      <label for="username"></label>
                      <input type="text" class="form-control" name="username" aria-describedby="helpId" placeholder="username" required>
                      <small id="helpId" class="form-text text-muted">Isi username</small>
                    </div>
                    <div class="form-group">
                      <label for="password"></label>
                      <input type="password" class="form-control" name="password" placeholder="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
            
        <?php }?>
        
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>