<?php
/*
Plugin Name: Affirmer
Description: Shows An Affirmation On Your Website. Add A Shortcode of 'affirm' and get to stepping
Version: 1.0
Author: Itai Neil Chiriseri
*/
// Define the shortcode function
function enqueue_bootstrap_stylesheet() {
    wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css');
}
function fetchAffirmation() {
    // Initialize cURL session
    $request = curl_init('https://www.affirmations.dev/');
    // Set cURL options
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
    // Execute cURL session and get the response
    $response = curl_exec($request);
    // Check if the request was successful
    if ($response === false) {
        return 'Failed To Get Affirmation';
    }
    // Decode the JSON response
    $data = json_decode($response);
    // Check if decoding was successful
    if (!$data) {
        return 'Failed to decode the JSON response';
    }
    // Close cURL session
    curl_close($request);

    // Get the affirmation
    $affirmation = $data->affirmation;

    // Echo the affirmation
    echo "<h4 style='color:green;' class='text-center'>Your Affirmation is " . $affirmation . "</h4>";

    return $affirmation;
}

add_action('wp_enqueue_scripts', 'enqueue_bootstrap_stylesheet');
add_action('wp_head', 'fetchAffirmation');
// Register the shortcode
add_shortcode('affirm', 'fetchAffirmation');
// Hook the function into the wp_head action
?>
