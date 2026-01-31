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

require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Free & Easy Photo Resizing Tool</title>
    <meta name="description" content="Easily resize your images online for free. Our tool helps you resize photos (JPEG, PNG, WEBP) for social media, websites, or email without losing quality. Fast, secure, and simple to use.">
    <meta name="keywords" content="image resizer, photo resizer, resize image, online image resizer, resize png, resize jpeg, image size converter, picture resizer">
    
    <!-- Favicon -->
    <link rel="icon" href="/assets/favicon.png" type="image/png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts and Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- General Styles --- */
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .card { background-color: white; border-radius: 0.75rem; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); }
        .drag-area { border: 2px dashed #cbd5e1; transition: all 0.3s ease; }
        .drag-area.active { border-color: #2563eb; background-color: #eff6ff; }
        
        /* --- Button Styles --- */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            border: 1px solid transparent;
        }
        .btn-primary {
            background-color: #2563eb;
            color: white;
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
        }
        .btn-primary:disabled {
            background-color: #9ca3af;
            cursor: not-allowed;
        }
        .btn-danger {
            background-color: #dc2626;
            color: white;
        }
        .btn-danger:hover {
            background-color: #b91c1c;
        }
        .btn-light {
            background-color: #f1f5f9;
            color: #334155;
            border-color: #e2e8f0;
        }
        .btn-light:hover {
            background-color: #e2e8f0;
        }

        .fade-in { animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .loader { border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        /* --- Header & Mobile Menu Styles --- */
        .mobile-menu {
            transition: max-height 0.3s ease-in-out;
            max-height: 0;
            overflow: hidden;
        }
        .mobile-menu.open {
            max-height: 500px; /* Adjust as needed */
        }

        /* --- FAQ Styles --- */
        .faq-question {
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out, padding 0.3s ease-in-out;
            padding-top: 0;
            padding-bottom: 0;
        }
        .faq-answer.open {
            max-height: 200px; /* Adjust as needed */
            padding-top: 0.5rem; /* Corresponds to mt-2 */
        }
        .faq-icon {
            transition: transform 0.3s ease;
        }
        .faq-icon.open {
            transform: rotate(45deg);
        }
    </style>
</head>
<body class="text-slate-800 flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                 <a href="<?php echo BASE_URL; ?>/" class="flex items-center space-x-3">
                    <img src="<?php echo LOGO_URL; ?>" alt="Site Logo" class="h-10 w-auto" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <span class="font-bold text-xl" style="display:none;"><?php echo SITE_NAME; ?></span>
                 </a>
                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="<?php echo BASE_URL; ?>/" class="text-slate-600 hover:text-blue-600 transition">Home</a>
                    <a href="<?php echo BASE_URL; ?>/pages/about" class="text-slate-600 hover:text-blue-600 transition">About</a>
                    <a href="<?php echo BASE_URL; ?>/pages/contact" class="text-slate-600 hover:text-blue-600 transition">Contact</a>
                    <a href="<?php echo BASE_URL; ?>/pages/privacy" class="text-slate-600 hover:text-blue-600 transition">Privacy Policy</a>
                    <a href="<?php echo BASE_URL; ?>/pages/tos" class="text-slate-600 hover:text-blue-600 transition">Terms Of Service</a>
                    <a href="<?php echo BASE_URL; ?>/pages/disclaimer" class="text-slate-600 hover:text-blue-600 transition">Disclaimer</a>
                </nav>
                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-slate-800 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="mobile-menu md:hidden">
                <nav class="flex flex-col space-y-2 pb-4">
                    <a href="<?php echo BASE_URL; ?>/" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100">Home</a>
                    <a href="<?php echo BASE_URL; ?>/pages/about" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100">About</a>
                    <a href="<?php echo BASE_URL; ?>/pages/contact" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100">Contact</a>
                    <a href="<?php echo BASE_URL; ?>/pages/privacy" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100">Privacy Policy</a>
                    <a href="<?php echo BASE_URL; ?>/pages/tos" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100">Terms Of Service</a>
                    <a href="<?php echo BASE_URL; ?>/pages/disclaimer" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100">Disclaimer</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main id="tool" class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-slate-900">Resize Your Images Instantly</h1>
            <p class="mt-4 text-lg text-slate-600">Fast, free, and secure. Upload your image, set your desired size, and download. Perfect for web, social media, and more.</p>
        </div>

        <!-- Image Resizer Tool Card -->
        <div id="resizer-card" class="card max-w-4xl mx-auto mt-12 p-6 sm:p-8 lg:p-10">
            <div id="loader-container" class="hidden flex-col items-center justify-center">
                <div class="loader"></div>
                <p id="loader-text" class="mt-4 text-slate-600">Uploading...</p>
            </div>

            <div id="upload-container">
                <div id="drag-area" class="drag-area p-8 text-center rounded-lg cursor-pointer">
                     <div class="flex flex-col items-center justify-center space-y-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="text-lg font-medium text-slate-700">Drag & Drop Your Image Here</p>
                        <p class="text-slate-500">or</p>
                        <label for="file-input" class="btn btn-primary">Browse Files</label>
                        <input type="file" id="file-input" class="hidden" accept="image/png, image/jpeg, image/webp">
                    </div>
                </div>
                <p id="error-message" class="text-red-500 text-center mt-4"></p>
            </div>

            <div id="resize-container" class="hidden fade-in">
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex flex-col items-center">
                        <h3 class="text-xl font-semibold mb-4 text-slate-800">Original Image</h3>
                        <div class="w-full max-w-sm bg-slate-100 rounded-lg p-2">
                            <img id="image-preview" src="#" alt="Image Preview" class="max-w-full max-h-80 mx-auto rounded">
                        </div>
                        <p id="original-dimensions" class="mt-2 text-sm text-slate-500"></p>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-xl font-semibold mb-4 text-slate-800">Resize Options</h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1">
                                    <label for="width-input" class="block text-sm font-medium text-slate-700">Width (px)</label>
                                    <input type="number" id="width-input" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div class="flex-1">
                                    <label for="height-input" class="block text-sm font-medium text-slate-700">Height (px)</label>
                                    <input type="number" id="height-input" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="flex items-center">
                                <input id="aspect-ratio-checkbox" type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <label for="aspect-ratio-checkbox" class="ml-2 block text-sm text-slate-800">Maintain aspect ratio</label>
                            </div>
                            <div class="pt-4">
                                <button id="resize-btn" class="w-full btn btn-primary text-lg">Resize Image</button>
                                <button id="reset-btn" class="w-full btn btn-light mt-3">Choose Another Image</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="download-container" class="hidden fade-in text-center">
                <h3 class="text-2xl font-bold text-slate-900 mb-4">Your Resized Image is Ready!</h3>
                <div class="flex justify-center mb-6">
                   <img id="resized-image-preview" src="#" alt="Resized Image Preview" class="max-w-full max-h-80 mx-auto rounded-lg shadow-lg">
                </div>
                <p id="new-dimensions" class="mb-4 text-slate-600"></p>
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                    <a id="download-btn" href="#" download="resized-image.png" class="btn btn-primary text-lg w-full sm:w-auto">Download Image</a>
                    <button id="delete-btn" class="btn btn-danger text-lg w-full sm:w-auto">Delete Files</button>
                    <button id="start-over-btn" class="btn btn-light w-full sm:w-auto">Start Over</button>
                </div>
                <p id="delete-status" class="text-green-600 mt-4"></p>
            </div>
        </div>
        
        <section id="why-resize" class="max-w-4xl mx-auto mt-20 sm:mt-24">
             <div class="text-center mb-12">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900">Why Resizing Your Images Matters</h2>
                <p class="mt-3 text-lg text-slate-600">Optimized images are crucial for a fast and professional online presence.</p>
            </div>
            <div class="space-y-10">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="flex-shrink-0 w-24 h-24 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-rocket fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-slate-800">Boost Website Speed</h3>
                        <p class="mt-2 text-slate-600">Large image files are the number one cause of slow websites. Resizing images before uploading them drastically reduces page load times, improving user experience and SEO rankings. A faster site keeps visitors engaged and reduces bounce rates.</p>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="flex-shrink-0 w-24 h-24 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-share-alt fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-slate-800">Perfect for Social Media</h3>
                        <p class="mt-2 text-slate-600">Each social media platform has its own recommended image dimensions for posts, profiles, and cover photos. Our tool helps you resize your photos to the perfect size for Instagram, Facebook, Twitter, LinkedIn, and more, ensuring your content looks sharp and professional.</p>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row items-center gap-8">
                     <div class="flex-shrink-0 w-24 h-24 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-envelope fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-slate-800">Optimize for Email & Storage</h3>
                        <p class="mt-2 text-slate-600">Sending large images via email can be slow and may exceed attachment size limits. Resizing images makes them easier to send and faster to download for the recipient. It also saves valuable storage space on your device and cloud services.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="max-w-4xl mx-auto mt-20 sm:mt-24">
            <h2 class="text-3xl font-bold text-center text-slate-900 mb-12">Frequently Asked Questions</h2>
            <div class="space-y-4" id="faq-container">
                <!-- FAQ items will be dynamically populated by JavaScript -->
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-800 text-slate-300 mt-auto">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                 <p>Copyright &copy; <?php echo date("Y"); ?> <?php echo SITE_NAME; ?>. All Rights Reserved.</p>
                 <div class="mt-4 space-x-4 text-sm">
                    <a href="<?php echo BASE_URL; ?>/pages/tos" class="hover:text-white transition">Terms of Service</a>
                    <span>&middot;</span>
                    <a href="<?php echo BASE_URL; ?>/pages/privacy" class="hover:text-white transition">Privacy Policy</a>
                    <span>&middot;</span>
                    <a href="<?php echo BASE_URL; ?>/pages/disclaimer" class="hover:text-white transition">Disclaimer</a>
                 </div>
            </div>
        </div>
    </footer>

    <script>
        // --- Dynamic URLs from PHP Config ---
        const UPLOAD_URL = '<?php echo BASE_URL; ?>/upload.php';
        const RESIZE_URL = '<?php echo BASE_URL; ?>/resize.php';
        const DELETE_URL = '<?php echo BASE_URL; ?>/delete.php';

        // DOM Elements
        const resizerCard = document.getElementById('resizer-card');
        const fileInput = document.getElementById('file-input');
        const errorMessage = document.getElementById('error-message');
        const loaderContainer = document.getElementById('loader-container');
        const loaderText = document.getElementById('loader-text');
        const uploadContainer = document.getElementById('upload-container');
        const resizeContainer = document.getElementById('resize-container');
        const downloadContainer = document.getElementById('download-container');
        const imagePreview = document.getElementById('image-preview');
        const originalDimensions = document.getElementById('original-dimensions');
        const widthInput = document.getElementById('width-input');
        const heightInput = document.getElementById('height-input');
        const aspectRatioCheckbox = document.getElementById('aspect-ratio-checkbox');
        const resizeBtn = document.getElementById('resize-btn');
        const resetBtn = document.getElementById('reset-btn');
        const startOverBtn = document.getElementById('start-over-btn');
        const resizedImagePreview = document.getElementById('resized-image-preview');
        const newDimensions = document.getElementById('new-dimensions');
        const downloadBtn = document.getElementById('download-btn');
        const deleteBtn = document.getElementById('delete-btn');
        const deleteStatus = document.getElementById('delete-status');

        // State
        let originalImageFile = null;
        let serverFilePaths = { original: null, resized: null };
        let originalWidth = 0;
        let originalHeight = 0;
        let originalAspectRatio = 1;

        // --- Event Listeners ---
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile Menu Handler
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('open');
            });

            // FAQ Handler
            setupFAQ();

            // Drag and Drop Area
            const dragArea = document.getElementById('drag-area');
            dragArea.addEventListener('dragover', (e) => { e.preventDefault(); dragArea.classList.add('active'); });
            dragArea.addEventListener('dragleave', () => dragArea.classList.remove('active'));
            dragArea.addEventListener('drop', (e) => {
                e.preventDefault();
                dragArea.classList.remove('active');
                const files = e.dataTransfer.files;
                if (files.length) handleFile(files[0]);
            });
            
            dragArea.addEventListener('click', (e) => {
                if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'LABEL') {
                   fileInput.click();
                }
            });

            fileInput.addEventListener('change', () => { if (fileInput.files.length) handleFile(fileInput.files[0]); });
            widthInput.addEventListener('input', () => { if (aspectRatioCheckbox.checked) { const w = parseInt(widthInput.value); if (!isNaN(w) && w > 0) heightInput.value = Math.round(w / originalAspectRatio); }});
            heightInput.addEventListener('input', () => { if (aspectRatioCheckbox.checked) { const h = parseInt(heightInput.value); if (!isNaN(h) && h > 0) widthInput.value = Math.round(h * originalAspectRatio); }});
            resizeBtn.addEventListener('click', handleResize);
            resetBtn.addEventListener('click', resetTool);
            startOverBtn.addEventListener('click', resetTool);
            deleteBtn.addEventListener('click', handleDelete);
        });
        
        // --- FAQ Data and Setup ---
        const faqData = [
            { question: "Is this image resizer tool free to use?", answer: "Yes, this Image Resizer is 100% free to use. You can resize unlimited images without any hidden charges or registration requirements." },
            { question: "How do I resize an image without losing quality?", answer: "Our Image Resizer uses high-quality resampling algorithms to ensure minimal loss in quality. For best results, avoid scaling an image up too much from its original size." },
            { question: "Can I resize PNG, JPG, and WebP images?", answer: "Absolutely! Our online image resizer supports PNG, JPG, JPEG, and WebP formats." },
            { question: "Is it safe to resize images online using this tool?", answer: "Yes, it’s completely safe. Your uploaded files are automatically deleted from our servers after a short period. We do not store or share your images." },
            { question: "Do I need to install any software?", answer: "No, this is an entirely web-based tool. You don’t need to install any software or plugins. Just open the tool in your browser, upload your image, resize it, and download the result." },
            { question: "Can I use this tool on mobile devices?", answer: "Yes, our Image Resizer is fully responsive and mobile-friendly. You can upload, resize, and download images directly from your phone or tablet." }
        ];

        function setupFAQ() {
            const container = document.getElementById('faq-container');
            if (!container) return;
            container.innerHTML = '';
            faqData.forEach(item => {
                const faqItem = document.createElement('div');
                faqItem.className = 'card p-4 md:p-6';
                faqItem.innerHTML = `
                    <div class="faq-question">
                        <h3 class="font-semibold text-lg text-slate-800">${item.question}</h3>
                        <span class="faq-icon text-slate-500 text-2xl font-light">+</span>
                    </div>
                    <div class="faq-answer">
                        <p class="text-slate-600">${item.answer}</p>
                    </div>
                `;
                container.appendChild(faqItem);
            });

            container.addEventListener('click', (e) => {
                const questionHeader = e.target.closest('.faq-question');
                if (questionHeader) {
                    const answer = questionHeader.nextElementSibling;
                    const icon = questionHeader.querySelector('.faq-icon');
                    
                    document.querySelectorAll('.faq-answer.open').forEach(openAnswer => {
                        if (openAnswer !== answer) {
                            openAnswer.classList.remove('open');
                            const openIcon = openAnswer.previousElementSibling.querySelector('.faq-icon');
                            openIcon.classList.remove('open');
                            openIcon.textContent = '+';
                        }
                    });

                    answer.classList.toggle('open');
                    icon.classList.toggle('open');
                    icon.textContent = icon.classList.contains('open') ? '−' : '+';
                }
            });
        }


        // --- Core Functions ---
        async function handleFile(file) {
            errorMessage.textContent = '';
            if (!file.type.startsWith('image/')) {
                errorMessage.textContent = 'Invalid file type. Please upload an image.';
                return;
            }
            originalImageFile = file;
            
            const formData = new FormData();
            formData.append('image', originalImageFile);

            showLoader('Uploading...');
            
            try {
                const response = await fetch(UPLOAD_URL, { method: 'POST', body: formData });
                
                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Server Error (${response.status}): ${errorText.substring(0, 200)}`);
                }

                const result = await response.json();

                if (result.error) {
                    throw new Error(result.error);
                }

                serverFilePaths.original = result.filePath;
                imagePreview.src = result.fileUrl; 
                imagePreview.onload = () => {
                    originalWidth = imagePreview.naturalWidth;
                    originalHeight = imagePreview.naturalHeight;
                    originalAspectRatio = originalWidth / originalHeight;
                    originalDimensions.textContent = `Original: ${originalWidth} x ${originalHeight} px`;
                    widthInput.value = originalWidth;
                    heightInput.value = originalHeight;
                    showResizeView();
                };
            } catch (error) {
                showError(error.message);
            }
        }

        async function handleResize() {
            const width = parseInt(widthInput.value);
            const height = parseInt(heightInput.value);

            if (isNaN(width) || isNaN(height) || width <= 0 || height <= 0) {
                showError('Please enter valid width and height.', false);
                return;
            }

            showLoader('Resizing...');

            try {
                const response = await fetch(RESIZE_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        filePath: serverFilePaths.original,
                        width: width,
                        height: height
                    })
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Server Error (${response.status}): ${errorText.substring(0, 200)}`);
                }

                const result = await response.json();

                if (result.error) {
                    throw new Error(result.error);
                }
                
                serverFilePaths.resized = result.filePath;
                resizedImagePreview.src = result.fileUrl;
                downloadBtn.href = result.fileUrl;
                downloadBtn.download = result.fileName;
                newDimensions.textContent = `New size: ${width} x ${height} px`;
                showDownloadView();

            } catch (error) {
                showError(error.message, false);
            }
        }

        async function handleDelete() {
            deleteStatus.textContent = 'Deleting...';
            deleteBtn.disabled = true;

            try {
                const response = await fetch(DELETE_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        original: serverFilePaths.original,
                        resized: serverFilePaths.resized
                    })
                });
                const result = await response.json();

                if (!response.ok || result.error) {
                    throw new Error(result.error || 'Could not delete files.');
                }

                deleteStatus.textContent = result.message || 'Files deleted successfully!';
                deleteStatus.classList.remove('text-red-500');
                deleteStatus.classList.add('text-green-600');
                
            } catch (error) {
                deleteStatus.textContent = error.message;
                deleteStatus.classList.remove('text-green-600');
                deleteStatus.classList.add('text-red-500');
                deleteBtn.disabled = false;
            }
        }

        // --- UI Control Functions ---
        function showLoader(text) {
            loaderText.textContent = text;
            loaderContainer.style.display = 'flex';
            uploadContainer.style.display = 'none';
            resizeContainer.style.display = 'none';
            downloadContainer.style.display = 'none';
        }

        function showError(message, doReset = true) {
            errorMessage.textContent = message;
            if (doReset) {
                resetTool();
            } else { 
                loaderContainer.style.display = 'none';
                resizeContainer.style.display = 'block';
            }
        }

        function resetTool() {
            originalImageFile = null;
            serverFilePaths = { original: null, resized: null };
            fileInput.value = '';
            deleteStatus.textContent = '';
            deleteBtn.disabled = false;
            loaderContainer.style.display = 'none';
            uploadContainer.style.display = 'block';
            resizeContainer.style.display = 'none';
            downloadContainer.style.display = 'none';
        }

        function showResizeView() {
            loaderContainer.style.display = 'none';
            uploadContainer.style.display = 'none';
            resizeContainer.style.display = 'block';
            downloadContainer.style.display = 'none';
        }

        function showDownloadView() {
            loaderContainer.style.display = 'none';
            uploadContainer.style.display = 'none';
            resizeContainer.style.display = 'none';
            downloadContainer.style.display = 'block';
        }
    </script>
</body>
</html>

