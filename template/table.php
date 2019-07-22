<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>HTML test level 0</title>
  <style>
    .colored {
      background-color: darkgray;
    }
    input[type="number"] {
      width: 100%;
    }
    table {
      width: 100%;
      border: 1px solid black;
    }
    tr, td, th {
      border: 1px solid black;
    }
  </style>
</head>
<body>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
  <?php
  if (isset($tablesRender)) {
    if (is_array($tablesRender)) {
      foreach ($tablesRender as $tablesRend) {
        echo $tablesRend;
      }
    } else
      echo $tablesRender;
  }
  ?>
  <input type="submit" value="Add table" name="AddTable">
  <input type="submit" value="Submit" name="Validate" formaction="verify.php">
</form>

</body>
</html>
