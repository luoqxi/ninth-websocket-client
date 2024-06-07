<?php

require __DIR__ . '/vendor/autoload.php';

\Ratchet\Client\connect('ws://localhost:8080')->then(function ($conn) {
    $conn->send(json_encode(['time' => '2024-06-03 12:00:00']));

    $conn->on('message', function ($msg) use ($conn) {
        echo "[" . date('Y-m-d H:i:s', time()) . "."
            . sprintf('%03d', (microtime(true) - floor(microtime(true)))
                * 1000) . "] " . "Received: {$msg}\n";
    });

    $conn->on('close', function ($code = null, $reason = null) {
        echo "Connection closed ({$code} - {$reason})\n";
    });
}, function ($e) {
    echo "Could not connect: {$e->getMessage()}\n";
});
