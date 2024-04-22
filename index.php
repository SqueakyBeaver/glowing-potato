<?php
// Start the session so we can store and access variables in the $_SESSION array
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Facts!</title>

    <!-- CSS rules are separated into files because otherwise I would have
            many, many lines of CSS, and that gets very overwhelming -->
    <link href="css/index.css" rel="stylesheet">
    <link href="css/mainContent.css" rel="stylesheet">
    <link href="css/popups.css" rel="stylesheet">
    <link href="css/sidebar.css" rel="stylesheet">

    <!-- Since this is just a class declaration,
            there is no need to put this in the body -->
    <script src="js/PopupContainer.js"></script>
</head>

<body>
    <?php
    $genConfig = parse_ini_file("config.ini", true)["general"];
    if ($genConfig["debug"] === "true") {
        // Display errors better and display them in the browser
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        error_reporting(E_ALL);
    }

    require('php/DB.php');

    $DATABASE = new DB();
    ?>

    <!-- Top header -->
    <?php require('php/templates/header.php'); ?>

    <!-- TODO: "fact of the visit" sidebar  -->
    <div class="sidebar left">
        <div id="fotv">
            <?php
            $entry = $DATABASE->getRandomEntry();
            ?>
            <p class="animal"><?= $entry["animal"] ?></p>
            <hr>
            <?php
            if (!empty($entry["image_path"])) {
            ?>
                <img src="<?= $entry["image_path"] ?>" alt="Image of a(n) <?= $entry["animal"] ?>">
            <?php
            }
            ?>

            <p class="fact"><?= $entry["fact"] ?></p>
            <hr>
            <p class="timestamp"><?= $entry["entry_time"] ?></p>
        </div>
    </div>

    <!-- Sidebar thingy on the right -->
    <div class="sidebar right">
        <!-- This is just a button to do something funny -->
        <div id="coffee-container">
            <img src="images/coffee.png" alt="cofee cup">
            <button id="coffee-button" name="coffee-button" type="button" style="min-width: 75%">
                Click for coffee
            </button>
            <p>Press it as many times as you can for a lot of coffees!</p>
        </div>
    </div>
    <script src="js/coffee.js"></script>

    <!-- Main section of content -->
    <div id="main-container">
        <!-- Input -->
        <form id="input-form" method="post" enctype="multipart/form-data" action="pages/upload.php">
            <p class="required">* is required</p>
            <label for="animal-input">Animal:&nbsp;&nbsp;</label>
            <input id="animal-input" class="input" type="text" name="animal" required="true" maxlength="30" value="<?= $_SESSION["inputs"]["animal"] ?? "" ?>">
            <span class="required">*</span>
            <br><br>

            <label for="fact-input">Fact:&nbsp;&nbsp;</label>
            <textarea id="fact-input" class="input" rows="5" cols="30" name="fact" required="true" maxlength="2000"><?= $_SESSION["inputs"]["fact"] ?? "" ?></textarea>
            <span class="required">*</span>
            <br><br>

            <label for="image-input">Image:&nbsp;&nbsp;</label>
            <input id="image-input" class="input" type="file" accept="image/*" name="animal-image">
            Max size is 5MB
            <br><br>

            <input type="submit" id="submit-main-input" value="submit"></input>
        </form>
    </div>
    <script src="js/popups.js"></script>
    <?php require('php/templates/footer.php'); ?>
</body>

</html>