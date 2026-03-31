<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        getSoftware();
        break;
    case 'POST':
        addSoftware();
        break;
    case 'PUT':
        updateSoftware();
        break;
    case 'DELETE':
        deleteSoftware();
        break;
    default:
        sendError('Method not allowed', 405);
}

function getSoftware() {
    $conn = getConnection();
    
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;
    
    if ($id) {
        $stmt = $conn->prepare("SELECT * FROM software WHERE id = ? AND is_active = 1");
        $stmt->execute([$id]);
        $software = $stmt->fetch();
        
        if ($software) {
            $software['features'] = json_decode($software['features']);
            sendResponse($software);
        } else {
            sendError('Software not found', 404);
        }
    } else {
        $stmt = $conn->query("SELECT * FROM software WHERE is_active = 1 ORDER BY sort_order ASC");
        $software = $stmt->fetchAll();
        
        foreach ($software as &$item) {
            $item['features'] = json_decode($item['features']);
        }
        
        sendResponse($software);
    }
}

function addSoftware() {
    $conn = getConnection();
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['name']) || !isset($data['description'])) {
        sendError('Name and description are required');
    }
    
    $stmt = $conn->prepare("
        INSERT INTO software (name, description, image, demo_url, buy_url, features, sort_order) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    
    $features = isset($data['features']) ? json_encode($data['features'], JSON_UNESCAPED_UNICODE) : '[]';
    
    $stmt->execute([
        $data['name'],
        $data['description'],
        $data['image'] ?? '',
        $data['demo_url'] ?? '#',
        $data['buy_url'] ?? '#',
        $features,
        $data['sort_order'] ?? 0
    ]);
    
    sendResponse(['success' => true, 'id' => $conn->lastInsertId()], 201);
}

function updateSoftware() {
    $conn = getConnection();
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        sendError('ID is required');
    }
    
    $fields = [];
    $values = [];
    
    if (isset($data['name'])) {
        $fields[] = 'name = ?';
        $values[] = $data['name'];
    }
    if (isset($data['description'])) {
        $fields[] = 'description = ?';
        $values[] = $data['description'];
    }
    if (isset($data['image'])) {
        $fields[] = 'image = ?';
        $values[] = $data['image'];
    }
    if (isset($data['demo_url'])) {
        $fields[] = 'demo_url = ?';
        $values[] = $data['demo_url'];
    }
    if (isset($data['buy_url'])) {
        $fields[] = 'buy_url = ?';
        $values[] = $data['buy_url'];
    }
    if (isset($data['features'])) {
        $fields[] = 'features = ?';
        $values[] = json_encode($data['features'], JSON_UNESCAPED_UNICODE);
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
    $sql = "UPDATE software SET " . implode(', ', $fields) . " WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($values);
    
    sendResponse(['success' => true]);
}

function deleteSoftware() {
    $conn = getConnection();
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        sendError('ID is required');
    }
    
    $stmt = $conn->prepare("UPDATE software SET is_active = 0 WHERE id = ?");
    $stmt->execute([$data['id']]);
    
    sendResponse(['success' => true]);
}
?>
