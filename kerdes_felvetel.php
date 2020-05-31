<?php
session_start();
if ($_SESSION["login_state"] == "not_signed_in") {
    header("location: index.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kérdés felvétele</title>
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
<header id="teteje">
        <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white border-bottom box-shadow mb-3">
            <div class="container">
                <a class="navbar-brand" href="test.php">Quiz</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse d-sm-inline-flex flex-sm-row-reverse">
                    <ul class="navbar-nav flex-grow-1">
                        <li class="nav-item active">
                            <a class="nav-link text-dark" href="test.php">Kérdések</a>
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
<body>
    <div class="container-fluid">
        <div class="row p-2">
            <div class="col-sm-5">
                <div class="card bg-success mb-3">
                    <div class="card-header">
                        <h2>Kérdés hozzáadása</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="comment"><strong>Kérdés:</strong></label>
                                <textarea class="form-control" rows="2" id="comment" placeholder="Írja be a kérdést" name="input_kerdes"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="text"><strong>'A' válasz:</strong></label>
                                <input id="input1" type="text" class="form-control" id="text" placeholder="Írja be az 'A' választ" oninput="addToSelectOption()" name="input_a">
                            </div>
                            <div class="form-group">
                                <label for="text"><strong>'B' válasz:</strong></label>
                                <input id="input2" type="text" class="form-control" id="text" placeholder="Írja be az 'B' választ" oninput="addToSelectOption()" name="input_b">
                            </div>
                            <div class="form-group">
                                <label for="text"><strong>'C' válasz:</strong></label>
                                <input id="input3" type="text" class="form-control" id="text" placeholder="Írja be az 'C' választ" oninput="addToSelectOption()" name="input_c">
                            </div>
                            <div class="form-group">
                                <label for="text"><strong>'D' válasz:</strong></label>
                                <input id="input4" type="text" class="form-control" id="text" placeholder="Írja be az 'D' választ" oninput="addToSelectOption()" name="input_d">
                            </div>
                            <div class="form-group">
                                <label for="text"><strong>Helyes válasz:</strong></label>
                                <select id="select" style="width:100%;" class="form-control" name="input_helyes">
                                    <option disabled selected>Válassza ki a helyes választ!</option>
                                </select>
                            </div>
                            <input type="hidden" name="action" value="cmd_insert">
                            <button type="submit" class="btn btn-primary p-4">Felvétel</button><br /><br />
                        </form>
                        <script>
                            function addToSelectOption() {
                                document.getElementById("select").innerHTML = "";
                                x = "<option disabled selected>Válassza ki a helyes választ!</option>";
                                if (document.getElementById("input1").value != null)
                                    x += `<option value="${document.getElementById("input1").value}">${document.getElementById("input1").value}</option>`;
                                if (document.getElementById("input2").value != null)
                                    x += `<option value="${document.getElementById("input2").value}">${document.getElementById("input2").value}</option>`;
                                if (document.getElementById("input3").value != null)
                                    x += `<option value="${document.getElementById("input3").value}">${document.getElementById("input3").value}</option>`;
                                if (document.getElementById("input4").value != null)
                                    x += `<option value="${document.getElementById("input2").value}">${document.getElementById("input4").value}</option>`;
                                document.getElementById("select").innerHTML = x;
                            }
                        </script>
                        <?php
                        $conn = mysqli_connect("localhost", "root", "", "quiz");
                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }
                        mysqli_query($conn, "SET CHARACTER SET 'utf8'");

                        /* FELVÉTEL  KEZDETE */
                        if (isset($_SESSION["login_user_permission"])) {
                            if ($_SESSION["login_user_permission"] == "admin" || $_SESSION["login_user_permission"] == "moderator") {
                                if (isset($_POST["action"]) && $_POST["action"] == "cmd_insert") {
                                    if (
                                        !empty($_POST["input_kerdes"]) &&
                                        !empty($_POST["input_a"]) &&
                                        !empty($_POST["input_b"]) &&
                                        !empty($_POST["input_c"]) &&
                                        !empty($_POST["input_d"]) &&
                                        !empty($_POST["input_helyes"])
                                    ) {
                                        $mennyiHasonlit = 0;
                                        $ugyanolyan = 0;
                                        $kerdes = array($_POST["input_a"], $_POST["input_b"], $_POST["input_c"], $_POST["input_d"]);
                                        for ($i = 0; $i < count($kerdes); $i++) {
                                            if ($kerdes[$i] == $_POST["input_helyes"]) {
                                                $mennyiHasonlit++;
                                            }
                                            for ($j = 0; $j < $i; $j++) {
                                                if ($kerdes[$i] == $kerdes[$j]) {
                                                    $ugyanolyan++;
                                                }
                                            }
                                        }
                                        if ($mennyiHasonlit == 1 && $ugyanolyan == 0) {
                                            $sql = "INSERT kerdesek (kerdes, valasz_A, valasz_B, valasz_C, valasz_D, helyes) 
                                                VALUES ('" . $_POST["input_kerdes"] . "',
                                                        '" . $_POST["input_a"] . "',
                                                        '" . $_POST["input_b"] . "',
                                                        '" . $_POST["input_c"] . "',
                                                        '" . $_POST["input_d"] . "',
                                                        '" . $_POST["input_helyes"] . "')";
                                            if (mysqli_query($conn, $sql)) {
                                                echo "<strong>Sikeres adatfelvétel!</strong>";
                                            } else {
                                                echo "<strong>Sikertelen adatfelvétel!</strong>";
                                            }
                                        } else if ($mennyiHasonlit == 0) {
                                            echo "<strong>A helyes válaszra egy válaszlehetőség sem hasonlít!</strong>";
                                        } else if ($mennyiHasonlit > 1) {
                                            echo "<strong>A válaszra csak egy válaszlehetőség hasonlíthat!</strong>";
                                        } else {
                                            echo "<strong>Két ugyanolyan válasz nem lehet!</strong>";
                                        }
                                    } else {
                        ?>
                                        <script>
                                            alert("Valami nincs kitöltve!")
                                        </script>
                                <?php
                                    }
                                }
                            } elseif (isset($_POST["action"]) && $_POST["action"] == "cmd_insert") { ?>
                                <script>
                                    alert("Önnek nincs joga hozzáadni");
                                </script><?php
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