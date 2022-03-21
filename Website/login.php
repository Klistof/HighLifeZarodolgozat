<?php
session_start();

if(isset($_COOKIE["loggedin"]) && $_COOKIE["loggedin"] == true){
    header("location: index.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["username"]))){
        $username_err = "Ird be a felhasználó neved.";
    } else{
        $username = trim($_POST["username"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Ird be a jelszavad.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT username,password,level FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = $username;

            if(mysqli_stmt_execute($stmt)){

                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){

                    mysqli_stmt_bind_result($stmt, $username, $hashed_password, $level);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password,$hashed_password)){
                            setcookie("loggedin",true, time() + 1500*300, "/");
                            setcookie("username",$username, time() + 1500*300, "/");
                            setcookie("level",$level, time() + 1500*300, "/");

                            if ($_COOKIE["level"] < 0) {
                                setcookie("level", "", time() - 3600);
                                setcookie("level",$level, time() + 1500*300, "/");
                            }
                            header("location: index.php");
                        } else{
                            $login_err = "Érvénytelen felhasználó név vagy jelszó!";
                        }
                    }
                } else{
                    $login_err = "Érvénytelen felhasználó név vagy jelszó!";
                }
            } else{
                echo "Oops! Hiba történt, kérlek próbáld meg újra.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
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
                            <div class="mb-md-5 mt-md-5 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Bejelentkezés</h2>
                                <?php
                                if(!empty($login_err)){
                                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                                }
                                ?>

                                <div class="form-outline form-white mb-5">
                                    <input type="username" id="username" name="username" class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" />
                                    <label class="form-label" for="username">Felhasználó Név</label>
                                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                                </div>

                                <div class="form-outline form-white mb-5">
                                    <input type="password" id="password" name="password" class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" />
                                    <label class="form-label" for="password">Jelszó</label>
                                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                </div>


                                <button class="btn btn-outline-light btn-lg px-5" type="submit" value="Login">Bejelentkezés</button>

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