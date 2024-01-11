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
function validateFormField($fieldName, $isMoney = false, $isInt = false, $optional = false) {
    $hasError = false; // Flag to indicate if there is an error
  
    if (empty($fieldName)) {
      if (!$optional) {
        $hasError = true; // Empty field is considered an error unless it is optional
        $fieldValue = NULL;
      }
    } else {
      $fieldValue = data_input($fieldName); // Get the field value
  
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
        // Check if the field value is a valid integer
        if (!filter_var($fieldValue, FILTER_VALIDATE_INT)) {
          $hasError = true; // Invalid field value is considered an error
        }
      }
    }

    if ($hasError === true) {
      return array(
          'value' => NULL,
          'hasError' => true
      );
  } else {
      return array(
          'value' => $fieldValue,
          'hasError' => false
      );
  }
}

  function generarPassword($longitud = 8) {
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';

    $max = strlen($caracteres) - 1;

    for ($i = 0; $i < $longitud; $i++) {
        $index = mt_rand(0, $max);
        $password .= $caracteres[$index];
    }

    return $password;
}

function unirNombres($firstName, $lastName) {
  // Eliminar espacios y caracteres especiales del first name
  $firstName = preg_replace('/[^A-Za-z0-9]/', '', $firstName);
  
  // Eliminar espacios y caracteres especiales del last name
  $lastName = preg_replace('/[^A-Za-z0-9]/', '', $lastName);
  
  // Convertir a minúsculas
  $firstName = strtolower($firstName);
  $lastName = strtolower($lastName);
  
  // Unir los nombres sin espacios
  $nombreCompleto = $firstName . $lastName;
  
  return $nombreCompleto;
}
?>