<?php

//1. POSTデータ取得
$wd_id = $_GET['wd_id'];


//2. DB接続します
//*** function化する！  *****************
try {
    //まずは接続にチャレンジしてください
    //ID:'root', Password: xamppは 空白 ''（MySQLに入る時には実はIDとパスワードが必要）
    $pdo = new PDO('mysql:dbname=php_kadai02;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
    //接続でエラーが生じたらこちらに進んでください
    exit('DBConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare('DELETE FROM words_and_deeds_table WHERE wd_id = :wd_id;');
$stmt->bindValue(':wd_id', $wd_id, PDO::PARAM_INT); //PARAM_INTなので注意
$status = $stmt->execute(); //実行


//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location: page00.php');
    exit();
}
