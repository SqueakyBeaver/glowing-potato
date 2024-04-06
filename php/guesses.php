<?php
// File that will handle determining the correct guess or available options

$POSSIBLE_GUESSES = explode("\n", file_get_contents("./animals.txt"));

// Won't explode so I can pass easily to a JavaScript function
$HINTS =file_get_contents("./hints.txt"); 

// So glad php has a builtin function to get a random array key
$CHOSEN_ANIMAL = $POSSIBLE_GUESSES[array_rand($POSSIBLE_GUESSES, 1)];

function newChosenAnimal() {
    global $CHOSEN_ANIMAL;
    global $POSSIBLE_GUESSES;
    $CHOSEN_ANIMAL = $POSSIBLE_GUESSES[array_rand($POSSIBLE_GUESSES, 1)];
}

function checkGuess($guess) {
    global $CHOSEN_ANIMAL;
    return $CHOSEN_ANIMAL === $guess;
}