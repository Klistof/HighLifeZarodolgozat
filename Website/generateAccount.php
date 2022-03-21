<?php
require "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] != "POST") {
    if (!isset($_GET["u"]) || !isset($_GET["k"]) || !isset($_GET["e"])) {
        header("location: ../login.php");
    } else {
        setcookie("key", $_GET["k"], time() + 3600, "/");
        setcookie("email", $_GET["e"], time() + 3600, "/");
        setcookie("uID",$_GET["u"], time() + 3600, "/");
    }

}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    echo $_COOKIE["email"];

    if(empty(trim($_POST["username"]))){
        $username_err = "Ird be a felhasználó neved.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "A felhasználó név tartalmazhat kis és nagy betűt illetve aláhúzást";
    } else{

        $sql = "SELECT username FROM users WHERE username = ? OR uID = ? OR email = ?";

        if($stmt = $link->prepare($sql)){
            $stmt->bind_param("sss", $param_username,$_COOKIE["uID"],$_COOKIE["email"]);

            $param_username = trim($_POST["username"]);

            if($stmt->execute()){
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $username_err = "Ez a felhaszáló vagy TeamSpeak Azonosító vagy email létezik a rendszerben.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Valami hiba történt, kérlek próbáld újra később.";
            }

            $stmt->close();
        }
    }


    if(empty(trim($_POST["password"]))){
        $password_err = "írd be a jelszavad";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "A jelszó 6 karakternél hosszabbnak kell lennie.";
    } else{
        $password = trim($_POST["password"]);
    }


    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Kérlek írd be a megerősítő jelszót";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "A jelszavak nem egyezznek.";
        }
    }


    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){


        $sql = "INSERT INTO users (username, password,level ,email,uID) VALUES (?,?,0,?,?)";

        if($stmt = $link->prepare($sql)){
            $stmt->bind_param("ssss", $param_username, $param_password, $_COOKIE["email"], $_COOKIE["uID"]);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if($stmt->execute()){
                $query = "DELETE FROM `generatetable` WHERE uID =\"".$_COOKIE["uID"]."\"";
                $link->query($query);


                setcookie("key", $_SESSION["key"], time() - 3600, "/");
                setcookie("email", $_SESSION["email"], time() - 3600, "/");
                setcookie("uID", $_SESSION["uID"], time() - 3600, "/");


                header("location: login.php");
            } else{
                echo "Valami hiba történt, kérlek próbáld újra később.";
            }

            $stmt->close();
        }
    }
    $link->close();
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>



    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="vh-100 gradient-custom">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="container py-5 h-100">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Új fiók létrehozása</h2>
                                <?php
                                if(!empty($login_err)){
                                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                                }
                                ?>

                                <div class="form-outline form-white mb-4">
                                    <input type="username" id="username" name="username" class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" />
                                    <label class="form-label" for="username">Felhasználó Név</label>
                                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" id="password" name="password" class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?> "/>
                                    <label class="form-label" for="password">Jelszó</label>
                                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" />
                                    <label class="form-label" for="confirm_password">Jelszó megerősítés</label>
                                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                                </div>


                                <button class="btn btn-outline-light btn-lg px-5" type="submit" value="Register">Regisztrálás</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

<script type="text/javascript">
    history.pushState(null, null, window.location.href);
    window.addEventListener('popstate', function (event) {
        history.pushState(null, null, window.location.href);
        event.preventDefault();
    });
</script>

</html>