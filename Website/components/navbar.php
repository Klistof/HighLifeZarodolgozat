<header>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">HighLife</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav" style="display: flex">
                    <li class="nav-item active">
                        <a href="../activity.php" class="nav-link"><i class="fas fa-chart-line"></i> Aktivitás </a>
                    </li>

                    <li class="nav-item active">
                        <a href="../mods.php" class="nav-link"><i class="fas fa-list"></i> Moderátor Lista </a>
                    </li>

                    <?php
                    require_once "./config.php";

                    if ($_COOKIE["level"] > 0){
                        echo '<li class="nav-item"> <a href="../management.php" class="nav-link"><i class="fas fa-users"></i> Moderátorok Kezelése</a></li>';
                    }
                    if ($_COOKIE["level"] > 1){
                        echo '<li class="nav-item"> <a href="../users.php" class="nav-link"><i class="fas fa-book-dead"></i> Felhasználói fiókok Kezelése</a></li>';
                    }
                    if ($_COOKIE["level"] > 1){
                        echo '<li class="nav-item"> <a href="../invites.php" class="nav-link"><i class="fas fa-envelope"></i> Meghívók Kezelése</a></li>';
                    }
                    ?>
                </ul>
                <ul class="navbar-nav ms-auto" style="display: flex">
                        <a class="nav-link" id="upload" href="../upload.php" ><i class="fas fa-upload"></i> Kép Feltöltés</a>
                        <a class="nav-link" id="logout" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Kijelentkezés</a>
                </ul>

            </div>
        </div>
    </nav>
    <div id="alert_placeholder">
    </div>l

</header>