<?php

/**
 * [Image Resizer]
 *
 * @package   Toolszu - Image Resizer
 * @author    Toolszu
 * @copyright Copyright (c) 2026, Toolszu
 * @license   https://toolszu.com/licenses
 * @link      https://toolszu.com
 * @since     1.0.0
 *
 * This software is developed and maintained by Toolszu.
 * Unauthorized distribution, resale, or modification without prior
 * written permission is strictly prohibited.
 */
 
// Include the magic configuration file
require_once 'config.php';

// Set the content type to JSON for the response
header('Content-Type: application/json');

// --- Response Helper Function ---
// A helper function to send a JSON response and exit.
function sendResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

// --- File Upload Logic ---
// Check if any file was uploaded.
if (empty($_FILES['image'])) {
    sendResponse(['error' => 'No file uploaded.'], 400);
}

$file = $_FILES['image'];

// Check for upload errors.
if ($file['error'] !== UPLOAD_ERR_OK) {
    sendResponse(['error' => 'An error occurred during file upload.'], 500);
}

// Check file size (e.g., limit to 10MB).
$maxFileSize = 10 * 1024 * 1024; // 10 MB
if ($file['size'] > $maxFileSize) {
    sendResponse(['error' => 'File is too large. Maximum size is 10MB.'], 400);
}

// Validate file type by checking its MIME type.
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
$fileMimeType = mime_content_type($file['tmp_name']);
if (!in_array($fileMimeType, $allowedMimeTypes)) {
    sendResponse(['error' => 'Invalid file type. Only JPG, PNG, and WEBP are allowed.'], 400);
}

// --- Create a Secure and Unique Filename ---
// Get the file extension from the original name.
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
// Generate a unique filename to prevent overwriting files and for security.
$newFileName = uniqid('img_', true) . '.' . $fileExtension;
// The full path on the server where the file will be saved, using the constant from config.php
$destinationPath = UPLOADS_PATH . '/' . $newFileName;

// --- Move the Uploaded File ---
// Move the temporary file to its final destination.
if (move_uploaded_file($file['tmp_name'], $destinationPath)) {
    // If successful, send back the file path and URL using constants from config.php
    sendResponse([
        'success' => true,
        'filePath' => $destinationPath, 
        'fileUrl' => UPLOADS_URL . '/' . $newFileName
    ]);
} else {
    // If the move fails, send an error.
    sendResponse(['error' => 'Failed to save the uploaded file.'], 500);
}
?>
