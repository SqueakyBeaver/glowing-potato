<?php
function cleanText(&$s) {
    $s = htmlspecialchars(stripslashes(trim($s)));
    return $s;
}

function validateImage() {
    if (!isset($_FILES["animal-image"])) {
        return false;
    }

    if (!getimagesize($_FILES["animal-image"]["tmp_name"])) {
        // File is not an image
        return false;
    }

    if ($_FILES["animal-image"]["size"] > 5000000) {
        // File too large (more than 5 MB)
        return false;
    }

    return true;
}
