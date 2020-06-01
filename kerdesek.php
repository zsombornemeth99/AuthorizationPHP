<?php
session_start();
if ($_SESSION["login_state"] == "not_signed_in") {
    header("location: index.php");
    die();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Quiz</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <link rel="stylesheet" href="site.css" />
    <style>
        table,
        td {
            border: 1px solid black;

        }

        h2 {
            text-align: center;
            color: white;
        }
    </style>
</head>

<body>
    <header id="teteje">
        <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white border-bottom box-shadow mb-3">
            <div class="container">
                <a class="navbar-brand" href="kerdesek.php">Quiz</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                        <?php
                        if (isset($_SESSION["login_user_permission"])) {
                            if ($_SESSION["login_user_permission"] == "admin" || $_SESSION["login_user_permission"] == "moderator") { ?>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="users.php">Userek</a>
                                </li><?php
                                    }
                                } ?>
                    </ul>
                </div>
                <form method="POST">
                    <input type="hidden" name="action" value="logout">
                    <input type="submit" value="Kijelentkezés" class="btn btn-primary float-right ml-3">
                </form>
            </div>
        </nav>
    </header>
    <?php if (isset($_POST["action"]) && $_POST["action"] == "logout") {
        $_SESSION["login_state"] = "not_signed_in";
        header("location: index.php");
    }
    $conn = mysqli_connect("localhost", "root", "", "quiz");
    if (!$conn) {
        die("Kapcsolódási hiba: " . mysqli_connect_error());
    }
    mysqli_query($conn, "SET CHARACTER SET 'utf8'");

    //Törlés
    if (isset($_SESSION["login_user_permission"])) {
        if ($_SESSION["login_user_permission"] == "admin" || $_SESSION["login_user_permission"] == "moderator") {
            if (isset($_POST["action"]) && $_POST["action"] == "cmd_delete") {
                $sql = "DELETE FROM kerdesek WHERE kerdes_id= " . $_POST['input_id'];
                if (mysqli_query($conn, $sql)) { ?>
                    <script>
                        alert("Sikeres törlés");
                    </script> <?php
                            } else {
                                echo "<strong>Sikertelen törlés!</strong>";
                            }
                        }
                    }
                }
    //Törlés vége
                // Mintaadat
                if (isset($_SESSION["login_user_permission"])) {
                    if ($_SESSION["login_user_permission"] == "admin" || $_SESSION["login_user_permission"] == "moderator") {
                        if (isset($_POST["action"]) && $_POST["action"] == "mintaadat") {
                            $sql = "TRUNCATE kerdesek";
                            $result = mysqli_query($conn, $sql);
                            $sql = "INSERT INTO kerdesek (kerdes, valasz_A, valasz_B, valasz_C, valasz_D, helyes) 
                                        VALUES ('Mi a fényerősség SI mértékegysége?', 'kandela', 'lumen', 'lux' ,'farad', 'kandela'), 
                                        ('Ki dolgozta ki a kvantumelméletet?', 'Werner Heisenberg', 'Erwin Schrödinger', 'Max Planck', 'Max Born', 'Max Planck'), 
                                        ('Hányas számrendszer a bináris számrendszer?', 'tizes', 'hetes', 'tizenkettes', 'kettes', 'kettes');";
                            $result = mysqli_query($conn, $sql);
                        }
                    }
                }
                //Mintaadat vége
                                ?>
    </div>
    </div>
    </div>
    <div class="offset-sm-2"></div>
    </div>
    <div class="col-sm-12">
        <div class="card bg-success mb-3">
            <div class="card-header">
                <h2>Kérdések</h2>
            </div>
            <div class="card-body text-center">
                <table class="table table-dark table-hover table-striped">
                    <tr>
                        <th>Kérdés</th>
                        <th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <?php
                        if (isset($_SESSION["login_user_permission"])) {
                            if ($_SESSION["login_user_permission"] == "admin" || $_SESSION["login_user_permission"] == "moderator") { ?>
                                <th>Törlés</th>
                    </tr>
            <?php
                            }
                        }
            ?>
            <?php
            /* LISTÁZÁS KEZDETE */

            $sql = "SELECT * FROM kerdesek";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>"; ?>
                    <td><?php echo $row['kerdes']; ?></td>
                    <td id='<?php echo 'valaszA' . $row['kerdes_id']; ?>' style="cursor: pointer;" onclick="helyesE('<?php echo $row['valasz_A']; ?>', '<?php echo $row['helyes']; ?>', '<?php echo 'valaszA' . $row['kerdes_id']; ?>')"><?php echo $row['valasz_A']; ?></td>
                    <td id='<?php echo 'valaszB' . $row['kerdes_id']; ?>' style="cursor: pointer;" onclick="helyesE('<?php echo $row['valasz_B']; ?>', '<?php echo $row['helyes']; ?>', '<?php echo 'valaszB' . $row['kerdes_id']; ?>')"><?php echo $row['valasz_B']; ?></td>
                    <td id='<?php echo 'valaszC' . $row['kerdes_id']; ?>' style="cursor: pointer;" onclick="helyesE('<?php echo $row['valasz_C']; ?>', '<?php echo $row['helyes']; ?>', '<?php echo 'valaszC' . $row['kerdes_id']; ?>')"><?php echo $row['valasz_C']; ?></td>
                    <td id='<?php echo 'valaszD' . $row['kerdes_id']; ?>' style="cursor: pointer;" onclick="helyesE('<?php echo $row['valasz_D']; ?>', '<?php echo $row['helyes']; ?>', '<?php echo 'valaszD' . $row['kerdes_id']; ?>')"><?php echo $row['valasz_D']; ?></td>
                    <script>
                        function helyesE(valasz, helyesvalasz, id) {
                            var backgroundcolor = document.getElementById(id).style.backgroundColor;
                            if (valasz == helyesvalasz) {
                                document.getElementById(id).style.backgroundColor = "green";

                            } else {
                                document.getElementById(id).style.backgroundColor = "red";

                            }
                            setTimeout(function() {
                                document.getElementById(id).style.backgroundColor = backgroundcolor;
                            }, 1500);
                            setTimeout(function() {
                                document.getElementById(id).style.color = "white";
                            }, 1500);
                        }
                    </script>

                    <?php
                    if (isset($_SESSION["login_user_permission"])) {
                        if ($_SESSION["login_user_permission"] == "admin" || $_SESSION["login_user_permission"] == "moderator") {
                            echo "<td>"; ?>
                            <form method="POST">
                                <input type="hidden" name="input_id" value="<?php echo $row['kerdes_id']; ?>">
                                <input type="hidden" name="action" value="cmd_delete">
                                <button type="submit" class="btn btn-danger p-0 btn-block my-1">Törlés</button>
                            </form>
                            <a href="kerdes_modositas.php/?kerdes_id=<?php echo $row['kerdes_id']; ?>" class="btn btn-success text-white btn-block p-0">Módosít</a>
                            </td> <?php
                                    echo "</tr>";
                                }
                            }
                        }
                    } else {
                        echo "<strong>Nincs adat</strong>";
                    }
                                    ?>
                </table>
            </div>
            <?php
            if (isset($_SESSION["login_user_permission"])) {
                if ($_SESSION["login_user_permission"] == "admin") { ?>
                    <div style="padding-left: 15px;">
                        <form method="POST">
                            <button type="submit" name="action" value="mintaadat" class="btn btn-primary p-3">Feltölt mintakérdésekkel</button><br /><br />
                        </form>
                    </div>
            <?php
                }
            } ?>
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