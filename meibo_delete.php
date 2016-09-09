<?php
require_once "sqlConn.php";
$error = [];
$stuID = htmlspecialchars($_GET["stuID"]);
//$name = rawurldecode(htmlspecialchars($_GET["name"]));
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">

</head>
<body>
<div id="wrapper">

    <?php
    if (!empty($stuID)) {
        try {
            $pdo->beginTransaction();
            $sql1 = "DELETE FROM students WHERE stuID={$stuID}";
            $sql2 = "DELETE FROM score WHERE stuID={$stuID}";

            $del1 = $pdo->prepare($sql1);
            $del2 = $pdo->prepare($sql2);
            $del2->execute();
            $del1->execute();

            $pdo->commit();
            echo "削除成功しました。<br>";
            echo "<a href='meibo_show.php'>一覧に戻ります</a>";
//    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo $e->getMessage();
        }
    }
    ?>
</div>
</body>
</html>


