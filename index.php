<?php
     $midasi = " " ;//見出し
     $honbun = " " ;//本文

     $FILE = 'article.txt' ; //保存するファイル名
     $id = uniqid() ; //記事一つ一つに被らない文字列のランダムなIDを自動生成
     $DATA = [] ; //一回分の投稿の情報を入れる配列
     $BOARD = [] ;//すべての投稿の情報を入れる配列



     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //postの内容を受け取る
        if (!empty($_POST['atitle']) && !empty($_POST['article'])){
         //post"atitle"が空でない　かつ　post"article"が空でない　とき

         $midasi = $_POST['atitle'];
         $honbun = $_POST['article'];
         //変数にpostの内容を代入

         //この後に保存の処理

         $DATA = [$id, $midasi, $honbun];
         $BOARD[] = $DATA

         //全体配列をファイルに保存
         file_put_contents($FILE, json_encode($BOARD));

        }
     }
?>

<!DOCTYPE html>
<html lang="ja">
 <head>
    <meta charset="utf-8" />
    <title>課題2 Lalavel News</title>
 </head>
 <body>

   <h2>Lalavel News</h2>
   <h3>さあ　最新ニュースをシェアしましょう</h3>
   <br>


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
       <input type="submit" value="投稿する">
     </div>
   </form>
 

   
  
   
   <hr>
   <div class="contents">
      <h3>
         <?php echo $midasi ?>
      </h3>
      <p>
         <?php echo $honbun ?>
      </p>
   </div>

   <hr>
   <div class="kakocontents">
     <?php foaeach ( (array) $BOARD as $ARTICLE) : ?>
       <!--配列＄BOARDを＄ARTICLEとして繰り返す-->
       <div class="content">
         <p>
         <?php echo $ARTICLE[1]; ?>
         <!--配列ARTICLEの中の$midasiを表示-->
         </P>
         <p>
         <?php echo $ARTICLE[2]; ?>
         <!--配列ARTICLEのなかの$honbunを表示-->
         </p>
       </div>
     <?php endforeach; ?>
   </div> 
  
  </body>
</html>
    
    
