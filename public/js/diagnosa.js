document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll(".wizard-step");
    const nextButtons = document.querySelectorAll(".next-step");
    const prevButtons = document.querySelectorAll(".prev-step");
    const progressBar = document.getElementById("progressBar");
    const form = document.getElementById("diagnosa-form");
    const symptomCards = document.querySelectorAll(".symptom-card");

    let currentStep = 0;
    const totalSteps = steps.length;

    /* =========================
       TAMPILKAN STEP
    ========================== */
    function showStep(stepIndex) {
        steps.forEach((step) => step.classList.remove("active"));

        if (steps[stepIndex]) {
            steps[stepIndex].classList.add("active");
            currentStep = stepIndex;
            updateProgressBar();
        }
    }

    /* =========================
       UPDATE PROGRESS BAR + %
    ========================== */
    function updateProgressBar() {
        // contoh:
        // step 0 dari 4 = 0%
        // step 1 dari 4 = 25%
        const progress = Math.round((currentStep / (totalSteps - 1)) * 100);

        progressBar.style.width = progress + "%";
        progressBar.textContent = progress + "%"; // ⭐ INI YANG KURANG
        progressBar.setAttribute("aria-valuenow", progress);
    }

    /* =========================
       NEXT STEP
    ========================== */
    nextButtons.forEach((button) => {
        button.addEventListener("click", () => {
            if (currentStep < totalSteps - 1) {
                showStep(currentStep + 1);
            }
        });
    });

    /* =========================
       PREVIOUS STEP
    ========================== */
    prevButtons.forEach((button) => {
        button.addEventListener("click", () => {
            if (currentStep > 0) {
                showStep(currentStep - 1);
            }
        });
    });

    /* =========================
       CHECK SYMPTOM CARD
    ========================== */
    symptomCards.forEach((card) => {
        const checkbox = card.querySelector('input[type="checkbox"]');

        card.addEventListener("click", () => {
            checkbox.checked = !checkbox.checked;
            card.classList.toggle("checked", checkbox.checked);
        });
    });

    /* =========================
       SUBMIT FORM
    ========================== */
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        if (typeof Swal === "undefined") {
            form.submit();
            return;
        }

        Swal.fire({
            title: "Menganalisis Gejala...",
            text: "Sistem sedang memproses diagnosis",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading(),
        });

        form.submit();
    });

    /* =========================
       INIT
    ========================== */
    showStep(0); // step awal = 0% ✔
});
