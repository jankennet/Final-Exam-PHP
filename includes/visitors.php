<?php
/* API for Visitor Logs */

include 'connect.php';

/**
 * Get all visitor records
 */
function getAllVisitors() {
    $query = "SELECT v.*, u.full_name as created_by_name 
              FROM visitors v 
              LEFT JOIN users u ON v.created_by = u.user_id 
              ORDER BY v.date_of_visit DESC, v.time_of_visit DESC";
    $cn = ConnectDB();
    $result = $cn->query($query);
    
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    return $data;
}

/**
 * Get visitor by ID
 */
function getVisitorById($id) {
    $query = "SELECT v.*, u.full_name as created_by_name 
              FROM visitors v 
              LEFT JOIN users u ON v.created_by = u.user_id 
              WHERE v.id = ?";
    $cn = ConnectDB();
    $stmt = $cn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}

/**
 * Add new visitor record
 */
function addVisitor($visitor_name, $date_of_visit, $time_of_visit, $address, $contact_number, $school_office, $purpose, $purpose_details, $created_by) {
    $query = "INSERT INTO visitors (visitor_name, date_of_visit, time_of_visit, address, contact_number, school_office, purpose, purpose_details, created_by) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $cn = ConnectDB();
    $stmt = $cn->prepare($query);
    
    if (!$stmt) {
        return ['success' => false, 'error' => $cn->error];
    }
    
    $stmt->bind_param(
        "ssssssssi",
        $visitor_name,
        $date_of_visit,
        $time_of_visit,
        $address,
        $contact_number,
        $school_office,
        $purpose,
        $purpose_details,
        $created_by
    );
    
    if ($stmt->execute()) {
        return ['success' => true, 'id' => $cn->insert_id];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

/**
 * Update visitor record
 */
function updateVisitor($id, $visitor_name, $date_of_visit, $time_of_visit, $address, $contact_number, $school_office, $purpose, $purpose_details) {
    $query = "UPDATE visitors 
              SET visitor_name = ?, date_of_visit = ?, time_of_visit = ?, address = ?, contact_number = ?, school_office = ?, purpose = ?, purpose_details = ?
              WHERE id = ?";
    
    $cn = ConnectDB();
    $stmt = $cn->prepare($query);
    
    if (!$stmt) {
        return ['success' => false, 'error' => $cn->error];
    }
    
    $stmt->bind_param(
        "ssssssssi",
        $visitor_name,
        $date_of_visit,
        $time_of_visit,
        $address,
        $contact_number,
        $school_office,
        $purpose,
        $purpose_details,
        $id
    );
    
    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

/**
 * Delete visitor record
 */
function deleteVisitor($id) {
    $query = "DELETE FROM visitors WHERE id = ?";
    $cn = ConnectDB();
    $stmt = $cn->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

/**
 * Get visitor count
 */
function getVisitorCount() {
    $query = "SELECT COUNT(*) as count FROM visitors";
    $cn = ConnectDB();
    $result = $cn->query($query);
    $row = $result->fetch_assoc();
    return $row['count'];
}

/**
 * Get today's visitors
 */
function getTodayVisitors() {
    $query = "SELECT COUNT(*) as count FROM visitors WHERE DATE(date_of_visit) = CURDATE()";
    $cn = ConnectDB();
    $result = $cn->query($query);
    $row = $result->fetch_assoc();
    return $row['count'];
}

/**
 * Get visitors by purpose
 */
function getVisitorsByPurpose($purpose) {
    $query = "SELECT v.*, u.full_name as created_by_name 
              FROM visitors v 
              LEFT JOIN users u ON v.created_by = u.user_id 
              WHERE v.purpose = ? 
              ORDER BY v.date_of_visit DESC";
    
    $cn = ConnectDB();
    $stmt = $cn->prepare($query);
    $stmt->bind_param("s", $purpose);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    return $data;
}


// Get purpose stats
function getPurposeStats() {
    $query = "SELECT purpose, COUNT(*) as count FROM visitors GROUP BY purpose";
    $cn = ConnectDB();
    $result = $cn->query($query);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    return $data;
}


// Get visitors by date range
function getVisitorsByDateRange($from_date = null, $to_date = null) {
    $query = "SELECT v.*, u.full_name as created_by_name 
              FROM visitors v 
              LEFT JOIN users u ON v.created_by = u.user_id";
    
    $params = [];
    $types = "";
    
    if ($from_date && $to_date) {
        $query .= " WHERE DATE(v.date_of_visit) BETWEEN ? AND ?";
        $params = [$from_date, $to_date];
        $types = "ss";
    } elseif ($from_date) {
        $query .= " WHERE DATE(v.date_of_visit) >= ?";
        $params = [$from_date];
        $types = "s";
    } elseif ($to_date) {
        $query .= " WHERE DATE(v.date_of_visit) <= ?";
        $params = [$to_date];
        $types = "s";
    }
    
    $query .= " ORDER BY v.date_of_visit DESC, v.time_of_visit DESC";
    
    $cn = ConnectDB();
    $stmt = $cn->prepare($query);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    return $data;
}

?>
