<?php

$user='meibo';
$password = 'Aug.2016';
$dbName = 'meibo';
$host = '192.168.1.201:3306';
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";

try{
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "データベースに接続したた";

}catch(Exception $e){
    $err = "<span class='error'>エラーがありました</span>";
    $err .= $e->getMessage();
    exit($err);
}



////////////////////


if (isset($_GET["stuID"])) {
    $stuID =$_GET["stuID"];
    $sql = "SELECT * FROM students WHERE stuID =$stuID";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);

    $name = $result[0]["name"];
    $age = $result[0]["age"];
    $gender = $result[0]["gender"];
    $enterYM = $result[0]["enterYM"];
    $sotsuYM = $result[0]["sotsuYM"];

} else {
    $name = "";
    $age = "";
    $gender = "";
    $enterYM = "";
    $sotsuYM = "";
}
///////////////////
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録フォーム</title>
</head>
<body>
<div>
    <p>登録する内容を入力してください。</p>
    <form method="post" action="meibo_check_input.php">


        生徒名：
        <input type="text" name="name" value="<?php echo $name ?>" placeholder="<名前を入れてください。"><br>
        年齢：
        <input type="number" name="age"  value="<?php echo $age ?>" placeholder="半角数字"><br>
        性別：
        <select name="gender">
            <option value="男性">男性</option>
            <option value="女性">女性</option>
        </select><br>
        入学年月：
        <input type="date" name="enterYM" value="<?php echo $enterYM ?>"><br>
        卒業年月：
        <input type="date" name="sotsuYM" value="<?php echo $sotsuYM ?>"><br>
        <input type="submit" value="登録"><br>
    </form>
</div>
</body>
</html>