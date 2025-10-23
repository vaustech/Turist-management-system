<?php
include 'includes/header.php';

// ব্যবহারকারী লগইন না থাকলে তাকে লগইন পেজে পাঠানো হবে
if (!isset($_SESSION['user_loggedin']) || $_SESSION['user_loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// ইউজারের তথ্য আনা
$stmt_user = $conn->prepare("SELECT name, emailid, mobile FROM tbl_userregistration WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_details = $result_user->fetch_assoc();
$stmt_user->close();

// বুকিং ডেটা আনা
$stmt_bookings = $conn->prepare("
    SELECT b.id AS booking_id, p.package_name, b.from_date, b.to_date, b.status, b.package_id
    FROM tbl_booking b
    JOIN tbl_tourpackage p ON b.package_id = p.id
    WHERE b.user_id = ?
    ORDER BY b.id DESC
");
$stmt_bookings->bind_param("i", $user_id);
$stmt_bookings->execute();
$result_bookings = $stmt_bookings->get_result();

$bookings = [];
while ($row = $result_bookings->fetch_assoc()) {
    $bookings[] = $row;
}
$stmt_bookings->close();

// নিকটতম আসন্ন ট্রিপ
$today = new DateTime('today');
$upcoming = null;
foreach ($bookings as $bk) {
    if ((int)$bk['status'] === 1) {
        $fd = new DateTime($bk['from_date']);
        if ($fd >= $today) {
            if ($upcoming === null || new DateTime($upcoming['from_date']) > $fd) {
                $upcoming = $bk;
            }
        }
    }
}

// নোটিফিকেশন
$notifications = [];
foreach ($bookings as $bk) {
    $fd = new DateTime($bk['from_date']);
    $td = new DateTime($bk['to_date']);
    if ((int)$bk['status'] === 0) {
        $notifications[] = "Pending confirmation: <strong>" . htmlspecialchars($bk['package_name']) . "</strong> (" . $fd->format('d M, Y') . " - " . $td->format('d M, Y') . ")";
    } elseif ((int)$bk['status'] === 1) {
        if ($fd >= $today) {
            $daysDiff = (int)$today->diff($fd)->format('%a');
            if ($daysDiff <= 7) {
                $notifications[] = "Heads up! Your trip <strong>" . htmlspecialchars($bk['package_name']) . "</strong> starts in <strong>{$daysDiff} day" . ($daysDiff != 1 ? 's' : '') . "</strong> on " . $fd->format('d M, Y') . ".";
            }
        } else {
            $notifications[] = "Trip completed: <strong>" . htmlspecialchars($bk['package_name']) . "</strong> (ended " . $td->format('d M, Y') . "). Consider leaving a review.";
        }
    } else {
        $notifications[] = "Cancelled: <strong>" . htmlspecialchars($bk['package_name']) . "</strong> (was " . $fd->format('d M, Y') . ").";
    }
}

// ---------- Progress Tracker Helper ----------
function renderStepper($status, $from_date, $to_date) {
    $steps = [
        "Booking"      => "fa fa-ticket-alt",
        "Payment"      => "fa fa-credit-card",
        "Confirmation" => "fa fa-check-circle",
        "Trip"         => "fa fa-plane-departure",
        "Review"       => "fa fa-star"
    ];
    $currentStep = 1;
    if ($status == 0) {
        $currentStep = 2;
    } elseif ($status == 1) {
        $today = new DateTime();
        $fd = new DateTime($from_date);
        $td = new DateTime($to_date);
        if ($today < $fd) $currentStep = 3;
        elseif ($today >= $fd && $today <= $td) $currentStep = 4;
        else $currentStep = 5;
    }
    echo '<div class="stepper">';
    $i = 1;
    foreach ($steps as $label => $icon) {
        $class = '';
        if ($i < $currentStep) $class = 'completed';
        elseif ($i == $currentStep) $class = 'active';
        echo '<div class="step '.$class.'">';
        echo '<div class="circle"><i class="'.$icon.'"></i></div>';
        echo '<div class="label">'.$label.'</div>';
        echo '</div>';
        $i++;
    }
    echo '</div>';
}
?>

<style>
.dashboard-card { min-height: 100%; }
.countdown-box { font-size: 1.1rem; font-weight: 600; }
.countdown-seg { display: inline-block; text-align: center; margin-right: 10px; }
.countdown-num { font-size: 1.8rem; line-height: 1; }
.checklist-item { display:flex; align-items:center; justify-content:space-between; padding:.5rem .75rem; border:1px solid #eee; border-radius: .375rem; margin-bottom:.5rem; }
.checklist-item.done { background: #f8fff8; text-decoration: line-through; opacity:.9; }
.checklist-actions button { margin-left:.25rem; }
.progress { height: 10px; margin-top: .5rem; }

/* Stepper */
.stepper { display:flex; justify-content:space-between; margin:20px 0; position:relative; }
.stepper::before { content:''; position:absolute; top:20px; left:0; width:100%; height:4px; background:#dee2e6; z-index:0; }
.step { text-align:center; flex:1; position:relative; z-index:1; }
.step .circle { width:40px;height:40px;border-radius:50%;background:#dee2e6;margin:0 auto;line-height:40px;color:#6c757d;font-size:18px; }
.step.active .circle, .step.completed .circle { background:#28a745;color:#fff; }
.step .label { margin-top:8px;font-size:13px;color:#6c757d; }
.step.active .label, .step.completed .label { color:#28a745;font-weight:600; }
.step.completed::after { content:''; position:absolute; top:20px; left:-50%; width:100%; height:4px; background:#28a745; z-index:-1; }
.step:first-child::after { content:none; }
</style>

<div class="container my-5 py-5">
    <h2 class="text-center mb-4">My Profile</h2>
    <p class="text-center lead">Welcome back, <?php echo htmlspecialchars($user_details['name']); ?>!</p>

    <div class="card profile-card mt-4 shadow-sm">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myProfileTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" id="info-tab" data-toggle="tab" href="#info" role="tab">Update Profile</a></li>
                <li class="nav-item"><a class="nav-link" id="bookings-tab" data-toggle="tab" href="#bookings" role="tab">My Bookings</a></li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content pt-3" id="myProfileTabContent">

                <!-- Dashboard -->
                <div class="tab-pane fade show active" id="dashboard">
                    <div class="row">
                        <!-- Upcoming -->
                        <div class="col-lg-4 mb-4"><div class="card dashboard-card h-100"><div class="card-body">
                            <h5 class="card-title">Upcoming Trip</h5>
                            <?php if ($upcoming): ?>
                                <p><strong><?php echo htmlspecialchars($upcoming['package_name']); ?></strong></p>
                                <p class="text-muted"><?php echo date('d M, Y', strtotime($upcoming['from_date'])); ?> – <?php echo date('d M, Y', strtotime($upcoming['to_date'])); ?></p>
                                <div class="countdown-box" id="countdown"><span class="text-muted">Calculating…</span></div>
                            <?php else: ?><p class="text-muted">No upcoming confirmed trips.</p><?php endif; ?>
                        </div></div></div>

                        <!-- Checklist -->
                        <div class="col-lg-4 mb-4"><div class="card dashboard-card h-100"><div class="card-body">
                            <h5 class="card-title">Pre-travel Checklist</h5>
                            <div class="progress"><div id="checklistProgress" class="progress-bar" style="width:0%">0%</div></div>
                            <div id="checklistContainer" class="mt-3"></div>
                            <div class="input-group mt-3">
                                <input type="text" id="newItemInput" class="form-control" placeholder="নতুন আইটেম যোগ করুন…">
                                <div class="input-group-append"><button class="btn btn-outline-primary" id="addItemBtn">Add</button></div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-sm btn-outline-secondary" id="resetChecklistBtn">Reset to default</button>
                                <button class="btn btn-sm btn-outline-info" id="exportChecklistBtn">Export</button>
                            </div>
                        </div></div></div>

                        <!-- Notifications -->
                        <div class="col-lg-4 mb-4"><div class="card dashboard-card h-100"><div class="card-body">
                            <h5 class="card-title">Notifications</h5>
                            <?php if ($notifications): ?><ul><?php foreach ($notifications as $n) echo "<li>$n</li>"; ?></ul>
                            <?php else: ?><p class="text-muted">No notifications.</p><?php endif; ?>
                        </div></div></div>
                    </div>
                </div>

                <!-- Update Profile -->
                <div class="tab-pane fade" id="info">
                    <form action="handle_update_profile.php" method="POST">
                        <div class="form-group"><label>Name</label><input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user_details['name']); ?>"></div>
                        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user_details['emailid']); ?>"></div>
                        <div class="form-group"><label>Mobile</label><input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($user_details['mobile']); ?>"></div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>

                <!-- Bookings -->
                <div class="tab-pane fade" id="bookings">
                    <?php if ($bookings): foreach ($bookings as $row): ?>
                        <div class="card mb-3"><div class="card-body">
                            <h5><?php echo htmlspecialchars($row['package_name']); ?></h5>
                            <p><?php echo date('d M, Y', strtotime($row['from_date'])); ?> → <?php echo date('d M, Y', strtotime($row['to_date'])); ?></p>
                            <?php renderStepper($row['status'],$row['from_date'],$row['to_date']); ?>
                        </div></div>
                    <?php endforeach; else: ?><p>No bookings yet.</p><?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
// Countdown
(function(){
  var d = <?php echo json_encode($upcoming ? $upcoming['from_date'] : null); ?>;
  if(!d) return;
  var target=new Date(d+'T00:00:00'),box=document.getElementById('countdown');
  function two(n){return n<10?'0'+n:n;}
  function tick(){
    var diff=target-new Date(); if(diff<=0){box.innerHTML='Trip Day!';return;}
    var s=Math.floor(diff/1000),dys=Math.floor(s/86400);s-=dys*86400;var h=Math.floor(s/3600);s-=h*3600;var m=Math.floor(s/60);s-=m*60;
    box.innerHTML='<div>'+dys+' Days '+two(h)+':'+two(m)+':'+two(s)+'</div>';
  }
  tick();setInterval(tick,1000);
})();

// Checklist + Export PDF
(function(){
  var state=[],defaults=['Passport / NID','Printed / digital tickets & itinerary','Hotel / package confirmation','Wallet, cash & cards','Medications & basic first-aid','Toiletries','Clothes','Phone chargers','Camera','Travel adapter','Local SIM','Travel insurance','Emergency contacts','Copies of documents'];
  var key='checklist';var cont=document.getElementById('checklistContainer'),prog=document.getElementById('checklistProgress');
  function save(){localStorage.setItem(key,JSON.stringify(state));render();}
  function load(){var d=localStorage.getItem(key);state=d?JSON.parse(d):defaults.map(t=>({text:t,done:false}));}
  function render(){cont.innerHTML='';var done=state.filter(i=>i.done).length,pct=Math.round(done/state.length*100);prog.style.width=pct+'%';prog.textContent=pct+'%';
    state.forEach((it,i)=>{var div=document.createElement('div');div.className='checklist-item'+(it.done?' done':'');div.innerHTML='<div><input type="checkbox" '+(it.done?'checked':'')+'> '+it.text+'</div><button class="btn btn-sm btn-outline-danger">Delete</button>';div.querySelector('input').onchange=e=>{state[i].done=e.target.checked;save();};div.querySelector('button').onclick=()=>{state.splice(i,1);save();};cont.appendChild(div);});
  }
  load();render();
  document.getElementById('addItemBtn').onclick=function(){var v=document.getElementById('newItemInput').value.trim();if(v){state.push({text:v,done:false});document.getElementById('newItemInput').value='';save();}};
  document.getElementById('resetChecklistBtn').onclick=function(){if(confirm('Reset?')){state=defaults.map(t=>({text:t,done:false}));save();}};
  document.getElementById('exportChecklistBtn').onclick=function(){const {jsPDF}=window.jspdf;var doc=new jsPDF();doc.setFontSize(16);doc.text("Pre-Travel Checklist",14,20);var y=40;state.forEach(it=>{var mark=it.done?'✓':'☐';doc.text(mark+' '+it.text,14,y);y+=8;if(y>280){doc.addPage();y=20;}});doc.save("pre-travel-checklist.pdf");};
})();
</script>
<?php include 'includes/footer.php'; ?>
