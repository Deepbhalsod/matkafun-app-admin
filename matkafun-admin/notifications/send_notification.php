<?php
require('config.php'); // Loads DB + Site_constants.php (which has all OneSignal config)

$alertMsg    = '';
$alertType   = '';

// ─── READ STATUS FROM REDIRECT (PRG pattern) ────────────────────
if (isset($_GET['test_headers'])) {
    $fields = [
        'app_id' => ONESIGNAL_APP_ID,
        'included_segments' => ['All'],
        'headings' => ['en' => 'Test Diagnostic Notification'],
        'contents' => ['en' => 'This is a diagnostic notification sent from VPS.'],
    ];

    // Test 1: Basic
    $ch1 = curl_init("https://onesignal.com/api/v1/notifications");
    curl_setopt($ch1, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . ONESIGNAL_REST_API_KEY,
    ]);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch1, CURLOPT_POST, true);
    curl_setopt($ch1, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
    $responseBasic = curl_exec($ch1);
    curl_close($ch1);

    // Test 2: Key
    $ch2 = curl_init("https://onesignal.com/api/v1/notifications");
    curl_setopt($ch2, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Key ' . ONESIGNAL_REST_API_KEY,
    ]);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_POST, true);
    curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
    $responseKey = curl_exec($ch2);
    curl_close($ch2);

    echo "<pre><h3>OneSignal Direct API Tests from VPS:</h3>";
    echo "<b>App ID:</b> " . ONESIGNAL_APP_ID . "\n";
    echo "<b>Key Length:</b> " . strlen(ONESIGNAL_REST_API_KEY) . "\n\n";
    echo "<b>Test 1 (Basic Scheme) Response:</b>\n" . htmlspecialchars($responseBasic) . "\n\n";
    echo "<b>Test 2 (Key Scheme) Response:</b>\n" . htmlspecialchars($responseKey) . "\n";
    echo "</pre>";
    exit;
}

// After POST we redirect here with ?status=success&msg=... to avoid
// re-sending the notification when the user refreshes the page.
if (isset($_GET['status'])) {
    $alertType = in_array($_GET['status'], ['success','error','warning'])
                 ? $_GET['status'] : '';
    $alertMsg  = htmlspecialchars(urldecode($_GET['msg'] ?? ''), ENT_QUOTES);
}

// ─── HANDLE DELETE ─────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// ─── HANDLE SEND ──────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title']   ?? '');
    $segment = trim($_POST['segment'] ?? 'All');
    $allowed_segments = ['All', 'Active Users', 'Engaged Users', 'Inactive Users'];
    if (!in_array($segment, $allowed_segments)) $segment = 'All';
    $msg = trim($_POST['message'] ?? '');

    if ($title === '' || $msg === '') {
        $rType = 'warning';
        $rMsg  = '⚠️ Both Title and Message are required.';
    } else {
        // 1️⃣ Save to DB
        $db_heading = "[MANUAL] " . $title; // For admin panel identification
        $ist_time = date('Y-m-d H:i:s');
        $stmt = $conn->prepare(
            "INSERT INTO notifications (heading, message, user_id, status, icon, created_date) VALUES (?, ?, 'all', 1, '', ?)"
        );
        $stmt->bind_param("sss", $db_heading, $msg, $ist_time);
        $dbOk = $stmt->execute();

        if (!$dbOk) {
            $rType = 'error';
            $rMsg  = '❌ Database error: ' . $conn->error;
        } else {
            // 2️⃣ Send to OneSignal
            $fields = [
                'app_id'            => ONESIGNAL_APP_ID,
                'included_segments' => [$segment],
                'headings'          => ['en' => $title],
                'contents'          => ['en' => $msg],
            ];

            $ch = curl_init(ONESIGNAL_API_URL);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json; charset=utf-8',
                'Authorization: Key ' . ONESIGNAL_REST_API_KEY,
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);

            $response = curl_exec($ch);
            $curlErr  = curl_error($ch);
            curl_close($ch);

            $res = json_decode($response, true);

            if (isset($res['id'])) {
                $rType = 'success';
                $rMsg  = '✅ Notification sent successfully to ' . htmlspecialchars($segment) . ' users!';
            } else {
                $errDetail = '';
                if (!empty($res['errors'])) $errDetail = implode(', ', (array)$res['errors']);
                if ($curlErr)              $errDetail = $curlErr;
                
                // Diagnostic block for VPS differences
                $keyLen = strlen(ONESIGNAL_REST_API_KEY);
                $maskedKey = substr(ONESIGNAL_REST_API_KEY, 0, 15) . '...' . substr(ONESIGNAL_REST_API_KEY, -5);
                $debugInfo = sprintf(
                    "<br><small style='display:block;margin-top:8px;font-size:11px;opacity:0.8;'><b>VPS Debug Info:</b><br>" .
                    "PHP: %s | Curl: %s | SSL: %s<br>" .
                    "URL: %s<br>" .
                    "Auth Sent: Key %s (Length: %d)<br>" .
                    "Raw Response: %s</small>",
                    PHP_VERSION,
                    curl_version()['version'],
                    curl_version()['ssl_version'],
                    ONESIGNAL_API_URL,
                    $maskedKey,
                    $keyLen,
                    htmlspecialchars($response)
                );
                
                $rType = 'error';
                $rMsg  = '❌ OneSignal Error: ' . ($errDetail ?: 'Unknown error. Check API key.') . $debugInfo;
            }
        }
    }

    // ✅ PRG: Redirect after POST so page refresh doesn't re-send
    header('Location: ' . $_SERVER['PHP_SELF'] . '?status=' . urlencode($rType) . '&msg=' . urlencode($rMsg));
    exit;
}

