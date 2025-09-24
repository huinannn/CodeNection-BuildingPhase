// side bar
document.addEventListener("DOMContentLoaded", function () {
    function checkScreenSize() {
        if (window.innerWidth < 1000) {
            alert("⚠️ This site is only available on screens 1000px and above! Please use a computer to access.");
        }
    }
    checkScreenSize();
    window.addEventListener("resize", checkScreenSize);

    const tabs = document.querySelectorAll(".side-nav .nav li");

    const currentPage = window.location.pathname.split("/").pop().split("?")[0]; 

    function setActiveTab(tab) {
        tabs.forEach(t => t.classList.remove("active"));
        tab.classList.add("active");
    }

    let matched = false;
    tabs.forEach(tab => {
        const target = tab.getAttribute("data-page"); 
        if (target === currentPage) {
            setActiveTab(tab);
            matched = true;
        }

        tab.addEventListener("click", () => {
            setActiveTab(tab);
            if (target) {
                window.location.href = target;
            }
        });
    });

    if (!matched && tabs.length > 0) {
        setActiveTab(tabs[0]);
    }
});

// search
const searchInput = document.getElementById('searchInput');
const table = document.getElementById('studentTable');
const tbodyRows = table.getElementsByTagName('tbody')[0].rows;
const notFoundContainer = document.getElementById('notFoundContainer');

searchInput.addEventListener('input', filterTable);

function filterTable() {
    const filter = searchInput.value.toLowerCase();
    let count = 0;

    for (let row of tbodyRows) {
        let cells = row.getElementsByTagName('td');
        let match = false;

        for (let cell of cells) {
            if (cell.textContent.toLowerCase().includes(filter)) {
                match = true;
                break;
            }
        }

        if (match) {
            row.style.display = '';
            count++;
            cells[0].textContent = count;
        } else {
            row.style.display = 'none';
        }
    }

    table.style.display = count > 0 ? '' : 'none';
    notFoundContainer.style.display = count > 0 ? 'none' : 'flex';
}