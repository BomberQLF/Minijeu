<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./Style/style.css">
    <script src="index.js"></script>
    <title>Battle Of Nations</title>

    <style>
        body {
            padding: 4rem;
        }
    </style>
</head>

<body>
    <?php
    require_once __DIR__ . '/../Class/CountryManager.php';
    $countryManager = new CountryManager($db);
    $countries = $countryManager->getAllCountries();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete'])) {
            $countryManager->deleteCountry($_POST['id']);
            header("Location: backoffice.php");
            exit();
        }
    }
    ?>
    <a href="index.php?action=home" style="text-decoration:none; color: white; padding-bottom: 2px; border-bottom: 1px solid white; position: absolute; top: 20px; font-size: 1.5rem">Home</a>
    <h1>Gestion des Pays</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Attaque</th>
                <th>Renforcement</th>
                <th>Bombe Nucléaire</th>
                <th>PV</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($countries as $country): ?>
                <tr>
                    <td><?= htmlspecialchars($country->getId()) ?></td>
                    <td><?= htmlspecialchars($country->getNom()) ?></td>
                    <td><?= htmlspecialchars($country->getAttaque()) ?></td>
                    <td><?= htmlspecialchars($country->getRenforcement()) ?></td>
                    <td><?= htmlspecialchars($country->getBombe_nucleaire()) ?></td>
                    <td><?= htmlspecialchars($country->getPv()) ?></td>
                    <td><img src="<?= htmlspecialchars($country->getImage()) ?>" width="50" height="50"></td>
                    <td>
                        <?php if (!isset($country)) {
                            header("Location: index.php?action=backoffice");
                            exit;
                        } ?>
                        <form method="post" action="index.php?action=editCountry" enctype="multipart/form-data" id="edit-form">
                            <input type="hidden" name="id" value="<?= $country->getId() ?>">
                            <label>Nom : <input type="text" name="nom"
                                    value="<?= htmlspecialchars($country->getNom()) ?>"></label>
                            <label>Attaque : <input type="number" name="attaque"
                                    value="<?= htmlspecialchars($country->getAttaque()) ?>"></label>
                            <label>Renforcement : <input type="number" name="renforcement"
                                    value="<?= htmlspecialchars($country->getRenforcement()) ?>"></label>
                            <label>Bombe nucléaire : <input type="number" name="bombe_nucleaire"
                                    value="<?= htmlspecialchars($country->getBombe_nucleaire()) ?>"></label>
                            <label>PV : <input type="number" name="pv"
                                    value="<?= htmlspecialchars($country->getPv()) ?>"></label>
                            <label>Image URL : <input type="text" name="image_url"
                                    value="<?= htmlspecialchars($country->getImage()) ?>"></label>
                            <label>Upload Image: <input type="file" name="image_upload"></label>
                            <button id="modify" type="submit">Modifier</button>
                        </form>
                        <form method="post" style="display:inline;" action="index.php?action=deleteCountry">
                            <input type="hidden" name="id" value="<?= $country->getId() ?>">
                            <button id="delete" type="submit" name="delete">Supprimer</button>
                        </form>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>