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
function sendResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

// --- Input Handling ---
// Get the JSON input from the request body.
$input = json_decode(file_get_contents('php://input'), true);

// Validate the input data.
if (!$input || !isset($input['filePath']) || !isset($input['width']) || !isset($input['height'])) {
    sendResponse(['error' => 'Invalid input. Missing required parameters.'], 400);
}

$sourcePath = $input['filePath'];
$newWidth = (int)$input['width'];
$newHeight = (int)$input['height'];

// --- Validation ---
// Check if the source file exists.
if (!file_exists($sourcePath)) {
    sendResponse(['error' => 'Source file not found on server.'], 404);
}

// Check for valid dimensions.
if ($newWidth <= 0 || $newHeight <= 0 || $newWidth > 5000 || $newHeight > 5000) {
    sendResponse(['error' => 'Invalid dimensions. Width and height must be between 1 and 5000 pixels.'], 400);
}

// --- Image Processing Logic ---
try {
    // Get image information (type, width, height).
    list($sourceWidth, $sourceHeight, $imageType) = getimagesize($sourcePath);

    // Create an image resource from the source file based on its type.
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_WEBP:
            $sourceImage = imagecreatefromwebp($sourcePath);
            break;
        default:
            throw new Exception('Unsupported image type.');
    }

    if (!$sourceImage) {
        throw new Exception('Could not create image resource from file.');
    }

    // Create a new true color image (the canvas for the resized image).
    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

    // --- Preserve Transparency for PNG and WEBP ---
    if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_WEBP) {
        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);
        $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
        imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
    }
    
    // Copy and resize the source image to the new canvas.
    imagecopyresampled(
        $resizedImage, $sourceImage,
        0, 0, 0, 0,
        $newWidth, $newHeight,
        $sourceWidth, $sourceHeight
    );

    // --- Save the Resized Image ---
    $originalFileName = pathinfo($sourcePath, PATHINFO_BASENAME);
    $newFileName = 'resized-' . $newWidth . 'x' . $newHeight . '-' . $originalFileName;
    // Use the path constant from config.php
    $destinationPath = RESIZED_PATH . '/' . $newFileName;

    $success = false;
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $success = imagejpeg($resizedImage, $destinationPath, 90); // 90% quality
            break;
        case IMAGETYPE_PNG:
            $success = imagepng($resizedImage, $destinationPath, 6); // Compression level 6
            break;
        case IMAGETYPE_WEBP:
            $success = imagewebp($resizedImage, $destinationPath, 90); // 90% quality
            break;
    }

    // --- Clean up memory ---
    imagedestroy($sourceImage);
    imagedestroy($resizedImage);

    if (!$success) {
        throw new Exception('Failed to save the resized image.');
    }
    
    // --- Send Success Response ---
    // Use the URL constant from config.php
    sendResponse([
        'success' => true,
        'filePath' => $destinationPath,
        'fileUrl' => RESIZED_URL . '/' . $newFileName,
        'fileName' => $newFileName
    ]);

} catch (Exception $e) {
    sendResponse(['error' => $e->getMessage()], 500);
}
?>
