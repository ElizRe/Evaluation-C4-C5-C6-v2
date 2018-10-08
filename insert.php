<?php
    require 'database.php';

    $nameError = $categoryError = $unitError = $priceError = $name = $category = $unit = $price = $isSuccess = "";

if (!empty($_POST)) {
    $name = checkInput($_POST["name"]);
    $category = checkInput($_POST["category_id"]);
    $unit = checkInput($_POST["unit_id"]);
    $price = checkInput($_POST["sales_price"]);
    $isSuccess = true;

    if (empty($name)) {
        $nameError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
    if (empty($category)) {
        $categoryError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
    if (empty($unit)) {
        $unitError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
    if (empty($price)) {
        $priceError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
}
if ($isSuccess) try {
    $db = Database::connect();
    $statement = $db->prepare("INSERT INTO articles (name,category_id,unit_id,sales_price) values(?, ?, ?, ?)");
    $statement->execute(array($name, $category,$unit,$price));
     echo 'Record added successfully'; // success message
} catch( PDOException $e ) {
    echo 'Error, Record not inserted'; // error message
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
        <title>Elizabeths Bio Épicerie</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale-1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type="text/css">
        <link rel="stylesheet" href="/assets/css/style.css">
    </head>
    <body>

        <h1 class="text-logo"><span class="glyphicon glyphicon-leaf"></span> Elizabeths Bio Épicerie<span class="glyphicon glyphicon-leaf"></span></h1>
        <div class="container admin">
            <div class="row">
                
                <h1><strong>Ajouter un item </strong></h1>
                <br>
                <form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nom:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                        <span class="help-inline"><?php echo $nameError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie:</label>
                        <select class="form-control" id="category" name="category_id" input type="number" >
                            <?php
                                $db = Database::connect();
                            foreach ($db->query('SELECT * FROM categories') as $row) {
                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                            }
                                Database::disconnect();
                            ?>  
                        </select>
                        <span class="help-inline"><?php echo $categoryError; ?></span>
                    </div>
                     <div class="form-group">
                        <label for="category">Unit Type:</label>
                        <select class="form-control" id="unit_id" name="unit_id" input type="number" >
                            <?php
                                $db = Database::connect();
                            foreach ($db->query('SELECT * FROM units') as $row) {
                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                            }
                                Database::disconnect();
                            ?>  
                        </select>
                        <span class="help-inline"><?php echo $unitError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="price">Prix: (en €)</label>
                        <input type="number"  step="0.01" class="form-control" id="sales_price" name="sales_price" placeholder="Prix" value="<?php echo $price; ?>">
                        <span class="help-inline"><?php echo $priceError; ?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>  
                </form>
            </div>
        </div>
    </body>
</html>