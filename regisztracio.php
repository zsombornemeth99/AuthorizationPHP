<!DOCTYPE html>
<html>
<head>
    <title>Regisztráció</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <link rel="stylesheet" href="site.css" />
	<style>
	 body{
        background-color:rgb(0, 130, 0);
	}
	a.signin{
		color: blue !important;
		font-size: 20px;
	}
	</style>
</head>
<body id="hatter">
    <div class="container-fluid">
        <div class="container">
            <div class="row px-3">
                <div id="bejelentkezes" class="col-12 mx-auto pt-4 px-5 pb-5">
                    <h1 style="font-size:40px !important;" class="text-light pb-3 pt-4">Regisztráció</h1>
							<form method="POST">
								<div class="form-group">
                                    <label for="text"><strong>Felhasználónév:</strong></label>
                                    <input type="text" class="form-control" id="username" placeholder="Írja be a felhasználónevet" name="input_username">
                                </div>
								<div class="form-group">
                                    <label for="pdw"><strong>Jelszó:</strong></label>
                                    <input type="password" class="form-control" id="pwd" placeholder="Írja be a jelszót" name="input_password">
                                </div>
								<a href="index.php" class="float-left bejelentkezes">Van már profilom</a>
                                <button type="submit" name="action" value="cmd_regist" class="btn btn-outline-warning float-right">Regisztráció</button><br/><br/>
                            </form>
                            
							<?php
                            // Csatlakozás
                            $conn = mysqli_connect("localhost","root","","quiz");
                            if (!$conn){
                                die ("Kapcsolódási hiba: ".mysqli_connect_error());
                            }

                            // Regisztráció
                            if(isset($_POST["action"]) && $_POST["action"] == "cmd_regist"){
                                if(empty($_POST["input_username"]) || empty($_POST["input_password"])){ ?>
                                    <br><div id='result' class='mt-4 alert alert-danger alert-dismissible fade show'><b>Hiba!</b> Nincs kitöltve minden mező.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div> <?php
                                }
                                else{
                                    //Létezik-e ez a felhasználónév
                                    $exist = "SELECT * FROM user WHERE username = '".$_POST["input_username"]."'";
                                    $result = mysqli_query($conn, $exist);
                                    if(mysqli_num_rows($result) == 0){
                                        $sql = "INSERT INTO `user`(`username`, `password`, `permission`, `activity`)
                                         VALUES ('".$_POST["input_username"]."','".$_POST["input_password"]."','user', 'active')";
                                        echo $sql;
                                        if(mysqli_query($conn, $sql)){ ?>
                                            <br><div class='mt-4 alert alert-success' role='alert'>Sikeres regisztáció!</div>
                                            <meta http-equiv = 'refresh' content = '1; url = index.php' /> <?php
                                        }
                                        else{ ?>
                                            <br><div id='result' class='mt-4 alert alert-danger alert-dismissible fade show'><b>Sikertelen regisztáció!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div> 
                                            <?php
                                        }
                                    }
                                    else{ ?>
                                        <br><div id='result' class='mt-4 alert alert-danger alert-dismissible fade show'>Ez a felhasználónév már foglalt! Próbálkozzon újra!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div> <?php
                                    }
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