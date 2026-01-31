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
 
// --- Automatic File Cleanup Script with Security Check ---

// CRITICAL SECURITY CHECK:
// This ensures the script can only be run from the command line (e.g., a cron job)
// and not from a web browser.
if (php_sapi_name() !== 'cli' && php_sapi_name() !== 'cgi-fcgi') {
    http_response_code(403);
    die('<h1>403 Forbidden</h1><p>You do not have permission to access this file.</p>');
}

// --- Dynamic Configuration ---
// Load the main config file to get the correct, absolute directory paths.
// __DIR__ ensures the path is relative to this cleanup.php file.
require_once __DIR__ . '/config.php';

// Use the dynamically defined paths from the config file.
// This is much more reliable for a cron job.
$uploadDir = UPLOADS_PATH . '/';
$resizedDir = RESIZED_PATH . '/';
$maxFileAge = 3600; // Time in seconds. 3600 seconds = 1 hour.

// --- Helper Function to Clean a Directory ---
function cleanDirectory($dir, $maxAge) {
    echo "Scanning directory: $dir\n";
    
    if (!is_dir($dir) || !is_readable($dir)) {
        echo "Error: Directory '$dir' does not exist or is not readable.\n";
        return;
    }

    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            // Ignore special directories and common placeholder/security files.
            if ($file == '.' || $file == '..' || $file == '.htaccess' || $file == 'index.html') {
                continue;
            }

            $filePath = $dir . $file;

            if (is_file($filePath)) {
                // Check if the file is older than the max age.
                if ((time() - filemtime($filePath)) > $maxAge) {
                    if (unlink($filePath)) {
                        echo "Deleted old file: $filePath\n";
                    } else {
                        echo "Error deleting file: $filePath\n";
                    }
                }
            }
        }
        closedir($handle);
    } else {
        echo "Error: Could not open directory '$dir'.\n";
    }
    echo "Finished scanning directory: $dir\n\n";
}

// --- Execute Cleanup ---
set_time_limit(0); 

echo "Starting cleanup process at " . date('Y-m-d H:i:s') . "\n";
cleanDirectory($uploadDir, $maxFileAge);
cleanDirectory($resizedDir, $maxFileAge);
echo "Cleanup process complete.\n";

?>

