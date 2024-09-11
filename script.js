document.addEventListener('DOMContentLoaded', function () {
    const addBookSection = document.getElementById('addBookSection');
    const bookListSection = document.getElementById('bookListSection');
    const showAddBookBtn = document.getElementById('showAddBook');
    const showBookListBtn = document.getElementById('showBookList');
    const addBookForm = document.getElementById('addBookForm');

    showAddBookBtn.addEventListener('click', () => {
        addBookSection.style.display = 'block';
        bookListSection.style.display = 'none';
    });

    showBookListBtn.addEventListener('click', () => {
        addBookSection.style.display = 'none';
        bookListSection.style.display = 'block';
        fetchBooks();
    });

    addBookForm.addEventListener('submit', function(e) {
        e.preventDefault();
        addBook();
    });

    fetchBooks(); // جلب الكتب عند تحميل الصفحة
});

function fetchBooks() {
    fetch('api.php?action=getBooks')
        .then(response => response.json())
        .then(books => {
            displayBooks(books);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء جلب الكتب من مكتبة Al_Sana');
        });
}

function displayBooks(books) {
    const booksContainer = document.getElementById('books');
    booksContainer.innerHTML = '';

    if (books.length === 0) {
        booksContainer.innerHTML = '<p>لا توجد كتب متاحة حاليًا في مكتبة Al_Sana.</p>';
        return;
    }

    books.forEach(book => {
        const bookElement = document.createElement('div');
        bookElement.classList.add('book-item');
        bookElement.innerHTML = `
            <h3>${book.title}</h3>
            <p>المؤلف: ${book.author}</p>
            <img src="${book.image}" alt="${book.title}" onerror="this.src='images/default-book.jpg'">
            <p>${book.description}</p>
            <a href="${book.downloadLink}" target="_blank">تحميل الكتاب من Al_Sana</a>
        `;
        booksContainer.appendChild(bookElement);
    });
}

function addBook() {
    const formData = new FormData(document.getElementById('addBookForm'));
    formData.append('action', 'addBook');

    fetch('api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('تمت إضافة الكتاب بنجاح إلى مكتبة Al_Sana');
            document.getElementById('addBookForm').reset();
            fetchBooks();
            document.getElementById('showBookList').click();
        } else {
            alert('حدث خطأ أثناء إضافة الكتاب إلى مكتبة Al_Sana: ' + result.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء إضافة الكتاب إلى مكتبة Al_Sana');
    });
}