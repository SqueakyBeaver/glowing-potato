<!-- This file makes it so I don't have to copy and paste the header everywhere -->
<header class="top-header">
    <?php
    // Since the relative location of index.php can change
    // If the file that require()'d this file is in the 
    // pages subfolder, we change the path
    $rooDir = "./";
    if (str_contains($_SERVER["PHP_SELF"], "pages")) {
        $rootDir = "../";
    }
    ?>
    <a id="site-logo" href="<?= $rootDir . "index.php" ?>">Animal Facts</a>
    <ul class="header-links">
        <li>
            <a href="<?= $rootDir . "pages/entries.php" ?>">View all entries</a>
        </li>
        <li>
            <a href="https://github.com/SqueakyBeaver/glowing-potato" target="_blank">Source on GitHub</a>
        </li>
        <!-- <li>

        </li> -->
    </ul>
</header>