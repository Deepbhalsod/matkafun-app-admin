<?php
// ============================================================
// ⚠️  ONESIGNAL VPS DIAGNOSTIC TOOL v2
//     Upload to VPS, open in browser, then DELETE immediately!
// ============================================================
$GUARD = 'debug2025';
if (($_GET['pass'] ?? '') !== $GUARD) {
    http_response_code(403);
    die('<h2 style="font-family:sans-serif;color:red">403 — Add ?pass=debug2025 to URL</h2>');
}

define('BASEPATH', 'system');
define('APPPATH',  'application/');
require_once 'application/Site_constants.php';

$APP_ID  = ONESIGNAL_APP_ID;
$API_KEY = ONESIGNAL_REST_API_KEY;
$API_URL = ONESIGNAL_API_URL; // https://api.onesignal.com/notifications

// ── Encoding analysis ─────────────────────────────────────
$key_raw_hex  = bin2hex($API_KEY);
$key_trimmed  = trim($API_KEY);
$key_len_orig = strlen($API_KEY);
$key_len_trim = strlen($key_trimmed);
$has_bom      = (substr($API_KEY, 0, 3) === "\xEF\xBB\xBF");
$has_cr       = (strpos($API_KEY, "\r") !== false);
$has_nl       = (strpos($API_KEY, "\n") !== false);
$has_space    = (strpos($API_KEY, ' ') !== false || $API_KEY !== trim($API_KEY));

// Clean key (strip all hidden chars just in case)
$clean_key = preg_replace('/[^a-zA-Z0-9_\-]/', '', $API_KEY);
$clean_len = strlen($clean_key);

// ── Helper: single cURL call ──────────────────────────────
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
        'auth'    => $auth_header,
        'http'    => $http,
        'curl_err'=> $err ?: '(none)',
        'ok'      => $ok,
        'verdict' => $ok ? '✅ SUCCESS — Notification sent! ID: '.$json['id'] : '❌ FAIL ['.$http.']: '.($json['errors'][0] ?? $err ?: 'unknown'),
        'raw'     => $body,
    ];
}

