<!doctype html>
<html lang="en">
  <head>
    <title>New User Creation</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body>
        <?php
        include("vendor/autoload.php");
        if(!empty($_POST["username"]))
        {
            include_once("database_class.php");
            include_once("account_DAO.php");
            $connection = new Database();
            if($connection->checkConnection())
            {
                krumo($connection->getConnection());
                $accountDAO = new account_DAO();
                $accountDAO->connect($connection->getConnection());
                krumo($accountDAO);
                $username = $_POST["username"];
                $password = $_POST["password"];
                $hashed_password = hash("sha256",$password);
                $role = $_POST["role"];
                $result = $accountDAO->new_user($username,$hashed_password,$role);
                echo $result." account is successfully created.";
            }
            else
            {
                echo "connection to database is failed";
            }
        }
        else
        {?>
            <div class="container">
                <form method="post">
                    <div class="form-group">
                        <label for="usernamelabel">Username</label>
                        <input type="text" class="form-control" name="username" aria-describedby="helpId" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                    <label for="Passwordlabel">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="password" required>
                    </div>
                    <div class="form-group">
                    <label for="Role"></label>
                    <select class="form-control" name="role">
                        <option value="B">Boss Mode</option>
                        <option value="T">Transactional Limited Account</option>
                        <option value="S">Stockkeeping Limited Account</option>
                    </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create account</button>
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