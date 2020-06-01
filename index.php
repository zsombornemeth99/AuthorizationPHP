<?php
session_start();
if(!isset($_SESSION["login_state"])){
	$_SESSION["login_state"] = "not_signed_in";
}
if($_SESSION["login_state"] == "signed_in"){
	header("location: kerdesek.php");
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bejelenkezés</title>
	<meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
	<link rel="stylesheet" href="site.css" />

</head>
<body id="hatter">
<?php if ($_SESSION["login_state"] == "not_signed_in"){ ?>
	<div class="container-fluid py-5">
		<div class="container">
        	<div class="row px-3">  
				<div id="bejelentkezes" class="col-12 mx-auto pt-4 px-5 pb-5">
					<h1 style="font-size:40px !important;" class="text-light pb-3 pt-4">Belépés</h1>                		
						<form method="POST">
							<div class="form-group">
                                <label for="text"><strong>Felhasználónév:</strong></label>
                                <input type="text" class="form-control" id="username" placeholder="Írja be a felhasználónevet" name="input_username">
                            </div>
							<div class="form-group">
                                <label for="pdw"><strong>Jelszó:</strong></label>
                                <input type="password" class="form-control" id="pwd" placeholder="Írja be a jelszót" name="input_jelszo">
                            </div>
							<a href="regisztracio.php" class="float-left bejelentkezes">Még nincs profilom</a>
                            <button type="submit" name="action" value="cmd_bejelentkezes" class="btn btn-outline-warning float-right">Bejelentkezés</button><br/><br/>
						</form>							
							<?php
							}
							if (isset($_POST["action"]) and $_POST["action"]=="cmd_bejelentkezes"){
								if(isset($_POST["input_username"]) and 
									!empty($_POST["input_username"]) and
									isset($_POST["input_jelszo"]) and
									!empty($_POST["input_jelszo"])
								){
									$conn = mysqli_connect("localhost", "root", "", "quiz");
									if (!$conn) {
										die("Connection failed: " . mysqli_connect_error());
									}
									$sql = "SELECT * FROM user WHERE username = '".$_POST["input_username"]."' AND password = '".$_POST["input_jelszo"]."' AND activity='active'";
									$result = mysqli_query($conn, $sql);
									if (mysqli_num_rows($result) == 1) {
										$row = mysqli_fetch_array($result);
										$_SESSION["login_state"] = "signed_in";
										$_SESSION["login_user_permission"] = $row["permission"];
								
                    					header("location: kerdesek.php");
                    					die();
									} else {
										$_SESSION["login_state"] == "not_signed_in";?>
                    					<br><div id='alert' class='mt-4 alert alert-danger alert-dismissible fade show'>Felhasználó név vagy jelszó hibás!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div> <?php
									}
											
								}else{ ?>
									<br><div id='alert' class='mt-4 alert alert-danger alert-dismissible fade show'><b>Hiba!</b> Nincs kitöltve minden mező.
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div> <?php				
							}
						}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
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
</body>
</html>