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
        require('php/DB.php');
        require('php/utils.php');


        $DATABASE = new DB();
        $DATABASE->getNextID();
        $DATABASE->createEntry("Mongoose", "cool animal oh yeah");

        $animalErr = $factErr = $imageErr = "";
        $animal = $fact = $imagePath = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["animal"])) {
                $Err = "Animal is required";
            } else {
                $animal = cleanText($_POST["animal"]);
                // $imagePath = $DATABASE->getConn()->
            }

            if (empty($_POST["fact"])) {
                $Err = "Fact is required";
            } else {
                $fact = cleanText($_POST["fact"]);
            }

            print_r($_POST["animal-image"]);
            if (!empty($_POST["animal-image"])) {
                if (validateImage()) {
                    if (!move_uploaded_file($_FILES["animal-image"]["tmp_name"], "images/submissions/$pathName")) {
                        $imageErr = "Image upload failed. Try again.";
                    }
                }
            }

          }
        ?>

        <!-- Top header -->
        <header class="top-header">
            <a id="site-logo">Animal Facts</a>
            <ul class="header-links">
                <li class="popup-origin">
                    About the creator
                    <div class="popup-content">
                        <p>
                            I am a college student (more to come later, I can't
                            think of anything else right now)
                        </p>
                        <ul id="about-me">
                            <li>Name: Sylva Ford</li>
                            <li>
                                Pronouns: She/Her and They/Them interchangeably
                            </li>
                            <li>Major: Computer Science</li>
                            <li>
                                Programming languages I know: C/C++, Python,
                                Java, HTML, JavaScript/TypeScript, CSS, Golang
                            </li>
                            <li>
                                Minor: Music (my main instrument is the
                                clarinet)
                            </li>
                            <li>
                                More to come when I can think of it (hopefully)
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="popup-origin">
                    About this project
                    <div class="popup-content">
                        <p>
                            This is a project for my intro to web development
                            class. It isn't the prettiest since I'm kind of
                            really bad at color design. The source is available
                            <!-- target="_blank" opens it in a new tab -->
                            <a
                                href="https://github.com/SqueakyBeaver/glowing-potato"
                                target="_blank">
                                here
                            </a>
                        </p>
                        <p>
                            P.S. you can type "clear" into the input box.
                        </p>
                    </div>
                </li>

                <li class="popup-origin">
                    Future plans
                    <div class="popup-content">
                        <ul>
                            <li>
                                Make everything prettier (I suck at colors and
                                this will take me a long time)
                            </li>
                            <li>Actually implement guessing the animal</li>
                            <li>Add a few more things to sidebars</li>
                            <li>
                                Make clicking the bubbles in the main content
                                show a sort of popup
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </header>
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
            <form id="input-form" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <label>Animal:&nbsp;&nbsp;</label><input
                    id="animal-input"
                    class="input"
                    type="text"
                    name="animal"
                    >
                    <span class="error">* <?= $genderErr ?></span>
                <br><br>
                <label>Fact:&nbsp;&nbsp;</label><textarea
                    id="fact-input"
                    class="input"
                    rows="5"
                    cols="30"
                    name="fact"
                    ></textarea>
                    <span class="error">* <?= $genderErr ?></span>
                    <br><br>
                <label>Image:&nbsp;&nbsp;</label><input
                    id="image-input"
                    class="input"
                    type="file"
                    accept="image/*"
                    name="animal-image"
                    >
                    <span class="error">* <?= $imageErr ?></span>
                    <br><br>
                <button id="submit-main-input" name="submit">Submit</button>
                </form>
        </div>
        <!-- <script src="js/input.js"></script> -->
        <script src="js/popups.js"></script>
        
    </body>
</html>