<?php

ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../config/dbcon.php');

// Function to fetch all records from a specified table
function getAll($table) {
    global $con;
    $query = "SELECT * FROM $table";
    return mysqli_query($con, $query);
}

// Function to fetch a record by ID from a specified table
function getByID($table, $id) {
    global $con;
    $query = "SELECT * FROM $table WHERE id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

// Function to redirect to a specified URL with a session message
function redirect($url, $message) {
    $_SESSION['message'] = $message;
    header('Location: ' . $url);
    exit(0);
}

// Function to add a new user
function addUser($name, $email, $phone, $password, $role) {
    global $con;
    $query = "INSERT INTO users (name, email, phone, password, role_as) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sssss', $name, $email, $phone, $password, $role);
    return mysqli_stmt_execute($stmt);
}

// Function to update an existing user without password change
function updateUser($id, $name, $email, $phone, $role) {
    global $con;
    $query = "UPDATE users SET name=?, email=?, phone=?, role_as=? WHERE id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'ssssi', $name, $email, $phone, $role, $id);
    return mysqli_stmt_execute($stmt);
}

// Function to update a user with password change
function updateUserWithPassword($id, $name, $email, $phone, $password, $role) {
    global $con;
    $query = "UPDATE users SET name=?, email=?, phone=?, password=?, role_as=? WHERE id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sssssi', $name, $email, $phone, $password, $role, $id);
    return mysqli_stmt_execute($stmt);
}

// Function to delete a user
function deleteUser($id) {
    global $con;
    $query = "DELETE FROM users WHERE id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    return mysqli_stmt_execute($stmt);
}

// Function to retrieve all users
function getAllUsers() {
    global $con;
    $query = "SELECT * FROM users";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Function to generate a PDF
function generatePDF($data, $reportType) {
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Inventory System');
    $pdf->SetTitle(ucfirst($reportType) . ' Report');
    $pdf->AddPage();

    $html = "<h1>" . ucfirst($reportType) . " Report</h1>";
    $html .= "<table border='1' cellspacing='0' cellpadding='5'>";
    $html .= "<tr>";

    // Add table headers dynamically based on data keys
    foreach (array_keys($data[0]) as $header) {
        $html .= "<th>" . ucfirst($header) . "</th>";
    }
    $html .= "</tr>";

    // Add table rows
    foreach ($data as $row) {
        $html .= "<tr>";
        foreach ($row as $value) {
            $html .= "<td>" . htmlspecialchars($value) . "</td>";
        }
        $html .= "</tr>";
    }
    $html .= "</table>";

    $pdf->writeHTML($html);
    $pdf->Output(ucfirst($reportType) . '_Report.pdf', 'D'); // Force download
}

// Function to generate Excel
function generateExcel($data, $reportType) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle(ucfirst($reportType) . ' Report');

    // Add headers
    $headers = array_keys($data[0]);
    foreach ($headers as $colIndex => $header) {
        $sheet->setCellValueByColumnAndRow($colIndex + 1, 1, ucfirst($header));
    }

    // Add data rows
    foreach ($data as $rowIndex => $row) {
        foreach ($row as $colIndex => $value) {
            $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 2, $value);
        }
    }

    // Export as Excel file
    $writer = new Xlsx($spreadsheet);
    $filename = ucfirst($reportType) . '_Report.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit();
}

?>
