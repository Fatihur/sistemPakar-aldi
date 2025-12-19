// Menunggu hingga seluruh konten halaman dimuat sebelum menjalankan script
document.addEventListener("DOMContentLoaded", () => {

    // --- Data Contoh Aktivitas Diagnosa ---
    // Anda bisa mengganti data ini dengan data asli dari database Anda.
    const diagnosisData = {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
        values: [88, 72, 95, 78, 110, 105, 123, 115, 130, 145, 132, 150]
    };

    // --- Opsi Konfigurasi untuk Grafik ApexCharts ---
    const chartOptions = {
        // Mendefinisikan seri data
        series: [{
            name: "Jumlah Diagnosa",
            data: diagnosisData.values
        }],
        // Pengaturan umum grafik
        chart: {
            type: 'bar', // Jenis grafik adalah 'bar'
            height: 350,
            toolbar: {
                show: false // Menyembunyikan menu toolbar di atas grafik
            }
        },
        // Opsi untuk tampilan batang
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%', // Lebar setiap batang
                borderRadius: 8, // Membuat sudut batang menjadi tumpul
                colors: {
                    backgroundBarColors: ['#f0f0f0'],
                    backgroundBarOpacity: 0.1,
                }
            },
        },
        // Pengaturan label data (angka di atas batang)
        dataLabels: {
            enabled: false // Menonaktifkan angka di atas setiap batang agar bersih
        },
        // Pengaturan sumbu X
        xaxis: {
            categories: diagnosisData.labels,
            labels: {
                style: {
                    fontSize: '12px',
                    fontFamily: 'Poppins, sans-serif'
                }
            }
        },
        // Pengaturan sumbu Y
        yaxis: {
            title: {
                text: 'Jumlah Diagnosa'
            }
        },
        // Pengaturan warna batang grafik
        colors: ['#007bff'], // Warna biru primer
        // Pengaturan tooltip saat mouse hover
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " diagnosa"
                }
            }
        },
        grid: {
            borderColor: '#e7e7e7',
            row: {
                colors: ['#f3f3f3', 'transparent'], // Warna zebra pada baris
                opacity: 0.5
            },
        },
    };

    // --- Render Grafik ---
    // Membuat instance baru dari ApexCharts
    const chart = new ApexCharts(document.querySelector("#diagnosis-chart"), chartOptions);
    // Menampilkan grafik
    chart.render();
});