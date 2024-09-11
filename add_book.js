document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('addBookForm');
    const messageDiv = document.getElementById('message');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('action', 'addBook');

        fetch('api.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                messageDiv.innerHTML = '<p class="success">تمت إضافة الكتاب بنجاح إلى مكتبة Al_Sana</p>';
                form.reset();
                //  هذا السطر لتحديث قائمة الكتب
                if (typeof updateBookList === 'function') updateBookList();
            } else {
                messageDiv.innerHTML = '<p class="error">حدث خطأ أثناء إضافة الكتاب: ' + result.error + '</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageDiv.innerHTML = '<p class="error">حدث خطأ أثناء إضافة الكتاب</p>';
        });
    });
});

//  هذه الدالة لتحديث قائمة الكتب
function updateBookList() {
    fetch('api.php?action=getBooks')
        .then(response => response.json())
        .then(books => {
            if (typeof displayBooks === 'function') displayBooks(books);
        })
        .catch(error => {
            console.error('Error updating book list:', error);
        });
}