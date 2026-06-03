<?php
// ============================================================
// ⚠️  ONESIGNAL VPS DIAGNOSTIC TOOL
//     Upload to VPS, open in browser, then DELETE immediately!
//     DO NOT leave this file on production server.
// ============================================================

// ── Secret guard — change this password before uploading ──
$GUARD_PASSWORD = 'debug2025';
if (($_GET['pass'] ?? '') !== $GUARD_PASSWORD) {
    http_response_code(403);
    die('<h2 style="font-family:sans-serif;color:red">403 — Forbidden.<br><small>Add ?pass=debug2025 to URL</small></h2>');
}

define('BASEPATH', 'system');
define('APPPATH', 'application/');
require_once 'application/Site_constants.php';

$APP_ID  = ONESIGNAL_APP_ID;
$API_KEY = ONESIGNAL_REST_API_KEY;
$API_URL = ONESIGNAL_API_URL;

$results = [];

// ── TEST 1: PHP / Curl / SSL environment ──────────────────
$results['env'] = [
    'PHP Version'      => PHP_VERSION,
    'cURL enabled'     => function_exists('curl_init') ? '✅ Yes' : '❌ NO — cURL is missing!',
    'cURL version'     => curl_version()['version'] ?? 'N/A',
    'SSL version'      => curl_version()['ssl_version'] ?? 'N/A',
    'App ID'           => $APP_ID,
    'Key length'       => strlen($API_KEY) . ' chars',
    'Key prefix'       => substr($API_KEY, 0, 20) . '...',
    'API URL'          => $API_URL,
];

// ── TEST 2: DNS resolution of api.onesignal.com ──────────
$dns = gethostbyname('api.onesignal.com');
$results['dns'] = ($dns === 'api.onesignal.com')
    ? '❌ DNS FAIL — cannot resolve api.onesignal.com (VPS network issue)'
    : '✅ Resolved to ' . $dns;

// ── TEST 3: GET /apps/{APP_ID} — validates App ID + Key pair ──
$chGet = curl_init("https://api.onesignal.com/apps/{$APP_ID}");
curl_setopt_array($chGet, [
    CURLOPT_HTTPHEADER     => ["Authorization: Key {$API_KEY}", "Content-Type: application/json"],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT        => 15,
]);
$getBody = curl_exec($chGet);
$getCurl = curl_error($chGet);
$getHttp = curl_getinfo($chGet, CURLINFO_HTTP_CODE);
curl_close($chGet);

$getJson = json_decode($getBody, true);
$results['app_lookup'] = [
    'HTTP code'    => $getHttp,
    'cURL error'   => $getCurl ?: '(none)',
    'raw response' => $getBody,
    'verdict'      => ($getHttp === 200)
                        ? '✅ App ID + Key are VALID & matched!'
                        : '❌ MISMATCH or invalid — HTTP ' . $getHttp . ': ' . ($getJson['errors'][0] ?? 'unknown'),
];

