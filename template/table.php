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
  </style>
</head>
<body>

<form action="verify.php" method="post">
  <?php
  if (isset($tables)) {
    echo $tables;
  }
  ?>
  <input type="submit" value="Submit">
</form>

</body>
</html>
