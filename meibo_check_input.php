<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>確認</title>
</head>
<body>
<div>

    <?php

    $user='meibo';
    $password = 'Aug.2016';
    $dbName = 'meibo';
    $host = '192.168.1.201:3306';
    $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";

    $name=$_POST['name'];
    $age=$_POST['age'];
    $gender=$_POST['gender'];
    $enterYM=$_POST['enterYM'];
    $sotsuYM=$_POST['sotsuYM'];

    htmlspecialchars($name);


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


    //エラーを入れる配列
    $errors =[];

    if (!isset($name) || ($name==="")){
        $errors[]="氏名を入力してください。";
    }
    if (!isset($age) || ($age==="")) {
        $errors[] = "年齢を入力してください。";
    }    elseif(!ctype_digit(strval($age))){
        $errors[]="年齢に整数を入力してください。";
    }
    if (!isset($enterYM) || ($enterYM==="")){
        $errors[]="入学年月を入力してください。";
    }
    if (!isset($sotsuYM) || ($sotsuYM==="")){
        $errors[]="卒業年月を入力してください。";
    }

    //エラーがあった時確認画面
    if (count($errors)>0) {
        echo '<ol>';
        foreach ($errors as $value) {
            echo "<li>", $value, "</li>";
        }
        echo "</ol>";
        echo "<hr>";
        echo "<a href='meibo_input.php'>戻る</a>";
        // exit();
    }
//正常時登録
    else{


        //sql文を作る（新規レコード追加）
        $sql ="INSERT students (name, age, gender, enterYM, sotsuYM) VALUES
    ('$name','$age','$gender','$enterYM','$sotsuYM')";
        //プリペアドステートメントを作る
        $stm=$pdo->prepare($sql);
        //SQL文を実行する
        $stm->execute();


        echo "<ul style='list-style:none;'>";
        echo "<li>氏名：". htmlspecialchars($name) ."</li><br>";
        echo "<li>年齢：". htmlspecialchars($age) ."</li><br>";
        echo "<li>性別：". htmlspecialchars($gender) ."</li><br>";
        echo "<li>入学年月：". htmlspecialchars($enterYM) ."</li><br>";
        echo "<li>卒業年月：". htmlspecialchars($sotsuYM) ."</li><br>";
        echo "</ul>";
        echo "<hr>";
        echo "この内容で登録しました。<br>";
    }

    ?>


</div>
</body>
</html>