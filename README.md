<div align="center">
  <img src="https://toolszu.com/assets/images/logo.png" alt="Toolszu Logo" width="200">

  # 📸 Professional Image Resizer (PHP)
  **The Official High-Performance Image Optimization Utility by [Toolszu.com](https://toolszu.com)**

  [![Website](https://img.shields.io/badge/Website-toolszu.com-blue)](https://toolszu.com)
  [![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)
  [![PHP](https://img.shields.io/badge/PHP-7.4+-777bb4)](https://php.net)
  [![Safety](https://img.shields.io/badge/Security-Verified-red)](#-security--brand-privacy)

---

</div>

## 🌟 Overview
Welcome to the official source code for the **Toolszu Image Resizer**. This tool is a lightweight, secure, and portable PHP solution designed for developers who need to integrate high-quality image resizing into their workflows without the overhead of heavy libraries.

### 🚀 Key Features
* **Universal Format Support:** Seamlessly resize JPEG, PNG, and WEBP formats.
* **Transparency Preservation:** Advanced logic to maintain alpha channels for PNG and WEBP files.
* **Magic Config (v2):** A truly dynamic configuration system that works instantly on any domain or subdirectory.
* **Modern UI:** A clean, responsive interface built with Tailwind CSS.
* **Automated Maintenance:** Includes a CLI-based cleanup script to keep your server storage optimized.

---

## 🛠️ Installation & Setup

1. **Upload:** Move the `image-resizer-php` folder to your server.
2. **Permissions:** Ensure the `uploads/` and `resized/` directories are writable (`chmod 755`).
3. **Configure:** (Optional) Update `config.php` to change your site name or logo.
4. **Cron Job:** Set up a cron job for `cleanup.php` to run hourly for automatic file management.

---

## 🛡️ Security & Brand Privacy
As a "Security-First" brand, we have implemented several professional safeguards:
* **Zero-Leak Config:** Error reporting is disabled in production to protect server paths.
* **Path Validation:** The deletion logic uses strict real-path checks to prevent unauthorized file access.
* **Access Control:** `.htaccess` rules block direct public access to sensitive system files.

---

## ⚖️ License
© 2026 **Toolszu**

This project is licensed under the **MIT License**. You are free to use, modify, and distribute this software, provided that the original copyright notice and company links remain intact.

---

<div align="center">
  <p>Maintained by <a href="https://toolszu.com">Toolszu</a></p>
  <i>Empowering digital workflows with professional-grade tools.</i>
</div>
