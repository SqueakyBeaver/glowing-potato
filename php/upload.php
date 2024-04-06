<!-- TODO: HTML stuff and style -->
<?php
require('php/DB.php');
require('php/utils.php');

$animalErr = $factErr = $imageErr = "";
$animal = $fact = $imagePath = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If it's empty, let it be known
    if (empty($_POST["animal"])) {
        $Err = "Animal is required";
    } else {
        $animal = cleanText($_POST["animal"]);
        $id = $DATABASE->getNextID();
        $imagePath = "./images/submissions/" . $animal . $id;
    }

    // If it's empty, let it be known
    if (empty($_POST["fact"])) {
        $Err = "Fact is required";
    } else {
        $fact = cleanText($_POST["fact"]);
    }
    
    if (validateImage() && !empty($imagePath)) {
            // Append the file extension
            $imagePath = "$imagePath." . pathinfo($_FILES["animal-image"]["name"], PATHINFO_EXTENSION);

            if (!move_uploaded_file($_FILES["animal-image"]["tmp_name"], "$imagePath")) {
                $code = $_FILES["animal-image"]["error"];
                $imageErr = "File not uploaded. Please try again. (Error Code $code)";
            } else {
                echo "uploadedededed";
            }
        }
    }
