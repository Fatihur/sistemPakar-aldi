/**
 * File: script.js / cuaca.js
 * Deskripsi: Menampilkan data cuaca KHUSUS untuk Kec. Moyo Hulu, Kab. Sumbawa
 * menggunakan OpenWeatherMap API.
 */

// --- KONFIGURASI ---
const API_KEY = "b84a82b4f2d87bd82167efe9d9a7ad69"; // API Key Anda

// KOORDINAT SPESIFIK: KECAMATAN MOYO HULU, KAB. SUMBAWA
// Koordinat ini diambil dari titik tengah area Moyo Hulu
const LAT_MOYO_HULU = -8.6189; 
const LON_MOYO_HULU = 117.4485;
const NAMA_LOKASI_TETAP = "Moyo Hulu, Kab. Sumbawa";

/**
 * Mengambil data cuaca dari OpenWeatherMap
 */
async function fetchWeather() {
    // URL Endpoint API
    const apiUrl = `https://api.openweathermap.org/data/2.5/weather?lat=${LAT_MOYO_HULU}&lon=${LON_MOYO_HULU}&units=metric&lang=id&appid=${API_KEY}`;
    
    try {
        const response = await fetch(apiUrl);
        
        if (!response.ok) {
            throw new Error(`Gagal mengambil data (Status: ${response.status})`);
        }
        
        return await response.json();
    } catch (error) {
        throw new Error('Gagal koneksi ke server cuaca.');
    }
}

/**
 * Memperbarui tampilan HTML (UI)
 */
function updateWeatherUI(data) {
    // Ambil elemen HTML
    const descEle = document.getElementById('weather-description');
    const tempEle = document.getElementById('weather-temp');
    const detailsEle = document.getElementById('weather-details');
    const iconEle = document.getElementById('weather-icon');
    const locationEle = document.getElementById('weather-location');

    // Cek keberadaan elemen agar tidak error
    if (!descEle || !tempEle || !detailsEle || !iconEle || !locationEle) return;

    // Ambil data yang dibutuhkan dari respon JSON
    const { weather, main, wind } = data;
    
    // Format Deskripsi (Huruf pertama kapital)
    const rawDesc = weather[0].description;
    const description = rawDesc.charAt(0).toUpperCase() + rawDesc.slice(1);

    // 1. Tampilkan Nama Lokasi (Hardcoded agar tetap Moyo Hulu)
    locationEle.textContent = NAMA_LOKASI_TETAP;

    // 2. Tampilkan Deskripsi & Suhu (dibulatkan)
    descEle.textContent = description;
    tempEle.textContent = `${Math.round(main.temp)}°C`;

    // 3. Tampilkan Detail (Kelembapan & Kecepatan Angin)
    // m/s = meter per detik
    detailsEle.innerHTML = `Kelembapan: ${main.humidity}% &middot; Angin: ${wind.speed} m/s`;

    // 4. Tampilkan Ikon Cuaca
    const iconCode = weather[0].icon;
    const iconUrl = `https://openweathermap.org/img/wn/${iconCode}@2x.png`;
    iconEle.innerHTML = `<img src="${iconUrl}" alt="${description}" style="width: 65px; height: 65px;">`;
}

/**
 * Fungsi Utama (Inisialisasi)
 */
async function initializeWeatherApp() {
    const weatherContent = document.getElementById('weather-content');
    const locationEle = document.getElementById('weather-location');
    const descEle = document.getElementById('weather-description');

    // Tampilkan status "Memuat..." saat awal
    if (locationEle) locationEle.textContent = NAMA_LOKASI_TETAP;
    if (descEle) descEle.textContent = "Memuat data cuaca...";

    try {
        // Panggil fungsi fetch
        const data = await fetchWeather();
        // Update tampilan
        updateWeatherUI(data);

    } catch (err) {
        console.error(err);
        // Tampilkan pesan error jika gagal
        if (weatherContent) {
            weatherContent.innerHTML = `<p class="text-danger small text-center" style="padding:10px;">${err.message}</p>`;
        }
    }
}

// Jalankan script otomatis saat halaman siap
document.addEventListener('DOMContentLoaded', initializeWeatherApp);