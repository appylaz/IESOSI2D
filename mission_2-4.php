﻿<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>mission_2-4</title>

</head>
<body>
<h1>簡易掲示板</h1>
<div style="border-style: solid ; border-width: 1px; width: 450px; border-color: #c9c9c9;">


<h2>投稿フォーム</h2>
<form action="mission_2-4.php" method="post">
<input type ="text" name ="name" placeholder="名前"/><br/>
<textarea name="comment" cols="50" rows="5" placeholder="コメント"/></textarea>
<input type ="submit">
</form>

<h2>削除フォーム</h2>
<form action="mission_2-4.php" method="post">
　<input type ="text" name ="delete" placeholder="削除番号"/><br/>
<input type ="submit">
</form>

</div>

<?php

//入力項目をテキストファイルへ書き込む（M2-2）
if($_POST['name'] != "" and $_POST['comment'] != ""){

 $today = getdate();
 $Comment = $_POST['comment'];
 $Name = $_POST['name'];
 $filename = 'write2.txt';

//投稿番号の計算
$lines = file('write2.txt');//テキストファイルを配列に格納
$c = count($lines);//配列の要素数をカウント

if($c == 0){
$ln = 0;

}else{

//explodeで配列に格納
  for($i=0; $i<$c; $i++){

  $amount = substr_count($lines[$i],"<>"); //<>の個数を取得
if($amount ==2 or $amount == 3){
  $boards = explode("<>",$lines[$i]);
  $ln = $boards[0];
  }


  }
}

/*
 echo "分岐成功";
 $sdfile = file_get_contents('write2.txt'); //ファイの中身を格納
 echo substr_count($sdfile,"<>"); //<>の個数を探してその値を返す

 $amount = substr_count($sdfile,"<>"); //<>の個数を取得
 //echo "$amount"; 
 //echo nl2br("\n");

 $last = $amount / 3; //最終投稿番の取得号
 //echo "$last";
 //echo nl2br("\n");

 $count = $last + 1; //最終投稿番号に1を加える
 //echo "$count";
 //echo nl2br("\n");
*/

//ファイルにデータを書き込む
 $count = $ln +1;
 $fp = fopen($filename, 'a');
 fputs($fp,$count."<>".$Name."<>".$Comment."<>".$today[year].$today[mon].$today[mday].$today[hours].$today[minutes].$today[seconds].PHP_EOL);
 fclose($fp);


 /*echo "送信完了しました";
 echo nl2br("\n"); 
 print '<pre>';
 print_r( $today ); //gettimeofdayの配列情報を全て出力
 print "</pre>\n";*/

}//M2-2終了


//削除番号に従ってテキストファイル上の投稿内容を削除(M2-4)
if($_POST["delete"] != ""){
$kai = "".PHP_EOL;
$lines = file('write2.txt');//テキストファイルを配列に格納
$c = count($lines);//配列の要素数をカウント
$delnum = $_POST["delete"];
$amount =0;
$reputs = array();//読み込んだテキスト上書きした後格納するための配列
$delf = 0;//delfの初期値は0

for($i=0; $i<$c; $i++){

$boards = explode("<>",$lines[$i]);
$amount = substr_count($lines[$i],"<>"); //<>の個数を取得
$change = $change + $amount;//これまで読み込んだ配列に登場した<>の個数を数える

//削除番号と照らし合わせてそのまま書き込むか、上書き削除するか決める。
if($boards[0] == $delnum or $delf == 1){  //$delf==1もしくは$boards[0]==削除番号なら$i番目に<>を$amount個書き込む。
$flag = $change % 3; //現在の<>合計数が3の倍数かどうか

//上書きを実行する場合、現在の行末までの<>の累計が3で割れなかった場合、次の行も上書き削除するフラグを立てる
if($flag == 0){//$flag != 0ならば$delf=1,==ならば$del=0

$delf=0;

}else{

$delf=1;

}

switch ($amount){
case 1:
  //echo "1起動";
  //echo nl2br("\n");
  $reputs[$i] = "";
  break;
case 2:
  //echo "2起動"; // ファイルに<>を上書きし、内容を削除する
  //echo nl2br("\n");
  $reputs[$i] = ""; 
  break;
case 3:
  //echo "3起動";
  //echo nl2br("\n");
  $reputs[$i] = "";  
  break;
case NULL:
  $reputs[$i] ="";
  break;
default:
  //echo "起動せず";
  break;
}

}else{

$reputs[$i] = $lines[$i];//そのまま上書き
}



}//上書き削除処理終了


$fp = fopen("write3.txt", 'a');
for($j=0;$j<count($reputs);$j++){
fputs($fp,$reputs[$j]);
}

fclose($fp);

rename("write3.txt","write2.txt");//削除後の中身が入ったファイルをリネーム
}


//表示処理(M2-3)
$lines1 = file('write2.txt');//テキストファイルを配列に格納
$c1 = count($lines1);//配列の要素数をカウント

//explodeで配列に格納
for($i=0; $i<$c1; $i++){

$boards1 = explode("<>",$lines1[$i]);
$amount1 = substr_count($lines1[$i],"<>"); //<>の個数を取得
//echo "$amount1";
//echo nl2br("\n");

$change1 = $change1 + $amount1;//これまで読み込んだ配列に登場した<>の個数を数える
for($j=0;$j<count($boards1);$j++){//$boardsの中身を表示
echo "$boards1[$j] ";
}

if($change1 % 3 == 0){//もし<>が3の倍数回登場していれば改行する
echo nl2br("\n");
}

echo nl2br("\n");//配列一段目の表示が終われば改行


}


?>
</body>
</html>