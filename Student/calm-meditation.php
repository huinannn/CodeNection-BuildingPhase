<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Calm Meditation Timer</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Itim&display=swap');

:root {
    --itim: 'Itim', cursive;
    --primary: #c3944eff;
    --secondary: #dec5a6ff;
    --bar-grey: #c3944eff;
}

body {
    font-family: var(--itim);
    background: url('../image/leisure/MeditationBG.png') no-repeat center center fixed;
    background-size: cover;
    color: gray;
    margin: 0;
    display: flex;
    flex-direction: column;
}

.leisure .header {
    width: 100%;
    position: fixed;
    padding-top: 25px;
    padding-left: 15px;
    z-index: 9999;

}

.leisure .header .header1{
    display: flex;
    align-items: center;
    /* padding: 10px 15px; */
    padding-bottom: 8px;
    /* padding-top: env(safe-area-inset-top); */
    font-size: 27px;

}

.leisure .header .header1 a img.back-arrow {
    width: 24px;
    height: 24px;
    cursor: pointer;
}

.leisure .header .header1 h1 {
    font-size: 27px;
    color: black;
    padding-left: 15px;
    padding-bottom: 8px;
    margin: 0;
}

.content {
    font-family: var(--itim);
    margin-top: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

#timerContainer {
    width: 250px;
    height: 250px;
    margin-bottom: 10px;
    position: relative;
}

.bar {
    stroke: var(--bar-grey);
    stroke-width: 10;
    fill: none;
    stroke-linecap: round;
    opacity: 1;
    transition: opacity 0.3s;
}

#timerText {
    font-family: var(--itim);
    font-size: 48px;
    color: var(--primary);
    margin-bottom: 20px;
}

select, #toggleBtn {
    font-family: var(--itim);
    padding: 10px 20px;
    margin: 10px;
    font-size: 16px;
    cursor: pointer;
    border: 2px solid none;
    border-radius: 30px;
    background-color: #e0c090ff;
    color: white;
}
#toggleBtn:hover { background-color: #e0c090ff; color: #fff; }

#quote {
    font-family: var(--itim);
    margin-top: 20px;
    font-size: 18px;
    text-align: center;
    max-width: 480px;
    color: var(--primary);
}

/* Modal Styles */
#modal {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;
    justify-content: flex-end;
    align-items: flex-end;
    z-index: 10000;
}

#modalOverlay {
    position: absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.5);
}

#modalContent {
    position: relative;
    background: #fff;
    padding: 20px 30px;
    border-radius: 15px 15px 0 0;
    text-align: center;
    width: 100%;
    max-width: 400px;
    z-index: 10001;
    font-family: var(--itim);
}

#modalContent img {
    width: 150px;
    padding-bottom: -15px;
}

#modalContent h2 {
    margin: 10px 0;
    font-size: 22px;
    color: var(--primary);
}

#modalContent p {
    margin: 10px 0 20px;
    font-size: 16px;
    color: #333;
}

#modalContent button {
    font-family: var(--itim);
    padding: 10px 20px;
    margin: 5px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 16px;
}
#modalContent button#endBtn {
    background-color: var(--secondary);
    color: #fff;
}
#modalContent button#againBtn {
    background-color: var(--primary);
    color: #fff;
}

