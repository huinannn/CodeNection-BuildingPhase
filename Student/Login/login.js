// options
document.addEventListener("DOMContentLoaded", () => {
    let isReload = false;
    try {
        const navEntries = performance.getEntriesByType && performance.getEntriesByType('navigation');
        if (navEntries && navEntries.length > 0) {
        isReload = navEntries[0].type === 'reload';
        } else if (performance.navigation) {
        isReload = performance.navigation.type === 1;
        }
    } catch (e) {
        isReload = false;
    }

    if (isReload) {
        Object.keys(sessionStorage).forEach(key => {
        if (key.startsWith('onboarding')) {
            sessionStorage.removeItem(key);
        }
        });
    }

    const pageEl = document.querySelector('.onboarding');
    const pageId = pageEl ? pageEl.dataset.page : null;
    if (!pageId) return; 

    const checkboxes = Array.from(document.querySelectorAll("input[type='checkbox']"));
    const saved = sessionStorage.getItem(pageId);
    if (saved) {
        try {
        const states = JSON.parse(saved);
        checkboxes.forEach((cb, idx) => {
            cb.checked = !!states[idx];
        });
        } catch (err) {
        }
    }

    const saveStates = () => {
        const states = checkboxes.map(cb => !!cb.checked);
        sessionStorage.setItem(pageId, JSON.stringify(states));
    };

    checkboxes.forEach(cb => cb.addEventListener('change', saveStates));
    
    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
        const s = sessionStorage.getItem(pageId);
        if (s) {
            try {
            const states = JSON.parse(s);
            checkboxes.forEach((cb, idx) => { cb.checked = !!states[idx]; });
            } catch (e) {}
        } else {
            checkboxes.forEach(cb => cb.checked = false);
        }
        }
    });
});

// login
function showSnackbar(message, type='error') {
    const snackbar = document.getElementById('snackbar');
    if(!snackbar) return;

    const icon = type === 'success'
        ? '<i class="fa-solid fa-check-circle" style="color: #AE8446;"></i>'
        : '<i class="fa-solid fa-triangle-exclamation" style="color: #DD3730;"></i>';

    snackbar.className = '';
    snackbar.classList.add(type, 'show');
    snackbar.querySelector('span').innerHTML = `${icon}${message}`;

    setTimeout(() => { snackbar.classList.remove('show'); }, 3000);
}

document.addEventListener('DOMContentLoaded', () => {
    if(window.SUCCESS) showSnackbar(window.SUCCESS, 'success');
    if(window.ERROR) showSnackbar(window.ERROR, 'error');
});

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    if(form) {
        form.addEventListener('submit', (e) => {
            const studentId = form.student_id ? form.student_id.value.trim() : '';
            const password = form.student_password ? form.student_password.value.trim() : '';
            const schoolId = form.school_id ? form.school_id.value : '';

            if(!studentId || !password || !schoolId) {
                e.preventDefault();
                showSnackbar('Please fill in all the required fields!', 'error');
            }
        });
    }

    const error = window.ERROR || '';
    const success = window.SUCCESS || '';
    if(error) showSnackbar(error, 'error');
    if(success) {
        showSnackbar(success, 'success');
        setTimeout(() => { window.location.href = 'dailyquote.php'; }, 300);
    }
});