document.addEventListener('DOMContentLoaded', function() {
    // Cari elemen judul H3 di dalam header
    const headerTitle = document.querySelector('.app-content-header .col-sm-6 h3');

    if (headerTitle) {
        // Fungsi untuk mendapatkan sapaan berdasarkan waktu
        function getGreeting() {
            const hour = new Date().getHours();
            if (hour < 11) {
                return 'Selamat Pagi, Pakar!';
            } else if (hour < 15) {
                return 'Selamat Siang, Pakar!';
            } else if (hour < 19) {
                return 'Selamat Sore, Pakar!';
            } else {
                return 'Selamat Malam, Pakar!';
            }
        }

        // Ganti teks judul dengan sapaan dinamis
        headerTitle.textContent = getGreeting();
        
        // Tambahkan ikon di sebelah sapaan
        headerTitle.innerHTML += ' <i class="bi bi-chat-dots-fill fs-4 ms-2"></i>';
    }
});
