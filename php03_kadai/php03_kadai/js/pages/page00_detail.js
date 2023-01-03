'use strict';




//Gameクラス
class Game {
	constructor( width, height ) {
		this.objs = [];

		this.frame = 0;

		//もしもwidthやheightに何も代入されていなければ、320を代入する
		this.width = width || 320;
		this.height = height || 320;

		this.canvas = document.getElementById( 'canvas' );
		//canvasの横幅とたて幅
		canvas.width = this.width;
		canvas.height = this.height;

		this.ctx = canvas.getContext( '2d' );
	}

	area(){
		this.ctx.clearRect(0, 0, canvas.width, canvas.height)
		this.ctx.fillStyle = "rgba(" + [0, 0, 0, 1] + ")";
		this.ctx.globalAlpha = 0.6;
		this.ctx.fillRect(0, 0, canvas.width, canvas.height);
	}

	//start()を呼び出すことで、メインループが開始される。
	start() {
		this._main();
	}

	//メインループ
	_main() {
		//背景を黒く塗りつぶす
        // this.ctx.fillStyle = "#000";
		// this.ctx.globalAlpha = 0.5;//文字のみかかった
		// this.ctx.globalAlpha = 0.5;//文字のみかかった
		// this.ctx.fillStyle = 'pink';
		// this.ctx.globalAlpha = 0.2;
		// this.ctx.fillStyle = "white"F
		// this.ctx.fillStyle = "rgb(255, 0, 0)";
		// this.ctx.globalAlpha = 0.3;

		// this.ctx.fillStyle = 'rgb(160, 160, 255)';
		// this.ctx.globalAlpha = 0.2;
		// this.ctx.fillRect(0, 0, 150,150);

		// this.ctx.fillStyle = 'rgb(155, 155, 0)';
		// this.ctx.globalAlpha = 0.1;
		// this.ctx.fillRect(0, 0, canvas.width,canvas.height);


		// this.ctx.fillRect(0, 0,this.width,this.height);
	

        //半透明(透明度50%)の青い四角を表示
        // this.ctx.beginPath();
        // this.ctx.fillStyle = "rgba(" + [0, 0, 255, 0.5] + ")";
        // this.ctx.fillRect(0, 0, this.width, this.height);

        //無透明(透明度0%)の青い四角を表示  
        // this.ctx.beginPath();
        // this.ctx.fillStyle = "rgba(" + [0, 0, 255, 1] + ")";
        // this.ctx.fillRect(this.width, this.height, this.width, this.height);

		//ゲームに登場するものの数だけ繰り返す
		for (let i=0; i<this.objs.length; i++) {
			//ゲームに登場するもののクラスから、render()を呼び出す
			this.objs[i].render( this.ctx, this.frame );
			// console.log(this.objs[i], "vvv")
		}

		//フレーム
		this.frame++;

		//_main()を呼び出す（ループさせる）
		requestAnimationFrame(this._main.bind(this));
	}

	//ゲームにテキストなどを表示するための関数
	add( obj, x, y ) {
		obj.x = x || 0;
		obj.y = y || 0;
		this.objs.push( obj );
	}
}

//Labelクラス
class Label {
	//Labelの初期設定
	constructor( label ) {
		this._text = [];
		//表示している文字列の長さ
		this._displayLength = 0;
		//表示している場所の行数（追加）
		this._visibleLine = 0;
		this._line = 0;
		this.label = label;
		this.font = "28px 'ヒラギノ角ゴ Pro', 'Hiragino Kaku Gothic Pro', 'ＭＳ ゴシック', 'MS Gothic', sans-serif";
		this.color = '#fff';
		this.maxLength = 30;
		this.baseline = 'top';
		this.interval = 0;
	}

	//次の行への切り替え機能
	next() {
		this._visibleLine++;
		this._text = [];
		this._displayLength = 0;
	}

