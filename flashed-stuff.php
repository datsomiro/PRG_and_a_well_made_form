<?php


/**
 * gets an array of flashed messages from the session
 * if they are there and deletes them from the session
 */
function getFlashedMessages()
{
    $flashed_messages = [];
 
    if (isset($_SESSION['flashed_messages'])) {
        $flashed_messages = $_SESSION['flashed_messages'];
        unset($_SESSION['flashed_messages']);
    }
 
    return $flashed_messages;
}

$messages = getFlashedMessages();

/**
 * define $flashed_data, fill it from the session
 * and delete it from the session (which is called
 * flashing)
 */
$flashed_data = [];
 
if (isset($_SESSION['flashed_data'])) {
    $flashed_data = $_SESSION['flashed_data'];
    unset($_SESSION['flashed_data']);
}
 
/**
 * gets the value submitted in the previous request by its name
 * 
 * allows to pass an optional second argument which is returned 
 * if such an element does not exist in old data
 */
function old($name, $default_value = null)
{
    // import $flashed_data from global scope
    // technically we don't want to use global
    // but right now we don't know how else to
    // use a variable both outside a function and inside
    // without having to pass it to each and every
    // call to the function :(
    global $flashed_data; 
 
    if (isset($flashed_data[$name])) {
        return $flashed_data[$name];
    } else {
        return $default_value;
    }
}