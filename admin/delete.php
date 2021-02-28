<?php
require 'database.php';

if (!empty($_GET['id'])) {
    $id = checkInput($_GET['id']);
}

if (!empty($_POST)) {
    $id = checkInput($_POST['id']);
    $db = Database::connect();
    $statement = $db->prepare("DELETE FROM items WHERE id=?");
    $statement->execute(array($id));
    Database::disconnect();
    header("Location: index.php");
}
function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Burger Menu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
          integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css"
          integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
            integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
            crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="js/script.js"></script>


</head>
<body>
<h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger <span
            class="glyphicon glyphicon-cutlery"></span></h1>

<div class="container admin">
    <div class="row">
        <h1><strong> Delete Items</strong></h1>
        <br>
        <form class="form" role="form" action="delete.php" method="post">

            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <p class="alert alert-warning"> Are you sure to delete this item ? </p>
            <div class="form-actions">
                <button type="submit" class="btn btn-warning"> YES</button>
                <a href="index.php" class="btn btn-primary"> NO</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>