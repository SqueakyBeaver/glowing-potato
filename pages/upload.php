<?php
// Start the session so we can store and access variables in the $_SESSION array
session_start();
?>

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
        ini_set('log_errors', 1);
        error_reporting(E_ALL);
    }

    require('../php/DB.php');
    require('../php/utils.php');

    if (!isset($DATABASE)) {
        $DATABASE = new DB("../config.ini");
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $redirect = false;
        $errors = [];
        $animal = cleanText($_POST["animal"]);
        $fact = cleanText($_POST["fact"]);


        // If it's just whitespace, mainly
        if (empty($animal)) {
            $redirect = true;
            array_push($errors, "Make sure your animal name is correct<br>");
        } else {
            $_SESSION["inputs"]["animal"] = $animal;

            $id = $DATABASE->getNextID();
            $imagePath = "../images/submissions/" . $_SESSION["inputs"]["animal"] . $id;
        }


        if (empty($fact)) {
            $redirect = true;
            array_push($errors, "Make sure your fact is correct<br>");
        } else {
            $_SESSION["inputs"]["fact"] = $fact;
        }

        if (!empty($_FILES["animal-image"]["tmp_name"])) {
            if (validateImage() && !empty($imagePath)) {
                // Append the file extension
                $imagePath = "$imagePath." . pathinfo($_FILES["animal-image"]["name"], PATHINFO_EXTENSION);

                // Save the file. If it fails, tell the user
                if (!move_uploaded_file($_FILES["animal-image"]["tmp_name"], "$imagePath")) {
                    $redirect = true;
                    array_push($errors, "Make sure the image is correct and is smaller than 5MB<br>");
                }
            } else {
                array_push($errors, "Make sure the image is correct and is smaller than 5MB<br>");
            }
        } else {
            $imagePath = "";
        }


        if ($redirect) {
    ?>
            <div class="results-container">

                <p>Looks like you made a wrong input.
                <p>Here are some problems:</p>
                <ul>
                    <?php
                    foreach ($errors as $err) {
                    ?>
                        <li class="error"><?= $err ?></li>
                    <?php
                    }
                    ?>
                </ul>
                </p>Please <a href="../index.php">go back to the home page</a> and try again.</p>
            </div>
        <?php
            // All inputs are good
        } else {
            $entry = $DATABASE->createEntry($_SESSION["inputs"]["animal"], $_SESSION["inputs"]["fact"], $imagePath);
        ?>
            <div class="results-container">
                <!-- Close the result status div and show the new entry -->
                <p>Entry created successfully! See it below.</p>
                <p><a href="../index.php">Return to the homepage</a></p>
                <p><a href="./entries.php">See all entries</a></p>
            </div>

            <div class="entry-card">
                <p class="animal"><?= $entry["animal"] ?></p>

                <?php
                if ($entry["image_path"]) {
                ?>
                    <img src="<?= $entry["image_path"] ?>" alt="Image of a <?= $entry["animal"] ?>">
                <?php
                }
                ?>

                <p class="fact"><?= $entry["fact"] ?></p>
                <p class="timestamp">Created at <?= $entry["entry_time"] ?></p>
            </div>
        <?php
        }
        // If the user just decided to type in the url for some reason, tell them to go away
    } else {
        ?>
        <div class="results-container">
            <p>Looks like you made a wrong Turn. Please <a href="../index.php">go back to the home page</a></p>
        </div>
    <?php
    }
    ?>
    </div>
    <?php require('../php/templates/footer.php'); ?>
</body>

</html>