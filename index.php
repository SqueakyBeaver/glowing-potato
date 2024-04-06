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
        <link href="css/rightSidebar.css" rel="stylesheet">

        <!-- Since this is just a class declaration,
            there is no need to put this in the body -->
        <script src="js/PopupContainer.js"></script>

        
    </head>
    <body>
        <?php 
        $genConfig = parse_ini_file("config.ini", true)["database"];
        if ($genConfig["debug"] === "true") {
            // Display errors better and display them in the browser
            ini_set('display_errors', 1);
            ini_set('log_errors',1);
            error_reporting(E_ALL); 
        }
        
        require('php/DB.php');
        require('php/utils.php');


        $DATABASE = new DB();

        $animalErr = $factErr = $imageErr = "";
        $animal = $fact = $imagePath = "";


        // require('php/upload.php');
        ?>

        <!-- Top header -->
        <?php require('php/templates/header.php'); ?>

        <!-- TODO: "fact of the visit" sidebar (once we setup mySQL db) -->

        <!-- Sidebar thingy on the right -->
        <div class="right-sidebar">
            <!-- This is just a button to do something funny -->
            <div id="coffee-container">
                <img src="images/coffee.png" alt="cofee cup">
                <button
                    id="coffee-button"
                    name="coffee-button"
                    type="button"
                    style="min-width: 75%">
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
                <p class="error">* is required</p>
                <label>Animal:&nbsp;&nbsp;</label><input
                    id="animal-input"
                    class="input"
                    type="text"
                    name="animal"
                    value="<?= $animal ?>"
                    >
                    <span class="error">* <?= $animalErr ?></span>
                <br><br>
                <label>Fact:&nbsp;&nbsp;</label><textarea
                    id="fact-input"
                    class="input"
                    rows="5"
                    cols="30"
                    name="fact"
                    value="<?= $fact ?>"
                    ></textarea>
                    <span class="error">* <?= $factErr ?></span>
                    <br><br>
                <label>Image:&nbsp;&nbsp;</label><input
                    id="image-input"
                    class="input"
                    type="file"
                    accept="image/*"
                    name="animal-image"
                    value="<?= $_FILES["animal-image"] ?>"
                    >
                    <span class="error"><?= $imageErr ?></span>
                    <br><br>
                <button id="submit-main-input" name="submit">Submit</button>
                </form>
        </div>
        <!-- <script src="js/input.js"></script> -->
        <script src="js/popups.js"></script>
        
    </body>
</html>
