document.addEventListener("DOMContentLoaded", function () {
    const notificationCountEl = document.getElementById("notification-count");
    const notificationListEl = document.getElementById("notification-list");

    // Pastikan gambar ini ada di folder public Anda
    const defaultAvatar = "{{ asset('lte/dist/assets/img/user_avatar.png') }}";

    // URL untuk "Lihat Semua Pesan"
    const seeAllUrl = "{{ route('notifications.fetch') }}";

    function fetchNotifications() {
        // Menggunakan route yang sudah kita buat di web.php
        fetch("{{ route('notifications.fetch') }}")
            .then((response) => {

                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                if (!data) return;

                // 1. UPDATE BADGE ANGKA
                if (data.count > 0) {
                    notificationCountEl.textContent = data.count;
                    notificationCountEl.classList.remove("d-none");
                    notificationCountEl.classList.add("active"); // Efek denyut
                } else {
                    notificationCountEl.classList.add("d-none");
                    notificationCountEl.classList.remove("active");
                }

                // 2. BANGUN ULANG DROPDOWN LIST
                let html = `<span class="dropdown-item dropdown-header">${data.count} Pesan Baru</span>
                            <div class="dropdown-divider"></div>`;

                if (data.notifications && data.notifications.length > 0) {
                    data.notifications.forEach((notif) => {
                        html += `
                        <a href="${notif.url}" class="dropdown-item">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="${defaultAvatar}" alt="User Avatar" 
                                         class="rounded-circle me-2" 
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                </div>
                                <div class="flex-grow-1" style="min-width: 0;">
                                    <h3 class="dropdown-item-title fw-bold" style="font-size: 0.9rem; margin:0;">
                                        ${notif.sender_name}
                                    </h3>
                                    <p class="text-muted text-truncate mb-0" style="font-size: 0.8rem;">
                                        ${notif.message_preview}
                                    </p>
                                    <p class="text-secondary mb-0" style="font-size: 0.7rem;">
                                        <i class="bi bi-clock-fill me-1"></i> ${notif.time}
                                    </p>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>`;
                    });
                } else {
                    html += `<a href="#" class="dropdown-item text-center text-muted">Tidak ada pesan baru</a>
                             <div class="dropdown-divider"></div>`;
                }

                // Tombol Lihat Semua
                html += `<a href="${seeAllUrl}" class="dropdown-item dropdown-footer text-center fw-bold">Lihat Semua Pesan</a>`;

                // Masukkan ke HTML
                notificationListEl.innerHTML = html;
            })
            .catch((error) =>
                console.error("Error fetching notifications:", error)
            );
    }

    // Panggil fungsi saat halaman pertama kali dimuat
    fetchNotifications();

    // Panggil fungsi setiap 10 detik (Real-time polling)
    setInterval(fetchNotifications, 10000);
});
