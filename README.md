# NexTech — Full-Featured Electronics & Tech E-Commerce Platform
# NexTech — المتجر الإلكتروني المتكامل للتقنية والأجهزة الذكية

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-8.x-777BB4.svg?logo=php&logoColor=white)](https://www.php.net/)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-v3-38B2AC.svg?logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![MySQL](https://img.shields.io/badge/Database-MySQL-4479A1.svg?logo=mysql&logoColor=white)](https://www.mysql.com/)

---

## 🌐 Table of Contents / الفهرس
1. [English](#-english)
   - [Overview](#overview)
   - [Key Features](#key-features)
   - [Tech Stack](#tech-stack)
   - [Prerequisites](#prerequisites)
   - [Installation & Setup](#installation--setup)
   - [Project Structure](#project-structure)
   - [License](#license)
2. [العربية (Arabic)](#-باللغة-العربية)
   - [نبذة عن المشروع](#نبذة-عن-المشروع)
   - [الميزات الرئيسية](#الميزات-الرئيسية)
   - [التقنيات المستخدمة](#التقنيات-المستخدمة)
   - [متطلبات التشغيل](#متطلبات-التشغيل)
   - [طريقة التثبيت والتشغيل](#طريقة-التثبيت-والتشغيل)
   - [هيكل المشروع](#هيكل-المشروع)
   - [الترخيص](#الترخيص)

---

# 🇬🇧 English

## Overview
**NexTech** is a modern and comprehensive e-commerce platform built for laptops, desktop computers, surveillance systems, and tech accessories. Featuring an ultra-modern responsive design, an administrative dashboard with real-time statistics, and seamless product catalog browsing.

---

## Key Features
- 💻 **Modern Storefront**:
  - Advanced catalog filtering by categories and technical specifications.
  - Dedicated product detail pages with specs sheet and image previews.
  - Quick WhatsApp ordering integration.
- 📊 **Comprehensive Admin Dashboard**:
  - Live charts and key performance indicators (KPIs).
  - Full CRUD operations for products and categories.
  - Secure authentication portal for store managers.
- ⚡ **High Performance & Responsive Design**:
  - Styled with Tailwind CSS and enhanced with smooth animations.
  - Clean, organized PHP architecture.

---

## Tech Stack
- **Frontend**: HTML5, CSS3, JavaScript (ES6+), Tailwind CSS, FontAwesome, AOS.
- **Backend**: PHP 8.x
- **Database**: MySQL / MariaDB
- **Environment**: Apache / XAMPP / LAMP stack

---

## Prerequisites
- Local web server such as **XAMPP**, **WAMP**, or **Docker** with:
  - **PHP 7.4+** or **PHP 8.x**
  - **MySQL 5.7+** or **MariaDB**
  - Extensions enabled: `pdo_mysql`, `mbstring`, `fileinfo`

---

## Installation & Setup
1. **Clone or move the project**:
   Place the project directory into your web server document root:
   ```bash
   C:\xampp\htdocs\new-lapstore
   ```
2. **Setup Database**:
   - Navigate to **phpMyAdmin**: `http://localhost/phpmyadmin`
   - Create a new database named `lapstore`.
   - Import the project tables.
3. **Configure Database Connection**:
   - Check [`includes/db.php`](includes/db.php) and verify your credentials:
     ```php
     $host = 'localhost';
     $user = 'root';
     $pass = '';
     $dbname = 'lapstore';
     ```
4. **Launch the Application**:
   - Open your browser and go to:
     ```text
     http://localhost/new-lapstore/
     ```
   - Access the admin portal:
     ```text
     http://localhost/new-lapstore/dashboard.php
     ```

---

## Project Structure
```text
new-lapstore/
├── assets/                 # Stylesheets, scripts, and static assets
├── includes/
│   ├── db.php              # Database connection configuration
│   ├── header.php          # Global header and navigation bar
│   └── footer.php          # Global footer and contact section
├── uploads/                # Product image upload storage
├── api.php                 # Backend API endpoints for dashboard
├── dashboard.php           # Admin control panel
├── index.php               # Landing page and showcase
├── store.php               # Catalog and store browsing
├── product.php             # Individual product details page
├── portal_x9.php           # Secure admin portal login
├── LICENSE                 # MIT License file
└── README.md               # Documentation
```

---

## License
This project is open-source and licensed under the **[MIT License](LICENSE)**.

---

<br/>

# 🇸🇦 باللغة العربية

## نبذة عن المشروع
**NexTech** هو منصة تجارة إلكترونية متطورة مخصصة لبيع أجهزة اللابتوب، الحواسيب، كاميرات المراقبة والأنظمة الأمنية وملحقات التقنية. يتميز المشروع بتصميم عصري واحترافي، لوحة تحكم إدارية كاملة لإدارة المخزون والطلبات، بالإضافة إلى واجهة استخدام سلسة وسريعة متوافقة مع جميع أحجام الشاشات.

---

## الميزات الرئيسية
- 💻 **واجهة متجر تفاعلية حديثة**:
  - استعراض متقدم للمنتجات مع فلاتر حسب الفئة والمواصفات.
  - صفحات تفصيلية للمنتجات مع معرض صور ومواصفات تفصيلية.
  - سلة مشتريات وتجربة طلب سهلة.
  - تكامل مباشر مع WhatsApp لخدمة العملاء والطلبات السريعة.
- 📊 **لوحة تحكم شاملة للإدارة (Admin Dashboard)**:
  - إحصائيات فورية ورسوم بيانية حول المبيعات والأداء.
  - إضافة، تعديل، وحذف المنتجات بسهولة مع رفع الصور.
  - إدارة تصنيفات المنتجات وحالات توفر المخزون.
  - واجهة آمنة لتسجيل دخول المسؤول.
- ⚡ **أداء عالي وتصميم متجاوب**:
  - واجهات مبنية باستخدام Tailwind CSS وتأثيرات بصرية جذابة (AOS Animations).
  - كتابة كود PHP نظيف ومنظم.

---

## التقنيات المستخدمة
- **الواجهة الأمامية (Frontend)**: HTML5, CSS3, JavaScript (ES6+), Tailwind CSS, FontAwesome, AOS.
- **الواجهة الخلفية (Backend)**: PHP 8.x
- **قاعدة البيانات (Database)**: MySQL / MariaDB (باستخدام PDO / MySQLi)
- **بيئة التشغيل المحلية**: XAMPP / WampServer / LAMP

---

## متطلبات التشغيل
- تثبيت حزمة **XAMPP** أو أي سيرفر محلي يدعم:
  - **PHP 7.4+** أو **PHP 8.x**
  - **MySQL 5.7+** أو **MariaDB**
  - تفعيل امتدادات: `pdo_mysql`, `mbstring`, `fileinfo`

---

## طريقة التثبيت والتشغيل
1. **استنساخ المستودع أو نقله**:
   قم بنسخ مجلد المشروع داخل مسار السيرفر المحلي:
   ```bash
   C:\xampp\htdocs\new-lapstore
   ```
2. **إنشاء قاعدة البيانات**:
   - افتح **phpMyAdmin** عبر المتصفح: `http://localhost/phpmyadmin`
   - أنشئ قاعدة بيانات جديدة باسم: `lapstore`
   - استورد ملف الجداول والبيانات إن وجد أو تأكد من إعداد الجداول من ملفات التهيئة.
3. **ضبط إعدادات الاتصال**:
   - افتح الملف [`includes/db.php`](includes/db.php) وتأكد من بيانات السيرفر وقاعدة البيانات:
     ```php
     $host = 'localhost';
     $user = 'root';
     $pass = '';
     $dbname = 'lapstore';
     ```
4. **تشغيل الموقع**:
   - افتح المتصفح وانتقل إلى:
     ```text
     http://localhost/new-lapstore/
     ```
   - للوصول للوحة التحكم:
     ```text
     http://localhost/new-lapstore/dashboard.php
     ```

---

## هيكل المشروع
```text
new-lapstore/
├── assets/                 # ملفات التنسيق والسكربتات والصور
├── includes/
│   ├── db.php              # ملف الاتصال بقاعدة البيانات
│   ├── header.php          # ترويسة الموقع الرئيسية وشريط التنقل
│   └── footer.php          # تذييل الموقع وروابط التواصل
├── uploads/                # مجلد حفظ صور المنتجات المرفوعة
├── api.php                 # واجهة برمجة التطبيقات (API) للوحة التحكم
├── dashboard.php           # لوحة تحكم المسؤول الشاملة
├── index.php               # الصفحة الرئيسية للمتجر
├── store.php               # صفحة تصفح وشراء المنتجات
├── product.php             # صفحة تفاصيل المنتج الواحد
├── portal_x9.php           # بوابة تسجيل دخول الإدارة الآمنة
├── LICENSE                 # رخصة الاستخدام (MIT)
└── README.md               # التوثيق الشامل
```

---

## الترخيص
هذا المشروع مرخص بموجب رخصة **[MIT](LICENSE)**.
