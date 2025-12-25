document.addEventListener('DOMContentLoaded', function () {
    
    // 1. Logika Lingkaran Persentase
    const circle = document.querySelector('.confidence-circle');
    if (circle) {
        const value = document.querySelector('.confidence-value').textContent.replace('%', '');
        // Set nilai --confidence di CSS untuk animasi
        circle.style.setProperty('--confidence', value);
    }

    // 2. Logika Grafik Bar (Chart.js)
    
    const ctx = document.getElementById('probabilityChart');
    
    // 'chartData' adalah variabel yang harus Anda buat di file Blade
    // untuk mengirim data dari Controller ke JavaScript
    if (ctx && typeof chartData !== 'undefined') {
        
        // Membuat warna dinamis: penyakit teratas akan berwarna hijau
        const backgroundColors = chartData.probabilities.map((prob) => {
            return prob > 50 ? '#28a745' : '#007bff';
        });

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels, // Kode Penyakit (P01, P02...)
                datasets: [{
                    label: 'Probabilitas Penyakit (%)',
                    data: chartData.probabilities, // Persentase (62.35, ...)
                    backgroundColor: backgroundColors,
                    borderColor: backgroundColors,
                    borderWidth: 1,
                    borderRadius: 5,
                }]
            },
            options: {
                indexAxis: 'y', // Membuat bar chart menjadi horizontal
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 100, // Skala dari 0 sampai 100%
                        title: {
                            display: true,
                            text: 'Persentase Keyakinan (%)'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Kode Penyakit'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda
                    }
                }
            }
        });
    }

    const obatModal = document.getElementById('obat-modal-overlay');
    
    // Pastikan elemen modal ada di halaman ini
    if (obatModal) {
        const modalObatImg = document.getElementById('modal-obat-image');
        const captionObatText = document.getElementById('modal-obat-caption');
        const closeObatBtn = document.querySelector('.close-obat-modal');

        // Ambil semua gambar obat yang bisa diklik
        const obatImages = document.querySelectorAll('.solution-image-clickable');

        obatImages.forEach(img => {
            img.addEventListener('click', function() {
                obatModal.style.display = "flex";
                modalObatImg.src = this.src;
                captionObatText.innerHTML = this.alt;
            });
        });

        // Fungsi untuk menutup modal
        function closeObatModal() {
            obatModal.style.display = "none";
        }

        // Event listener untuk tombol close (X)
        if(closeObatBtn) {
            closeObatBtn.addEventListener('click', closeObatModal);
        }
        
        // Event listener untuk klik di luar gambar (di overlay)
        obatModal.addEventListener('click', function(e) {
            if (e.target === obatModal) {
                closeObatModal();
            }
        });
    }

});

document.addEventListener("DOMContentLoaded", () => {

    const modal = document.getElementById("obatModal");
    const modalImg = document.getElementById("modal-obat-image");
    const modalCaption = document.getElementById("modal-obat-caption");
    const closeBtn = document.getElementById("closeObatModal");

    document.querySelectorAll(".solution-image-clickable").forEach(img => {
        img.onclick = () => {
            modal.style.display = "flex";
            modalImg.src = img.src;
            modalCaption.innerText = img.alt;
            document.body.style.overflow = "hidden";
        };
    });

    closeBtn.onclick = closeModal;
    modal.onclick = e => e.target === modal && closeModal();

    function closeModal(){
        modal.style.display = "none";
        document.body.style.overflow = "";
    }
});