@keyframes slideUp {
    from { transform: translateY(100%); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>
</head>
<body>

<div class="leisure">
    <div class="header">
        <div class="header1">
            <a href="leisure.php">
                <img src="../image/icons/arrow.png" alt="Back arrow" class="back-arrow">
            </a>
            <h1>Calm Meditation</h1>
        </div>
    </div>
</div>

<div class="content">
    <svg id="timerContainer"></svg>
    <div id="timerText">00:00</div>

    <label for="timeSelect">Select duration:</label>
    <select id="timeSelect">
        <option value="30">30 sec</option>
        <option value="60">1 min</option>
        <option value="300">5 min</option>
        <option value="600">10 min</option>
        <option value="900">15 min</option>
        <option value="1200">20 min</option>
        <option value="1500">25 min</option>
        <option value="1800">30 min</option>
        <option value="2700">45 min</option>
        <option value="3600">60 min</option>
    </select>

    <button id="toggleBtn" >Start Session</button>

    <div id="quote">"Take a deep breath and relax."</div>
</div>

<!-- Modal -->
<div id="modal">
    <div id="modalOverlay"></div>
    <div id="modalContent">
        <img src="../image/leisure/Yoga.png" alt="Meditation Complete">
        <h2>Meditation session completed!</h2>
        <p>——————————————————————<br>
        Would you like to start another session<br> 
        or end the session?<br>
        ——————————————————————</p>
        <button id="endBtn">End</button>
        <button id="againBtn">Again</button>
    </div>
</div>

<audio id="meditationAudio" loop>
    <source src="Audio.mp3" type="audio/mpeg">
</audio>
<audio id="bellAudio">
    <source src="bell-ringing-05.mp3" type="audio/mpeg">
</audio>

<script>
const timerContainer = document.getElementById('timerContainer');
const timerText = document.getElementById('timerText');
const toggleBtn = document.getElementById('toggleBtn');
const timeSelect = document.getElementById('timeSelect');
const meditationAudio = document.getElementById('meditationAudio');
const bellAudio = document.getElementById('bellAudio');
const modal = document.getElementById('modal');
const endBtn = document.getElementById('endBtn');
const againBtn = document.getElementById('againBtn');

let timer = null;
let remainingTime = 0;
let totalTime = 0;
let isRunning = false;
let bars = [];
const maxBars = 45;

// Initialize clock with all grey bars
function drawBars(count){
    timerContainer.innerHTML = '';
    bars = [];
    const cx = 125, cy = 125, r = 110;
    const step = 360 / count;
    for(let i=0;i<count;i++){
        const angle = -90 + i*step;
        const x1 = cx + r * Math.cos(angle * Math.PI/180);
        const y1 = cy + r * Math.sin(angle * Math.PI/180);
        const x2 = cx + (r-15) * Math.cos(angle * Math.PI/180);
        const y2 = cy + (r-15) * Math.sin(angle * Math.PI/180);
        const line = document.createElementNS("http://www.w3.org/2000/svg","line");
        line.setAttribute("x1",x1);
        line.setAttribute("y1",y1);
        line.setAttribute("x2",x2);
        line.setAttribute("y2",y2);
        line.setAttribute("class","bar");
        timerContainer.appendChild(line);
        bars.push(line);
    }
}

// Show full grey before start
drawBars(maxBars);

function updateBars(){
    const fraction = remainingTime / totalTime;
    const activeBars = Math.ceil(fraction * bars.length);
    bars.forEach((bar,i)=>{
        bar.style.opacity = i < activeBars ? 1 : 0.2;
    });
}

function formatTime(seconds){
    const min = Math.floor(seconds/60);
    const sec = seconds % 60;
    return `${min.toString().padStart(2,'0')}:${sec.toString().padStart(2,'0')}`;
}

function getRandomStartTime(audio){
    return Math.random() * audio.duration; 
}

function startCountdown(){
    timer = setInterval(()=>{
        remainingTime--;
        timerText.textContent = formatTime(remainingTime);
        updateBars();
        if(remainingTime<=0){
            clearInterval(timer);
            isRunning=false;
            toggleBtn.textContent='Start Session';
            meditationAudio.pause();
            setTimeout(()=>bellAudio.play().catch(e=>console.log("Bell blocked",e)),50);
            modal.style.display='flex';
        }
    },1000);
}

toggleBtn.addEventListener('click',()=>{
    if(!isRunning){
        remainingTime = parseInt(timeSelect.value);
        totalTime = remainingTime;
        timerText.textContent = formatTime(remainingTime);

        let barCount = totalTime <= maxBars ? totalTime : maxBars;
        drawBars(barCount);
        updateBars();

        meditationAudio.load();
        meditationAudio.addEventListener('loadedmetadata',()=>{
            meditationAudio.currentTime = getRandomStartTime(meditationAudio);
            meditationAudio.play().catch(err=>console.log("Click to allow audio"));
        },{once:true});

        startCountdown();
        toggleBtn.textContent='Stop';
        isRunning=true;
    } else {
        clearInterval(timer);
        meditationAudio.pause();
        meditationAudio.currentTime=0;
        timerText.textContent="00:00";
        drawBars(maxBars); // reset to full grey
        toggleBtn.textContent='Start Session';
        isRunning=false;
    }
});

// Modal buttons
endBtn.addEventListener('click',()=> window.location.href='leisure.php');
againBtn.addEventListener('click',()=> modal.style.display='none');
</script>

</body>
</html>
