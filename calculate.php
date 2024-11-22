<?php
include_once 'connection.php'; // Include your database connection

$sql = "SELECT username, score FROM quiz_scores ORDER BY score DESC";
$result = $conn->query($sql);

$rankings = [];
if ($result->num_rows > 0) {
    $rank = 1;
    while ($row = $result->fetch_assoc()) {
        $rankings[] = [
            'rank' => $rank,
            'username' => htmlspecialchars($row['username']),
            'score' => $row['score']
        ];
        $rank++;
    }
}

$conn->close();
?>