// ── TEST 4: POST test notification (dry-run — sends a real ping) ──
if (isset($_GET['send_test'])) {
    $payload = json_encode([
        'app_id'            => $APP_ID,
        'included_segments' => ['All'],
        'headings'          => ['en' => '🔧 VPS Debug Test'],
        'contents'          => ['en' => 'If you see this, notifications are working from VPS! 🎉'],
    ]);

    $chPost = curl_init($API_URL);
    curl_setopt_array($chPost, [
        CURLOPT_HTTPHEADER     => [
            "Content-Type: application/json; charset=utf-8",
            "Authorization: Key {$API_KEY}",
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 15,
    ]);
    $postBody = curl_exec($chPost);
    $postCurl = curl_error($chPost);
    $postHttp = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
    curl_close($chPost);

    $postJson = json_decode($postBody, true);
    $results['test_send'] = [
        'HTTP code'    => $postHttp,
        'cURL error'   => $postCurl ?: '(none)',
        'raw response' => $postBody,
        'verdict'      => isset($postJson['id'])
                            ? '✅ Notification SENT! ID: ' . $postJson['id']
                            : '❌ FAILED: ' . ($postJson['errors'][0] ?? 'unknown error'),
    ];
}

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>OneSignal VPS Debug</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Courier New', monospace; background: #0f1117; color: #e2e8f0; padding: 24px; }
  h1 { font-family: sans-serif; color: #f0f; margin-bottom: 6px; font-size: 22px; }
  .warn { background: #7c2d12; border: 1px solid #ea580c; padding: 10px 14px; border-radius: 8px; color: #fdba74; font-family: sans-serif; font-size: 13px; margin-bottom: 20px; }
  .section { background: #1e2030; border: 1px solid #334155; border-radius: 10px; padding: 16px 20px; margin-bottom: 18px; }
  .section h2 { font-family: sans-serif; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; margin-bottom: 12px; }
  table { width: 100%; border-collapse: collapse; font-size: 13px; }
  td { padding: 6px 10px; border-bottom: 1px solid #1e293b; vertical-align: top; }
  td:first-child { color: #94a3b8; width: 200px; white-space: nowrap; }
  td:last-child { color: #e2e8f0; word-break: break-all; }
  .ok  { color: #4ade80; }
  .err { color: #f87171; }
  .pre { background: #0f172a; padding: 10px; border-radius: 6px; overflow-x: auto; font-size: 11px; color: #7dd3fc; white-space: pre-wrap; margin-top: 8px; }
  .btn { display: inline-block; margin-top: 16px; padding: 10px 24px; background: linear-gradient(135deg, #7c3aed, #2563eb); color: #fff; border-radius: 8px; text-decoration: none; font-family: sans-serif; font-size: 14px; font-weight: 700; }
  .btn:hover { opacity: .85; }
  .verdict-ok  { color: #4ade80; font-weight: bold; font-family: sans-serif; }
  .verdict-err { color: #f87171; font-weight: bold; font-family: sans-serif; }
</style>
</head>
<body>

<h1>🔧 OneSignal VPS Diagnostic</h1>
<div class="warn">⚠️ SECURITY: Delete this file (<code>onesignal_debug.php</code>) from VPS immediately after debugging!</div>

<!-- ENV -->
<div class="section">
  <h2>📦 Test 1 — Environment</h2>
  <table>
  <?php foreach ($results['env'] as $k => $v): ?>
    <tr><td><?= htmlspecialchars($k) ?></td><td><?= htmlspecialchars($v) ?></td></tr>
  <?php endforeach; ?>
  </table>
</div>

<!-- DNS -->
<div class="section">
  <h2>🌐 Test 2 — DNS Resolution</h2>
  <p class="<?= str_contains($results['dns'], '✅') ? 'verdict-ok' : 'verdict-err' ?>">
    <?= htmlspecialchars($results['dns']) ?>
  </p>
</div>

<!-- APP LOOKUP -->
<div class="section">
  <h2>🔑 Test 3 — App ID + REST Key Validation (GET /apps/{id})</h2>
  <table>
    <tr><td>HTTP Code</td><td><?= $results['app_lookup']['HTTP code'] ?></td></tr>
    <tr><td>cURL Error</td><td><?= htmlspecialchars($results['app_lookup']['cURL error']) ?></td></tr>
    <tr><td>Verdict</td><td class="<?= str_contains($results['app_lookup']['verdict'], '✅') ? 'verdict-ok' : 'verdict-err' ?>"><?= htmlspecialchars($results['app_lookup']['verdict']) ?></td></tr>
  </table>
  <div class="pre"><?= htmlspecialchars(json_encode(json_decode($results['app_lookup']['raw response'], true), JSON_PRETTY_PRINT)) ?></div>
</div>

<!-- TEST SEND -->
<?php if (isset($results['test_send'])): ?>
<div class="section">
  <h2>🚀 Test 4 — Live Notification Send</h2>
  <table>
    <tr><td>HTTP Code</td><td><?= $results['test_send']['HTTP code'] ?></td></tr>
    <tr><td>cURL Error</td><td><?= htmlspecialchars($results['test_send']['cURL error']) ?></td></tr>
    <tr><td>Verdict</td><td class="<?= str_contains($results['test_send']['verdict'], '✅') ? 'verdict-ok' : 'verdict-err' ?>"><?= htmlspecialchars($results['test_send']['verdict']) ?></td></tr>
  </table>
  <div class="pre"><?= htmlspecialchars(json_encode(json_decode($results['test_send']['raw response'], true), JSON_PRETTY_PRINT)) ?></div>
</div>
<?php else: ?>
<div class="section">
  <h2>🚀 Test 4 — Live Notification Send (optional)</h2>
  <p style="color:#94a3b8;font-family:sans-serif;font-size:13px;margin-bottom:12px;">Click to send a real test push notification to all subscribed users.</p>
  <a class="btn" href="?pass=<?= htmlspecialchars($_GET['pass']) ?>&send_test=1">Send Test Notification</a>
</div>
<?php endif; ?>

<br>
<p style="color:#475569;font-size:12px;font-family:sans-serif;">
  ⚠️ Remember: delete <strong>onesignal_debug.php</strong> from your server after you finish debugging!
</p>

</body>
</html>
