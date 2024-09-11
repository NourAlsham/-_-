<?php
// تعريف المسار الأساسي للمشروع
define('BASE_PATH', __DIR__);

// تضمين ملف قاعدة البيانات
require_once BASE_PATH . '/db.php';


define('UPLOADS_PATH', BASE_PATH . '/uploads');
define('IMAGES_PATH', BASE_PATH . '/images');


define('BASE_URL', 'http://localhost/al_sana_library');


ini_set('display_errors', 1);
error_reporting(E_ALL);

// دالة لتحميل الملفات JavaScript
function load_js($file) {
    echo '<script src="' . BASE_URL . '/' . $file . '"></script>';
}

// دالة لتحميل ملفات CSS
function load_css($file) {
    echo '<link rel="stylesheet" href="' . BASE_URL . '/' . $file . '">';
}

// دالة للتحقق من وجود المجلدات الضرورية وإنشائها إذا لم تكن موجودة
function check_and_create_directories() {
    $directories = [UPLOADS_PATH, IMAGES_PATH];
    foreach ($directories as $dir) {
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}

// استدعاء دالة التحقق من المجلدات
check_and_create_directories();