	//Labelを表示するための関数（メインループから呼び出される）
	render( ctx, frame ) {

		// moji
		// ctx.beginPath();
		ctx.fillStyle = this.color;
		ctx.font = this.font;
		ctx.textBaseline = this.baseline;
		// ctx.closePath();

		//文字を表示する間隔（はやさ）が0の場合は、文字を一気に表示
		if ( this.interval === 0 ) {
			//表示する文字数を、１行に表示する最大の文字数で割り、切り上げることで、その文字列が何行になるのかが分かる
			this._line = Math.ceil( this.label[ this._visibleLine ].length/this.maxLength );
			//文字列の行数だけ繰り返す
			for( var i=0; i<this._line; i++ ) {
				this._text[i] = this._text[i] || '';
				this._text[i] = this.label[ this._visibleLine ].substr( i*this.maxLength, this.maxLength );
				//文字列の表示
				ctx.fillText( this._text[i], this.x, this.y + ( i * 25 ) );
			}
		}
		//文字を表示する間隔（はやさ）が0以外の場合、一文字ずつ表示していく
		else {
			if( this._displayLength < this.label[ this._visibleLine ].length && frame%this.interval === 0 ) {
				this._text[this._line] = this._text[this._line] || '';
				//this.labelに代入されている文字列を、this._text[this._line]に一文字ずつ入れていく
				this._text[this._line] += this.label[ this._visibleLine ].charAt( this._displayLength );
				this._displayLength++;
				if ( this._displayLength % this.maxLength === 0 ) {
					this._line++;
				}
			}

			for( var i=0; i<this._line+1; i++ ) {
				this._text[i] = this._text[i] || '';
				ctx.fillText( this._text[i], this.x, this.y + ( i * 25 ) );
			}
		}
	}
}





const str = [
    'ぼくたちは駅近のおしゃれなカフェに入ってランチをしている。',
    'カフェに入って15分が経ち、注文したメニューが運ばれてきた。',
    'ぼくと◯◯はそれぞれ自分の料理を食べ始めた。',
    'さて、アイスブレイクも終盤に差しかかっているな。'
];

//ゲームのオブジェクトを640×480サイズで作る
let game = new Game( 1000, 200 );
// let game = new Game( 640, 480 );
 
//ラベルオブジェクトを作る
let label = new Label( str );
label.interval = 5;
label.maxLength = 32;
 
//add()を使って、ゲームにラベルを表示
game.add( label, 0, 0 );

//キーボードが押された時
// const abc = document.querySelector('.page00__inner');
// if(abc.css.display != none){}
// const abc = document.querySelector('#canvas');
addEventListener( "keydown", (event) => {
	const key_code = event.keyCode;
	//先ほど登録したスペースキーが押された時、label.next()を実行
	if( key_code === 32) {
		game.area();
		label.next();
	}
	//方向キーでブラウザがスクロールしないようにする
	// event.preventDefault();
}, false);

//ゲームスタート
game.area();
game.start();






// 選択肢表示のギミック
$('.js-display-choices-button').on('click', function(){
    // $('.page00__choices').css('display', 'block');
	$('.page00__words-and-deeds').css('display', 'flex');
    $('.page00__inner').css('display', 'none');
    $('.page00__button-area').css('display', 'none');
});




// グローバルナビゲーションのギミック
$(".page00__global-nav-button").click(function () {//ボタンがクリックされたら
	$(this).toggleClass('active');//ボタン自身に activeクラスを付与し
    $(".page00__global-nav").toggleClass('panelactive');//ナビゲーションにpanelactiveクラスを付与
});





// 「過去にした言動一覧」のメニューを開いているときの設定
// let abc = document.getElementsByClassName('js-lists-of-done-div')[0];
// let abcd = getComputedStyle(abc).display;
// console.log(abcd);
// if( abcd == 'block' ){
// 	alert('上手く動作しているよ！');
// }

