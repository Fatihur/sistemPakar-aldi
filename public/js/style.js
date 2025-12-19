document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('conversation-search');
    
    // Hanya jalankan jika elemen pencarian ada
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            const conversationList = document.querySelectorAll('.contacts-list > li');

            conversationList.forEach(function(item) {
                // Jangan filter item 'empty message'
                if (item.querySelector('.contacts-list-info')) {
                    const name = item.querySelector('.contacts-list-name').textContent.toLowerCase();
                    if (name.includes(filter)) {
                        item.style.display = ""; // Tampilkan jika cocok
                    } else {
                        item.style.display = "none"; // Sembunyikan jika tidak cocok
                    }
                }
            });
        });
    }
});