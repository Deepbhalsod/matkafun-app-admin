<?php
// ============================================================
// ⚠️  ONESIGNAL VPS DIAGNOSTIC TOOL v3
// ============================================================
$GUARD = 'debug2025';
if (($_GET['pass'] ?? '') !== $GUARD) {
    http_response_code(403);
    die('<h2 style="font-family:sans-serif;color:red">403</h2>');
}

define('BASEPATH', 'system');
define('APPPATH',  'application/');
require_once 'application/Site_constants.php';

$APP_ID  = ONESIGNAL_APP_ID;
$API_KEY = trim(ONESIGNAL_REST_API_KEY);

function doPost($url, $app_id, $key, $auth_header) {
    $payload = json_encode([
        'app_id'            => $app_id,
        'included_segments' => ['All'],
        'headings'          => ['en' => '🔧 VPS Debug Test'],
        'contents'          => ['en' => 'Diagnostic test - ignore this notification'],
    ]);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json; charset=utf-8',
            $auth_header,
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 12,
    ]);
    $body = curl_exec($ch);
    $err  = curl_error($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $json = json_decode($body, true);
    $ok   = isset($json['id']);
    return [
        'url'     => $url,
        'auth'    => $auth_header,
        'http'    => $http,
        'curl_err'=> $err ?: '(none)',
        'ok'      => $ok,
        'verdict' => $ok ? '✅ SUCCESS — Notification sent! ID: '.$json['id'] : '❌ FAIL ['.$http.']: '.($json['errors'][0] ?? $err ?: 'unknown'),
        'raw'     => $body,
    ];
}

// ── Run cross-tests on URL endpoints AND Header formats ──
$tests = [
    doPost('https://onesignal.com/api/v1/notifications', $APP_ID, $API_KEY, "Authorization: Basic {$API_KEY}"),
    doPost('https://onesignal.com/api/v1/notifications', $APP_ID, $API_KEY, "Authorization: Key {$API_KEY}"),
    doPost('https://api.onesignal.com/notifications', $APP_ID, $API_KEY, "Authorization: Basic {$API_KEY}"),
    doPost('https://api.onesignal.com/notifications', $APP_ID, $API_KEY, "Authorization: Key {$API_KEY}"),
];

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>OneSignal Debug v3</title>
<style>
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:'Courier New',monospace;background:#0a0d14;color:#e2e8f0;padding:20px}
  h1{font-family:sans-serif;color:#a78bfa;margin-bottom:6px;font-size:20px}
  .sec{background:#111827;border:1px solid #1f2937;border-radius:10px;padding:16px 20px;margin-bottom:16px}
  .sec h2{font-family:sans-serif;font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#6b7280;margin-bottom:12px}
  table{width:100%;border-collapse:collapse;font-size:12px}
  td{padding:5px 8px;border-bottom:1px solid #1e293b;vertical-align:top}
  .ok{color:#34d399;font-weight:bold}
  .err{color:#f87171;font-weight:bold}
  .pre{background:#060a14;padding:10px;border-radius:6px;overflow-x:auto;font-size:11px;color:#67e8f9;white-space:pre-wrap;margin-top:8px;border:1px solid #1e3a4a}
  .test-card{border-radius:8px;padding:14px 16px;margin-bottom:10px;border:1px solid #1f2937}
  .test-ok{background:#052e16;border-color:#16a34a}
  .test-err{background:#1a0a0a;border-color:#450a0a}
  .auth-label{font-size:13px;color:#c4b5fd;font-family:sans-serif;font-weight:700;margin-bottom:6px}
</style>
</head>
<body>

<h1>🔧 OneSignal VPS Diagnostic v3</h1>

<!-- AUTH FORMAT TESTS -->
<div class="sec">
  <h2>🔐 Endpoint & Authorization Format Tests</h2>
  <?php foreach ($tests as $i => $t): ?>
  <div class="test-card <?= $t['ok'] ? 'test-ok' : 'test-err' ?>">
    <div class="auth-label">Test <?= $i+1 ?>: <?= htmlspecialchars($t['url']) ?></div>
    <div style="font-size:12px;color:#fcd34d;margin-bottom:8px">Header: <?= htmlspecialchars($t['auth']) ?></div>
    <table>
      <tr><td style="width:100px">HTTP</td><td><?= $t['http'] ?></td></tr>
      <tr><td>Result</td><td class="<?= $t['ok'] ? 'ok' : 'err' ?>"><?= htmlspecialchars($t['verdict']) ?></td></tr>
    </table>
    <div class="pre"><?= htmlspecialchars(json_encode(json_decode($t['raw'], true), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></div>
  </div>
  <?php endforeach; ?>
</div>

<!-- FINAL VERDICT -->
<div class="sec">
  <h2>📋 Final Verdict</h2>
  <?php
  $anyOk = array_filter($tests, fn($t) => $t['ok']);
  if ($anyOk) {
      $winner = array_values($anyOk)[0];
      echo '<p class="ok" style="font-family:sans-serif">✅ Working combination found!<br><br>';
      echo '<strong>URL:</strong> ' . htmlspecialchars($winner['url']) . '<br>';
      echo '<strong>Header:</strong> ' . htmlspecialchars($winner['auth']) . '</p>';
  } else {
      echo '<p class="err" style="font-family:sans-serif">❌ ALL TESTS FAILED. If the key has NO IP Allowlist, OneSignal is actively blocking your VPS IP Address from their end.</p>';
  }
  ?>
</div>
</body>
</html>
