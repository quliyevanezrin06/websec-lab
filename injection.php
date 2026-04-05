<?php
header("Content-Type: application/json; charset=utf-8");

// Baza bağlantısı (Bazanın adının magaza_db olduğundan əmin ol)
$conn = new mysqli("localhost", "root", "", "magaza_db");

// Brauzerdən (JS-dən) gələn paketi oxuyuruq
$data = json_decode(file_get_contents("php://input"), true);
$ad = $data['kart_ad'] ?? '';

// KRİTİK ZƏİFLİK: $ad dəyişəni birbaşa SQL sorğusuna daxil edilir
// Bu dırnaqlar (') sən injection edəndə qırılacaq
$sql = "SELECT * FROM odenis_melumatlari WHERE kart_sahibi = '$ad'";

$result = $conn->query($sql);

if ($result) {
    // Sorğu uğurlu icra olundusa (hətta nəticə boş olsa belə), success: true qaytarır
    echo json_encode(["success" => true]);
} else {
    // Əgər SQL sintaksisində xəta olsa, xətanı göstəririk
    echo json_encode(["success" => false, "mesaj" => "SQL Xətası: " . $conn->error]);
}

$conn->close();
?>
