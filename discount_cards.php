<!doctype html>
<html lang="en">
  <head>
    <title>Daftar Kartu Diskon</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
      <?php
      session_start();
      include_once("vendor/autoload.php");
      krumo::disable();
      if(!isset($_SESSION["level"]) || $_SESSION["level"] != "B")
      {
        header("location: login.php?redirposition=discount_cards.php");
      }
      include_once("database_class.php");
      include_once("DAO/discount_card_DAO.php");
      $connection = new Database();
      krumo($connection);
      $discount_card_DAO = new discount_card_DAO($connection->getConnection());
      krumo($discount_card_DAO);
      
      krumo($result);
      if(empty($_POST["check"]))
      {?>
      <div class="container">
          <h1>Daftar Kartu Diskon</h1>
          <a name="new_card" id="new_card" class="btn btn-primary" href="new_discount_card.php" role="button"><i class="fa fa-address-book" aria-hidden="true"></i>Registrasi Kartu Diskon Baru</a>
          <a name="home" id="home" class="btn btn-secondary" href="index.php" role="button"><i class="fa fa-home" aria-hidden="true"></i> Kembali ke menu awal</a>
          <form action="discount_cards.php" method="post"></form>
          <table class="table">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Nomor Telepon</th>
                      <th>Hapus?</th>
                  </tr>
              </thead>
              <tbody>
      <?php
            $result = $discount_card_DAO->list_all_cards();
          for($i = 0;$i <$result->rowCount();$i++)
          {
              $currentRow = $result->getNext(new discount_card_DAO($connection->getConnection()),$i);
          ?>
              <tr>
                  <td scope="row"><?php echo $currentRow->discount_id;?></td>
                  <td><?php echo $currentRow->discount_phone;?></td>
                <td><div class="form-check">
                  <input type="checkbox" class="form-check-input" name="check[]" value="<?php echo $currentRow->discount_id; ?>">
              </div></td>
              </tr>
          <?php };?>
              </tbody>
          </table>
          <button type="submit" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Hapus kartu diskon</button>
          </form>
      </div>
          <?php }
          else
          {
            foreach($_POST["check"] as $id)
            {
                $discount_card_DAO->remove_card($id);
                echo "Kartu $id telah dihapus dari database<br />";
            }?>
        <a name="home" id="home" class="btn btn-secondary" href="index.php" role="button"><i class="fa fa-home" aria-hidden="true"></i> Kembali ke menu awal</a>
          <?php } ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>