<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة كتاب - مكتبة Al_Sana</title>
    <?php load_css('style.css'); ?>
</head>
<body>
    <header>
        <h1>مكتبة Al_Sana</h1>
        <nav>
            <a href="book_list.php">عرض الكتب</a>
        </nav>
    </header>

    <main>
        <h2>إضافة كتاب جديد</h2>
        <form id="addBookForm" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="عنوان الكتاب" required>
            <input type="text" name="author" placeholder="اسم المؤلف" required>
            <textarea name="description" placeholder="وصف الكتاب" required></textarea>
            <input type="file" name="image" accept="image/*" required>
            <input type="file" name="bookFile" accept=".pdf,.epub,.mobi" required>
            <button type="submit">إضافة الكتاب</button>
        </form>
        <div id="message"></div>
    </main>

    <?php load_js('add_book.js'); ?>
</body>
</html>