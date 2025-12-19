document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll(".wizard-step");
    const nextButtons = document.querySelectorAll(".next-step");
    const prevButtons = document.querySelectorAll(".prev-step");
    const progressBar = document.getElementById("progressBar");
    const form = document.getElementById("diagnosa-form");
    const symptomCards = document.querySelectorAll(".symptom-card");

    let currentStep = 0;
    const totalSteps = steps.length;

    // Fungsi untuk menampilkan langkah berdasarkan nomor
    function showStep(stepIndex) {
        // Sembunyikan semua langkah
        steps.forEach((step) => step.classList.remove("active"));

        // Tampilkan langkah yang diinginkan
        if (steps[stepIndex]) {
            steps[stepIndex].classList.add("active");
            currentStep = stepIndex;
            updateProgressBar();
        }
    }

    // Fungsi untuk memperbarui progress bar
    function updateProgressBar() {
        // Menghitung persentase progress
        const progress = (currentStep / (totalSteps - 1)) * 100;
        progressBar.style.width = progress + "%";
        // Opsional: Update aria-valuenow untuk aksesibilitas
        progressBar.setAttribute("aria-valuenow", progress);
    }
    // Event listener untuk tombol "Berikutnya"
    nextButtons.forEach((button) => {
        button.addEventListener("click", () => {
            if (currentStep < totalSteps - 1) {
                showStep(currentStep + 1);
            }
        });
    });

    // Event listener untuk tombol "Sebelumnya"
    prevButtons.forEach((button) => {
        button.addEventListener("click", () => {
            if (currentStep > 0) {
                // PERBAIKAN: Gunakan kurang (-) bukan tambah (+)
                showStep(currentStep - 1);
            }
        });
    });

    // Event listener untuk kartu gejala (toggle class 'checked')
    symptomCards.forEach((card) => {
        const checkbox = card.querySelector('input[type="checkbox"]');
        card.addEventListener("click", (e) => {
            // Kita toggle class 'checked' berdasarkan status checkbox
            if (checkbox.checked) {
                card.classList.add("checked");
            } else {
                card.classList.remove("checked");
            }
        });
    });

    // Event listener untuk submit form
    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Hentikan submit otomatis

        // Cek jika ada SweetAlert2
        if (typeof Swal === "undefined") {
            // Jika tidak ada SweetAlert, langsung submit
            form.submit();
        } else {
            // Tampilkan loading spinner
            Swal.fire({
                title: "Menganalisis Gejala...",
                text: "Mohon tunggu, sistem sedang menghitung diagnosis.",
                imageUrl: "https://i.gifer.com/ZZ5H.gif", // Anda bisa ganti dengan URL loading GIF
                imageWidth: 100,
                imageHeight: 100,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });

            // Langsung submit form ke backend
            form.submit();
        }
    });

    // Tampilkan langkah pertama saat halaman dimuat
    showStep(0);
});
