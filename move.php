<?php
    require 'database.php';

    $articleError = $quantityError = $typeError = $purchaseError = $article = $quantity = $type = $purchase = $isSuccess = "";
//set the variables
if (!empty($_POST)) {
    $article = checkInput($_POST['article_id']);
    $quantity = checkInput($_POST['quantity']);
    $type = checkInput($_POST['movement_type_id']);
    $purchase = checkInput($_POST['purchase_id']);
    $isSuccess = true;

    if (empty($article)) {
        $articleError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
    if (empty($quantity)) {
        $quantityError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
    if (empty($type)) {
        $typeError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
    if (empty($purchase)) {
        $purchaseError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
}
// if fields are not empty then connect to the database and insert data
if ($isSuccess) try  {
    $db = Database::connect();
    $statement = $db->prepare("INSERT INTO movements (article_id, quantity, movement_type_id, purchase_id) values(?, ?, ?, ?)");
    $statement->execute(array($article, $quantity,$type,$purchase));
     echo 'Record updated successfully'; // success message
} catch( PDOException $e ) {
    echo 'Error, Record not inserted'; // error message
    Database::disconnect();
    header("Location: index.php");
}

// protect the data
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
                
                <h1><strong>Saisie de mouvement</strong></h1>
                <br>
                <form class="form" role="form" action="move.php" method="post" enctype="multipart/form-data">
                     <div class="form-group">
                        <label for="article">Article:</label>
                        <select class="form-control" id="article" name="article_id">
                            <?php
                                $db = Database::connect();
                            foreach ($db->query('SELECT * FROM articles') as $row) {
                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                            }
                                Database::disconnect();
                            ?>  
                        </select>
                        <span class="help-inline"><?php echo $articleError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity" value="<?php echo $quantity; ?>">
                        <span class="help-inline"><?php echo $quantityError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="type">Movement Type:</label>
                        <select class="form-control" id="type" name="movement_type_id">
                            <?php
                                $db = Database::connect();
                            foreach ($db->query('SELECT * FROM movement_types') as $row) {
                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                            }
                                Database::disconnect();
                            ?>  
                        </select>
                        <span class="help-inline"><?php echo $typeError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="type">Purchase Type:</label>
                        <select class="form-control" id="purchase" name="purchase_id">
                            <?php
                                $db = Database::connect();
                            foreach ($db->query('SELECT * from purchases
                            INNER JOIN suppliers as sup
                            ON purchases.supplier_id=sup.id') as $row) {
                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                            }
                                Database::disconnect();
                            ?>  
                        </select>
                        <span class="help-inline"><?php echo $purchaseError; ?></span>
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