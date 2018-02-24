<!doctype html>
<html lang="en">
  <head>
    <title>Laporan</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <script src="js/reporting_wrapper.js"></script>
  </head>
  <?php
  session_start();
  if(!isset($_SESSION["level"]) || $_SESSION["level"] != "B")
  {
    header("location: login.php?redirposition=reporting.php");
  }
  else
  { ?>
  <body>
    <div class="container">
    <h1>Laporan Pemasukan</h1>
    <a name="home" id="home" class="btn btn-dark btn-sm" href="index.php" role="button"><i class="fas fa-home"></i> Kembali ke menu awal</a>
    <br />
    <table class="table table-inverse table-responsive">
          <tbody>
            <tr>
              <td scope="row">Harian</td>
              <td><input type="date" id="dailypicker" /></td>
              <td><div id="daily_sum"></div></td>
            </tr>
            <tr>
              <td scope="row">Bulanan</td>
              <td><div id="monthreporting"></div></td>
              <td><div id="monthly_sum"></div></td>
            </tr>
            <tr id="monthlyspecs_wrapper" hidden>
              <td scope="row"></td>
              <td><div id="monthlyspecs"></div></td>
              <td></td>
            </tr>
            <tr>
              <td scope="row">Tahunan</td>
              <td><div id="yearreporting"></div></td>
              <td><div id="yearly_sum"></div></td>
            </tr>
          </tbody>
      </table>
    </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
  <?php
  }
  ?>
</html>