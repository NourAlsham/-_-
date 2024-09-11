<?php
require_once 'config.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'getBooks':
        getBooks();
        break;
    case 'addBook':
        addBook();
        break;
    default:
        echo json_encode(['error' => 'إجراء غير معروف في مكتبة Al_Sana']);
}

function getBooks() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM books ORDER BY id DESC");
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($books);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'فشل في جلب الكتب من مكتبة Al_Sana: ' . $e->getMessage()]);
    }
}

function addBook() {
    global $pdo;
    
    error_log("Received POST data: " . print_r($_POST, true));
    error_log("Received FILES data: " . print_r($_FILES, true));

    if (empty($_POST['title']) || empty($_POST['author']) || empty($_POST['description'])) {
        echo json_encode(['error' => 'جميع الحقول مطلوبة لإضافة كتاب إلى مكتبة Al_Sana']);
        return;
    }

    $uploadDir = UPLOADS_PATH . '/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $imageFileName = uniqid() . '_' . basename($_FILES['image']['name']);
    $bookFileName = uniqid() . '_' . basename($_FILES['bookFile']['name']);
    $imageFilePath = $uploadDir . $imageFileName;
    $bookFilePath = $uploadDir . $bookFileName;

    error_log("Attempting to move uploaded files to: $imageFilePath and $bookFilePath");

    if (move_uploaded_file($_FILES['image']['tmp_name'], $imageFilePath) &&
        move_uploaded_file($_FILES['bookFile']['tmp_name'], $bookFilePath)) {
        
        try {
            $stmt = $pdo->prepare("INSERT INTO books (title, author, description, image, downloadLink) VALUES (?, ?, ?, ?, ?)");
            $result = $stmt->execute([
                $_POST['title'],
                $_POST['author'],
                $_POST['description'],
                'uploads/' . $imageFileName,
                'uploads/' . $bookFileName
            ]);

            if ($result) {
                error_log("Book added successfully to database");
                echo json_encode(['success' => true, 'message' => 'تمت إضافة الكتاب بنجاح إلى مكتبة Al_Sana']);
            } else {
                error_log("Failed to add book to database. PDO error info: " . print_r($stmt->errorInfo(), true));
                echo json_encode(['error' => 'فشل في إضافة الكتاب إلى قاعدة البيانات']);
            }
        } catch (PDOException $e) {
            error_log("PDO Exception: " . $e->getMessage());
            echo json_encode(['error' => 'فشل في إضافة الكتاب إلى مكتبة Al_Sana: ' . $e->getMessage()]);
        }
    } else {
        error_log("Failed to move uploaded files");
        echo json_encode(['error' => 'فشل في رفع الملفات إلى مكتبة Al_Sana']);
    }
}