<?php
$dbh = new PDO('mysql:host=localhost;dbname=online_board_app;charset=utf8', 'board_user', 'B6abwnoH');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $deleteId = $_POST["delete"];

    try {
        $stmt = $dbh->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$deleteId]);
        header("Location: delete_complete.php");
        exit();
    } catch (PDOException $e) {
        die("削除に失敗しました: " . $e->getMessage());
    }
}
?>
