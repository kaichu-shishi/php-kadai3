<?php
$wd_id = $_GET['wd_id'];

function h($str){
  return htmlspecialchars($str, ENT_QUOTES);
}



//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=php_kadai02;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnectError'.$e->getMessage());
}



//２．データ取得SQL作成
// update用のデータ
$stmt = $pdo->prepare("SELECT * FROM words_and_deeds_table WHERE wd_id = :wd_id;");
$stmt->bindValue(':wd_id', $wd_id, PDO::PARAM_INT);
$status = $stmt->execute();
$def_cards = array('男フォルダに入れ', 'うまくいじって上下関係を築け', 'タイムコンストレインメソッド', 'Cフェーズ', '恋愛遍歴の話を引き出せ');
$wd_cards = '';

// 言動一覧用のデータ
$stmt2 = $pdo->prepare("SELECT * FROM words_and_deeds_table;");
$status2 = $stmt2->execute();



//３．データ表示
// update用のデータ
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //データが取得できた場合の処理
    $result_for_update = $stmt->fetch();
    $wd_cards = explode(',', $result_for_update['wd_cards']);
    var_dump($wd_cards);
}

// 言動一覧用のデータ
$view="";
if ($status2==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt2->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  //一行取ったら「$result」に格納する、一行取ったら……の繰り返し
  while ($result = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $view .= 
    '<li class="page00__global-nav-lists-of-done-item">' . 
    '<p>番号：' . $result['wd_id'] . '</p>' . 
    '<br>' . 
    '<p><span>【言動のタイトル】</span><br>' . h($result['wd_title']) . '</p>' . 
    '<br>' . 
    '<p><span>【使用したカード】</span><br>' . h($result['wd_cards']) . '</p>' . 
    '<br>' . 
    '<p><span>【入力した言動】</span><br>' . h($result['wd_text']) . '</p>' . 
    '<br>' . 
    '<p><span>【入力した日時】</span><br>' . $result['date'] . '</p>' . 
    '<br>' . 
    '<p>
        <button class="page00__global-nav-lists-of-done-item-update-button js-link-to-update-page" dataKey="' . $result['wd_id'] . '">入力画面を再現する</button>
        <button class="page00__global-nav-lists-of-done-item-delete-button js-link-to-delete-page" dataKey="' . $result['wd_id'] . '">記憶から抹消する</button>
    </p>' . 
    '</li>';
  }
}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../sass_plus_css/styles.css">
</head>
<body>
    
    <div class="page00">
        <div class="page00__global-nav-button js-global-nav-button"><span></span><span></span><span></span></div>
        <nav class="page00__global-nav">
            <div class="page00__global-nav-inner g-nav-inner">
                <ul class="page00__global-nav-lists js-gnav-lists">
                    <li class="page00__global-nav-item js-lists-of-done">過去にした言動一覧</li>
                    <li class="page00__global-nav-item js-cards-of-having">所持しているカード一覧</li>
                    <li class="page00__global-nav-item js-save-the-data">セーブ</li>
                    <li class="page00__global-nav-item js-return-to-start">スタート画面に戻る</li>
                </ul>
                <div class="page00__global-nav-lists-of-done js-lists-of-done-div">
                    <div class="page00__global-nav-lists-of-done-ly">
                        <h2 class="page00__global-nav-lists-of-done-heading">過去にした言動一覧</h2>
                        <div class="page00__global-nav-lists-of-done-lists-wrapper">
                            <ul class="page00__global-nav-lists-of-done-lists">
                                <?= $view ?>
                            </ul>
                        </div>
                        <button class="page00__global-nav-lists-of-done-button js-lists-of-done-button">メニューに戻る</button>
                    </div>
                </div>
                <div class="page00__global-nav-cards-of-having js-cards-of-having-div">
                    <h2 class="page00__global-nav-cards-of-having-heading">所持しているカード一覧</h2>
                    <ul class="page00__global-nav-cards-of-having-lists">
                        <li class="page00__global-nav-cards-of-having-item magic-card">男フォルダに入れ</li>
                        <li class="page00__global-nav-cards-of-having-item magic-card">うまくいじって上下関係を築け</li>
                        <li class="page00__global-nav-cards-of-having-item magic-card">タイムコンストレインメソッド</li>
                        <li class="page00__global-nav-cards-of-having-item magic-card">Cフェーズ</li>
                        <li class="page00__global-nav-cards-of-having-item magic-card">恋愛遍歴の話を引き出せ</li>
                    </ul>
                    <button class="page00__global-nav-cards-of-having-button js-cards-of-having-button">メニューに戻る</button>
                </div>
            </div>
        </nav>

        <form class="js-form" method="post" action="page00_update.php">
            <div class="page00__words-and-deeds">
                <h2 class="page00__words-and-deeds-heading">どんな言動をする？</h2>
                <div class="page00__titile-area">
                    <p class="page00__title-area-heading">【言動のタイトル】</p>
                    <input class="page00__title-area-input js-words-and-deeds-title" name="wd_title" type="text" placeholder="ここに言動のタイトルを入力してください" required="required" value="<?=$result_for_update['wd_title']?>">
                </div>
                <div class="page00__card-choice">
                    <p class="page00__card-choice-heading">【使用するカード】<span class="page00__card-choice-sub">※使用するカードを修正しない場合でも、最低1回はチェックボックス操作を行ってください<br>（でないと「修正」ボタンが有効になりません）</span></p>
                    <ul class="page00__cards">
                        <?php foreach($def_cards as $def_card):?>
                            <!-- ※以下のdata-savekeyとidはlocalStorageを使う際につけた名残り。phpでは使用しない。 -->
                            <li>
                                <input class="page00__card js-words-and-deeds-cards" type="checkbox" name="wd_cards[]" value="<?= $def_card ?>" data-savekey="<?= $def_card ?>" id="<?= $def_card ?>" onchange="change()" <?= in_array($def_card, $wd_cards) ? 'checked' : '' ?>>
                                <span><?= $def_card ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>           
                <div class="page00__entry">
                    <p class="page00__entry-heading">【カードをもとに言動を入力】</p>
                    <textarea class="page00__entry-textarea js-words-and-deeds-text" name="wd_text" placeholder="ここに言動を入力してください" required="required"><?=$result_for_update['wd_text']?></textarea>
                </div>
                <input type="hidden" name="wd_id" value="<?=$result_for_update['wd_id']?>">
                <div class="page00__confirm-button-area">
                    <button class="page00__confirm-button js-button" type="submit" disabled>修正</button>
                </div>
            </div>
        </form>
        
        <div class="page00__inner">
            <canvas class="page00__canvas" id="canvas"></canvas>
        </div>
        <div class="page00__next-step-button-area">
            <button class="page00__display-choices-button js-display-choices-button">言動の入力に進む</button>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="../../js/pages/page00_detail.js"></script>
</body>
</html>