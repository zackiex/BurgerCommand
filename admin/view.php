<?php
require 'database.php';

if (!empty($_GET['id'])) {
    $id = checkInput($_GET['id']);
}

$db = Database::connect();

$statement = $db->prepare('SELECT items.id, items.name, items.description, items.price,items.image,categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id =?');

$statement->execute(array($id));
$item = $statement->fetch();

Database::disconnect();

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
        <div class="col-sm-6">
            <h1><strong>Items Viewer</strong></h1>
            <br>
            <form>
                <div class="form-group">
                    <label>Name :</label><?php echo '  ' . $item['name']; ?>
                </div>
                <div class="form-group">
                    <label>Description :</label><?php echo '  ' . $item['description']; ?>
                </div>
                <div class="form-group">
                    <label>Price :</label><?php echo '  ' . number_format((float)$item['price'], 2, '.', ''); ?>
                </div>
                <div class="form-group">
                    <label>Category :</label><?php echo '  ' . $item['category']; ?>
                </div>
                <div class="form-group">
                    <label>Image :</label><?php echo '  ' . $item['image']; ?>
                </div>
            </form>

            <div class="form-actions">
                <a href="index.php" class="btn btn-primary">
                    <span class="glyphicon glyphicon-arrow-left"></span> Back
                </a>
            </div>


        </div>
        <div class="col-sm-6 col-md-4 site">
            <div class="thumbnail">
                <img src="<?php echo '../images/' . $item['image']; ?>" alt="..." style="width:100%">
                <div class="price"><?php echo '  ' . number_format((float)$item['price'], 2, '.', ''); ?> €</div>
                <div class="caption">
                    <h4><?php echo $item['name']; ?></h4>
                    <p><?php echo $item['description']; ?></p>
                    <a href="#" class="btn btn-order" role="button"><span
                                class="glyphicon glyphicon-shopping-cart"></span> Commander</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>