// ─── FETCH HISTORY ─────────────────────────────────────────────
$history = $conn->query(
    "SELECT id, heading, message, created_date FROM notifications ORDER BY id DESC LIMIT 50"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Send Notification — Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../variables.css"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --accent:   var(--main-col-);
      --dark:     var(--main-drk);
      --bg:       #f4f6f9;
      --card:     #ffffff;
      --border:   #e2e8f0;
      --text:     #1c274c;
      --muted:    #64748b;
      --green:    #16a34a;
      --red:      #dc2626;
      --yellow:   #d97706;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      padding: 20px 12px 60px;
    }

    .header {
      text-align: center;
      margin-bottom: 24px;
      padding: 0 4px;
    }
    .header .badge {
      display: inline-block;
      background: rgba(34,139,34,.12);
      color: var(--accent);
      border: 1px solid rgba(34,139,34,.3);
      border-radius: 30px;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1px;
      padding: 4px 14px;
      text-transform: uppercase;
      margin-bottom: 10px;
    }
    .header h1 {
      font-size: clamp(20px, 5vw, 28px);
      font-weight: 800;
      color: var(--dark);
      line-height: 1.2;
    }
    .header p { color: var(--muted); font-size: 13px; margin-top: 6px; }

    /* ── LAYOUT ── */
    .layout {
      display: grid;
      grid-template-columns: minmax(0, 420px) 1fr;
      gap: 20px;
      max-width: 1100px;
      margin: 0 auto;
    }
    /* Tablet: stack vertically */
    @media (max-width: 860px) {
      .layout { grid-template-columns: 1fr; }
    }

    /* ── CARD ── */
    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 24px 20px;
      box-shadow: 0 2px 12px rgba(0,0,0,.06);
    }
    @media (max-width: 480px) {
      .card { padding: 18px 14px; border-radius: 12px; }
    }
    .card-title {
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .9px;
      color: var(--muted);
      margin-bottom: 22px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* ── FORM ── */
    .form-group { margin-bottom: 18px; }
    .form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: .5px;
      margin-bottom: 7px;
    }
    .form-group input,
    .form-group textarea {
      width: 100%;
      background: #f8fafc;
      border: 1px solid var(--border);
      border-radius: 10px;
      color: var(--text);
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      padding: 12px 15px;
      outline: none;
      transition: border .2s, box-shadow .2s;
    }
    .form-group input::placeholder,
    .form-group textarea::placeholder { color: #94a3b8; }
    .form-group input:focus,
    .form-group textarea:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(34,139,34,.12);
    }
    .form-group textarea { resize: vertical; min-height: 110px; }

    /* live preview */
    .preview-box {
      background: #f0fdf4;
      border: 1px dashed rgba(34,139,34,.4);
      border-radius: 10px;
      padding: 14px 16px;
      margin-bottom: 20px;
    }
    .preview-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: .7px; font-weight: 600; margin-bottom: 10px; }
    .preview-phone {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      background: #fff;
      border-radius: 10px;
      padding: 12px;
      border: 1px solid var(--border);
    }
    .preview-icon {
      width: 36px; height: 36px;
      background: linear-gradient(135deg, var(--main-col-), var(--main-drk));
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 18px; flex-shrink: 0;
    }
    .preview-text .p-title { font-size: 13px; font-weight: 700; color: var(--text); }
    .preview-text .p-body  { font-size: 12px; color: var(--muted); margin-top: 3px; line-height: 1.4; }

    .send-btn {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, var(--main-col-), var(--main-drk));
      border: none;
      border-radius: 10px;
      color: #fff;
      font-size: 15px;
      font-weight: 700;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      transition: all .2s;
      letter-spacing: .3px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .send-btn:hover { opacity: .88; transform: translateY(-1px); box-shadow: 0 8px 25px rgba(34,139,34,.3); }
    .send-btn:active { transform: translateY(0); }

    /* ── SEGMENT SELECTOR ── */
    .segment-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 8px;
    }
    /* On narrow screens use 2 columns */
    @media (max-width: 600px) {
      .segment-grid { grid-template-columns: 1fr 1fr; }
    }
    /* Very small phones: still 2 columns but tighter */
    @media (max-width: 360px) {
      .segment-grid { grid-template-columns: 1fr 1fr; gap: 6px; }
    }
    .seg-card {
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 14px 10px;
      background: #f8fafc;
      border: 1px solid var(--border);
      border-radius: 10px;
      cursor: pointer;
      transition: all .2s;
      gap: 4px;
    }
    .seg-card input[type=radio] { display: none; }
    .seg-card:hover { border-color: var(--accent); background: #f0fdf4; }
    .seg-card:has(input:checked) {
      border-color: var(--accent);
      background: #f0fdf4;
      box-shadow: 0 0 0 2px rgba(34,139,34,.15);
    }
    .seg-icon { font-size: 20px; }
    .seg-name { font-size: 12px; font-weight: 700; color: var(--text); }
    .seg-desc { font-size: 10.5px; color: var(--muted); line-height: 1.3; }
    .seg-card:has(input:checked)::after {
      content: '✔';
      position: absolute;
      top: 6px; right: 8px;
      font-size: 11px;
      color: var(--accent);
      font-weight: 700;
    }

    /* ── ALERT ── */
    .alert {
      border-radius: 10px;
      padding: 13px 16px;
      font-size: 13.5px;
      font-weight: 500;
      margin-bottom: 20px;
      animation: fadeIn .4s ease;
    }
    .alert-success { background: #f0fdf4;  border: 1px solid #86efac; color: var(--green); }
    .alert-error   { background: #fef2f2;  border: 1px solid #fca5a5; color: var(--red); }
    .alert-warning { background: #fffbeb;  border: 1px solid #fcd34d; color: var(--yellow); }

    /* ── HISTORY TABLE ── */
    .history-title {
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .9px;
      color: var(--muted);
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .empty-state {
      text-align: center;
      padding: 40px 20px;
      color: var(--muted);
      font-size: 14px;
    }
    .empty-state .empty-icon { font-size: 40px; margin-bottom: 10px; }

    /* Desktop table */
    .notif-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .notif-table thead th {
      padding: 10px 14px;
      text-align: left;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .6px;
      color: var(--muted);
      border-bottom: 1px solid var(--border);
    }
    .notif-table tbody tr { transition: background .15s; }
    .notif-table tbody tr:hover { background: #f8fafc; }
    .notif-table tbody td {
      padding: 13px 14px;
      border-bottom: 1px solid var(--border);
      vertical-align: top;
    }
    .td-title { font-weight: 600; color: var(--text); font-size: 13px; }
    .td-msg   { color: var(--muted); font-size: 12.5px; margin-top: 3px; line-height: 1.5; }
    .td-date  { color: #94a3b8; font-size: 12px; white-space: nowrap; }
    .del-btn {
      background: #fef2f2;
      border: 1px solid #fca5a5;
      color: var(--red);
      border-radius: 6px;
      padding: 5px 10px;
      font-size: 12px;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      font-weight: 600;
      transition: all .2s;
      white-space: nowrap;
    }
    .del-btn:hover { background: #fee2e2; }

    /* Mobile: card-style rows instead of table */
    @media (max-width: 600px) {
      .notif-table thead { display: none; }
      .notif-table, .notif-table tbody, .notif-table tr, .notif-table td {
        display: block;
        width: 100%;
      }
      .notif-table tr {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        margin-bottom: 10px;
        padding: 12px 14px;
        position: relative;
      }
      .notif-table tr:hover { background: #f8fafc; }
      .notif-table td {
        padding: 2px 0;
        border: none;
      }
      /* hide the # column on mobile */
      .notif-table td:first-child { display: none; }
      /* date inline small */
      .td-date { display: block; margin-top: 6px; font-size: 11px; }
      /* delete button top-right */
      .notif-table td:last-child {
        position: absolute;
        top: 10px; right: 10px;
      }
    }
    @keyframes fadeIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }
  </style>
</head>
<body>

<div class="header">
  <div class="badge">📢 Admin Panel</div>
  <h1>Send Custom Notification</h1>
  <p>Broadcast a push notification to all subscribed users instantly</p>
</div>

<div class="layout">

  <!-- ── SEND FORM ── -->
  <div class="card">
    <div class="card-title">✏️ Compose Notification</div>

    <?php if ($alertMsg): ?>
    <div class="alert alert-<?= $alertType ?>">
      <?= $alertMsg ?>
    </div>
    <?php endif; ?>

    <form method="POST" id="notifForm">

      <!-- TARGET AUDIENCE -->
      <div class="form-group">
        <label>Target Audience</label>
        <div class="segment-grid">
          <label class="seg-card">
            <input type="radio" name="segment" value="All" <?= (($_POST['segment'] ?? 'All') === 'All') ? 'checked' : '' ?>/>
            <span class="seg-icon">📢</span>
            <span class="seg-name">All Users</span>
            <span class="seg-desc">Every subscribed user</span>
          </label>
          <label class="seg-card">
            <input type="radio" name="segment" value="Active Users" <?= (($_POST['segment'] ?? '') === 'Active Users') ? 'checked' : '' ?>/>
            <span class="seg-icon">🟢</span>
            <span class="seg-name">Active Users</span>
            <span class="seg-desc">Opened app recently</span>
          </label>
          <label class="seg-card">
            <input type="radio" name="segment" value="Engaged Users" <?= (($_POST['segment'] ?? '') === 'Engaged Users') ? 'checked' : '' ?>/>
            <span class="seg-icon">⭐</span>
            <span class="seg-name">Engaged Users</span>
            <span class="seg-desc">Loyal long-time users</span>
          </label>
          <label class="seg-card">
            <input type="radio" name="segment" value="Inactive Users" <?= (($_POST['segment'] ?? '') === 'Inactive Users') ? 'checked' : '' ?>/>
            <span class="seg-icon">😴</span>
            <span class="seg-name">Inactive Users</span>
            <span class="seg-desc">Haven't opened in 7+ days</span>
          </label>
        </div>
      </div>

      <div class="form-group">
        <label>Notice Title *</label>
        <input
          type="text"
          name="title"
          id="inp_title"
          placeholder="e.g. Important Update"
          maxlength="100"
          value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
          required
          oninput="updatePreview()"
        />
      </div>

      <div class="form-group">
        <label>Notification Content *</label>
        <textarea
          name="message"
          id="inp_msg"
          placeholder="e.g. Server maintenance scheduled tonight at 10 PM IST. Please withdraw your winnings before 9:30 PM."
          maxlength="500"
          required
          oninput="updatePreview()"
        ><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
      </div>

      <!-- Live Phone Preview -->
      <div class="preview-box">
        <div class="preview-label">📱 Live Preview — How it looks on device</div>
        <div class="preview-phone">
          <div class="preview-icon">🔔</div>
          <div class="preview-text">
            <div class="p-title" id="prev_title">Your Title Here</div>
            <div class="p-body"  id="prev_body">Your notification message will appear here...</div>
          </div>
        </div>
      </div>

      <button type="submit" class="send-btn" id="sendBtn">
        🚀 Send to All Users
      </button>

    </form>
  </div>

  <!-- ── HISTORY ── -->
  <div class="card">
    <div class="history-title">🕒 Notification History</div>

    <?php if ($history && $history->num_rows > 0): ?>
    <div style="overflow-x:auto;">
      <table class="notif-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Title &amp; Message</th>
            <th>Sent At</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($row = $history->fetch_assoc()): ?>
          <tr>
            <td style="color:var(--muted);font-size:12px;"><?= $i++ ?></td>
            <td>
              <div class="td-title"><?= htmlspecialchars($row['heading'] ?: '—') ?></div>
              <div class="td-msg"><?= htmlspecialchars($row['message']) ?></div>
            </td>
            <td class="td-date"><?= htmlspecialchars($row['created_date'] ?: '—') ?></td>
            <td>
              <button
                class="del-btn"
                onclick="if(confirm('Delete this notification?')) location.href='?delete=<?= $row['id'] ?>'"
              >✕ Delete</button>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
      <div class="empty-icon">📭</div>
      No notifications sent yet.<br>
      Compose and send your first notification!
    </div>
    <?php endif; ?>
  </div>

</div><!-- end .layout -->

<script>
  // Live preview updater
  function updatePreview() {
    const t = document.getElementById('inp_title').value.trim();
    const m = document.getElementById('inp_msg').value.trim();
    document.getElementById('prev_title').textContent = t || 'Your Title Here';
    document.getElementById('prev_body').textContent  = m || 'Your notification message will appear here...';
  }

  // Disable button on submit to prevent double-send
  document.getElementById('notifForm').addEventListener('submit', function() {
    const btn = document.getElementById('sendBtn');
    btn.disabled = true;
    btn.textContent = '⏳ Sending...';
  });

  // Init preview on page load (if values pre-filled)
  updatePreview();
</script>
</body>
</html>