// グローバルナビゲーション内の画面遷移
$(".js-lists-of-done").click(function () {
	$('.js-gnav-lists').css('display', 'none');
	// $('.js-lists-of-done-div').css('display', 'block');
	$('.js-lists-of-done-div').css('display', 'flex');

	// for(let i=0; i<localStorage.length; i++){
	// 	// let wordsAndDeedsObj= {};
    //     let titleAsKey = localStorage.key(i);
    //     let values = JSON.parse(localStorage.getItem(titleAsKey));
    //     console.log(values);

	// 	const titleHtml = `言動のタイトル：${titleAsKey}`;
	// 	const cardsHtml = `選んだカード：${values.cardsUsed}`;
	// 	const textHtml = `実際にした言動：${values.wordsAndDeeds}`;

    //     $(".js-lists-of-done-title").append(titleHtml);
	// 	$(".js-lists-of-done-cards").append(cardsHtml);
	// 	$(".js-lists-of-done-text").append(textHtml);
    // }
});
$(".js-lists-of-done-button").click(function () {
	$('.js-lists-of-done-div').css('display', 'none');
	$('.js-gnav-lists').css('display', 'block');

	// $(".js-lists-of-done-title").empty();
	// $(".js-lists-of-done-cards").empty();
	// $(".js-lists-of-done-text").empty();
});



$(".js-cards-of-having").click(function () {
	$('.js-gnav-lists').css('display', 'none');
	$('.js-cards-of-having-div').css('display', 'block');
});
$(".js-cards-of-having-button").click(function () {
	$('.js-cards-of-having-div').css('display', 'none');
	$('.js-gnav-lists').css('display', 'block');
});



$(".js-global-nav-button").click(function () {
	$('.js-lists-of-done-div').css('display', 'none');
	$('.js-cards-of-having-div').css('display', 'none');
	$('.js-gnav-lists').css('display', 'block');

	// $(".js-lists-of-done-title").empty();
	// $(".js-lists-of-done-cards").empty();
	// $(".js-lists-of-done-text").empty();
});





// チェックボックスが1つも押されていなかったら確定ボタンが無効になり、1つ以上押されていたら有効になるギミック
function change() {
	const submitBtn = document.querySelector('.js-button');
	const checkboxes = document.querySelectorAll('input[name="wd_cards[]"]:checked');
	if (checkboxes.length === 0) {
		submitBtn.disabled = true;
		submitBtn.style.opacity = 0.2;
    	submitBtn.style.cursor = "default";
	} else {
		submitBtn.disabled = false;
		submitBtn.style.opacity = 1;
    	submitBtn.style.cursor = "pointer";
	}
}





// メニュー＞過去にした言動一覧の「入力画面を再現する」ボタンを押したときの挙動
$(document).on('click', '.js-link-to-update-page', function() {
	// wd_id(dataKey)を取得する
	let clickDom = event.target;
	let wd_id = clickDom.getAttribute('dataKey');

	if( confirm('この言動を入力した画面を再現しますか？') ){
		// wd_id(dataKey)情報と共にpage00_update.phpに飛ぶ
		location = `page00_update.php?wd_id=${wd_id}`;
	} else {
		return false;
	}
});

// メニュー＞過去にした言動一覧の「記憶から抹消する」ボタンを押したときの挙動
$(document).on('click', '.js-link-to-delete-page', function() {
	// wd_id(dataKey)を取得する
	let clickDom = event.target;
	let wd_id = clickDom.getAttribute('dataKey');

	if( confirm('この言動を記憶から抹消しますか？') ){
		// wd_id(dataKey)情報と共にpage00_delete.phpに飛ぶ
		location = `page00_delete.php?wd_id=${wd_id}`;
	} else {
		return false;
	}
});






