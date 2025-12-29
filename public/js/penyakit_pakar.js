document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("image-modal-overlay");
    const modalImg = document.getElementById("modal-image");
    const caption = document.getElementById("modal-caption");
    const closeBtn = document.querySelector(".close-image-modal");

    // Klik gambar → buka modal
    document.querySelectorAll(".open-image-modal").forEach((img) => {
        img.addEventListener("click", function () {
            modal.style.display = "flex";
            modalImg.src = this.src;
            caption.textContent = this.dataset.caption || "";
        });
    });

    // Klik tombol X → tutup modal
    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
        modalImg.src = "";
    });

    // Klik area gelap → tutup modal
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
            modalImg.src = "";
        }
    });

    // ESC key → tutup modal
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            modal.style.display = "none";
            modalImg.src = "";
        }
    });
});
