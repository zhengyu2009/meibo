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
        <input type="text" name="name" placeholder="名前を入れてください。"><br>
        年齢：
        <input type="number" name="age" placeholder="半角数字"><br>
        性別：
        <select name="gender">
            <option value="男性">男性</option>
            <option value="女性">女性</option>
        </select><br>
        入学年月：
        <input type="date" name="enterYM"><br>
        卒業年月：
        <input type="date" name="sotsuYM"><br>
        <input type="submit" value="登録"><br>

    </form>
</div>
</body>
</html>