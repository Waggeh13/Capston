<?php
header('Content-Type: application/json');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load API key from config file
$config = include('../settings/config.php');
$OPENAI_API_KEY = $config['OPENAI_API_KEY'];

if (!isset($OPENAI_API_KEY) || empty($OPENAI_API_KEY)) {
    echo json_encode(['error' => 'API key not configured']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $user_message = isset($data['message']) ? trim($data['message']) : '';

    if (empty($user_message)) {
        echo json_encode(['error' => 'Message is required']);
        exit;
    }

    // Initialize chat history if not set
    if (!isset($_SESSION['chat_history'])) {
        $_SESSION['chat_history'] = [];
    }

    // Add user message to chat history
    $_SESSION['chat_history'][] = [
        'role' => 'user',
        'content' => $user_message
    ];

    // Prepare messages for OpenAI API (system prompt + chat history)
    $messages = [
        [
            'role' => 'system',
            'content' => 'You are a health assistant chatbot designed to provide information about symptoms of medical illnesses. You can respond to:
1. Questions asking about symptoms of medical illnesses (e.g., "What are the symptoms of flu?" or "What does a migraine feel like?").
2. Statements describing personal symptoms (e.g., "I have a fever and sore throat" or "I feel dizzy"). For these, provide information about the symptoms of medical illnesses commonly associated with the described symptoms.
Do not provide medical advice, diagnoses, or treatment recommendations. For any other type of input (e.g., general knowledge, unrelated topics, or requests beyond symptom information), respond with: "Input not supported. Please ask about symptoms of medical illnesses.""'
        ]
    ];
    $messages = array_merge($messages, $_SESSION['chat_history']);

    $payload = [
        'model' => 'gpt-4.1', 
        'messages' => $messages,
        'temperature' => 0.7
    ];

    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $OPENAI_API_KEY
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        echo json_encode(['error' => 'Failed to fetch response from OpenAI']);
        exit;
    }

    $result = json_decode($response, true);
    if (isset($result['error'])) {
        echo json_encode(['error' => $result['error']['message']]);
        exit;
    }

    $bot_message = $result['choices'][0]['message']['content'] ?? 'No response';

    // Add bot response to chat history
    $_SESSION['chat_history'][] = [
        'role' => 'assistant',
        'content' => $bot_message
    ];

    echo json_encode(['reply' => $bot_message]);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>