<?php
// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../visitors.php');
    exit;
}

include 'visitors.php';

// Get date range from form
$from_date = $_POST['export_from'] ?? null;
$to_date = $_POST['export_to'] ?? null;

// If no dates provided, export all
if (!$from_date && !$to_date) {
    $visitors = getAllVisitors();
} else {
    $visitors = getVisitorsByDateRange($from_date, $to_date);
}

if (empty($visitors)) {
    header('Location: ../dashboard.php?message=No records found');
    exit;
}

// Create filename
$filename = 'Visitor_Logs_' . date('Y-m-d_H-i-s') . '.csv';

// Set headers for download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Create output
$output = fopen('php://output', 'w');

// Add BOM for UTF-8 to ensure Excel reads it correctly
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Write header row
fputcsv($output, [
    'ID',
    'Visitor Name',
    'Date of Visit',
    'Time of Visit',
    'Address',
    'Contact Number',
    'School Office/Department',
    'Purpose',
    'Purpose Details',
    'Recorded By',
    'Created At'
]);

// Write data rows
foreach ($visitors as $visitor) {
    fputcsv($output, [
        $visitor['id'],
        $visitor['visitor_name'],
        date('M d, Y', strtotime($visitor['date_of_visit'])),
        date('h:i A', strtotime($visitor['time_of_visit'])),
        $visitor['address'],
        $visitor['contact_number'],
        $visitor['school_office'],
        ucfirst($visitor['purpose']),
        $visitor['purpose_details'] ?? '',
        $visitor['created_by_name'] ?? 'Unknown',
        date('M d, Y h:i A', strtotime($visitor['created_at']))
    ]);
}

fclose($output);
exit;
?>
