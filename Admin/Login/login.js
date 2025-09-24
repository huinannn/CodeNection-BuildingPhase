// login required
const form = document.getElementById('loginForm');
const snackbar = document.getElementById('snackbar');

form.addEventListener('submit', function(e){
    let admin = document.getElementById('admin-id').value.trim();
    let password = document.getElementById('password').value.trim();

    if(admin === "" || password === ""){
        e.preventDefault();
        snackbar.classList.add('show');
        setTimeout(() => snackbar.classList.remove('show'), 3000);
    }
});