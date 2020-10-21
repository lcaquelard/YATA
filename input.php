<?php
  require('DB.php');
  require('Travel.php');
  function populate_travel()
  {
    $db = new DB();
    $travel = new Travel($_POST['json']);
    $db->insert($travel->get_array());
  }

if (isset($_POST['json'])) {
  populate_travel();
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Travel input</title>
  </head>
  <body>
    <form method="post">
      <label for="json">Fill in a travel sequence in json:</label>
      <textarea id="json" name="json"></textarea>
      <input type="submit">
    </form>
  </body>
</html>
