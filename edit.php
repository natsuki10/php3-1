<?php
$dbh = 'mysql:host=localhost;dbname=online_board_app;charset=utf8';
$user = 'board_user';
$pass = 'B6abwnoH';
try {
    $pdo = new PDO($dbh, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch(PDOException $e) {
    echo '接続失敗'. $e->getMessage();
    exit();
}

$editId = $_GET['id'];
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $editId = $_GET["id"];

    try {
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$editId]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("データの取得に失敗しました: " . $e->getMessage());
    }
} 

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $content = $_POST["content"];
    $id = $_POST["id"];

    try{
        $stmt = $pdo->prepare("UPDATE posts SET name = ?, content = ? WHERE id = ?");
        $stmt -> execute([$name,$content,$id]);
        header("Location: edit_comlete.php");
        exit();
    } catch(PDOException $e) {
        die("編集に失敗しました:".$e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>編集画面</title>
</head>
<body>
   <h2>編集ページ</h2>
   <form method="POST" action="edit.php">
        <input type="hidden" name="id" value="<?php echo $post["id"]; ?>">
        <label for="name">name:</label>
        <input type="text" id="name" name="name" value="<?php echo $post["name"]; ?>" required><br>
        <label for="content">投稿内容:</label><br>
        <textarea id="content" name="content" required><?php echo $post["content"]; ?></textarea><br>
        <input class="submit" type="submit" value="更新">
        <a href="index.php" class="submit">戻る</a>
    </form> 
</body>