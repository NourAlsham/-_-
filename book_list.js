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
            <a href="${book.downloadLink}" target="_blank">تحميل الكتاب</a>
        `;
        booksContainer.appendChild(bookElement);
    });
}
document.addEventListener('DOMContentLoaded', fetchBooks);
