<?php
session_start();
if ($_SESSION["login_state"] == "not_signed_in"){
    header("location: index.php");
    die();
} 
if ($_SESSION["login_user_permission"]!="admin" && $_SESSION["login_user_permission"]!="moderator"){ 
    header("location: access_denied.php");
    die();   
    }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Userek módosítása</title>
	<meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <link rel="stylesheet" href="site.css" />
	<style>  
		table,td{
			border: 1px solid black;

        }
        h2{
            text-align:center;
            color:white;
        }

	</style>
</head>
</head>
<body>
<header id="teteje">
        <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white border-bottom box-shadow mb-3">
            <div class="container">
            <a class="navbar-brand" href="test.php">Quiz</a> 
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse d-sm-inline-flex flex-sm-row-reverse">
                    <ul class="navbar-nav flex-grow-1">
                        <li class="nav-item active">
                            <a class="nav-link text-dark" href="https://localhost/otthon/test.php">Kérdések</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link text-dark" href="kerdes_felvetel.php">Kérdés hozzáadása</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="https://localhost/otthon/users.php">Userek</a>
                        </li>
                    </ul>
                </div>
                <form method="POST">
	    		    <input type="hidden" name="action" value="logout">
	    		    <input type="submit" value="Kijelentkezés" class="btn btn-primary float-right ml-3">
	    	    </form>
            </div>
        </nav>
    </header>
    <?php if(isset($_POST["action"]) && $_POST["action"] == "logout"){
			$_SESSION["login_state"] = "not_signed_in";
			header("location: index.php");
	} 
	$conn = mysqli_connect("localhost","root","","quiz");
	if (!$conn){
		die ("Kapcsolódási hiba: ".mysqli_connect_error());
	}
    mysqli_query($conn, "SET CHARACTER SET 'utf8'"); 
    //Hozzáad
    if(isset($_POST["action"]) && $_POST["action"]=="cmd_hozzaad"){
        if(isset($_POST["input_id"]) && !empty($_POST["input_id"]) && 
        isset($_POST["input_username"]) && !empty($_POST["input_username"]) 
        && isset($_POST["input_permission"]) && !empty($_POST["input_permission"]) 
        && isset($_POST["input_activity"]) && !empty($_POST["input_activity"])
        && isset($_POST["input_password"]) && !empty($_POST["input_password"])){
            //Létezik-e ez a felhasználónév
            $exist = "SELECT * FROM user WHERE username = '".$_POST["input_username"]."'";
            $result = mysqli_query($conn, $exist);
            if(mysqli_num_rows($result) == 0){
                $sql = "INSERT INTO user (username, password, permission, activity) VALUES  
                    ('".$_POST["input_username"]."',
                    '".$_POST["input_permission"]."',
                    '".$_POST["input_activity"]."',
                    '".$_POST["input_password"]."')"
            ;
                echo $sql;
                if(mysqli_query($conn, $sql)){ ?>
                    <br><div class='mt-4 alert alert-success' role='alert'>Sikeres hozzáadás</div><?php
                }
                else{ ?>
                    <br><div id='result' class='mt-4 alert alert-danger alert-dismissible fade show'><b>Sikertelen hozzáadás!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div> 
                    <?php
                }
            }
            else{ ?>
                <br><div id='result' class='mt-4 alert alert-danger alert-dismissible fade show'>Ez a felhasználónév már foglalt! Próbálkozzon újra!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div> <?php
            }
        }
    }

    //Megjelenítés
        $sql = "SELECT username,permission,activity,password FROM user";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){           
                ?>
                <div class="border container bg-dark" style="padding:30px;">
                <h2 class="text-info ">User Módosítása</h2>
                <br />
                <form method="post">
                    <input type="hidden" name="input_id" value="<?php echo $row["id"]; ?>">
                    <div class="form-group row">
                        <div class="col-3 text-light">
                            <label><h3><strong>Username</strong></h3></label>
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control" name="input_username"><br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 text-light">
                            <label><h3><strong>Permission</strong></h3></label>
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control" name="input_permission"><br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 text-light">
                            <label><h3><strong>Activity</strong></h3></label>
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control" name="input_activity"><br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 text-light">
                            <label><h3><strong>Password</strong></h3></label>
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control" name="input_password"><br>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <div class="col-3 offset-3">
                            <input type="hidden" name="action" value="cmd_hozzaad">                   
                            <input type="submit" value="Hozzáad" class="btn btn-primary form-control">
                        </div>
                        <div class="col-3">
                            <a href="https://localhost/otthon/users.php" class="btn btn-success form-control">Vissza a userekhez</a>
                        </div>
                    </div>
                </form>
            </div>
                <?php
        }
        else{
            echo "Nincsenek rögzített adatok!";
        }
    ?>

    <footer class="border-top footer text-muted">
        <div class="container-fluid bg-white">
            <div class="row">
                <div class="col-sm-12">
                    &copy; 2020 - QuizASP - Németh Zsombor &nbsp;
                    <a href="#teteje" class="btn btn-dark float-right py-2" role="button">Oldal teteje</a>
                </div>           
            </div>           
        </div>
    </footer>
    
</div>
</body>
</html>