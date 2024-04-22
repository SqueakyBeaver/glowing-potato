<footer>
    <p>Created by Sylva Ford</p>
    <ul class="footer-links">
        <li class="popup-origin">
            <a href="#">About the creator</a>
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
            <a href="#">About this project</a>
            <div class="popup-content">
                <p>
                    Upload a fact about a certain animal using the box on the homepage.
                    You can also view all the entries by clicking the "view all entries" button at the top of the page.<br>
                    This idea is completely different than what was present at the previous project drop.
                </p>
            </div>
        </li>

        <li class="popup-origin">
            <a href="#">Explanation of Pages</a>
            <div class="popup-content">
                <ul>
                    <?php
                    // Since the relative location of the pages can change
                    // If the file that require()'d this file is in the 
                    // pages subfolder, we change the path
                    $rootDir = "./";
                    if (str_contains($_SERVER["PHP_SELF"], "pages")) {
                        $rootDir = "../";
                    }
                    ?>
                    <li>The <a href="<?= $rootDir ?>pages/entries.php">entries</a> page shows all the submitted facts</li>
                    <li>The <a href="<?= $rootDir ?>pages/upload.php">upload</a> page is where you end up after you submit a fact</li>
                    <li>The <a href="<?= $rootDir ?>index.php">home</a> page is where you can submit a fact and see a random fact each visit</li>
                </ul>
            </div>
        </li>
</footer>