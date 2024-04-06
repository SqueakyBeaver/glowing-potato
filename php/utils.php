<?php
function cleanText($s) {
    return htmlspecialchars(stripslashes(trim($s)));
}

function validateImage() {
    $check = getimagesize($_FILES["animal-image"]["tmp_name"]);
    if ($check == false) {
        // File is not an image
        return false;
    }

    if ($_FILES["animal-image"]["size"] > 5000000) {
        // File too large (more than 5 MB)
        return false;
    }

    return true;
}
