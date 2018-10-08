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

        <h1 class="text-logo"><span class="glyphicon glyphicon-leaf"></span>Elizabeths Bio Épicerie <span class="glyphicon glyphicon-leaf"></span></h1>
        <div class="container admin">
            <div class="row">
                <h1><strong>Statistiques</strong></h1>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Catégorie</th>
                            <th>Valeur par catégorie</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        require 'database.php';
                        $db = Database::connect();
                        $statement = $db->query('SELECT * FROM `category_value`');
                        while ($articles = $statement->fetch()) {
                            echo '<tr>';
                            echo '<td>'.$articles['category'] . '</td>';
                            echo '<td>'.$articles['total_value'] . '</td>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        $statement = $db->query('SELECT * FROM `total_value`');
                        while ($articles = $statement->fetch()) {
                            echo '<tr>';
                            echo '<th>Valeur totale du stock</th>';
                            echo '<td>'.$articles['total_value'] . '</td>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        Database::disconnect();
                        ?>
                        </tbody>
                        </table>
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                        </div>
                        </div>

                        </body>
                        </html>