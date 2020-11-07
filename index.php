<?php
     $midasi = " " ;//見出し
     $honbun = " " ;//本文

     

     
     

     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //postの内容を受け取る
        if (!empty($_POST['atitle']) && !empty($_POST['article'])){
         //post"atitle"が空でない　かつ　post"article"が空でない　とき

         $midasi = $_POST['atitle'];
         $honbun = $_POST['article'];
         //変数にpostの内容を代入

         //この後に保存の処理

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

 
  
  </body>
</html>
    
    
