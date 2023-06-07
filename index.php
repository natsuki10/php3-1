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

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $content = $_POST["content"];

    try {
        $stmt = $pdo->prepare("INSERT INTO posts (name, content) VALUES (?, ?)");
        $stmt->execute([$name, $content]);
    } catch (PDOException $e) {
        die("新規登録に失敗しました: " . $e->getMessage());
    }
    header("Location: complete.php");
    exit();
}

try {
    $stmt = $pdo->query("SELECT * FROM posts ORDER BY id DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("データの取得に失敗しました: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>掲示板</title>
</head>
<body>
    <h1>掲示板</h1>
    <h2>新規投稿</h2>
    <form method="POST" action="index.php">
        <label for="name">name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="content">投稿内容:</label><br>
        <textarea id="content" name="content" required></textarea><br>
        <input class="submit" type="submit" value="投稿する">
    </form>
    
    <h2>投稿一覧</h2>
    <div class="post-list">
    <?php foreach (array_reverse($posts) as $index => $post): ?>
        <div class="post-item">
            <div>
                <span>No:</span>
                <span><?php echo $index + 1; ?></span>
            </div>
            <div>
                <span>名前:</span>
                <span><?php echo $post['name']; ?></span>
            </div>
            <div>
                <span>投稿内容:</span>
                <span><?php echo $post['content']; ?></span>
            </div>
            <form method="POST" action="delete.php">
                <input type="hidden" name="delete" value="<?php echo $post['id'] ?>">
                <input class="submit" type="submit" value="削除">
            </form>
        </div>
    <?php endforeach; ?>
    </div>
</body>
</html>
