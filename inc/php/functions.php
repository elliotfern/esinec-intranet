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

?>