// カードを最低1枚以上選んでいるかどうかをチェックするギミック
// function isCheck() {
//     let arr_checkBoxes = document.getElementsByClassName("js-check");
//     let count = 0;
//     for (let i = 0; i < arr_checkBoxes.length; i++) {
//         if (arr_checkBoxes[i].checked) {
//             count++;
//         }
//     }
//     if (count > 0) {
//         moveCheck();
//     } else {
//         // alert("【使用するカード】から1つ以上選択してください。");
//         return false;
//     }
// }

// 本当に確定するかどうかをチェックするギミック
// function moveCheck() {
	// let title = $('.js-words-and-deeds-title').val();
	// let arr_checkBoxes = document.getElementsByClassName("js-check");
	// let text = $('.js-words-and-deeds-text').val();
    // let count = 0;
    // for (let i = 0; i < arr_checkBoxes.length; i++) {
    //     if (arr_checkBoxes[i].checked) {
    //         count++;
    //     }
    // }
	// if ( title == '' || text == '') {
	// 	return false;
	// } else {
		// if( !confirm("この内容で確定しますか？") ) {
		// 	return false;
		// }
	// }
	// if ( title !== '' && count > 0 && text !== '' ) {
	// 	if( confirm("この内容で確定しますか？") ) {
	// 		alert("言動を保存しました。");
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
	// } else {
	// 	return false;
	// }
// }




// $(function(){
// 	let title = $(".js-words-and-deeds-title").val();
// 	let text = $(".js-words-and-deeds-text").val();
// 	// 初期状態のボタンは無効
// 	$(".js-button").prop("disabled", true);
// 	$(".js-button").prop("color", '#808080');
// 	// $(".js-validation").css('background-image', '#808080');
// 	$(".js-words-and-deeds-confirm-button").css('background', '#808080');
// 	// チェックボックスの状態が変わったら（クリックされたら）
// 	$("input[type='checkbox']").on('change', function () {
// 		// チェックされているチェックボックスの数
// 		if ($(".js-check:checked").length > 0 && title !== '' && text !== '') {
// 		// ボタン有効
// 		$(".js-button").prop("disabled", false);
// 		} else {
// 		// ボタン無効
// 		$(".js-button").prop("disabled", true);
// 		}
// 	});
// });


// const form = document.querySelector('.js-form');
// const button = document.querySelector('.js-button');

// form.addEventListener("input", update);
// form.addEventListener("change", update);

// function update() {
// 	const isRequired = form.checkValidity();
// 	if (isRequired) {
// 		// button.disabled = false;
// 		button.style.opacity = 1;
//     	button.style.cursor = "pointer";
// 		return;
// 	} else {
// 		// button.disabled = true;
// 		button.style.opacity = 0.2;
//     	button.style.cursor = "default";
// 		return;
// 	}
// }


// // 入力した言動をローカルストレージに保存するギミック
// $(".js-words-and-deeds-confirm-button").on("click", function(){
// 	let cards = document.getElementsByClassName('js-words-and-deeds-cards')
// 	let cardsLength = cards.length;
// 	let cardsUsedArray = [];
// 	// let cardsUsedObj = {};

// 	for(let i=0; i < cardsLength; i++){
// 		if( cards[i].checked ){
// 			let name = cards[i].id;
// 			// console.log(name);
// 			cardsUsedArray.push(name);
// 			// let checkbox = cards[i].checked;
// 			// cardsUsedObj[name]=checkbox;

// 			// let cardsUsed = {
// 			// 	name: checked
// 			// };
// 			// {
// 			// 	cards[i].id : cards[i].checked
// 			// };
// 			// cardsUsed[i].key = name;
// 			// cardsUsed[i].value = checked;			
// 		}
// 	}
// 	// console.log(cardsUsedObj);
// 	// console.log(cardsUsedArray);

// 	let titleAsKey = $(".js-words-and-deeds-title").val();
// 	let values = {
// 		cardsUsed: cardsUsedArray,
// 		wordsAndDeeds: $(".js-words-and-deeds-text").val()
// 	};
// 	localStorage.setItem(titleAsKey, JSON.stringify(values));//JSONに変換
// });
