<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>検索結果</title>
    <style>
        #wrapper {
            width: 60%;
            margin:  20px auto 0;
            padding:  15px 20px;
            background-color: ghostwhite;
        }
        table {
            background-color: white;
            text-align: center;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="form">
    <?php
    $gobackURL = "meibo_search_form.php";
    //エラー処理

    $user='testuser';
    $password = 'pw4testuser';
    $dbName = 'meibo';
    $host = '192.168.1.201:3306';
    $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";

    try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(Exception $e){
        $err = "<span class='error'>エラーがありました</span>";
        $err .= $e->getMessage();
        exit($err);
    }

    try {
        //POST取得
        $name = $_POST["name"];
        $age1 = $_POST["age1"];
        $age2 = $_POST["age2"];
        $gender = $_POST["gender"];
        $enterYM1 = $_POST["enterYM1"];
        $enterYM2 = $_POST["enterYM2"];
        $sotsuYM1 = $_POST["sotsuYM1"];
        $sotsuYM2 = $_POST["sotsuYM2"];
        $subject = $_POST["subject"];
        $middle1 = $_POST["middle1"];
        $middle2 = $_POST["middle2"];
        $final1 = $_POST["final1"];
        $final2 = $_POST["final2"];
        //全選択のSQL
        $sqlFirst = "SELECT students.name, students.age, students.gender, students.enterYM, students.sotsuYM, subject.subject, subject.teacher, score.middle, score.final
        FROM students, subject, score
        WHERE score.stuID = students.stuID AND score.subID = subject.subID AND students.isDeleted = 0";
        //検索条件。if(isset)チェックでsql文をどんどん足していく。
        if (!(($_POST["name"]==""))) {
            $sql1 = " AND students.name LIKE(:name)";
        }
        //age12
        if ((!(($_POST["age1"])==""))&&(($_POST["age2"])=="")) {
            $sql2 = " AND students.age = (:age1)";
        }
        if ((!(($_POST["age1"])==""))&&(!(($_POST["age2"])==""))) {
            $sql2 = " AND students.age BETWEEN (:age1) AND (:age2)";
        }

        if (!(($_POST["gender"])=="")) {
            $sql3 = " AND students.gender LIKE(:gender)";
        }
        //enterYM12
        if ((!(($_POST["enterYM1"])=="")) && (($_POST["enterYM2"])=="")) {
            $sql4 = " AND students.enterYM = (:enterYM1)";
        }
        if ((!(($_POST["enterYM1"])=="")) && (!(($_POST["enterYM2"])==""))) {
            $sql4 = " AND students.enterYM BETWEEN (:enterYM1) AND (:enterYM2)";
        }
        //sotsuYM12
        if ((!(($_POST["sotsuYM1"])=="")) && (($_POST["sotsuYM2"])=="")) {
            $sql5 = " AND students.sotsuYM = (:sotsuYM1)";
        }
        if ((!(($_POST["sotsuYM1"])=="")) && (!(($_POST["sotsuYM2"])==""))) {
            $sql5 = " AND students.sotsuYM BETWEEN (:sotsuYM1) AND (:sotsuYM2)";
        }

        if (!(($_POST["subject"])=="")) {
            $sql6 = " AND subject.subject LIKE(:subject)";
        }
        //middle
        if ((!(($_POST["middle1"])=="")) && (($_POST["middle2"])=="")){
            $sql7 = " AND score.middle = (:middle1)";
        }
        if ((!(($_POST["middle1"])=="")) && (!(($_POST["middle2"])==""))){
            $sql7 = " AND score.middle BETWEEN (:middle1) AND (:middle2)";
        }
        //final
        if ((!(($_POST["final1"])=="")) && (($_POST["final2"])=="")){
            $sql8 = " AND score.final = (:final1)";
        }
        if ((!(($_POST["final1"])=="")) && (!(($_POST["final2"])==""))){
            $sql8 = " AND score.final BETWEEN (:final1) AND (:final2)";
        }
        //生徒ID順で並び替え
        $sqlEnd = " ORDER BY students.stuID";

        $sqlMiddle = "";
        for ($i=1; $i<=8; $i++){
            if (isset(${"sql".$i})){
                $sqlMiddle .= ${"sql".$i};
            }
        }
        //最終sql
        $sql = $sqlFirst . $sqlMiddle . $sqlEnd;
        //本番では、最終sql代入。
        $stm = $pdo->prepare($sql);
        //検索条件のバインド。if(isset)チェックでどんどんバインドしていく。
        if(!(($_POST["name"])=="")){
            $stm->bindValue(':name', "%{$name}%", PDO::PARAM_STR);
        }
        //age
        if (!(($_POST["age1"])=="")) {
            $stm->bindValue(':age1', $age1, PDO::PARAM_INT);
        }
        if (!(($_POST["age2"])=="")) {
            $stm->bindValue(':age2', $age2, PDO::PARAM_INT);
        }

        if (!(($_POST["gender"])=="")) {
            $stm->bindValue(':gender', $gender, PDO::PARAM_STR);
        }
        //enterYM
        if (!(($_POST["enterYM1"])=="")) {
            $stm->bindValue(':enterYM1', $enterYM1, PDO::PARAM_INT);
        }
        if (!(($_POST["enterYM2"])=="")) {
            $stm->bindValue(':enterYM2', $enterYM2, PDO::PARAM_INT);
        }
        //sotsuYM
        if (!(($_POST["sotsuYM1"])=="")) {
            $stm->bindValue(':sotsuYM1', $sotsuYM1, PDO::PARAM_INT);
        }
        if (!(($_POST["sotsuYM2"])=="")) {
            $stm->bindValue(':sotsuYM2', $sotsuYM2, PDO::PARAM_INT);
        }

        if (!(($_POST["subject"])=="")) {
            $stm->bindValue(':subject', $subject, PDO::PARAM_STR);
        }
        //middle
        if (!(($_POST["middle1"])=="")) {
            $stm->bindValue(':middle1', $middle1, PDO::PARAM_INT);
        }
        if (!(($_POST["middle2"])=="")) {
            $stm->bindValue(':middle2', $middle2, PDO::PARAM_INT);
        }
        //final
        if (!(($_POST["final1"])=="")) {
            $stm->bindValue(':final1', $final1, PDO::PARAM_INT);
        }
        if (!(($_POST["final2"])=="")) {
            $stm->bindValue(':final2', $final2, PDO::PARAM_INT);
        }

        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3 style='text-align: center'>検索結果</h3>";
        echo '<table border="1"><thead><tr>';
        echo '<th>名前</th>';
        echo '<th>年齢</th>';
        echo '<th>性別</th>';
        echo '<th>入学年月</th>';
        echo '<th>卒業年月</th>';
        echo '<th>科目</th>';
        echo '<th>先生</th>';
        echo '<th>中間テスト</th>';
        echo '<th>期末テスト</th>';
        echo '</tr></thead><tbody>';

        foreach($result as $row){
            echo '<tr>';
            echo "<td>", $row['name'], "</td>";
            echo "<td>", $row['age'], "</td>";
            echo "<td>", $row['gender'], "</td>";
            echo "<td>", $row['enterYM'], "</td>";
            echo "<td>", $row['sotsuYM'], "</td>";
            echo "<td>", $row['subject'], "</td>";
            echo "<td>", $row['teacher'], "</td>";
            echo "<td>", $row['middle'], "</td>";
            echo "<td>", $row['final'], "</td>";
            echo '</tr>';
        }
        echo '</tbody></table><br>';

    }catch(Exception $e){
        echo '<span class="error">エラーがありました</span>';
        echo $e->getMessage();
        exit();
    }
    ?>
        </div>
    <hr>
    <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
</div>
</body>
</html>


<!--
検証済みデータベース構造
        DB名：meibo
        テーブル名：students(6)：stuID, 名前name, 年齢age,性別gender,入学年月enterYM,卒業年月sotsuYM, isDeleted
        テーブル名：subject(3)：subID,  科目名subject, 先生teacher
        テーブル名：score(4)： scoreID, stuID, subID, 中間テストmiddle,期末テストfinal

memo
        $stm->bindValue(' :gender', '男', PDO::PARAM_STR);
-->