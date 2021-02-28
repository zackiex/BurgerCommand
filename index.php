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

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/script.js"></script>


</head>
<body>
<div class="container site">
    <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger <span
                class="glyphicon glyphicon-cutlery"></span></h1>

    <?php
    require 'admin/database.php';
    echo '<nav>
		          <ul class="nav nav-pills">';
    $db = Database::connect();
    $statement = $db->query('SELECT * FROM categories');
    $categories = $statement->fetchAll();
    foreach ($categories as $category) {
        if ($category['id'] == '1') {
            echo '<li role="presentation" class="active"><a href="#' . $category['id'] . '"  data-toggle="tab">' . $category['name'] . '</a>
		  </li>';
        } else {
            echo '<li role="presentation">
		    <a href="#' . $category['id'] . '" data-toggle="tab">' . $category['name'] . '</a>
		  </li>';
        }
    }
    echo '</ul>
		  </nav>';
    echo '<div class="tab-content">';
    foreach ($categories as $category) {
        if ($category['id'] == '1')
            echo '<div class="tab-pane active" id="' . $category['id'] . '">';
        else
            echo '<div class="tab-pane" id="' . $category['id'] . '">';

        echo '<div class="row">';
        $statement = $db->prepare('SELECT * FROM items WHERE items.category = ?');
        $statement->execute(array($category['id']));
        while ($item = $statement->fetch()) {

            echo '<div class="col-sm-6 col-md-4">
						<div class="thumbnail">
							<img src="images/' . $item['image'] . '" alt="..." style="width:100%">
							<div class="price">' . number_format($item['price'], 2, '.', '') . ' €</div>
							<div class="caption">
								<h4>' . $item['name'] . '</h4>
								<p>' . $item['description'] . '</p>
								<a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>
							</div>
						</div>
					</div>';
        }
        echo '</div>
			</div>';
    }
    Database::disconnect();
    echo '</div>';
    ?>
</div>
</body>
</html>