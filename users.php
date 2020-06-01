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
<title>Userek</title>
<meta charset="utf-8">
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
<body>
    <header id="teteje">
        <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white border-bottom box-shadow mb-3">
            <div class="container">
            <a class="navbar-brand" href="kerdesek.php">Quiz</a> 
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse d-sm-inline-flex flex-sm-row-reverse">
                    <ul class="navbar-nav flex-grow-1">
                        <li class="nav-item active">
                            <a class="nav-link text-dark" href="kerdesek.php">Kérdések</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link text-dark" href="kerdes_felvetel.php">Kérdés hozzáadása</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="users.php">Userek</a>
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
    //törlés(inactiválás)
    if (isset($_SESSION["login_user_permission"])){
        if ($_SESSION["login_user_permission"]=="admin"){
            if(isset($_POST["action"]) && $_POST["action"]=="cmd_delete"){
                $sql = "UPDATE user SET 
                    activity = 'nem active'
                    WHERE id = ".$_POST['input_id'];
                    //echo $sql;
                    if(mysqli_query($conn,$sql)){ ?>
                        <br><div class='mt-4 alert alert-success alert-dismissible fade show'>
                            <b>Sikeres inaktiválás<b><button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span></button></div> <?php          
                    }
                    else{?>
                        <br><divt' class='mt-4 alert alert-danger alert-dismissible fade show'>
                            <b>Sikertelen inaktiválás<b><button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span></button></div> <?php  
                    }
           }
        }
        elseif(isset($_POST["action"]) && $_POST["action"]=="cmd_delete"){
            header("location: access_denied.php");
            die();  
        }
    }
    ?>
    <div class="container-fluid">
        <main role="main" class="pb-3">
        <div class="col-sm-12">
            <div class="card bg-success mb-3">
                    <div class="card-header"><h2>Userek</h2></div>
                        <div class="card-body text-center">
                            <table class="table table-dark table-hover table-striped">
                            <tr><th>Id</th><th>Username</th><th>Permission</th><th>Activity</th><th>Password</th><th>Törlés</th></tr>
                            <?php
                            //LISTÁZÁS

                            $sql = "SELECT * FROM user";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0)
                            {
                                while($row = mysqli_fetch_assoc($result))
                                {
                                    echo "<tr>"; ?>
                                      <td><?php echo $row['id']; ?></td>
                                      <td> <?php echo $row["username"] ?></td>
                                      <td> <?php echo $row["permission"] ?></td>
                                      <td> <?php echo $row["activity"] ?></td>
                                      <td> <?php echo $row["password"] ?></td>                                       
                                    <td>
                                    <form method="POST">
                                      <input type="hidden" name="input_id" value="<?php echo $row['id']; ?>">
                                      <input type="hidden" name="action" value="cmd_delete">
                                      <button type="submit" class="btn btn-danger btn-block p-0">Törlés</button>&nbsp;
                                    </form> 
                                    <a href="user_modositas.php/?id=<?php echo $row['id'];?>" class="btn btn-success text-white btn-block p-0">Módosít</a>
                                    </td> <?php
                                    echo "</tr>";
                                } 
                            }
                            else
                            {
                                echo "<strong>Nincs adat</strong>";
                            }
                            ?>
                        </table>
                        <div class="col-12">
                            <a href="user_hozzaadasa.php" class="btn btn-info form-control text-white btn-block">Új user hozzáadása</a>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
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