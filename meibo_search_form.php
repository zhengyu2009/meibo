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

    //取り出す検索フォーム用の値をDBから取得する。
    //科目テーブルの科目名　cource.subject
    //科目テーブルの教師名 cource.teacher
    $sql = "SELECT subID, subject, teacher FROM subject";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $subject = $stm->fetchAll(PDO::FETCH_ASSOC);

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
    <title>検索フォーム</title>
    <style>
        #wrapper {
            width: 60%;
            margin:  20px auto 0;
            padding:  15px 20px;
            background-color: ghostwhite;
        }
        #form{
            width: 50%;
            margin: 0 auto;
        }
        input{
            margin-top: 4px;
            padding: 2px 0;
        }
        select{
            margin-top: 4px;
            padding: 2px 0;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="form">
        <h3 style="text-align: center">名簿検索</h3>
        <p>検索する内容を入力してください。</p>
    <form method="post" action="meibo_search_confirm.php">
        生徒名：
        <input type="text" name="name" placeholder="名前を入れてください。"><br>
        年齢：
        <input type="text" name="age1" size="3" placeholder="0">～<input type="text" name="age2" size="3" placeholder="100"><br>
        性別：
        <select name="gender">
            <option value="">未選択</option>
            <option value="男">男</option>
            <option value="女">女</option>
        </select><br>
        入学年月：
        <input type="text" name="enterYM1" size="6" placeholder="196401">～<input type="text" name="enterYM2" size="6" placeholder="201612"><br>
        卒業年月：
        <input type="text" name="sotsuYM1" size="6" placeholder="196401">～<input type="text" name="sotsuYM2" size="6" placeholder="201612"><br>
        科目名：
        <select name="subject">
            <option value="">未選択</option>
            <?php
            foreach ($subject as $row){
                echo "<option value='", $row['subject'],"'>", $row['subject'],"</option>";
            }
            ?>
        </select><br>
        中間テスト点数：
        <input type="text" name="middle1" size="3" placeholder="0">～<input type="text" name="middle2" size="3" placeholder="100"><br>
        期末テスト点数：
        <input type="text" name="final1" size="3" placeholder="0">～<input type="text" name="final2" size="3" placeholder="100"><br>

        <p style="text-align: right"><input type="submit" value="検索する"></p>
    </form>
    </div>
</div>
</body>
</html>

<!--
検証済みデータベース構造
        DB名：meibo
        テーブル名：students(6)：stuID, 名前name, 年齢age,性別gender,入学年月enterYM,卒業年月sotsuYM, isDeleted
        テーブル名：subject(3)：subID,  科目名subject, 先生teacher
        テーブル名：score(4)： scoreID, stuID, subID, 中間テストmiddle,期末テストfinal
-->