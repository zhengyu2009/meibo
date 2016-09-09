<?php
require_once "sqlConn.php";
$error = [];

//$user = "meibo";
//$pw = "Aug.2016";
//$dbName = "meibo";
//$host = "192.168.1.201:3306";
//$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
//
//$pdo = new PDO($dsn,$user, $pw);
//$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
    <style>

    </style>
</head>
<body>
<div id="wrapper">
<h1>学生一覧</h1>
<table border="1">
    <form
    <tr>
        <th>ID</th>
        <th>名前</th>
        <th>年齢</th>
        <th>性別</th>
        <th>入学年月</th>
        <th>卒業年月</th>
        <th>操作</th>
    </tr>
    <?php
    if (empty($result)) {
        echo "登録されている学生はいません。<br>";
        echo "<a href='Meibo_input.php'>新規登録</a>";
    } else {
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['stuID']) . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['age']) . "</td>";
            echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
            echo "<td>" . htmlspecialchars($row['enterYM']) . "</td>";
            echo "<td>" . htmlspecialchars($row['sotsuYM']) . "</td>";
            echo "<td><a href='Meibo_input.php?stuID=" . htmlspecialchars($row['stuID']) . "'>編集|</a>";
//            echo "<a href='meibo_delete.php?stuID=" . htmlspecialchars($row['stuID']) . "&name=" . rawurlencode(htmlspecialchars($row['name'])) . "' onclick='delConfirm()'>削除</a></td>";
//            echo "<a href='meibo_delete.php?stuID=" . htmlspecialchars($row['stuID']) . "&name=" . rawurlencode(htmlspecialchars($row['name'])) . "'>削除</a></td>";
            echo "<a herf='' onclick='delConfirm()'>削除</a></td>";
            echo "</tr>";
        }
    }
    ?>
</table>
</div>
<script>
    function delConfirm() {
        isDel = confirm("本当に削除しますか？");
        if (!isDel) {
            console.log("<?php echo 'キャンセル';?>");
            return false;
        } else {
//            location.href("meibo_delete.php?stuID=<php? echo htmlspecialchars($row['stuID']);?>");
            console.log("<?php echo '削除する';?>");
            stuID = "<?php echo htmlspecialchars($row['stuID']);?>";
            location.href="meibo_delete.php?stuID=" + stuID;
        }
    }
</script>
</body>
</html>