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
        <h1><strong>Items Liste </strong><a href="insert.php" class="btn btn-success btn-lg"><span
                        class="glyphicon glyphicon-plus"></span> Add </a></h1>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Categories</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            require 'database.php';
            $db = Database::connect();
            $statement = $db->query('SELECT items.id, items.name, items.description, items.price,categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id ORDER BY items.id DESC');
            while ($item = $statement->fetch()) {
                echo '<tr>';
                echo '<td>' . $item['name'] . '</td>';
                echo '<td>' . $item['description'] . '</td>';
                echo '<td>' . number_format((float)$item['price'], 2, '.', '') . '</td>';
                echo '<td>' . $item['category'] . '</td>';
                echo '<td width="300">';
                echo '<a href="view.php?id=' . $item['id'] . '" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span> View</a>';
                echo '  ';
                echo '<a href="update.php?id=' . $item['id'] . '" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Update</a>';
                echo '  ';
                echo '<a href="delete.php?id=' . $item['id'] . '" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Delete</a>';
                echo '</td>';
                echo '</tr>';

            }
            Database::disconnect();
            ?>

            </tbody>
        </table>
    </div>
</div>
</body>
</html>