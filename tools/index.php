<?php

    $url = "https://www.bcv.org.ve";
    
    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Adjust based on your security needs
    $html = curl_exec($ch);
    curl_close($ch);
    
    // Load HTML into DOMDocument
    $doc = new DOMDocument();
    @$doc->loadHTML($html); // @ to suppress warnings about malformed HTML
    
    // Use XPath to find the USD rate before "Fecha Valor"
    $xpath = new DOMXPath($doc);
    // Look for "USD" and the next numeric value, stopping before "Fecha Valor"
 
    $rate = null;
echo "hola";
    
    // Fallback: Use regex on raw HTML, targeting rate near "USD" but before "Fecha Valor"
    if (!$rate) {
        echo "hola";
        // Extract portion of HTML before "Fecha Valor"
       echo  $htmlBeforeFecha = substr($html, 0, strpos($html, 'Fecha Valor'));
        preg_match('/USD\s*[\r\n\s]*(\d+,\d{2,8})/', $htmlBeforeFecha, $matches);
        if (isset($matches[1])) {
            $rate = $matches[1];
        }
    }
    

?>