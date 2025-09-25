<?php
    session_start();
    include '../conn.php';

    if (!isset($_SESSION['admin_id'])) {
        header("Location: ../index.php");
        exit();
    }

    if (isset($_SESSION['admin_id'])) {
        $admin_id = $_SESSION['admin_id'];
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Unicare</title>
    <link rel="icon" href="../image/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="style.css" />
    <style>
        body {
            overflow: hidden !important;
            background-color: #212934 !important;
        }

        .head {
            background-color: #212934 !important;
        }

        .page .head .title h1 {
            color: white;
        }

        .page .head .subtitle h1.active {
            color: white !important;
        }

        .sort {
            background-color: #212934 !important;
        }

        .each_sort {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
        }

        .each_sort .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            font-size: 12px;
            font-weight: bold;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99;
        }

        .each_data p {
            font-size: 12px;
            font-weight: 500;
        }

        .no_data p {
            font-family: 'Itim', cursive;
            font-size: 15px;
            font-weight: 500;
            text-align: center;
            margin-top: 50px;
        }

    </style>
</head>
<body>
    <?php include 'navigation_dark.php' ?>
    <div class="page">
        <div class="head">
            <div class="title">
                <h1>Reviews - Sad Corner</h1>
            </div>
            <div class="subtitle">
                <h1 onclick="window.location.href='reviews_post_sad.php'">Posts</h1>
                <div class="vertical"></div>
                <h1 onclick="window.location.href='reviews_comment_sad.php'">Comments</h1>
                <div class="vertical"></div>
                <h1 class="active">Replies</h1>
                <div class="spacer"></div>
                <div class="dark_light">
                    <input type="checkbox" checked onchange="window.location.href='reviews_reply_happy.php'">
                </div>
            </div>
        </div>
        <div class="sort">
            <div class="each_sort active" data-filter="all"><p>All</p></div>
            <div class="each_sort" data-filter="pending"><p>Pending</p><span class="badge" id="pendingCount"></span></div>
            <div class="each_sort" data-filter="approved"><p>Approved</p></div>
            <div class="each_sort" data-filter="rejected"><p>Rejected</p></div>
        </div>
        <div class="table">
            <div class="table_header">
                <h2>Post Content</h2>
                <h2>Time Stamp</h2>
                <h2>Action</h2>
            </div>
            <div class="table_data" data-status="all">
                <?php
                    $all_sql = "SELECT r.*, s.student_name
                                FROM reply r
                                JOIN comment cm
                                ON r.comment_id = cm.comment_id
                                JOIN confession c 
                                ON cm.confession_id = c.confession_id
                                JOIN student s 
                                ON r.student_id = s.student_id
                                JOIN school sc 
                                ON s.school_id = sc.school_id
                                JOIN admin a 
                                ON a.school_id = sc.school_id
                                WHERE c.mode = 'sad' AND a.admin_id = ?
                                ORDER BY r.reply_date_time DESC;";
                    $all_stmt = $dbConn->prepare($all_sql);
                    $all_stmt->bind_param('s', $admin_id);
                    $all_stmt->execute();
                    $all_result = $all_stmt->get_result();

                    if ($all_result->num_rows > 0) {
                        while ($all_row = $all_result->fetch_assoc()) {
                ?>
                <div class="horizontal"></div>
                <div class="each_data" data-id="<?php echo $all_row['reply_id']; ?>" data-time="<?php echo $all_row['reply_date_time']; ?>">
                    <div class="content">
                        <div class="each_content">
                            <p><?php echo $all_row['reply_message'] ?></p>
                        </div>
                        <div class="each_content">
                            <?php
                                $all_unformat_date = $all_row['reply_date_time'];
                                $all_format_date = date("Y-n-j hi A", strtotime($all_unformat_date));
                            ?>
                            <h3><?php echo $all_format_date ?></h3>
                        </div>
                        <?php
                            if ($all_row['reply_status'] === "pending") {
                        ?>
                        <div class="each_content button">
                            <button class="btn approve-btn" data-type="reply" data-id="<?php echo $all_row['reply_id']; ?>">Approve</button>
                            <div style="height:20px;"></div>
                            <button class="btn reject-btn" data-type="reply" data-id="<?php echo $all_row['reply_id']; ?>" id="reject">Reject</button>
                        </div>
                        <?php
                            } elseif ($all_row['reply_status'] === "approved") {
                        ?>
                        <div class="each_content button">
                            <button class="btn done">Approved</button>
                        </div>
                        <?php
                            } else {
                        ?>
                        <div class="each_content button">
                            <button class="btn done">Rejected</button>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <p>Post By: <?php echo $all_row['student_name'] ?></p>
                </div>
                <?php
                        }
                    }
                ?>
            </div>
            <div class="table_data" data-status="pending" style="display: none;">
                <?php
                    $pending_sql = "SELECT r.*, s.student_name
                                FROM reply r
                                JOIN comment cm
                                ON r.comment_id = cm.comment_id
                                JOIN confession c 
                                ON cm.confession_id = c.confession_id
                                JOIN student s 
                                ON r.student_id = s.student_id
                                JOIN school sc 
                                ON s.school_id = sc.school_id
                                JOIN admin a 
                                ON a.school_id = sc.school_id
                                WHERE c.mode = 'sad' AND r.reply_status = 'pending' AND a.admin_id = ?
                                ORDER BY r.reply_date_time DESC;";
                    $pending_stmt = $dbConn->prepare($pending_sql);
                    $pending_stmt->bind_param('s', $admin_id);
                    $pending_stmt->execute();
                    $pending_result = $pending_stmt->get_result();

                    if ($pending_result->num_rows > 0) {
                        while ($pending_row = $pending_result->fetch_assoc()) {
                ?>
                <div class="horizontal"></div>
                <div class="each_data" data-id="<?php echo $pending_row['reply_id']; ?>" data-time="<?php echo $pending_row['reply_date_time']; ?>">
                    <div class="content">
                        <div class="each_content">
                            <p><?php echo $pending_row['reply_message'] ?></p>
                        </div>
                        <div class="each_content">
                            <?php
                                $pending_unformat_date = $pending_row['reply_date_time'];
                                $pending_format_date = date("Y-n-j hi A", strtotime($pending_unformat_date));
                            ?>
                            <h3><?php echo $pending_format_date ?></h3>
                        </div>
                        <?php
                            if ($pending_row['reply_status'] === "pending") {
                        ?>
                        <div class="each_content button">
                            <button class="btn approve-btn" data-type="reply" data-id="<?php echo $pending_row['reply_id']; ?>">Approve</button>
                            <div style="height:20px;"></div>
                            <button class="btn reject-btn" data-type="reply" data-id="<?php echo $pending_row['reply_id']; ?>" id="reject">Reject</button>
                        </div>
                        <?php
                            } elseif ($pending_row['reply_status'] === "approved") {
                        ?>
                        <div class="each_content button">
                            <button class="btn done">Approved</button>
                        </div>
                        <?php
                            } else {
                        ?>
                        <div class="each_content button">
                            <button class="btn done">Rejected</button>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <p>Post By: <?php echo $pending_row['student_name'] ?></p>
                </div>
                <?php
                        }
                    } else {
                ?>
                <div class="horizontal"></div>
                <div class="no_data">
                    <p>No Pending Comments Yet!</p>
                </div>
                <?php
                    }
                ?>
            </div>
            <div class="table_data" data-status="approved" style="display: none;">
                <?php
                    $approved_sql = "SELECT r.*, s.student_name
                                FROM reply r
                                JOIN comment cm
                                ON r.comment_id = cm.comment_id
                                JOIN confession c 
                                ON cm.confession_id = c.confession_id
                                JOIN student s 
                                ON r.student_id = s.student_id
                                JOIN school sc 
                                ON s.school_id = sc.school_id
                                JOIN admin a 
                                ON a.school_id = sc.school_id
                                WHERE c.mode = 'sad' AND r.reply_status = 'approved' AND a.admin_id = ?
                                ORDER BY r.reply_date_time DESC;";
                    $approved_stmt = $dbConn->prepare($approved_sql);
                    $approved_stmt->bind_param('s', $admin_id);
                    $approved_stmt->execute();
                    $approved_result = $approved_stmt->get_result();

                    if ($approved_result->num_rows > 0) {
                        while ($approved_row = $approved_result->fetch_assoc()) {
                ?>
                <div class="horizontal"></div>
                <div class="each_data" data-id="<?php echo $approved_row['reply_id']; ?>" data-time="<?php echo $approved_row['reply_date_time']; ?>">
                    <div class="content">
                        <div class="each_content">
                            <p><?php echo $approved_row['reply_message'] ?></p>
                        </div>
                        <div class="each_content">
                            <?php
                                $approved_unformat_date = $approved_row['reply_date_time'];
                                $approved_format_date = date("Y-n-j hi A", strtotime($approved_unformat_date));
                            ?>
                            <h3><?php echo $approved_format_date ?></h3>
                        </div>
                        <?php
                            if ($approved_row['reply_status'] === "pending") {
                        ?>
                        <div class="each_content button">
                            <button class="btn approve-btn" data-type="reply" data-id="<?php echo $approved_row['reply_id']; ?>">Approve</button>
                            <div style="height:20px;"></div>
                            <button class="btn reject-btn" data-type="reply" data-id="<?php echo $approved_row['reply_id']; ?>" id="reject">Reject</button>
                        </div>
                        <?php
                            } elseif ($approved_row['reply_status'] === "approved") {
                        ?>
                        <div class="each_content button">
                            <button class="btn done">Approved</button>
                        </div>
                        <?php
                            } else {
                        ?>
                        <div class="each_content button">
                            <button class="btn done">Rejected</button>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <p>Post By: <?php echo $approved_row['student_name'] ?></p>
                </div>
                <?php
                        }
                    } else {
                ?>
                <div class="horizontal"></div>
                <div class="no_data">
                    <p>No Approved Comments Yet!</p>
                </div>
                <?php
                    }
                ?>
            </div>
            <div class="table_data" data-status="rejected" style="display: none;">
                <?php
                    $rejected_sql = "SELECT r.*, s.student_name
                                FROM reply r
                                JOIN comment cm
                                ON r.comment_id = cm.comment_id
                                JOIN confession c 
                                ON cm.confession_id = c.confession_id
                                JOIN student s 
                                ON r.student_id = s.student_id
                                JOIN school sc 
                                ON s.school_id = sc.school_id
                                JOIN admin a 
                                ON a.school_id = sc.school_id
                                WHERE c.mode = 'sad' AND r.reply_status = 'rejected' AND a.admin_id = ?
                                ORDER BY r.reply_date_time DESC;";
                    $rejected_stmt = $dbConn->prepare($rejected_sql);
                    $rejected_stmt->bind_param('s', $admin_id);
                    $rejected_stmt->execute();
                    $rejected_result = $rejected_stmt->get_result();

                    if ($rejected_result->num_rows > 0) {
                        while ($rejected_row = $rejected_result->fetch_assoc()) {
                ?>
                <div class="horizontal"></div>
                <div class="each_data" data-id="<?php echo $rejected_row['reply_id']; ?>" data-time="<?php echo $rejected_row['reply_date_time']; ?>"> 
                    <div class="content">
                        <div class="each_content">
                            <p><?php echo $rejected_row['reply_message'] ?></p>
                        </div>
                        <div class="each_content">
                            <?php
                                $rejected_unformat_date = $rejected_row['reply_date_time'];
                                $rejected_format_date = date("Y-n-j hi A", strtotime($rejected_unformat_date));
                            ?>
                            <h3><?php echo $rejected_format_date ?></h3>
                        </div>
                        <?php
                            if ($rejected_row['reply_status'] === "pending") {
                        ?>
                        <div class="each_content button">
                            <button class="btn approve-btn" data-type="reply" data-id="<?php echo $rejected_row['reply_id']; ?>">Approve</button>
                            <div style="height:20px;"></div>
                            <button class="btn reject-btn" data-type="reply" data-id="<?php echo $rejected_row['reply_id']; ?>" id="reject">Reject</button>
                        </div>
                        <?php
                            } elseif ($rejected_row['reply_status'] === "approved") {
                        ?>
                        <div class="each_content button">
                            <button class="btn done">Approved</button>
                        </div>
                        <?php
                            } else {
                        ?>
                        <div class="each_content button">
                            <button class="btn done">Rejected</button>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <p>Post By: <?php echo $rejected_row['student_name'] ?></p>
                </div>
                <?php
                        }
                    } else {
                ?>
                <div class="horizontal"></div>
                <div class="no_data">
                    <p>No Rejected Comments Yet!</p>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.each_sort').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.each_sort').forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                let filter = this.getAttribute('data-filter');
                document.querySelectorAll('.table_data').forEach(section => {
                    section.style.display = (filter === 'all' && section.getAttribute('data-status') === 'all') 
                        || section.getAttribute('data-status') === filter
                        ? 'block' : 'none';
                });
            });
        });

        function updatePendingCount() {
            let count = document.querySelectorAll('.table_data[data-status="pending"] .each_data').length;
            let badge = document.getElementById('pendingCount');
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'flex';
            } else {
                badge.textContent = '';
                badge.style.display = 'none';
            }
        }

        function updateNoData(section) {
            if (section.querySelectorAll('.each_data').length === 0) {
                if (!section.querySelector('.no_data')) {
                    const statusLabel = section.getAttribute('data-status') || 'items';
                    const labelCapitalized = statusLabel.charAt(0).toUpperCase() + statusLabel.slice(1);
                    const noDiv = document.createElement('div');
                    noDiv.className = 'no_data';
                    noDiv.innerHTML = `<p>No ${labelCapitalized} Posts Yet!</p>`;
                    section.appendChild(noDiv);
                }
            }
        }

        function sortSection(section) {
            let items = [...section.querySelectorAll('.each_data')];

            // Sort newest first
            items.sort((a, b) => {
                let timeA = new Date(a.dataset.time);
                let timeB = new Date(b.dataset.time);
                return timeB - timeA;
            });

            // Remove existing items + dividers
            section.querySelectorAll('.each_data, .horizontal').forEach(el => el.remove());

            // Re-append with dividers
            items.forEach((item, i) => {
                if (i > 0) {
                    const divider = document.createElement('div');
                    divider.className = 'horizontal';
                    section.appendChild(divider);
                }
                section.appendChild(item);
            });
        }


        // 🔥 New: update UI in all tabs at once
        function updateConfessionUI(id, newStatus) {
            const statusLower = newStatus.toLowerCase();

            ['all','pending','approved','rejected'].forEach(tab => {
                const section = document.querySelector(`.table_data[data-status="${tab}"]`);
                if (!section) return;

                // find confession in this section
                const dataBlock = [...section.querySelectorAll('.each_data')].find(el => el.dataset.id == id);

                if (tab === 'pending' && dataBlock) {
                    // remove from pending
                    let hr = dataBlock.previousElementSibling;
                    if (hr && hr.classList.contains('horizontal')) hr.remove();
                    dataBlock.remove();
                    updateNoData(section);

                } else if (tab === 'all' && dataBlock) {
                    // just update button in All tab
                    const actionContainer = dataBlock.querySelector('.each_content.button');
                    if (actionContainer) {
                        actionContainer.innerHTML = `<button class="btn done">${newStatus}</button>`;
                    }

                } else if ((tab === 'approved' && statusLower === 'approved') ||
                        (tab === 'rejected' && statusLower === 'rejected')) {

                    if (dataBlock) {
                        // Case 1: Already exists → update its button
                        const actionContainer = dataBlock.querySelector('.each_content.button');
                        if (actionContainer) {
                            actionContainer.innerHTML = `<button class="btn done">${newStatus}</button>`;
                        }
                    } else {
                        // Case 2: Not there → clone from All tab
                        const allTab = document.querySelector('.table_data[data-status="all"]');
                        const original = allTab.querySelector(`.each_data[data-id="${id}"]`);
                        if (original) {
                            const clone = original.cloneNode(true);

                            // update button
                            const actionContainer = clone.querySelector('.each_content.button');
                            if (actionContainer) {
                                actionContainer.innerHTML = `<button class="btn done">${newStatus}</button>`;
                            }

                            // remove no_data if exists
                            const noData = section.querySelector('.no_data');
                            if (noData) noData.remove();

                            // add divider then append
                            const divider = document.createElement('div');
                            divider.className = 'horizontal';
                            section.appendChild(divider);
                            section.appendChild(clone);
                            sortSection(section);
                        }
                    }
                }

            });

            updatePendingCount();
        }


        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('click', function(e) {
                if (e.target.classList.contains('approve-btn') || e.target.classList.contains('reject-btn')) {
                    const id = e.target.dataset.id;
                    const status = e.target.classList.contains('approve-btn') ? 'Approved' : 'Rejected';
                    const type = e.target.dataset.type;

                    fetch('update_status.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `type=${encodeURIComponent(type)}&id=${encodeURIComponent(id)}&status=${encodeURIComponent(status.toLowerCase())}`
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            updateConfessionUI(id, status);
                        } else {
                            alert(data.message || 'Error updating status');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('AJAX request failed');
                    });
                }
            });

            updatePendingCount();
        });
    </script>
</body>
</html>