// ── Run 4 auth format tests ───────────────────────────────
$tests = [
    doPost($API_URL, $APP_ID, $API_KEY,   "Authorization: Key {$API_KEY}"),
    doPost($API_URL, $APP_ID, $clean_key, "Authorization: Key {$clean_key}"),
    doPost($API_URL, $APP_ID, $API_KEY,   "Authorization: Bearer {$API_KEY}"),
    doPost($API_URL, $APP_ID, $API_KEY,   "Authorization: Basic {$API_KEY}"),
];

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>OneSignal Debug v2</title>
<style>
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:'Courier New',monospace;background:#0a0d14;color:#e2e8f0;padding:20px}
  h1{font-family:sans-serif;color:#a78bfa;margin-bottom:6px;font-size:20px}
  .warn{background:#7c2d12;border:1px solid #ea580c;padding:10px 14px;border-radius:8px;color:#fdba74;font-family:sans-serif;font-size:12px;margin-bottom:18px}
  .sec{background:#111827;border:1px solid #1f2937;border-radius:10px;padding:16px 20px;margin-bottom:16px}
  .sec h2{font-family:sans-serif;font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#6b7280;margin-bottom:12px}
  table{width:100%;border-collapse:collapse;font-size:12px}
  td{padding:5px 8px;border-bottom:1px solid #1e293b;vertical-align:top}
  td:first-child{color:#6b7280;width:220px;white-space:nowrap}
  .ok{color:#34d399;font-weight:bold}
  .err{color:#f87171;font-weight:bold}
  .warn2{color:#fbbf24;font-weight:bold}
  .pre{background:#060a14;padding:10px;border-radius:6px;overflow-x:auto;font-size:11px;color:#67e8f9;white-space:pre-wrap;margin-top:8px;border:1px solid #1e3a4a}
  .tag-ok{display:inline-block;background:#052e16;border:1px solid #16a34a;color:#4ade80;padding:2px 8px;border-radius:20px;font-size:11px}
  .tag-err{display:inline-block;background:#2d0a0a;border:1px solid #b91c1c;color:#f87171;padding:2px 8px;border-radius:20px;font-size:11px}
  .test-card{border-radius:8px;padding:14px 16px;margin-bottom:10px;border:1px solid #1f2937}
  .test-ok{background:#052e16;border-color:#16a34a}
  .test-err{background:#1a0a0a;border-color:#450a0a}
  .auth-label{font-size:13px;color:#c4b5fd;font-family:sans-serif;font-weight:700;margin-bottom:6px}
</style>
</head>
<body>

<h1>🔧 OneSignal VPS Diagnostic v2</h1>
<div class="warn">⚠️ Delete <strong>onesignal_debug.php</strong> from VPS immediately after debugging!</div>

<!-- ENCODING ANALYSIS -->
<div class="sec">
  <h2>🔬 Key Encoding Analysis</h2>
  <table>
    <tr><td>Original key length</td><td><?= $key_len_orig ?> chars</td></tr>
    <tr><td>Trimmed key length</td><td><?= $key_len_trim ?> chars <?= $key_len_orig !== $key_len_trim ? '<span class="err">⚠️ WHITESPACE DETECTED!</span>' : '<span class="ok">✅ Same</span>' ?></td></tr>
    <tr><td>Cleaned key length</td><td><?= $clean_len ?> chars <?= $key_len_orig !== $clean_len ? '<span class="err">⚠️ INVISIBLE CHARS FOUND!</span>' : '<span class="ok">✅ Same — no hidden chars</span>' ?></td></tr>
    <tr><td>Has UTF-8 BOM (﻿)</td><td><?= $has_bom ? '<span class="err">❌ YES — BOM found!</span>' : '<span class="ok">✅ No</span>' ?></td></tr>
    <tr><td>Has CR (\r)</td><td><?= $has_cr ? '<span class="err">❌ YES — carriage return!</span>' : '<span class="ok">✅ No</span>' ?></td></tr>
    <tr><td>Has newline (\n)</td><td><?= $has_nl ? '<span class="err">❌ YES — newline found!</span>' : '<span class="ok">✅ No</span>' ?></td></tr>
    <tr><td>Has extra whitespace</td><td><?= $has_space ? '<span class="err">❌ YES — spaces/whitespace!</span>' : '<span class="ok">✅ No</span>' ?></td></tr>
    <tr><td>App ID</td><td><?= htmlspecialchars($APP_ID) ?></td></tr>
    <tr><td>Key (first 30 chars)</td><td><?= htmlspecialchars(substr($API_KEY, 0, 30)) ?>...</td></tr>
    <tr><td>Key hex (first 40 chars)</td><td style="word-break:break-all;font-size:11px"><?= substr($key_raw_hex, 0, 40) ?>...</td></tr>
  </table>
</div>

<!-- AUTH FORMAT TESTS -->
<div class="sec">
  <h2>🔐 Authorization Format Tests (4 variants sent to OneSignal)</h2>
  <?php
  $labels = [
      '1. "Key {api_key}" — standard format',
      '2. "Key {cleaned_key}" — key stripped of hidden chars',
      '3. "Bearer {api_key}" — Bearer token format',
      '4. "Basic {api_key}" — Basic format',
  ];
  foreach ($tests as $i => $t):
  ?>
  <div class="test-card <?= $t['ok'] ? 'test-ok' : 'test-err' ?>">
    <div class="auth-label"><?= $labels[$i] ?></div>
    <table>
      <tr><td>HTTP</td><td><?= $t['http'] ?></td></tr>
      <tr><td>cURL Error</td><td><?= htmlspecialchars($t['curl_err']) ?></td></tr>
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
      echo '<p class="ok" style="font-family:sans-serif">✅ Working format found! Use: <code>' . htmlspecialchars($winner['auth']) . '</code></p>';
  } else {
      echo '<p class="err" style="font-family:sans-serif;font-size:13px">❌ ALL 4 FORMATS FAILED — This is NOT a PHP/code issue.<br><br>';
      echo 'Possible causes:<br>';
      echo '• This OneSignal app may be deleted, disabled or restricted<br>';
      echo '• Your VPS IP may be blocked by OneSignal<br>';
      echo '• Try logging out &amp; back into OneSignal and regenerating the key<br>';
      echo '• Try creating a brand new OneSignal app entirely</p>';
  }
  ?>
</div>

<br>
<p style="color:#374151;font-size:11px;font-family:sans-serif">⚠️ Delete this file from VPS after debugging. URL: <code><?= htmlspecialchars($_SERVER['PHP_SELF']) ?></code></p>
</body>
</html>
