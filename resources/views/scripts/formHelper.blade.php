<script>
    document.querySelectorAll('.show-hide-password').forEach(function(button) {
        button.addEventListener('click', function() {
            const password = document.querySelector('.password');
            if (password.type === 'password') {
                password.type = 'text';
                button.querySelector('i').classList.add('fa-eye-slash');
                button.querySelector('i').classList.remove('fa-eye');
            } else {
                password.type = 'password';
                button.querySelector('i').classList.add('fa-eye');
                button.querySelector('i').classList.remove('fa-eye-slash');
            }
        });
    });
</script>
