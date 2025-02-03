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
require_once __DIR__ . '/../Class/CountryManager.php';
  $countryManager = new CountryManager($db);
  $countryNames = $countryManager->getAllCountries();
  ?>
  <div class="home-container">
    <div class="top">
      <div class="upper-container">
        <div class="title">
          <div class="subtitle">
            <?php if (isset($_SESSION['winner'])): ?>
              <h2><?php echo $_SESSION['winner']; ?></h2>
              <a href="index.php?action=reset">Rejouer</a>
            <?php endif; ?>
          </div>
          <?php echo $player1->getNom() . ' VS ' . $player2->getNom(); ?>
        </div>
      </div>
    </div>
    <div class="middle">
      <div class="middle-container">
        <!-- SECTION DU PLAYER1 -->
        <div class="player1">
          <div class="interaction-container">
            <div class="img-container">
              <img src="<?php echo $player1->getImage(); ?>" alt="">
            </div>
            <div class="menu-battle">
              <div class="health-bar">
                <div class="health">Health :
                  <span class="health-nbr"><?= $_SESSION['pv1'] ?? 0; ?></span>
                </div>
              </div>
              <div class="attack-bar">
                <a href="index.php?action=attaque&target=player1">Invade</a>
                <a href="index.php?action=renforcer&target=player1">Reinforce</a>
              </div>
              <!-- Bouton nuclear pour player2 s'il en possède, affiché dans la zone de player1 -->
              <?php if ($player2->getBombe_nucleaire() > 0): ?>
                <div class="nuclear-bar">
                  <a href="index.php?action=bombe_nucleaire&target=player1">Nuclear Bomb</a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <!-- VS -->
        <div class="vs">
          VS
        </div>
        <!-- SECTION DU PLAYER2 -->
        <div class="player2">
          <div class="interaction-container">
            <div class="img-container">
              <img src="<?php echo $player2->getImage(); ?>" alt="">
            </div>
            <div class="menu-battle">
              <div class="health-bar">
                <div class="health">Health :
                  <span class="health-nbr"><?= $_SESSION['pv2'] ?? 0; ?></span>
                </div>
              </div>
              <div class="attack-bar">
                <a href="index.php?action=attaque&target=player2">Invade</a>
                <a href="index.php?action=renforcer&target=player2">Reinforce</a>
              </div>
              <!-- Bouton nuclear pour player1 s'il en possède, affiché dans la zone de player2 -->
              <?php if ($player1->getBombe_nucleaire() > 0): ?>
                <div class="nuclear-bar">
                  <a href="index.php?action=bombe_nucleaire&target=player2">Nuclear Bomb</a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
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