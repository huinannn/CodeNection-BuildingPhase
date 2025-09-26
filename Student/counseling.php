<?php
session_start();
include '../conn.php';
if(!isset($_SESSION['student_id'])){
    header("Location: Login/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Get booked dates for calendar (only pending and approved)
$booked_query = "SELECT DATE(booking_date) as date, booking_status FROM booking WHERE student_id = ? AND booking_status IN ('pending', 'approved')";
$stmt = $dbConn->prepare($booked_query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$booked_dates = [];
while($row = $result->fetch_assoc()){
    $booked_dates[$row['date']] = $row['booking_status']; // store status
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>Book Counselling</title>
<link rel="icon" href="image/favicon.png" type="image/x-icon" />
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body { font-family: 'Itim', cursive; background: #fff; margin: 0; padding-bottom: 25%; }
.dashboard-header {
    color: #F48C8C;
    font-size: 2rem;
    font-weight: bold;
    margin: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.dashboard-icons { display: flex; gap: 16px; }
.dashboard-icons img { width: 28px; height: 28px; }
.profile-dropdown { position: relative; cursor: pointer; }
.profile-dropdown-content {
    display: none;
    position: absolute;
    top: 36px;
    right: 0;
    box-shadow: 0px 8px 24px rgba(0,0,0,0.12);
    border-radius: 8px;
    min-width: 140px;
    z-index: 10;
}
.profile-dropdown-content a {
    display: block;
    padding: 12px 16px;
    text-decoration: none;
    color: #3D3D3D;
    font-size: 0.95rem;
    font-weight: normal;
}
.profile-dropdown-content a:hover { background-color: #f1f1f1; }
.profile-dropdown:hover .profile-dropdown-content { display: block; }
.profile-dropdown-content a.logout-link {
    display: flex;
    align-items: center;
    gap: 15px; 
    text-decoration: none;
    color: #000; 
    font-size: 0.95rem;
}

.Content_1, .Content_2 {
    background-color: #FEF3E7;
    padding: 16px;
    border-radius: 12px;
    margin: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.Content_1 h2, .Content_2 h2 { margin-top: 0; color: #F48C8C; }
.Content_1 p, .Content_2 p { color: #444; margin-bottom: 8px; }
.Content_1 .action, .Content_2 .action { display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 1.1rem; color: #E8B45E; font-weight: bold; }
.Content_1 .action i, .Content_2 .action i { color: #F48C8C; }

.calendar-section { margin: 0 20px 20px 20px; }
.calendar-title { color: #F48C8C; font-size: 1.2rem; font-weight: bold; margin-bottom: 8px; }

.calendar-selects { margin-bottom: 10px; display: flex; gap: 10px; justify-content: center; }
.calendar-selects select { padding: 4px 8px; border-radius: 6px; border: 1px solid #ccc; color: orange; font-weight: bold; }

.calendar-table { width: 100%; border-collapse: collapse; }
.calendar-table th, .calendar-table td { width: 14%; text-align: center; padding: 6px 0; }
.calendar-table th { color: #F48C8C; font-weight: 500; } /* weekday headers pink */
.calendar-table td { color: #444; }
.calendar-weekend { color: orange !important; font-weight: 500; }

/* Booked status squares */
.calendar-booked-pending {
    background: pink;
    color: #fff;
    font-weight: bold;
    border-radius: 8px;
}
.calendar-booked-approved {
    background: #d9f5b3; /* light yellow-green */
    color: #444;
    font-weight: bold;
    border-radius: 8px;
}

/* Today's date */
.calendar-today {
    color: red !important;
    font-weight: bold;
}

.calendar-month { background: #FFA85C; color: #fff; border-radius: 8px; padding: 2px 10px; font-size: 0.95rem; margin-bottom: 6px; display: inline-block; text-align: center; }

/* Legend */
.calendar-legend { display: flex; gap: 15px; margin: 10px 0 0 20px; align-items: center; }
.legend-box { width: 20px; height: 20px; display: inline-block; border-radius: 8px; }
.legend-text { margin-left: 5px; font-weight: bold; }

@media (max-width: 500px) {
    .calendar-section { margin: 10px; }
}
</style>
</head>
<body>
<div class="dashboard-header">
    Counselling
    <div class="dashboard-icons">
        <div class="profile-dropdown">
            <img src="../image/icons/profile.png" alt="Profile" />
            <div class="profile-dropdown-content">
                 <a href="../Student/Login/logout.php" class="logout-link">
                    <i class="fa-solid fa-right-from-bracket"></i> Log Out
                </a>
            </div>
        </div>
    </div>
</div>

<div class="Content_1">
    <h2>Book a Session</h2>
    <p>Someone to listen & give advice.</p>
    <div class="action" onclick="location.href='BookSession.php'">
        <i class="fa-solid fa-play"></i> Book Now
    </div>
</div>

<div class="Content_2">
    <h2>24 Hour Center</h2>
    <p>Available anytime you need immediate support.</p>
    <div class="action" onclick="callEmergency()">
        <i class="fa-solid fa-play"></i> Call Now
    </div>
</div>

<div class="calendar-section">
    <div class="calendar-title">Calendar</div>
    <div class="calendar-selects">
        <select id="month-select"></select>
        <select id="year-select"></select>
    </div>
    <table class="calendar-table">
        <thead>
            <tr>
                <th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th><th>Su</th>
            </tr>
        </thead>
        <tbody id="calendar-body">
        </tbody>
    </table>

    <!-- Legend -->
    <div class="calendar-legend">
        <div class="legend-box" style="background:pink;"></div><span class="legend-text">Pending</span>
        <div class="legend-box" style="background:#d9f5b3;"></div><span class="legend-text">Approved</span>
    </div>
</div>

<?php include 'navigation.php' ?>

<script>
const bookedDates = <?php echo json_encode($booked_dates); ?>;
const today = new Date();
let selectedMonth = today.getMonth(); 
let selectedYear = today.getFullYear();

const monthSelect = document.getElementById('month-select');
const yearSelect = document.getElementById('year-select');
const monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];

monthNames.forEach((m,i)=> { 
    const option = document.createElement('option');
    option.value = i;
    option.text = m;
    if(i===selectedMonth) option.selected=true;
    monthSelect.appendChild(option);
});
for(let y=today.getFullYear()-5; y<=today.getFullYear()+5; y++){
    const option = document.createElement('option');
    option.value=y;
    option.text=y;
    if(y===selectedYear) option.selected=true;
    yearSelect.appendChild(option);
}

monthSelect.addEventListener('change', ()=>{ selectedMonth=parseInt(monthSelect.value); generateCalendar(); });
yearSelect.addEventListener('change', ()=>{ selectedYear=parseInt(yearSelect.value); generateCalendar(); });

function generateCalendar(){
    const firstDay = new Date(selectedYear, selectedMonth, 1).getDay(); // 0=Sun
    const daysInMonth = new Date(selectedYear, selectedMonth+1, 0).getDate();
    let html='';
    let day=1;
    for(let row=0; row<6; row++){
        html+='<tr>';
        for(let col=1; col<=7; col++){
            let cellDay = (row===0 && col < ((firstDay===0?7:firstDay))) ? '' : day<=daysInMonth?day:'';
            let classes='';
            let content=cellDay?cellDay:'';

            if(cellDay){
                let cellMonth = selectedMonth+1;
                let cellDateStr = selectedYear + '-' + (cellMonth<10?'0'+cellMonth:cellMonth) + '-' + (cellDay<10?'0'+cellDay:cellDay);
                if(bookedDates[cellDateStr]==='pending'){
                    classes+=' calendar-booked-pending';
                } else if(bookedDates[cellDateStr]==='approved'){
                    classes+=' calendar-booked-approved';
                } else if(col===6 || col===7){
                    classes+=' calendar-weekend';
                }

                // Today font red
                if(cellDay===today.getDate() && selectedMonth===today.getMonth() && selectedYear===today.getFullYear()){
                    classes+=' calendar-today';
                }

                day++;
            }
            html+=`<td class="${classes}">${content}</td>`;
        }
        html+='</tr>';
        if(day>daysInMonth) break;
    }
    document.getElementById('calendar-body').innerHTML=html;
}

generateCalendar();

function callEmergency() {
    if(confirm("Are you sure you want to call emergency?")) {
        window.location.href = "tel:0162716278";
    }
}
</script>
</body>
</html>
