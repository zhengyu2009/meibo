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

$sql = "SELECT * FROM course";
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
<div>
    <!--入力フォーム-->
    <form method="POST" action="meibo_course.php">
        <ul>
            <li>
                <label>コース名:
                    <input type="text" name="subject" placeholder="subject">
                </label>
            </li>
            <li>
            <label>先生:
                <input type="text" name="teacher" placeholder="teacher">
            </li>

                <input type="submit" value="追加">
        </ul>
    </form>
</div>

<table border="1">
    <tr>
        <th>ID</th>
        <th>コース名</th>
        <th>先生</th>
    </tr>
    <?php
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['subID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
        echo "<td>" . htmlspecialchars($row['teacher']) . "</td></tr>";
    }
    //簡単なエラー処理
    $errors=[];
    if(!isset($_POST["subject"])||($_POST["subject"]==="")){
        $errors[]="コース名を入力してください。";
    } elseif (!isset($_POST["teacher"]) || ($_POST["teacher"] === "")){
            $errors[] = "名前を入力してください。";
    } else {
        echo "koko";
        $subject = $_POST["subject"];
        $teacher = $_POST["teacher"];
        echo $subject, $teacher;
        $sql = "INSERT INTO course (subject, teacher) VALUES ($subject, $teacher)";
        $stm = $pdo->prepare($sql);
        echo $stm->execute();
    }
    print_r($errors);
    ?>
</table>
</div>
</body>
</html>