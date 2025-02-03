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
</head>
<body>
  <?php
    // Inclure le gestionnaire de pays et récupérer la liste des pays
    require_once __DIR__ . '/../Class/CountryManager.php';
    $countryManager = new CountryManager($db);
    $countryNames = $countryManager->getAllCountries();
  ?>
  <div class="home-container">
    <div class="top">
      <div class="upper-container">
        <div class="title">
          Battle Of Nations
          <div class="lower-title">2 Player Game!</div>
        </div>
      </div>
    </div>
    <div class="middle">
      <div class="middle-container">
        <!-- SECTION DU PLAYER1 -->
        <div class="player1">
          <div class="interaction-container">
            <div class="img-container">
              <!-- On affiche une image par défaut si player1 n'est pas défini -->
              <img src="<?php echo $player1 ? $player1->getImage() : 'default.png'; ?>" alt="">
            </div>
            <div class="select-details">
              <form action="index.php?action=country1" method="POST">
                <label for="nom"></label>
                <select name="nom" id="select-pays1" onchange="this.form.submit()">
                  <option value="">Change Country</option>
                  <?php foreach ($countryNames as $country): ?>
                    <option value="<?= htmlspecialchars($country->getNom()) ?>" 
                      <?= ($player1 && $player1->getNom() === $country->getNom()) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($country->getNom()) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </form>
              <div class="stats-container">
                <span>STATS</span>
              </div>
              <div class="stats-details" id="stats1" style="display: none;">
                <p>Name :<span> <?= $player1->getNom(); ?></span></p>
                <p>Attack :<span> <?= $player1->getAttaque(); ?></span></p>
                <p>Reinforcement :<span> <?= $player1->getRenforcement(); ?></span></p>
                <p>Nuclear Bombs :<span> <?= $player1->getBombe_nucleaire(); ?></span></p>
                <p>Health :<span> <?= $player1->getPv(); ?></span></p>
              </div>
            </div>
          </div>
        </div>
        <!-- VS -->
        <div class="vs">
          VS
          <div class="ready">
            <a href="index.php?action=play">Play</a>
          </div>
        </div>
        <!-- SECTION DU PLAYER2 -->
        <div class="player2">
          <div class="interaction-container">
            <div class="img-container">
              <img src="<?php echo $player2 ? $player2->getImage() : 'default.png'; ?>" alt="">
            </div>
            <div class="select-details">
              <form action="index.php?action=country2" method="POST">
                <label for="nom"></label>
                <select name="nom" id="select-pays2" onchange="this.form.submit()">
                  <option value="">Change Country</option>
                  <?php foreach ($countryNames as $country): ?>
                    <option value="<?= htmlspecialchars($country->getNom()) ?>" 
                      <?= ($player2 && $player2->getNom() === $country->getNom()) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($country->getNom()) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </form>
              <div class="stats-container">
                <span>STATS</span>
              </div>
              <div class="stats-details" id="stats2" style="display: none;">
                <p>Name :<span> <?= $player2->getNom(); ?></span></p>
                <p>Attack :<span> <?= $player2->getAttaque(); ?></span></p>
                <p>Reinforcement :<span> <?= $player2->getRenforcement(); ?></span></p>
                <p>Nuclear Bombs :<span> <?= $player2->getBombe_nucleaire(); ?></span></p>
                <p>Health :<span> <?= $player2->getPv(); ?></span></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>  
    <div class="backoffice-link" style="position: absolute; top: 20px; right: 20px; font-size: 2rem;">
        <a href="index.php?action=backoffice" style="text-decoration: none; color: white;">Backoffice</a>
    </div>
    <div class="bottom-container">
      <span class="add-country">Add a country</span>
      <div class="add-country-container" style="display: none;">
        <form style="padding:3rem;" action="index.php?action=addCountry" method="POST" enctype="multipart/form-data">
          <label for="nom">Nom</label>
          <input type="text" name="nom" id="nom">
          <label for="attaque">Invade</label>
          <input type="number" name="attaque" id="attaque" max="100">
          <label for="renforcement">Reinforcement</label>
          <input type="number" name="renforcement" id="renforcement" max="50">
          <label for="bombe_nucleaire">Nuclear Bomb</label>
          <input type="number" name="bombe_nucleaire" id="bombe_nucleaire" max="10">
          <label for="pv">PV</label>
          <input type="number" name="pv" id="pv" max="1000">
          <label for="image">Image</label>
          <input type="file" name="image" id="image">
          <button type="submit">ADD</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
