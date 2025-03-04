<?php
function validateInput($input, $pattern = "/^[a-zA-Z0-9À-ÖØ-öø-ÿ\s\-']+$/") {
    $input = trim($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); 
    if (!preg_match($pattern, $input)) {
        return false;
    }
    return $input;
}
?>
