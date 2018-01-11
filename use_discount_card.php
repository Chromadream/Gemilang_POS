<!doctype html>
<html lang="en">
  <head>
    <title>Kartu Diskon</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="js/discount_wrapper.js"></script>
  </head>
  <body>
  <?php 
    session_start();
    if(!isset($_SESSION["level"]) || ($_SESSION["level"] != "B" && $_SESSION["level"] != "T"))
    {
      header("location: login.php?redirposition=invoice.php?mode=".$_GET["tid"]);
    }?>
    <div class="container">
        <h1>Kartu Diskon</h1>
        <div class="form-group">
          <label for="cardid">Cari berdasarkan ID</label>
          <input type="text" class="form-control" id="cardid" placeholder="ID kartu">
          <button type="button" onclick="search_by_id(<?php echo $_GET['tid'];?>)" class="btn btn-danger" btn-lg btn-block>Apply</button>
          <div id="idresult"></div>
        </div>
        <br />
        <br />
        <div class="form-group">
          <label for="phoneid">Cari berdasarkan Nomor Telepon</label>
          <input type="text" class="form-control" id="phonenum" placeholder="ID kartu">
          <button type="button" onclick="search_by_phone(<?php echo $_GET['tid'];?>)" class="btn btn-danger" btn-lg btn-block>Apply</button>
          <div id="phresult"></div>
        </div>
    </div>
    
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>