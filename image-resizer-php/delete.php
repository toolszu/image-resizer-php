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

// --- Use path constants from config.php for allowed directories ---
$allowedDirs = [UPLOADS_PATH, RESIZED_PATH];

// --- Response Helper Function ---
function sendResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

// --- Security Check Function ---
// This function ensures the file path is within one of the allowed directories.
function isPathSafe($filePath, $allowedDirs) {
    // Get the real, absolute path of the file.
    $realPath = realpath($filePath);
    
    // If the file doesn't exist, it's not "safe" to proceed.
    if ($realPath === false) {
        return false;
    }

    // Check if the real path starts with any of the allowed directory paths.
    foreach ($allowedDirs as $dir) {
        // realpath() on the allowed dir ensures a consistent comparison
        if (strpos($realPath, realpath($dir)) === 0) {
            return true; // The path is safe.
        }
    }
    
    return false;
}

// --- Input Handling ---
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    sendResponse(['error' => 'Invalid request.'], 400);
}

// Get the file paths from the input.
$originalPath = isset($input['original']) ? $input['original'] : null;
$resizedPath = isset($input['resized']) ? $input['resized'] : null;

if (!$originalPath && !$resizedPath) {
    sendResponse(['error' => 'No file paths provided to delete.'], 400);
}

// --- Deletion Logic ---
$deletedFiles = [];
$errors = [];

// Delete the original file if its path is provided and valid.
if ($originalPath) {
    if (isPathSafe($originalPath, $allowedDirs)) {
        if (file_exists($originalPath)) {
            if (unlink($originalPath)) {
                $deletedFiles[] = basename($originalPath);
            } else {
                $errors[] = "Could not delete original file.";
            }
        }
    } else {
        $errors[] = "Unauthorized attempt to delete original file.";
    }
}

// Delete the resized file if its path is provided and valid.
if ($resizedPath) {
    if (isPathSafe($resizedPath, $allowedDirs)) {
        if (file_exists($resizedPath)) {
            if (unlink($resizedPath)) {
                $deletedFiles[] = basename($resizedPath);
            } else {
                $errors[] = "Could not delete resized file.";
            }
        }
    } else {
        $errors[] = "Unauthorized attempt to delete resized file.";
    }
}

// --- Send Final Response ---
if (!empty($errors)) {
    sendResponse(['error' => implode('; ', $errors)], 500);
} else {
    sendResponse([
        'success' => true,
        'message' => 'Files deleted successfully.',
        'deleted' => $deletedFiles
    ]);
}
?>
