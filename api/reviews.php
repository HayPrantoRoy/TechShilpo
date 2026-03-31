<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        getReviews();
        break;
    case 'POST':
        addReview();
        break;
    case 'PUT':
        updateReview();
        break;
    case 'DELETE':
        deleteReview();
        break;
    default:
        sendError('Method not allowed', 405);
}

function getReviews() {
    $conn = getConnection();
    
    $stmt = $conn->query("
        SELECT * FROM client_reviews 
        WHERE is_active = 1 
        ORDER BY sort_order ASC
    ");
    
    sendResponse($stmt->fetchAll());
}

function addReview() {
    $conn = getConnection();
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['client_name']) || !isset($data['review_text'])) {
        sendError('Client name and review text are required');
    }
    
    $stmt = $conn->prepare("
        INSERT INTO client_reviews (client_name, company_name, client_image, review_text, rating, sort_order) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    
    $stmt->execute([
        $data['client_name'],
        $data['company_name'] ?? '',
        $data['client_image'] ?? '',
        $data['review_text'],
        $data['rating'] ?? 5,
        $data['sort_order'] ?? 0
    ]);
    
    sendResponse(['success' => true, 'id' => $conn->lastInsertId()], 201);
}

function updateReview() {
    $conn = getConnection();
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        sendError('ID is required');
    }
    
    $fields = [];
    $values = [];
    
    if (isset($data['client_name'])) {
        $fields[] = 'client_name = ?';
        $values[] = $data['client_name'];
    }
    if (isset($data['company_name'])) {
        $fields[] = 'company_name = ?';
        $values[] = $data['company_name'];
    }
    if (isset($data['client_image'])) {
        $fields[] = 'client_image = ?';
        $values[] = $data['client_image'];
    }
    if (isset($data['review_text'])) {
        $fields[] = 'review_text = ?';
        $values[] = $data['review_text'];
    }
    if (isset($data['rating'])) {
        $fields[] = 'rating = ?';
        $values[] = $data['rating'];
    }
    if (isset($data['sort_order'])) {
        $fields[] = 'sort_order = ?';
        $values[] = $data['sort_order'];
    }
    if (isset($data['is_active'])) {
        $fields[] = 'is_active = ?';
        $values[] = $data['is_active'] ? 1 : 0;
    }
    
    if (empty($fields)) {
        sendError('No fields to update');
    }
    
    $values[] = $data['id'];
    $sql = "UPDATE client_reviews SET " . implode(', ', $fields) . " WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($values);
    
    sendResponse(['success' => true]);
}

function deleteReview() {
    $conn = getConnection();
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        sendError('ID is required');
    }
    
    $stmt = $conn->prepare("UPDATE client_reviews SET is_active = 0 WHERE id = ?");
    $stmt->execute([$data['id']]);
    
    sendResponse(['success' => true]);
}
?>
