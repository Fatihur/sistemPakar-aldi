document.addEventListener('DOMContentLoaded', () => {
        const setupPasswordToggle = (toggleId, inputId) => {
            const toggle = document.getElementById(toggleId);
            const input = document.getElementById(inputId);
            const icon = toggle.querySelector('i');

            if (toggle && input) {
                toggle.addEventListener('click', () => {
                    const isPassword = input.getAttribute('type') === 'password';
                    
                    if (isPassword) {
                        input.setAttribute('type', 'text');
                        icon.classList.remove('bi-eye-slash-fill');
                        icon.classList.add('bi-eye-fill');
                    } else {
                        input.setAttribute('type', 'password');
                        icon.classList.remove('bi-eye-fill');
                        icon.classList.add('bi-eye-slash-fill');
                    }
                });
            }
        };

        setupPasswordToggle('togglePassword', 'password');
        setupPasswordToggle('togglePasswordConfirmation', 'password_confirmation');
    });