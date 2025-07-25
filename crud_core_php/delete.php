<?php
	session_start();
	require_once 'db_connection.php';
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['id'])) {
        $uid = $data['id'];
        
        // Prepare and execute the delete statement
        $sql = "DELETE FROM users WHERE id='$uid'";
        if ($conn->query($sql) === TRUE) { 
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No ID provided.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>