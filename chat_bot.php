<?php
// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set response type
header('Content-Type: application/json');

// OpenRouter API credentials
$apiKey = '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'; // Keep this secure
$apiUrl = 'https://openrouter.ai/api/v1/chat/completions';

// Get user message from POST request
$input = json_decode(file_get_contents('php://input'), true);
$userMessage = $input['message'] ?? 'Hello';

// Prepare request payload
$data = [
    "model" => "openai/gpt-3.5-turbo", // More stable model
    "messages" => [
        ["role" => "user", "content" => $userMessage]
    ]
];

// Set headers
$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
];

// Initialize cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For local testing only

// Execute request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    curl_close($ch);
    echo json_encode(['reply' => 'Request failed: ' . $error_msg]);
    exit;
}

curl_close($ch);

// Decode the response
$result = json_decode($response, true);

// Extract reply safely
$reply = $result['choices'][0]['message']['content'] ?? 'Sorry, no response from OpenRouter.';

// Return reply as JSON
echo json_encode(['reply' => $reply]);
?>