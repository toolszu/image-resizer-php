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

/**
 * Magic Config for Portable Image Resizer Tool (v2)
 *
 * This configuration file dynamically generates all necessary paths and URLs,
 * allowing the tool to be deployed on any domain, subdomain, or subdirectory
 * without any manual changes to the code.
 */


// --- Truly Dynamic Path and URL Generation ---

// 1. Determine the protocol and domain
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];

// 2. Calculate the base path relative to the document root
// This is the key to making it work everywhere.
$documentRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$configFileDir = str_replace('\\', '/', __DIR__);
$basePath = str_replace($documentRoot, '', $configFileDir);
define('BASE_URL', rtrim($protocol . $domainName . $basePath, '/'));

// 3. Determine the base file path
define('BASE_PATH', __DIR__);

// 4. Define directory names
define('UPLOADS_DIR_NAME', 'uploads');
define('RESIZED_DIR_NAME', 'resized');

// 5. Define full server paths for file operations
define('UPLOADS_PATH', BASE_PATH . '/' . UPLOADS_DIR_NAME);
define('RESIZED_PATH', BASE_PATH . '/' . RESIZED_DIR_NAME);

// 6. Define full URLs for browser access
define('UPLOADS_URL', BASE_URL . '/' . UPLOADS_DIR_NAME);
define('RESIZED_URL', BASE_URL . '/' . RESIZED_DIR_NAME);

// --- Site-Specific Settings ---
define('SITE_NAME', 'Online Image Resizer');
define('LOGO_URL', BASE_URL . '/assets/logo.png'); 
define('FAVICON_URL', BASE_URL . '/assets/favicon.png');

// --- Create Directories if they don't exist ---
if (!is_dir(UPLOADS_PATH)) {
    mkdir(UPLOADS_PATH, 0755, true);
}
if (!is_dir(RESIZED_PATH)) {
    mkdir(RESIZED_PATH, 0755, true);
}

?>

