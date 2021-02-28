<?php
require 'database.php';
$nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";

if (!empty($_POST)) {
    $name = checkInput($_POST['name']);
    $description = checkInput($_POST['description']);
    $price = checkInput($_POST['price']);
    $category = checkInput($_POST['category']);
    $image = checkInput($_FILES['image']['name']);
    $imagePath = '../images/' . basename($image);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess = true;
    $isUploadSuccess = false;
}

if (empty($name)) {
    $nameError = 'This field is required';
    $isSuccess = false;
}

if (empty($description)) {
    $descriptionError = 'This field is required';
    $isSuccess = false;
}

if (empty($price)) {
    $priceError = 'This field is required';
    $isSuccess = false;
}

if (empty($category)) {
    $categoryError = 'This field is required';
    $isSuccess = false;
}

if (empty($image)) {
    $imageError = 'This field is required';
    $isSuccess = false;
} else {
    $isUploadSuccess = true;
    if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif") {
        $imageError = "Invalid Extension";
        $isUploadSuccess = false;
    }
    if (file_exists($imagePath)) {
        $imageError = "File already exists";
        $isUploadSuccess = false;
    }
    if ($_FILES["image"]["size"] > 3000000) {
        $imageError = "File must not exceed 3 MB";
        $isUploadSuccess = false;
    }
    if ($isUploadSuccess) {
        if (!move_uploaded_file($FILES["image"]["tmp_name"], $imagePath)) {
            $imageError = "Upload Error!";
            $isUploadSuccess = false;
        }
    }
}

if ($isSuccess && $isUploadSuccess) {
    $db = Database::connect();
    $statement = $db->prepare("INSERT INTO items(name,description,price,category,image) values(?,?,?,?,?)");
    $statement->execute(array($name, $description, $price, $category, $image));
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
        <h1><strong> Add Items</strong></h1>
        <br>
        <form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="name">Name :</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Name"
                       value="<?php echo $name; ?>">
                <span class="help-inline"><?php echo $nameError; ?></span>
            </div>

            <div class="form-group">
                <label>Description :</label>
                <input type="text" name="description" id="description" class="form-control" placeholder="Description"
                       value="<?php echo $description; ?>">
                <span class="help-inline"><?php echo $descriptionError; ?></span>
            </div>

            <div class="form-group">
                <label>Price : €</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" placeholder="Price"
                       value="<?php echo $price; ?>">
                <span class="help-inline"><?php echo $priceError; ?></span>
            </div>

            <div class="form-group">
                <label>Category :</label>
                <select class="form-control" name="category" id="category">
                    <?php
                    $db = Database::connect();
                    foreach ($db->query('SELECT * FROM categories') as $row) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                    Database::disconnect();

                    ?>
                    <span class="help-inline"><?php echo $categoryError; ?></span>
                </select>
            </div>

            <div class="form-group">
                <label>Upload Image :</label>
                <input type="file" id="image" name="image">
                <span class="help-inline"><?php echo $imageError; ?></span>
            </div>
            <br>
            <div class="form-actions">
                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Add
                </button>
                <a href="index.php" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span>
                    Back</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>