<?php

// Pastikan direktori writable di serverless /tmp
$directories = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Tangkap error secara eksplisit dan tampilkan jika terjadi crash
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/html; charset=utf-8');
    echo "<h1>Terjadi Kesalahan pada Serverless (Vercel)</h1>";
    echo "<p><strong>Pesan Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Baris: " . $e->getLine() . ")</p>";
    echo "<pre style='background:#f4f4f4;padding:15px;border-radius:5px;overflow:auto;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    exit;
}
