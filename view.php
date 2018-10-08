<?php

    require 'database.php';

if (!empty($_GET['id'])) {
    $id = checkInput($_GET['id']);
}

    $db = Database::connect();
    $statement = $db->prepare('SELECT articles.id, articles.name, articles.category_id, articles.unit_id, articles.sales_price FROM articles Where articles.id = ?');

    $statement->execute(array($id));
    $articles = $statement->fetch();
    Database::disconnect();

function checkInput($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
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
                <h1><strong>Voir un item </strong></h1>
                <br>
                <form>
                    <div class="form-group">
                        <label>Nom:</label><?php echo '  ' . $articles['name']; ?>
                    </div>
                    <div class="form-group">
                        <label>Catégorie ID:</label><?php echo '  ' . $articles['category_id']; ?>
                    </div>
                     <div class="form-group">
                        <label>Unit ID:</label><?php echo '  ' . $articles['unit_id']; ?>
                    </div>
                    <div class="form-group">
                        <label>Prix:</label><?php echo '  ' . number_format((float)$articles['sales_price'], 2, '.', '') . ' €'; ?>
                    </div>
                </form>
                <br>
            <div class="form-actions">
                <a class="btn btn-primary" href="list.php"><span class="glyphicon glyphicon-arrow-left"></span>Retour</a>
            </div>
            </div>
                </div>
            </div>
        </div>
    </body>
</html>