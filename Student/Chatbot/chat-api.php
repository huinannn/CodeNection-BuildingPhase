<?php

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$userMessage = $input['message'] ?? '';

$config = include __DIR__ . '/config.php';
$apiKey = $config['OPENROUTER_KEY'];

if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['error' => 'API key not configured.']);
    exit;
}

$data = [
    'model' => 'deepseek/deepseek-chat-v3.1:free',
    'messages' => [
        ['role' => 'system', 'content' => 'Answer concisely in 2-3 short sentences.'],
        ['role' => 'user', 'content' => $userMessage]
    ],
    'max_tokens' => 150
];

$ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$err = curl_error($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($err) {
    http_response_code(500);
    echo json_encode(['error' => $err]);
    exit;
}

http_response_code($httpcode);
echo $response;