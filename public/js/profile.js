document.addEventListener('DOMContentLoaded', () => {
    // Fungsi generik untuk menangani toggle password
    const setupPasswordToggle = (toggleId, inputId) => {
        const toggle = document.getElementById(toggleId);
        const input = document.getElementById(inputId);
        const icon = toggle.querySelector('i');

        if (toggle && input) {
            toggle.addEventListener('click', () => {
                // Cek tipe input saat ini
                const isPassword = input.getAttribute('type') === 'password';
                
                if (isPassword) {
                    // Jika password, ubah ke text dan ganti ikon mata terbuka
                    input.setAttribute('type', 'text');
                    icon.classList.remove('bi-eye-slash-fill');
                    icon.classList.add('bi-eye-fill');
                } else {
                    // Jika text, ubah kembali ke password dan ganti ikon mata tertutup
                    input.setAttribute('type', 'password');
                    icon.classList.remove('bi-eye-fill');
                    icon.classList.add('bi-eye-slash-fill');
                }
            });
        }
    };

    // Terapkan fungsi ke kedua input password
    setupPasswordToggle('togglePassword', 'password');
    setupPasswordToggle('togglePasswordConfirmation', 'password_confirmation');

    
});