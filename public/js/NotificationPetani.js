
document.addEventListener('DOMContentLoaded', function () {
    const notificationCountEl = document.getElementById('notification-count');
    const notificationListEl = document.getElementById('notification-list');
    const defaultAvatar = "{{ asset('lte/dist/assets/img/user_avatar.png') }}";
    const seeAllUrl = "{{ route('pakar.chat.index') }}";

    function fetchNotifications() {
        // Pastikan route ini benar dan bisa diakses
        fetch("{{ route('notifications.fetch') }}")
            .then(response => {
                if (!response.ok) {
                    console.error("Network response was not ok: " + response.statusText);
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (!data) return;

                // Update jumlah notifikasi
                if (data.count > 0) {
                    notificationCountEl.textContent = data.count;
                    notificationCountEl.classList.remove('d-none');
                    notificationCountEl.classList.add('active');
                } else {
                    notificationCountEl.classList.add('d-none');
                    notificationCountEl.classList.remove('active');
                }

                // Bangun ulang daftar dropdown notifikasi
                let html = `<span class="dropdown-item dropdown-header">${data.count} Pesan Baru</span><div class="dropdown-divider"></div>`;

                if (data.notifications && data.notifications.length > 0) {
                    data.notifications.forEach(notif => {
                        html += `
                        <a href="${notif.url}" class="dropdown-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="${defaultAvatar}" alt="User Avatar" class="img-size-50 rounded-circle me-3" />
                                </div>
                                <div class="flex-grow-1">
                                    <h3 class="dropdown-item-title">${notif.sender_name}</h3>
                                    <p class="fs-7">${notif.message_preview}</p>
                                    <p class="fs-7 text-secondary">
                                        <i class="bi bi-clock-fill me-1"></i> ${notif.time}
                                    </p>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>`;
                    });
                } else {
                    html += `<a href="#" class="dropdown-item text-center text-muted">Tidak ada pesan baru</a><div class="dropdown-divider"></div>`;
                }

                html += `<a href="${seeAllUrl}" class="dropdown-item dropdown-footer">Lihat Semua Pesan</a>`;
                notificationListEl.innerHTML = html;
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }

    // Panggil fungsi saat halaman pertama kali dimuat
    fetchNotifications();

    // Panggil fungsi setiap 15 detik
    setInterval(fetchNotifications, 15000); 
});