<?php require_once '../config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - <?php echo SITE_NAME; ?></title>
    <link rel="icon" href="<?php echo FAVICON_URL; ?>" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .content-card { background-color: white; border-radius: 0.75rem; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); }
        .prose p { margin-bottom: 1em; line-height: 1.6; }
        .mobile-menu { transition: max-height 0.3s ease-in-out; max-height: 0; overflow: hidden; }
        .mobile-menu.open { max-height: 500px; }
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
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="<?php echo BASE_URL; ?>/" class="text-slate-600 hover:text-blue-600 transition">Home</a>
                    <a href="<?php echo BASE_URL; ?>/pages/about" class="text-slate-600 hover:text-blue-600 transition">About</a>
                    <a href="<?php echo BASE_URL; ?>/pages/contact" class="text-blue-600 font-semibold">Contact</a>
                    <a href="<?php echo BASE_URL; ?>/pages/privacy" class="text-slate-600 hover:text-blue-600 transition">Privacy Policy</a>
                    <a href="<?php echo BASE_URL; ?>/pages/tos" class="text-slate-600 hover:text-blue-600 transition">Terms Of Service</a>
                    <a href="<?php echo BASE_URL; ?>/pages/disclaimer" class="text-slate-600 hover:text-blue-600 transition">Disclaimer</a>
                </nav>
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-slate-800 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                    </button>
                </div>
            </div>
            <div id="mobile-menu" class="mobile-menu md:hidden">
                <nav class="flex flex-col space-y-2 pb-4">
                    <a href="<?php echo BASE_URL; ?>/" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100">Home</a>
                    <a href="<?php echo BASE_URL; ?>/pages/about" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100">About</a>
                    <a href="<?php echo BASE_URL; ?>/pages/contact" class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 bg-slate-100">Contact</a>
                    <a href="<?php echo BASE_URL; ?>/pages/privacy" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100">Privacy Policy</a>
                    <a href="<?php echo BASE_URL; ?>/pages/tos" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100">Terms Of Service</a>
                    <a href="<?php echo BASE_URL; ?>/pages/disclaimer" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-100">Disclaimer</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="content-card max-w-4xl mx-auto p-6 sm:p-8 lg:p-10">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-6">Contact Us</h1>
            <div class="prose max-w-none text-slate-600">
                <p>We'd love to hear from you! Whether you have a question, feedback, or a suggestion, please feel free to reach out. We are constantly working to improve our tool and your input is valuable to us.</p>
                <p>You can contact us by sending an email to: <a href="mailto:support@example.com" class="text-blue-600 hover:underline">support@example.com</a>.</p>
                <p>We do our best to respond to all inquiries as quickly as possible.</p>
            </div>
        </div>
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
        document.getElementById('mobile-menu-button').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('open');
        });
    </script>
</body>
</html>

