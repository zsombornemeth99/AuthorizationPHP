<?php
session_start();
if ($_SESSION["login_state"] == "not_signed_in"){
    header("location: index.php");
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
        body{
            background-color:rgb(255, 255, 255);
        }
	</style>
</head>
</head>
<body>
<header id="teteje">
        <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white border-bottom box-shadow mb-3">
            <div class="container">
            <a class="navbar-brand" href="kerdesek.php">Quiz</a> 
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>                
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
	}  ?>
    <div class="container-fluid">
        <main role="main" class="pb-3">
            <h1 class="text-danger">Access denied</h1>
            <p class="text-danger">You do not have access to this resource.</p>
        </main>
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