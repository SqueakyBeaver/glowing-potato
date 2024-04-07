<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entries</title>

    <link href="../css/index.css" rel="stylesheet">
    <link href="../css/entries.css" rel="stylesheet">
    <link href="../css/popups.css" rel="stylesheet">

    <script src="../js/PopupContainer.js"></script>
    <script src="../js/popups.js"></script>
</head>

<body>
    <?php require('../php/templates/header.php'); ?>
    <div class="entries-container">
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

        foreach ($DATABASE->getEntries() as $entry) {
        ?>
            <div class="entry-card">
                <?php
                if ($entry["image_path"]) {
                ?>
                    <img src="<?= $entry["image_path"] ?>" alt="Image of a <?= $entry["animal"] ?>">
                <?php
                }
                ?>
                <p class="animal"><?= htmlspecialchars($entry["animal"]) ?></p>
                <p class="fact"><?= htmlspecialchars($entry["fact"]) ?></p>
                <p class="timestamp">Created at <?= $entry["entry_time"] ?></p>
            </div>
        <?php
        }
        ?>
    </div>
</body>

</html>