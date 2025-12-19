$(document).ready(function () {
    // ==========================================================
    // LOGIKA UNTUK HALAMAN CREATE & EDIT
    // ==========================================================

    // 1. Logika klik untuk Checkbox Card (Gejala)
    // Menggunakan delegation 'on' agar elemen baru (AJAX) juga bisa diklik
    $(document).on(
        "click",
        "#gejala-grid-container .symptom-card, .tab-pane .symptom-card",
        function (e) {
            var card = $(this);
            var checkbox = card.find('input[type="checkbox"]');

            // Mencegah double toggle jika yang diklik pas di checkbox-nya
            if (!$(e.target).is('input[type="checkbox"]')) {
                checkbox.prop("checked", !checkbox.prop("checked"));
            }
            // Update visual card
            card.toggleClass("checked", checkbox.prop("checked"));
        }
    );

    // 2. Logika klik untuk Checkbox Card (Solusi)
    $(document).on(
        "click",
        "#solusi-grid-container .symptom-card",
        function (e) {
            var card = $(this);
            var checkbox = card.find('input[type="checkbox"]');

            if (!$(e.target).is('input[type="checkbox"]')) {
                checkbox.prop("checked", !checkbox.prop("checked"));
            }
            card.toggleClass("checked", checkbox.prop("checked"));
        }
    );

    // 3. --- Logika AJAX Simpan GEJALA Baru ---
    $("#btnSimpanGejala").on("click", function () {
        var button = $(this);
        var ajaxUrl = button.data("url"); // Pastikan di HTML tombolnya ada data-url="..."

        button.prop("disabled", true).text("Menyimpan...");

        // Bersihkan error
        $("#gejala_kode, #gejala_nama, #gejala_bagian").removeClass(
            "is-invalid"
        );
        $("#error_gejala_kode, #error_gejala_nama, #error_gejala_bagian").text(
            ""
        );

        $.ajax({
            url: ajaxUrl,
            type: "POST",
            data: $("#formTambahGejala").serialize(),
            success: function (response) {
                if (response.success) {
                    var newGejala = response.gejala;

                    // Badge Kategori
                    var kategoriLabel = "";
                    if (newGejala.bagian) {
                        // Ubah snake_case ke spasi (opsional)
                        var displayBagian = newGejala.bagian
                            .replace("_", " ")
                            .toUpperCase();
                        kategoriLabel = `<span class="badge bg-info mb-1" style="font-size: 9px;">${displayBagian}</span>`;
                    }

                    // HTML Card Baru
                    var newCardHtml = `
                    <div class="col-md-6 col-lg-4 mb-2">
                        <label class="symptom-card checked w-100">
                            <input type="checkbox" name="gejala_ids[]" value="${newGejala.id}" checked>
                            <div class="symptom-content p-2 border rounded">
                                ${kategoriLabel}
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-primary">${newGejala.kode}</span>
                                </div>
                                <div class="symptom-desc small mt-1">${newGejala.gejala}</div>
                            </div>
                        </label>
                    </div>`;

                    // --- LOGIKA PENEMPATAN KARTU (PENTING) ---
                    // Cek ID container mana yang cocok berdasarkan kategori yang dipilih
                    // Asumsi ID Tab di View Anda: #daun, #batang_pucuk, dll. atau container di dalamnya.
                    var targetContainer = "#gejala-grid-container"; // Default

                    // Mencoba mencari container spesifik berdasarkan bagian
                    if ($("#container-" + newGejala.bagian).length) {
                        targetContainer = "#container-" + newGejala.bagian;
                    } else if ($("#" + newGejala.bagian + " .row").length) {
                        // Jika struktur tab pane -> row
                        targetContainer = "#" + newGejala.bagian + " .row";
                    }

                    $(targetContainer).append(newCardHtml);

                    // Reset Form
                    $("#modalTambahGejala").modal("hide");
                    $("#formTambahGejala")[0].reset();
                    Swal.fire("Berhasil!", response.message, "success");
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.kode) {
                        $("#gejala_kode").addClass("is-invalid");
                        $("#error_gejala_kode").text(errors.kode[0]);
                    }
                    if (errors.gejala) {
                        $("#gejala_nama").addClass("is-invalid");
                        $("#error_gejala_nama").text(errors.gejala[0]);
                    }
                    if (errors.bagian) {
                        $("#gejala_bagian").addClass("is-invalid");
                        $("#error_gejala_bagian").text(errors.bagian[0]);
                    }
                } else {
                    Swal.fire("Error!", "Terjadi kesalahan.", "error");
                }
            },
            complete: function () {
                button.prop("disabled", false).text("Simpan Gejala");
            },
        });
    });

    // 4. --- Logika Preview Gambar Solusi ---
    $("#solusi_gambar").on("change", function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $("#img-preview").attr("src", e.target.result);
                $("#preview-container").removeClass("d-none");
            };
            reader.readAsDataURL(file);
        } else {
            $("#preview-container").addClass("d-none");
        }
    });

    // 5. --- Logika AJAX Simpan SOLUSI Baru (FIX UPLOAD GAMBAR) ---
    $("#btnSimpanSolusi").on("click", function () {
        var button = $(this);

        // Ambil URL dari tombol "Obat Baru" yang ada di View utama
        // Kita cari elemen button pemicu modal untuk mengambil data-url nya
        var ajaxUrl = button.data("url");
        console.log("URL AJAX:", ajaxUrl);

        if (!ajaxUrl) {
            alert("URL Ajax tidak ditemukan!");
            return;
        }
        // Loading state
        button.prop("disabled", true).text("Menyimpan...");

        // Bersihkan error
        $("#solusi_kode, #solusi_nama, #solusi_gambar").removeClass(
            "is-invalid"
        );
        $("#error_solusi_kode, #error_solusi_nama, #error_solusi_gambar").text(
            ""
        );

        // Gunakan FormData untuk file upload
        var formElement = $("#formTambahSolusi")[0]; // Definisikan dulu (ambil form ID)
        var formData = new FormData(formElement);

        $.ajax({
            url: ajaxUrl,
            type: "POST",
            data: formData,
            processData: false, // Wajib false untuk FormData
            contentType: false, // Wajib false untuk FormData
            success: function (response) {
                if (response.success) {
                    var newSolusi = response.solusi;
                    var imgUrl = response.image_url;

                    // Cek apakah ada gambar untuk ditampilkan di card
                    var imgHtml = "";
                    if (imgUrl) {
                        imgHtml = `<div class="text-center mb-2">
                                       <img src="${imgUrl}" class="rounded" style="height: 50px; width: auto; object-fit: cover;">
                                   </div>`;
                    }

                    // Buat HTML Card baru
                    var newCardHtml = `
                    <label class="symptom-card checked">
                        <input type="checkbox" name="solusi_ids[]" value="${newSolusi.id}" checked>
                        <div class="symptom-content">
                            ${imgHtml}
                            <div class="symptom-code">${newSolusi.kode}</div>
                            <div class="symptom-desc">${newSolusi.nama_obat}</div>
                        </div>
                    </label>`;

                    // Append ke Grid
                    $("#solusi-grid-container").append(newCardHtml);

                    // Reset & Tutup Modal
                    $("#modalTambahSolusi").modal("hide");
                    $("#formTambahSolusi")[0].reset();
                    $("#preview-container-solusi").addClass("d-none");

                    Swal.fire("Berhasil!", response.message, "success");
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.kode) {
                        $("#solusi_kode").addClass("is-invalid");
                        $("#error_solusi_kode").text(errors.kode[0]);
                    }
                    if (errors.nama_obat) {
                        $("#solusi_nama").addClass("is-invalid");
                        $("#error_solusi_nama").text(errors.nama_obat[0]);
                    }
                    if (errors.gambar) {
                        $("#solusi_gambar").addClass("is-invalid");
                        $("#error_solusi_gambar").text(errors.gambar[0]);
                    }
                } else {
                    Swal.fire("Error!", "Terjadi kesalahan server.", "error");
                }
            },
            complete: function () {
                button.prop("disabled", false).text("Simpan Obat");
            },
        });
    });
});
