<?php

// require libraries needed for "database" access
require_once 'DBBlackbox.php';

// start the session to have the possibility
// to work with flashed data
session_start();

include 'flashed-stuff.php'; // provides $flashed_messages 
                               // and the old() function

// display-form.php?action=create
// display-form.php?action=edit&puppy_id=1

// is this creating a new puppy or editing and existing puppy
if (isset($_GET['puppy_id'])) {
    // this is editing a puppy with id $_GET['puppy_id']
    
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

// prepare the query string for handle-form.php
// so that it too knows if this is create or edit
if (isset($_GET['puppy_id'])) {
    //               ?puppy_id=1   <- trying to create this
    $query_string = '?puppy_id=' . $_GET['puppy_id'];
} else {
    $query_string = '';
}

// same as above:
// $query_string = isset($_GET['puppy_id']) ? '?puppy_id=' . $_GET['puppy_id'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The form</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <nav>

            <a href="display-form.php">Create a new puppy</a>    
            <a href="display-form.php?puppy_id=1">Edit puppy 1</a>    
            <a href="display-form.php?puppy_id=2">Edit puppy 2</a>    
        
        </nav>
    </header>

    <?php foreach ($messages as $message) : ?>

        <div class="message"><?= $message ?></div>

    <?php endforeach; ?>

    <form action="handle-form.php<?= $query_string ?>" method="post">
    
        <label for="">
            Puppy name:<br>
            <input type="text" name="name" value="<?= htmlspecialchars(old('name', $puppy['name'])) ?>">
        </label>
        <br><br>

        <label for="">
            Breed:<br>
            <input type="text" name="breed" value="<?= old('breed', $puppy['breed']) ?>">
        </label>
        <br><br>

        <label for="">
            Cuteness level:<br>
            <select name="cuteness" id="">
                <option value="9" <?= old('cuteness', $puppy['cuteness']) == 9 ? 'selected' : '' ?>>9</option>
                <option value="10" <?= old('cuteness', $puppy['cuteness']) == 10 ? 'selected' : '' ?>>10</option>
            </select>
        </label>
        <br><br>

        <label for="">
            Gender:<br>
            <input type="radio" name="gender" value="male" <?= old('gender', $puppy['gender']) == 'male' ? 'checked' : '' ?>>
            <input type="radio" name="gender" value="female" <?= old('gender', $puppy['gender']) == 'female' ? 'checked' : '' ?>>
        </label>
        <br><br>

        <!-- <input type="submit" value="Save"> -->
        <button>Save</button>
    
    </form>
    
</body>
</html>
