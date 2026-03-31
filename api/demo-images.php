<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        getDemoImages();
        break;
    case 'POST':
        addDemoImage();
        break;
    case 'PUT':
        updateDemoImage();
        break;
    case 'DELETE':
        deleteDemoImage();
        break;
    default:
        sendError('Method not allowed', 405);
}

function getDemoImages() {
    $conn = getConnection();
    
    $stmt = $conn->query("
        SELECT d.*, s.name as software_name 
        FROM demo_images d 
        LEFT JOIN software s ON d.software_id = s.id 
        WHERE d.is_active = 1 
        ORDER BY d.sort_order ASC
    ");
    
    sendResponse($stmt->fetchAll());
}

function addDemoImage() {
    $conn = getConnection();
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['title']) || !isset($data['image_url'])) {
        sendError('Title and image_url are required');
    }
    
    $stmt = $conn->prepare("
        INSERT INTO demo_images (software_id, title, image_url, link_url, sort_order) 
        VALUES (?, ?, ?, ?, ?)
    ");
    
    $stmt->execute([
        $data['software_id'] ?? null,
        $data['title'],
        $data['image_url'],
        $data['link_url'] ?? '#',
        $data['sort_order'] ?? 0
    ]);
    
    sendResponse(['success' => true, 'id' => $conn->lastInsertId()], 201);
}

function updateDemoImage() {
    $conn = getConnection();
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        sendError('ID is required');
    }
    
    $fields = [];
    $values = [];
    
    if (isset($data['software_id'])) {
        $fields[] = 'software_id = ?';
        $values[] = $data['software_id'];
    }
    if (isset($data['title'])) {
        $fields[] = 'title = ?';
        $values[] = $data['title'];
    }
    if (isset($data['image_url'])) {
        $fields[] = 'image_url = ?';
        $values[] = $data['image_url'];
    }
    if (isset($data['link_url'])) {
        $fields[] = 'link_url = ?';
        $values[] = $data['link_url'];
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
    $sql = "UPDATE demo_images SET " . implode(', ', $fields) . " WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($values);
    
    sendResponse(['success' => true]);
}

function deleteDemoImage() {
    $conn = getConnection();
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        sendError('ID is required');
    }
    
    $stmt = $conn->prepare("UPDATE demo_images SET is_active = 0 WHERE id = ?");
    $stmt->execute([$data['id']]);
    
    sendResponse(['success' => true]);
}
?>
