<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Upload Results</title>

        <link href="../css/index.css" rel="stylesheet">
        <link href="../css/upload.css" rel="stylesheet">
        <link href="../css/popups.css" rel="stylesheet">

        <script src="../js/PopupContainer.js"></script>
        <script src="../js/popups.js"></script>

    </head>
    <body>
    <?php require('../php/templates/header.php'); ?>
    <?php
    $genConfig = parse_ini_file("../config.ini", true)["database"];
    if ($genConfig["debug"] === "true") {
        // Display errors better and display them in the browser
        ini_set('display_errors', 1);
        ini_set('log_errors',1);
        error_reporting(E_ALL); 
    }

    require('../php/DB.php');
    require('../php/utils.php');
    
    if (!isset($DATABASE)) {
        $DATABASE = new DB("../config.ini");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $redirect = false;

        // If it's empty, let it be known
        if (empty($_POST["animal"])) {
            $Err = "Animal is required";
            $redirect = true;
        } else {
            $animal = cleanText($_POST["animal"]);
        $id = $DATABASE->getNextID(); 
            $imagePath = "../images/submissions/" . $animal . $id;
        }

        // If it's empty, let it be known
        if (empty($_POST["fact"])) {
            $Err = "Fact is required";
            $redirect = true;
        } else {
            $fact = cleanText($_POST["fact"]);
        }

        if (validateImage() && !empty($imagePath)) {
            // Append the file extension
            $imagePath = "$imagePath." . pathinfo($_FILES["animal-image"]["name"], PATHINFO_EXTENSION);

            if (!move_uploaded_file($_FILES["animal-image"]["tmp_name"], "$imagePath")) {
                $imageErr = "File not uploaded. Please try again.";
                $redirect = true;
            }
        }
        if ($redirect) {
            ?>
            <p class="rejected">Looks like you made a wrong input. Please <a href="../index.php">go back to the home page</a></p>
            <?php
        } else {
            $DATABASE->createEntry($animal, $fact, $imagePath);
            ?>
            <p class="rejected">succ</a></p>

            <?php
        }
    // If the user just decided to type in the url for some reason, tell them to go away
    } else {
        ?>
    <p class="rejected">Looks like you made a wrong Turn. Please <a href="../index.php">go back to the home page</a></p>
    <?php
    }
    ?>
    </body>
</html>