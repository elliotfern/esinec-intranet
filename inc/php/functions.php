<?php

/**
 * Formats a price with the given currency symbol, decimal separator, and thousands separator.
 *
 * @param float $price The price to format.
 * @return string The formatted price with currency symbol.
 */
function wc_price( $price ) {
    $currency_symbol = '€'; // replace with your currency symbol
    $decimal_separator = ','; // replace with your decimal separator
    $thousands_separator = '.'; // replace with your thousands separator
    
    $price = number_format( $price, 2, $decimal_separator, $thousands_separator );
    
    return $price . $currency_symbol;
}

function data_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

/**
 * Validates a form field.
 *
 * @param string $fieldName The name of the field to validate.
 * @param bool $isMoney Flag to indicate if the field should be treated as money.
 * @param bool $isInt Flag to indicate if the field should be treated as an integer.
 * @return mixed The validated field value.
 */
function validateFormField($fieldName, $isMoney = false, $isInt = false) {
    $hasError = false; // Flag to indicate if there is an error
    
    // Check if the field name is empty
    if (empty($fieldName)) {
        $hasError = true; // Empty field is considered an error
    } else {
        $fieldValue = data_input($fieldName); // Get the field value
        
        // Check if the field should be treated as money
        if ($isMoney) {
            // Check decimal separator and convert to dot if necessary
            if (strpos($fieldValue, ',') !== false && strpos($fieldValue, '.') === false) {
                $fieldValue = str_replace(',', '.', $fieldValue); // Replace comma with dot
            }
            
            // Check if the field value is numeric and has two decimal places
            if (!is_numeric($fieldValue) || round($fieldValue, 2) != $fieldValue) {
                $hasError = true; // Invalid field value is considered an error
            }
        } elseif ($isInt) {
            // Check if the field should be treated as an integer
            if (!filter_var($fieldValue, FILTER_VALIDATE_INT)) {
                $hasError = true; // Invalid field value is considered an error
            }
        }
    }
    
    return $fieldValue; // Return the validated field value
}
?>