// overlay
window.onload = () => {
    const overlay = document.getElementById('reminder-overlay');
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden'; 
};

document.getElementById('continueBtn').addEventListener('click', () => {
    document.getElementById('reminder-overlay').style.display = 'none';
    document.body.style.overflow = 'auto'; 
});

// answer
const btn = document.querySelector('.get-answers-btn');
const centerText = document.querySelector('.center-text');

resetToBook();

btn.addEventListener('click', () => { 
    if (btn.innerText === "Get Answers") {
        startCountdown();
    } else if (btn.innerText === "Ask Another Question") {
        resetToBook();
    }
});

function startCountdown() {
    const icons = document.querySelectorAll('.answer-card .icon');
    icons.forEach(icon => icon.style.display = "none");

    let countdown = 3;
    centerText.innerText = countdown;

    const timer = setInterval(() => {
        countdown--;
        if (countdown > 0) {
            centerText.innerText = countdown;
        } else {
            clearInterval(timer);
            displayAnswer();
        }
    }, 1000);
}

// https://api.adviceslip.com/advice
function displayAnswer() {
    fetch("http://answerbook.david888.com/?lang=en")
        .then(res => res.json())
        .then(data => {
            centerText.innerText = data.answer || "No answer received";
            centerText.style.fontSize = "30px";
            btn.innerText = "Ask Another Question";
        })
        .catch(err => {
            console.error(err);
            const backupAnswers = [
                "Trust your instincts 🌙",
                "Good fortune is near 🍀",
                "Be patient, the answer will come 🕰️",
                "A surprise awaits you 🎁",
                "Focus on love and kindness 💙",
                "The path is unclear, but keep walking 🚶"
            ];
            const randomAnswer = backupAnswers[Math.floor(Math.random() * backupAnswers.length)];
            centerText.innerText = randomAnswer;
            centerText.style.fontSize = "30px";
            btn.innerText = "Ask Another Question";
        });
}

function resetToBook() {
    centerText.innerHTML = "Book<br/>Of<br/>Answers";
    centerText.style.fontSize = "40px";
    btn.innerText = "Get Answers";

    const icons = document.querySelectorAll('.answer-card .icon');
    icons.forEach(icon => icon.style.display = "inline-block");
}

// button navigation
const tabs = document.querySelectorAll('.bottom_nav .nav .each_nav');

function setActiveTab(tab) {
    tabs.forEach(t => {
        t.classList.remove('active');
        const img = t.querySelector('img');
        const name = t.querySelector('p').innerText.toLowerCase();
        img.src = `../../image/icons/${name}.png`;
    });

    tab.classList.add('active');
    const activeImg = tab.querySelector('img');
    const activeName = tab.querySelector('p').innerText.toLowerCase();
    activeImg.src = `../../image/icons/${activeName}_brown.png`;
}

const currentPage = window.location.pathname.split('/').pop().split('-2')[0]; 

let matched = false;
tabs.forEach(tab => {
    const hrefMatch = tab.getAttribute('onclick').match(/'([^']+)'/);
    if (hrefMatch && hrefMatch[1] === currentPage) {
        setActiveTab(tab);
        matched = true;
    }
});

if (!matched) {
    const homeTab = Array.from(tabs).find(t => t.querySelector('p').innerText === 'Home');
    if (homeTab) {
        setActiveTab(homeTab);
    }
}