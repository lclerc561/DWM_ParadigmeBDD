<?php
require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

try {
    $client = new Client("mongodb://mongo:27017");
    $collection = $client->chopizza->produits;

    echo "<h1>Résultats des requêtes MongoDB</h1>";

    echo "<h3>1. Liste des produits (Libellés)</h3>";
    $results = $collection->find();
    foreach ($results as $doc) {
        echo $doc['libelle'] . "<br>";
    }

    echo "<h3>2. Compter les produits</h3>";
    $count = $collection->countDocuments();
    echo "Nombre total de produits : $count <br>";

    echo "<h3>3. Produits triés par numéro décroissant</h3>";
    $results = $collection->find([], ['sort' => ['numero' => -1]]);
    foreach ($results as $doc) {
        echo "N°" . $doc['numero'] . " : " . $doc['libelle'] . "<br>";
    }

    echo "<h3>4. Le produit 'Margherita'</h3>";
    $p = $collection->findOne(['libelle' => 'Margherita']);
    echo $p ? "Trouvé : " . $p['description'] : "Non trouvé";
    echo "<br>";

    echo "<h3>5. Produits de la catégorie 'Boissons'</h3>";
    $results = $collection->find(['categorie' => 'Boissons']);
    foreach ($results as $doc) {
        echo $doc['libelle'] . "<br>";
    }

    echo "<h3>6. Projection : Catégorie, Numéro, Libellé</h3>";
    $results = $collection->find([], [
        'projection' => [
            'categorie' => 1,
            'numero' => 1,
            'libelle' => 1
        ]
    ]);
    foreach ($results as $doc) {
        echo "[{$doc['categorie']}] N°{$doc['numero']} - {$doc['libelle']}<br>";
    }

    echo "<h3>7. Projection avec Tarifs</h3>";
    $results = $collection->find([], [
        'projection' => [
            'categorie' => 1,
            'numero' => 1,
            'libelle' => 1,
            'tarifs' => 1
        ]
    ]);
    foreach ($results as $doc) {
        echo "<b>{$doc['libelle']}</b> : ";
        foreach ($doc['tarifs'] as $t) {
            echo "{$t['taille']} ({$t['tarif']}€) ";
        }
        echo "<br>";
    }

    echo "<h3>8. Produits avec un tarif < 8.0</h3>";
    $results = $collection->find(['tarifs.tarif' => ['$lt' => 8.0]]);
    foreach ($results as $doc) {
        echo $doc['libelle'] . "<br>";
    }

    echo "<h3>9. Produits avec un tarif grande taille < 8.0</h3>";
    $results = $collection->find([
        'tarifs' => [
            '$elemMatch' => [
                'taille' => 'grande',
                'tarif' => ['$lt' => 8.0]
            ]
        ]
    ]);
    foreach ($results as $doc) {
        echo $doc['libelle'] . "<br>";
    }

    echo "<h3>10. Insertion d'un nouveau produit</h3>";
    $existe = $collection->findOne(['numero' => 999]);
    if (!$existe) {
        $results = $collection->insertOne([
            'numero' => 999,
            'libelle' => 'Pizza Speciale Dev',
            'categorie' => 'Pizzas',
            'description' => 'Une pizza créée par PHP',
            'tarifs' => [
                ['taille' => 'normale', 'tarif' => 12.5]
            ]
        ]);
        echo "Produit inséré avec l'ID : " . $results->getInsertedId();
    } else {
        echo "Le produit de test existe déjà.";
    }
    echo "<br>";

    echo "<h3>11. Recettes associées au produit 1 (Lookup)</h3>";
    $results = $collection->aggregate([
        [ '$match' => ['numero' => 1] ],
        [ '$lookup' => [
            'from' => 'recettes',
            'localField' => 'recettes',
            'foreignField' => '_id',
            'as' => 'recettes_complet'
        ]]
    ]);

    foreach ($results as $doc) {
        echo "Produit : " . $doc['libelle'] . "<br>";
        echo "<ul>";
        if (isset($doc['recettes_complet'])) {
            foreach ($doc['recettes_complet'] as $recette) {
                echo "<li>Recette : " . $recette['nom'] . " (Difficulté : " . $recette['difficulte'] . ")</li>";
            }
        }
        echo "</ul>";
    }

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>