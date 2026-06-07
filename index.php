<?php
$defaultUrl = 'https://example.com';
$url = $_POST['url'] ?? $defaultUrl;
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start = microtime(true);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_NOBODY => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => true,
    ]);
    curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    $time = round((microtime(true) - $start) * 1000, 2);
    $result = ['status' => $status, 'error' => $error, 'time' => $time];
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Website Uptime Monitor</title><link rel="stylesheet" href="style.css"></head>
<body><main><h1>Website Uptime Monitor</h1><form method="post"><input name="url" value="<?= htmlspecialchars($url) ?>" placeholder="https://example.com"><button>Check</button></form>
<?php if ($result): ?><section class="card"><h2>Result</h2><p>Status Code: <strong><?= htmlspecialchars($result['status']) ?></strong></p><p>Response Time: <strong><?= htmlspecialchars($result['time']) ?> ms</strong></p><p><?= $result['error'] ? htmlspecialchars($result['error']) : 'Website responded successfully.' ?></p></section><?php endif; ?>
</main></body></html>
