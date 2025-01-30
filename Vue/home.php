<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./Style/style.css">
    <title>Battle Of Nations</title>
</head>

<body>
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
                <div class="player1">
                    <div class="interaction-container">
                        <div class="img-container">
                            <!-- ICI APPELER L'IMG DE LA BDD - PAR DÉFAUT USA -->
                            <img src="https://flagcdn.com/w320/us.png" alt="">
                        </div>
                        <div class="select-details">
                            <form action="" method="POST">
                                <label for="nom"></label>
                                <select name="nom" id="select-pays1" onchange="this.form.submit()">
                                <!-- BOUCLER ICI -->
                                    <option value="">Change Country</option>
                                    <option value="USA">USA</option>
                                </select>
                            </form>
                            <div class="stats-container">
                                <span>STATS</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="vs">
                    VS
                </div>
                <div class="player2">
                    <div class="interaction-container">
                        <div class="img-container">
                            <!-- ICI APPELER L'IMG DE LA BDD - PAR DÉFAUT USA -->
                            <img src="https://flagcdn.com/w320/us.png" alt="">
                        </div>
                        <div class="select-details">
                            <form action="" method="POST">
                                <label for="nom"></label>
                                <select name="nom" id="select-pays1" onchange="this.form.submit()">
                                <!-- BOUCLER ICI -->
                                    <option value="">Change Country</option>
                                    <option value="USA">USA</option>
                                </select>
                            </form>
                            <div class="stats-container">
                                <span>STATS</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>