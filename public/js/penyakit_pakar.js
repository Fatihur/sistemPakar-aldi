document.addEventListener('DOMContentLoaded', function() {
    // Ambil elemen-elemen modal
    const modal = document.getElementById('image-modal-overlay');
    const modalImg = document.getElementById('modal-image');
    const captionText = document.getElementById('modal-caption');
    const closeBtn = document.querySelector('.close-image-modal');

    // Ambil semua gambar thumbnail di tabel
    const images = document.querySelectorAll('.disease-image-thumbnail');

    // Tambahkan event listener untuk setiap gambar
    images.forEach(img => {
        img.addEventListener('click', function() {
            modal.style.display = "flex"; // Tampilkan modal
            modalImg.src = this.src; // Set gambar di modal dengan gambar yang diklik
            captionText.innerHTML = this.alt; // Set caption dengan teks alt gambar
        });
    });

    // Fungsi untuk menutup modal
    function closeModal() {
        modal.style.display = "none";
    }

    // Tambahkan event listener untuk tombol close
    if(closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }
    
    // Tambahkan event listener untuk mengklik di luar gambar (di overlay)
    if(modal) {
        modal.addEventListener('click', function(e) {
            // Hanya tutup jika yang diklik adalah overlay, bukan gambarnya
            if (e.target === modal) {
                closeModal();
            }
        });
    }
});