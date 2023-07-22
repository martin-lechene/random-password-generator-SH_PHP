<?php
// Script Name: Password_creator.php
// Description: Description du script.
//
// Created by: Martin Lechêne
// Date: 19/07/2023
// Version: 1.0
//

// Declaring min length of password.
const MIN_LENGTH = 8;

// Declaring arrays for characters for password.
$DIGITS = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
$LOWERCASE_CHARACTERS = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',  
                     'i', 'j', 'k', 'm', 'n', 'o', 'p', 'q', 
                     'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 
                     'z'];
$UPPERCASE_CHARACTERS = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',  
                     'I', 'J', 'K', 'M', 'N', 'O', 'p', 'Q', 
                     'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 
                     'Z'];
$SYMBOLS = ['@', '#', '$', '%', '=', ':', '?', '.', '/', '|', '~', '>',  
           '*', '(', ')'];

// This function will generate a password and return it.
function password_generator($pwd_len = MIN_LENGTH) {
    global $DIGITS, $LOWERCASE_CHARACTERS, $UPPERCASE_CHARACTERS, $SYMBOLS;

    $all_list = array_merge($DIGITS, $LOWERCASE_CHARACTERS, $UPPERCASE_CHARACTERS, $SYMBOLS);

    // Getting at least one different character
    $one_digit = $DIGITS[array_rand($DIGITS)];
    $one_lowercase = $LOWERCASE_CHARACTERS[array_rand($LOWERCASE_CHARACTERS)];
    $one_uppercase = $UPPERCASE_CHARACTERS[array_rand($UPPERCASE_CHARACTERS)];
    $one_symbol = $SYMBOLS[array_rand($SYMBOLS)];

    // Making base password with each character
    $strong_password = $one_digit . $one_lowercase . $one_symbol . $one_uppercase;

    // Adding remaining characters to the password
    for ($i = 0; $i < $pwd_len - 4; $i++) {
        $strong_password .= $all_list[array_rand($all_list)];
    }

    // Shuffling password
    $strong_password_array = str_split($strong_password);
    shuffle($strong_password_array);
    $strong_password = implode('', $strong_password_array);

    // Returning password
    return $strong_password;
}

// Main function to call our generator function
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "Enter the desired length of the password or type 'Default' for minimum length:";
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pwd_len = isset($_POST['pwd_len']) ? $_POST['pwd_len'] : MIN_LENGTH;
    if (strtolower($pwd_len) === 'default') {
        $pwd_len = MIN_LENGTH;
    }

    $password = password_generator(intval($pwd_len));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Generator</title>
</head>
<body>
    <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') { ?>
        <form method="post">
            <input type="text" name="pwd_len" placeholder="Desired password length or 'Default'">
            <button type="submit">Generate Password</button>
        </form>
    <?php } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') { ?>
        <h2>Generated Password:</h2>
        <p><?php echo $password; ?></p>
    <?php } ?>
</body>
</html>
