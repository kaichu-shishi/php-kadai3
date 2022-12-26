<?php

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
$stmt = $pdo->prepare("SELECT * FROM words_and_deeds_table;");
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  //一行取ったら「$result」に格納する、一行取ったら……の繰り返し
  while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
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

<!-- <a href="page00_update.php?wd_id=' . $result['wd_id'] . '" class="page00__global-nav-lists-of-done-item-update-button js-link-to-update-page" onClick="if( !confirm("この言動を入力した画面を再現しますか？") ) { return false; }">入力画面を再現する</a>
        <a href="page00_delete.php?wd_id='. $result['wd_id'] .'" class="page00__global-nav-lists-of-done-item-delete-button js-link-to-delete-page" onClick="if( !confirm("この言動を記憶から抹消しますか？") ) { return false; }">記憶から抹消する</a> -->


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

        <form class="js-form" method="post" action="page00_insert.php">
            <div class="page00__words-and-deeds">
                <h2 class="page00__words-and-deeds-heading">どんな言動をする？</h2>
                <div class="page00__titile-area">
                    <p class="page00__title-area-heading">【言動のタイトル】</p>
                    <input class="page00__title-area-input js-words-and-deeds-title" name="wd_title" type="text" placeholder="ここに言動のタイトルを入力してください" required="required">
                </div>
                <div class="page00__card-choice">
                    <p class="page00__card-choice-heading">【使用するカード】</p>
                    <ul class="page00__cards">
                        <!-- ※以下のdata-savekeyとidはlocalStorageを使う際につけた名残り。phpでは使用しない。 -->
                        <li>
                            <input class="page00__card js-words-and-deeds-cards" type="checkbox" name="wd_cards[]" value="男フォルダに入れ" data-savekey="男フォルダに入れ" id="男フォルダに入れ" onchange="change()">
                            <span>男フォルダに入れ</span>
                        </li>
                        <li>
                            <input class="page00__card js-words-and-deeds-cards" type="checkbox" name="wd_cards[]" value="うまくいじって上下関係を築け" data-savekey="うまくいじって上下関係を築け" id="うまくいじって上下関係を築け" onchange="change()">
                            <span>うまくいじって上下関係を築け</span>
                        </li>
                        <li>
                            <input class="page00__card js-words-and-deeds-cards" type="checkbox" name="wd_cards[]" value="タイムコンストレインメソッド" data-savekey="タイムコンストレインメソッド" id="タイムコンストレインメソッド" onchange="change()">
                            <span>タイムコンストレインメソッド</span>
                        </li>
                        <li>
                            <input class="page00__card js-words-and-deeds-cards" type="checkbox" name="wd_cards[]" value="Cフェーズ" data-savekey="Cフェーズ" id="Cフェーズ" onchange="change()">
                            <span>Cフェーズ</span>
                        </li>
                        <li>
                            <input class="page00__card js-words-and-deeds-cards" type="checkbox" name="wd_cards[]" value="恋愛遍歴の話を引き出せ" data-savekey="恋愛遍歴の話を引き出せ" id="恋愛遍歴の話を引き出せ" onchange="change()">
                            <span>恋愛遍歴の話を引き出せ</span>
                        </li>
                    </ul>
                </div>           
                <div class="page00__entry">
                    <p class="page00__entry-heading">【カードをもとに言動を入力】</p>
                    <textarea class="page00__entry-textarea js-words-and-deeds-text" name="wd_text" placeholder="ここに言動を入力してください" required="required"></textarea>
                </div>
                <div class="page00__confirm-button-area">
                    <!-- <div class="page00__confirm-button button-border-gradient-wrap button-border-gradient-wrap--gold js-validation">
                        <div class="page00__confirm-button-as-link button button-border-gradient js-words-and-deeds-confirm-button">
                            <input class="button-text-gradient--gold js-button" type="submit" value="確定">
                        </div>
                    </div> -->
                    <button class="page00__confirm-button js-button" type="submit" disabled>確定</button>
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
    <script src="../../js/pages/page00.js"></script>
</body>
</html>