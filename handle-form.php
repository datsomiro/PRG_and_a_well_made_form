<?php

// require libraries needed for "database" access
require_once 'DBBlackbox.php';

// start the session to have the possibility
// to flash data
session_start();

// validation (a simple solution)
$valid = true;
$errors = [];

if (empty($_POST['name'])) { // is the name missing from POST or is it empty?
    $valid = false;
    $errors[] = 'The name field is mandatory.';
}

if ($_POST['cuteness'] > 9) {
    $valid = false;
    $errors[] = 'NO! That is too cute!';
}

if (!$valid) { // some check failed and $valid was set to false

    // flash submitted data
    $_SESSION['flashed_data'] = $_POST;

    // flash error messages
    $_SESSION['flashed_messages'] = $errors;

    // prepare a query string that reflects this being create or edit
    $query_string = 
        isset($_GET['puppy_id']) 
        ? '?puppy_id=' . $_GET['puppy_id']
        : '';

    // URL of form to create a new puppy:
    // display-form.php

    // URL of form to edit an existing puppy:
    // display-form.php?puppy_id=1

    header('Location: display-form.php' . $query_string);
    exit();
}

// is this creating a new puppy or editing and existing puppy
if (isset($_GET['puppy_id'])) {
    // this is editing a puppy with id $_GET['puppy_id']

    // get puppy_id from the URL
    $puppy_id = $_GET['puppy_id'];

    // find the correct puppy in the database
    $puppy = find($_GET['puppy_id']);

} else {
    // this is creating a new puppy

    // prepare empty data
    $puppy = [
        'name' => null,
        'breed' => null,
        'cuteness' => 9,
        'gender' => 'male'
    ];
}

// fill data with request data:

// long version for explanation
// if (isset($_POST['name'])) {
//     $puppy['name'] = $_POST['name'];
// } else {
//     $puppy['name'] = $puppy['name']; // i.e. "keep the value"
// }

// short version
$puppy['name']      = $_POST['name']     ?? $puppy['name'];
$puppy['breed']     = $_POST['breed']    ?? $puppy['breed'];
$puppy['cuteness']  = $_POST['cuteness'] ?? $puppy['cuteness'];
$puppy['gender']  = $_POST['gender']     ?? $puppy['gender'];

// save the data
if (isset($_GET['puppy_id'])) {
    // this is editing a puppy with id $_GET['puppy_id']
    
    // update an existing record
    update($_GET['puppy_id'], $puppy);

} else {
    // this is creating a new puppy
    $puppy_id = insert($puppy);
}

// flash success message(s)
$_SESSION['flashed_messages'] = [
    'Puppy successfully saved!'
];

// redirect (to the display form, with the inserted puppy's id)
header('Location: display-form.php?puppy_id=' . $puppy_id);