<?php
  require('DB.php');
  require('Travel.php');

  $db = new DB();
  $travels = $db->fetch();
  $print = array();
  foreach ($travels as $id => $travel)
  {
    $otravel = new Travel($travel);
    $travels[$id] = $otravel;
    $print[] = $otravel->print();
  }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Travel display</title>
</head>
<body>
<div>
  <h1>List of the different travels</h1>
  <?php
    foreach($print as $key => $travel)
    {
      echo ("<h2>Travel $key</h2>");
      echo ($travel);
    }
  ?>
</div>
</body>
</html>