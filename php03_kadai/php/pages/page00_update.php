<?php
//1. POSTデータ取得
$wd_title     = $_POST['wd_title'];
$wd_cards     = $_POST['wd_cards'];
$wd_cards_csv = implode(',', $wd_cards);
$wd_text      = $_POST['wd_text'];
$wd_id        = $_POST['wd_id'];



//2. DB接続します（この記述が決まり文句。基本全コピペ。）
try {
  //まずは接続にチャレンジしてください
  //ID:'root', Password: xamppは 空白 ''（MySQLに入る時には実はIDとパスワードが必要）
  $pdo = new PDO('mysql:dbname=php_kadai02;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  //接続でエラーが生じたらこちらに進んでください
  exit('DBConnectError:'.$e->getMessage());
}



//３．データ登録SQL作成
// 1. SQL文を用意
$stmt = $pdo->prepare('UPDATE words_and_deeds_table SET wd_title = :wd_title, wd_cards = :wd_cards_csv, wd_text = :wd_text, date = sysdate() WHERE wd_id = :wd_id;');

//  2. バインド変数を用意
$stmt->bindValue(':wd_title', $wd_title, PDO::PARAM_STR);
$stmt->bindValue(':wd_cards_csv', $wd_cards_csv, PDO::PARAM_STR);
$stmt->bindValue(':wd_text', $wd_text, PDO::PARAM_STR);
$stmt->bindValue(':wd_id', $wd_id, PDO::PARAM_INT);

//  3. 実行
$status = $stmt->execute();




//４．データ登録処理後
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクトを取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  //５．page00.phpへリダイレクト
  header('Location: page00.php');
}
?>
