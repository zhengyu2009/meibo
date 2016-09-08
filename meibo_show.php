<?php
$error = [];

$user = "meibo";
$pw = "Aug.2016";
$dbName = "meibo";
$host = "192.168.1.201:3306";
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";

$pdo = new PDO($dsn,$user, $pw);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//echo "データベース{$dbName}に接続しました。<br>";

$sql = "SELECT * FROM students";
$stm = $pdo->prepare($sql);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);

//print_r($result);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">

</head>
<body>
<table border="1">
    <tr>
        <th>ID</th>
        <th>名前</th>
        <th>年齢</th>
        <th>性別</th>
        <th>入学年月</th>
        <th>卒業年月</th>
    </tr>
    <?php
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['stuID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['age']) . "</td>";
        echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
        echo "<td>" . htmlspecialchars($row['enterYM']) . "</td>";
        echo "<td>" . htmlspecialchars($row['sotsuYM']) . "</td></tr>";
    }
    ?>
</table>
</body>
</html>