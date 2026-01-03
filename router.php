<?php
// Get the requested URI without the base path
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = trim($request, '/');  // Remove leading and trailing slashes

// Check if the corresponding PHP file exists (with the .php extension)
$filePath = $request . '.php';

if (file_exists($filePath)) {
    include $filePath;  // Include the .php file
} else {
    // Handle 404 or other routing logic
    echo "404 Not Found";
}
