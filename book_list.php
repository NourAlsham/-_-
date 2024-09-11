<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة الكتب - مكتبة Al_Sana</title>
    <?php load_css('style.css'); ?>
</head>
<body>
    <header>
        <h1>مكتبة Al_Sana</h1>
        <nav>
            <a href="add_book.php">إضافة كتاب</a>
        </nav>
    </header>

    <main>
        <h2>قائمة الكتب</h2>
        <div id="books"></div>
    </main>

    <?php 
    load_js('book_list.js');
    load_js('add_book.js');
    ?>
</body>
</html>