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

        <h1 class="text-logo"><span class="glyphicon glyphicon-leaf"></span>Elizabeths Bio Épicerie<span class="glyphicon glyphicon-leaf"></span></h1>
        <div class="container admin">
            <div class="row">
                <h1><strong>Liste des articles </strong><a href="insert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Catégorie ID</th>
                            <th>Unit ID</th>
                            <th>Prix</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
// connect to the database
                        require 'database.php';
                        $db = Database::connect();
                        $statement = $db->query('SELECT articles.id, articles.name, articles.category_id, articles.unit_id,articles.sales_price,cat.name as nom1,units.name as nom2
                            FROM articles
                            LEFT JOIN categories as cat
                            ON articles.category_id=cat.id
                            LEFT JOIN units
                            on articles.unit_id=units.id
                            ORDER BY articles.id DESC');
                        while ($articles = $statement->fetch()) {
                            echo '<tr>';
                             echo '<td>' . $articles ['id'] . '</td>';
                            echo '<td>' . $articles ['name'] . '</td>';
                            echo '<td>' . $articles ['nom1'] . '</td>';
                            echo '<td>' . $articles ['nom2'] . '</td>';
                            echo '<td>' . number_format((float)$articles ['sales_price'], 2, '.', '') . '</td>';
                            echo '<td width="300">';
                            echo '<a class="btn btn-default" href="view.php?id=' . $articles ['id'] . '"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                            echo ' ';
                            echo '<a class="btn btn-primary" href="update.php?id=' . $articles ['id'] . '"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="delete.php?id=' . $articles ['id'] . '"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
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