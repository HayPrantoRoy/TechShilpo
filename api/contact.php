<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        getMessages();
        break;
    case 'POST':
        saveMessage();
        break;
    case 'PUT':
        markAsRead();
        break;
    case 'DELETE':
        deleteMessage();
        break;
    default:
        sendError('Method not allowed', 405);
}

function getMessages() {
    $conn = getConnection();
    
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;
    
    if ($id) {
        $stmt = $conn->prepare("SELECT * FROM contact_messages WHERE id = ?");
        $stmt->execute([$id]);
        $message = $stmt->fetch();
        
        if ($message) {
            sendResponse($message);
        } else {
            sendError('Message not found', 404);
        }
    } else {
        $stmt = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
        sendResponse($stmt->fetchAll());
    }
}

function saveMessage() {
    $conn = getConnection();
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['name']) || !isset($data['email']) || !isset($data['message'])) {
        sendError('Name, email and message are required');
    }
    
    $stmt = $conn->prepare("
        INSERT INTO contact_messages (name, email, phone, message) 
        VALUES (?, ?, ?, ?)
    ");
    
    $stmt->execute([
        $data['name'],
        $data['email'],
        $data['phone'] ?? '',
        $data['message']
    ]);
    
    sendResponse(['success' => true, 'id' => $conn->lastInsertId(), 'message' => 'বার্তা সফলভাবে পাঠানো হয়েছে!'], 201);
}

function markAsRead() {
    $conn = getConnection();
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        sendError('ID is required');
    }
    
    $stmt = $conn->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
    $stmt->execute([$data['id']]);
    
    sendResponse(['success' => true]);
}

function deleteMessage() {
    $conn = getConnection();
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        sendError('ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->execute([$data['id']]);
    
    sendResponse(['success' => true]);
}
?>
