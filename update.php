<?php

    require 'database.php';

if (!empty($_GET['id'])) {
    $id = checkInput($_GET['id']);
}

    $nameError = $category_idError = $unit_idError = $sales_priceError = $name = $category_id = $unit_id = $sales_price = $isSuccess = "";

if (!empty($_POST)) {
    $name = checkInput($_POST['name']);
    $category_id = checkInput($_POST['category_id']);
    $unit_id = checkInput($_POST['unit_id']);
    $sales_price = checkInput($_POST['sales_price']);
    $isSuccess = true;
        
    if (empty($name)) {
        $nameError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
    if (empty($category_id)) {
        $category_idError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
    if (empty($unit_id)) {
        $unit_idError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
    if (empty($sales_price)) {
        $sales_priceError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
}
if ($isSuccess) try{
    $db = Database::connect();
  
        $statement = $db->prepare("UPDATE articles set name = ?, category_id = ?, unit_id = ?, sales_price = ? WHERE id = ?");
        $statement->execute(array($name,$category_id,$unit_id,$sales_price,$id));
        echo 'Record updated successfully'; // success message
} catch( PDOException $e ) {
    echo 'Error, Record not updated'; // error message


        Database::disconnect();
        header("Location: index.php");
} else {
    $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM articles WHERE id = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    $name = $item['name'];
    $category_id = $item['category_id'];
    $unit_id = $item['unit_id'];
    $sales_price = $item['sales_price'];
    Database::disconnect();
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
                <div class="col-sm-6">
                <h1><strong>Modifier un article </strong></h1>
                <br>
                <form class="form" role="form" action="<?php echo 'update.php?id=' . $id; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nom:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                        <span class="help-inline"><?php echo $nameError; ?></span>
                    </div>
                   <div class="form-group">
                        <label for="category">Catégorie:</label>
                        <select class="form-control" id="category_id" name="category_id" input type="number" >
                            <?php
                                $db = Database::connect();
                            foreach ($db->query('SELECT * FROM categories') as $row) {
                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                            }
                                Database::disconnect();
                            ?>  
                        </select>
                        <span class="help-inline"><?php echo $category_idError; ?></span>
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
                        <span class="help-inline"><?php echo $unit_idError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="sales_price">Prix: (en €)</label>
                        <input type="number"  step="0.01" class="form-control" id="sales_price" name="sales_price" placeholder="Prix" value="<?php echo $sales_price; ?>">
                        <span class="help-inline"><?php echo $sales_priceError; ?></span>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>  
                    </form>
                </div>
                </div>
            </div>
        </div>
    </body>
</html>

