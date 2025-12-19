document.addEventListener("DOMContentLoaded", function () {
    // 1. Tentukan Koordinat (Marga Karya, Moyo Hulu)
    var lat = -8.6366;
    var lng = 117.4584;

    // 2. Inisialisasi Peta
    var map = L.map("map").setView([lat, lng], 15); // Angka 15 adalah level zoom

    // 3. Tambahkan Tile Layer (Tampilan Peta - Mode Hybrid/Satelit agar terlihat sawah/lahan)
    // Kita pakai Google Maps Style agar terlihat familiar
    L.tileLayer("http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}", {
        maxZoom: 20,
        subdomains: ["mt0", "mt1", "mt2", "mt3"],
    }).addTo(map);

    // --- OPSI LAIN: Jika ingin tampilan peta jalan biasa (bersih), ganti kode di atas dengan ini: ---
    /*
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        */

    // 4. Custom Icon (Agar terlihat seperti kantor)
    var officeIcon = L.icon({
        iconUrl: "https://cdn-icons-png.flaticon.com/512/2776/2776067.png", // Ikon Gedung Hijau
        iconSize: [40, 40], // Ukuran ikon
        iconAnchor: [20, 40], // Titik tumpu ikon
        popupAnchor: [0, -40], // Posisi popup relatif terhadap ikon
    });

    // 5. Konten Popup yang Menarik
    var popupContent = `
            <div class="custom-popup">
                <div class="popup-header">
                    Balai Penyuluhan Pertanian
                </div>
                <div class="popup-body">
                    <b>Marga Karya, Kec. Moyo Hulu</b><br>
                    Kabupaten Sumbawa, NTB<br>
                    Kode Pos: 84371<br><br>
                    
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" 
                       target="_blank" class="btn-rute">
                       <i class="bi bi-cursor-fill"></i> Buka Rute Google Maps
                    </a>
                </div>
            </div>
        `;

    // 6. Tambahkan Marker ke Peta
    L.marker([lat, lng], { icon: officeIcon })
        .addTo(map)
        .bindPopup(popupContent)
        .openPopup(); // Otomatis nampilkan popup saat load
});
