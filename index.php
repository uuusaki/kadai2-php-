<?php
     $title = " " ;//見出し
     $text = " " ;//本文

     $FILE = 'article.txt'; //保存するファイル名
     $id = uniqid() ; //記事ごとに被りがない文字列のIDを作成
     $DATA = []; //一回分の情報を入れる配列
     $BOARD = []; //すべての投稿の情報を入れる配列

     $error = '';//エラーメッセージ

     if (file_exists($FILE)){
       //$FILE(article.txt)が存在しているとき以下を実行

       $BOARD = json_decode(file_get_contents($FILE));
       //$FILEからコンテンツを取り出し、Json形式を戻す
     }
     

     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //postの内容を受け取る
        if (!empty($_POST['atitle']) && !empty($_POST['article'])){
         //post"atitle"が空でない　かつ　post"article"が空でない　とき

         $title = $_POST['atitle'];
         $text = $_POST['article'];
         //変数にpostの内容を代入

         //この後に保存の処理
         //新規データ
         $DATA = [$id, $title, $text];
         //$DATAにid、title,textを入れる
         $BOARD[] = $DATA;
         //＄BOARDという配列に＄DATAを入れる

         //全体配列をファイルに保存する
         file_put_contents($FILE, json_encode($BOARD));
         //article.txtのファイルに＄BOARDの内容をJson形式で上書き

        }elseif(empty($_POST['atitle']) && empty($_POST['article'])){
          //post"atitle"が空の時 かつ　post"article"が空の時

          $error = 'タイトルと記事を入力してください';
          //'error'に代入

        }elseif(!empty($_POST['atitle']) && empty($_POST['article'])){
          //post"atitle"が空でない、"article"が空
        

          $error = '記事を入力してください';
          //'error'に代入

        }elseif(empty($_POST['atitle']) && !empty($_POST['article'])){
          //post"atitle"が空、"article"が空でないのとき

          $error = 'タイトルを入力してください';
        }
     }
?>

<!DOCTYPE html>
<html lang="ja">
 <head>
    <meta charset="utf-8" />
    <title>課題2 Lalavel News</title>
    <link rel="stylesheet" href="styles.css">
 </head>
 <body>

   <h2 class="laravelnews">Laravel News</h2>
   <h3>さあ　最新ニュースをシェアしましょう</h3>
   <br>

   <p class="error"> 
    <?php echo $error ?>
   </p>


   <form method="post" >  
     <div class="atytle">
       <p>タイトル：</p>
       <input type="text" name="atitle"> 
     </div><br>
     <div class="article">
       <p>記事：</p>
       <textarea name="article" rows="10" cols="50"></textarea>
     </div><br>
     <div class="submit">
       <input type="submit" value="投稿する" >
     </div>
   </form>
 

   <hr>
  
   
   <hr>
   <div class="contents">
      <h3>
         <?php echo $title ?>
      </h3>
      <p>
         <?php echo $text ?>
      </p>
      <p style= "text-align : right ;"><?php echo strlen ("$text") ?>字</p>
      　<!--文字数カウント-->
   </div>

   <hr>
   <div>
     <?php $BOARD = array_reverse($BOARD); ?>
     <?php foreach ((array)$BOARD as $ARTICLE) : ?>
       <!--配列＄BOARDの内容を変数＄ARTICLEとして繰り返す-->
       　<div>
          <p><b>
            <?php echo $ARTICLE[1]; ?></b>
            <!--$ARTICLEの[1]（＄title）を表示-->
          </P>
          <p>
            <?php echo $ARTICLE[2]; ?>
            <!--＄ARTICLE[2]($text)を表示-->
          </p>
         </div>
        <a href="action.php">詳細・コメントをみる</a><br>
     <?php endforeach; ?>
   </div>


  
　　　
 
  
  </body>
</html>
    
    
