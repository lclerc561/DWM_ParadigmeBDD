<?php
require_once __DIR__ . '/../vendor/autoload.php';

try {
    $client = new MongoDB\Client("mongodb://mongo:27017");
    $collection = $client->chopizza->produits;
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$message = "";

if (!empty($_POST)) {
    $nouveauTarif = [
        "taille" => $_POST['taille'], 
        "tarif"  => (float) $_POST['tarif']
    ];

    $nouveauProduit = [
        "numero"      => (int) $_POST['numero'],
        "libelle"     => $_POST['libelle'],
        "categorie"   => $_POST['categorie'],
        "description" => $_POST['description'],
        "tarifs"      => [$nouveauTarif]
    ];

    $collection->insertOne($nouveauProduit);
    $message = "Produit ajouté avec succès !";
}


$categories = $collection->distinct('categorie');


$filtre = [];
if (isset($_GET['cat'])) {
    $filtre['categorie'] = $_GET['cat'];
}

$results = $collection->find($filtre, ['sort' => ['numero' => 1]]);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chopizza</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">

    <h1>Chopizza</h1>
    
    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <hr>

    <h3>1. Choisir une catégorie :</h3>
    <div class="mb-4">
        <a href="index.php" class="btn btn-secondary">Tout voir</a>
        <?php foreach ($categories as $cat): ?>
            <a href="index.php?cat=<?= $cat ?>" class="btn btn-outline-primary">
                <?= $cat ?>
            </a>
        <?php endforeach; ?>
    </div>

    <h3>2. Liste des produits :</h3>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>N°</th>
                <th>Libellé</th>
                <th>Description</th>
                <th>Tarifs</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $produit): ?>
                <tr>
                    <td><?= $produit['numero'] ?></td>
                    <td>
                        <strong><?= $produit['libelle'] ?></strong><br>
                        <small class="text-muted"><?= $produit['categorie'] ?></small>
                    </td>
                    <td><?= $produit['description'] ?></td>
                    <td>
                        <?php foreach ($produit['tarifs'] as $t): ?>
                            <?= $t['taille'] ?> : <?= $t['tarif'] ?> € <br>
                        <?php endforeach; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <div class="card bg-light p-4 mt-5">
        <h3>3. Ajouter un produit</h3>
        <form method="POST" action="index.php">
            
            <div class="row">
                <div class="col-md-2">
                    <label>Numéro</label>
                    <input type="number" name="numero" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Libellé</label>
                    <input type="text" name="libelle" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Catégorie</label>
                    <select name="categorie" class="form-select">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat ?>"><?= $cat ?></option>
                        <?php endforeach; ?>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Description</label>
                    <input type="text" name="description" class="form-control">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <label>Taille</label>
                    <select name="taille" class="form-select">
                        <option value="normale">Normale</option>
                        <option value="grande">Grande</option>
                        <option value="geant">Géant</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Prix</label>
                    <input type="number" step="0.1" name="tarif" class="form-control" required>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">Enregistrer le produit</button>
                </div>
            </div>

        </form>
    </div>

    <?php
    echo "<hr><h1>Partie 2 : Requêtes en PHP</h1>";

    echo "<h3>1. Liste simple (Numéro, Catégorie, Libellé)</h3>";
    $results = $collection->find([], [
        'projection' => [
            'numero' => 1,
            'categorie' => 1,
            'libelle' => 1,
            '_id' => 0
        ]
    ]);
    foreach ($results as $p) {
        echo "N°{$p['numero']} - [{$p['categorie']}] {$p['libelle']}<br>";
    }

    echo "<h3>2. Détail du produit N°6</h3>";
    $p6 = $collection->findOne(
        ['numero' => 6],
        [
            'projection' => [
                'libelle' => 1,
                'categorie' => 1,
                'description' => 1,
                'tarifs' => 1,
                '_id' => 0
            ]
        ]
    );

    if ($p6) {
        echo "<strong>{$p6['libelle']}</strong> ({$p6['categorie']})<br>";
        echo "<em>{$p6['description']}</em><br>";
        echo "Tarifs : ";
        foreach ($p6['tarifs'] as $t) {
            echo "{$t['taille']}={$t['tarif']}€ ";
        }
    } else {
        echo "Produit 6 introuvable.";
    }

    echo "<h3>3. Produits pas chers (taille normale <= 3.0€)</h3>";
    $results = $collection->find([
        'tarifs' => [
            '$elemMatch' => [
                'taille' => 'normale',
                'tarif' => ['$lte' => 3.0]
            ]
        ]
    ]);
    foreach ($results as $p) {
        echo "- {$p['libelle']}<br>";
    }

    echo "<h3>4. Produits ayant exactement 4 recettes</h3>";
    $results = $collection->find([
        'recettes' => ['$size' => 4]
    ]);
    foreach ($results as $p) {
        echo "- {$p['libelle']} (N°{$p['numero']})<br>";
    }

    echo "<h3>5. Recettes du produit N°6</h3>";
    $results = $collection->aggregate([
        ['$match' => ['numero' => 6]], 
        ['$lookup' => [
            'from' => 'recettes',       
            'localField' => 'recettes', 
            'foreignField' => '_id',    
            'as' => 'details_recettes'  
        ]]
    ]);

    foreach ($results as $doc) {
        echo "Produit : <b>{$doc['libelle']}</b><br>";
        echo "Recettes associées :<ul>";
        if (isset($doc['details_recettes'])) {
            foreach ($doc['details_recettes'] as $r) {
                echo "<li>{$r['nom']} (Diff: {$r['difficulte']})</li>";
            }
        }
        echo "</ul>";
    }

    echo "<h3>6. Fonction PHP et JSON</h3>";

    if (!function_exists('getProduitInfo')) {
        function getProduitInfo($collection, $numero, $tailleDemande) {
            $produit = $collection->findOne(['numero' => $numero]);
            if (!$produit) return ["erreur" => "Produit introuvable"];

            $tarifTrouve = null;
            foreach ($produit['tarifs'] as $t) {
                if ($t['taille'] === $tailleDemande) {
                    $tarifTrouve = $t['tarif'];
                    break;
                }
            }

            if ($tarifTrouve === null) return ["erreur" => "Taille inexistante"];

            return [
                'numero' => $produit['numero'],
                'libelle' => $produit['libelle'],
                'categorie' => $produit['categorie'],
                'taille' => $tailleDemande,
                'tarif' => $tarifTrouve
            ];
        }
    }

    $info = getProduitInfo($collection, 2, 'grande');

    echo "<pre>" . json_encode($info, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
    ?>
</body>
</html>