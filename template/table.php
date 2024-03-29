<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>HTML test level 0</title>
  <style>
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
    th:nth-child(4n + 5), td:nth-child(4n+5), th:last-child, td:last-child {
      background-color: darkgray;
    }
  </style>
</head>
<body>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
  <?php
  if (isset($tablesRender)) {
    foreach ($tablesRender as $tablesRend) {
      echo $tablesRend;
    }
  }
  ?>
  <input type="submit" value="Add table" name="AddTable">
  <input type="submit" value="Submit" name="Validate" formaction="verify.php">
</form>
  <script src="/js.js"></script>
</body>
</html>
