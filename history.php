<!DOCTYPE html>
<html>
    <head>
        <title>Elizabeths Bio Épicerie</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale-1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type="text/css">
        <link rel="stylesheet" href="/assets/css/style.css">
    </head>
    <body>

        <h1 class="text-logo"><span class="glyphicon glyphicon-leaf"></span> Elizabeths Bio Épicerie <span class="glyphicon glyphicon-leaf"></span></h1>
        <div class="container admin">
            <div class="row">
                <h1><strong>Historique des Mouvements</strong></h1>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Date de Mouvement</th>
                            <th>Article-Nom</th>
                            <th>Quantité</th>
                            <th>Type-Mouvement </th>
                            <th>Direction-Mouvement </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        require 'database.php';
                        $db = Database::connect();
                        $statement = $db->query('SELECT movements.article_id,movements.date_time,movements.quantity,movements.movement_type_id,articles.name as nom,movement_types.name, movement_types.direction_id,directions.name as dnom from movements
                            LEFT JOIN articles
                            ON movements.article_id=articles.id
                            LEFT JOIN purchases
                            ON movements.purchase_id=purchases.id
                            LEFT JOIN sales
                            ON movements.sale_id=sales.id
                            LEFT JOIN movement_types
                            on movements.movement_type_id=movement_types.id
                            LEFT JOIN directions
                            on movement_types.direction_id=directions.id
                            ORDER BY movements.date_time');
                        while ($articles = $statement->fetch()) {
                            echo '<tr>';
                            echo '<td>' . $articles ['date_time'] . '</td>';
                            echo '<td>' . $articles ['nom'] . '</td>';
                            echo '<td>' . $articles ['quantity'] . '</td>';
                            echo '<td>' . $articles ['name'] . '</td>';
                            echo '<td>' . $articles ['dnom'] . '</td>';
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