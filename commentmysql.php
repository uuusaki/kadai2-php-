<?php
  $user = 'root';
  $password = 'root';
  $db = 'laravelnews'; //データベース名
  $host = 'localhost';
  $port = 3306;
  $link = mysqli_init();
  $success = mysqli_real_connect(
    $link, 
    $host, 
    $user, 
    $password, 
    $db,
    $port
  );

  $getid = "";//パラメータ経由で取得したID
  $id = "";
  $title = "";
  $article = "";
  $thistitle = "";
  $thisareticle = "";

  //MySQLからデータを取得
  $query = "SELECT * FROM `date` ";
  if ($success) {
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
      $BOARD[] = [$row['id'], $row['title'], $row['article']];
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

   <h2 class="laravelnews"><a href="indexmysql.php">Laravel News</a></h2>
   <h3>ニュースの詳細</h3>
   <br>

   <p>
     <?php
       $getid = $_GET["id"];
       echo $getid;
       echo $BOARD;
       ?>
   </p>

    <div>
        <h3>※タイトル
        <?php echo $thistitle; ?></h3>

        <p>※記事の内容
        <?php echo $thisareticle; ?></P>
    </div>
 
   <p class="error"> 
    <?php echo $error ?>
   </p>

  <hr>

    <div>
      <h3>コメント</h3>
      <form method="post" > 
        <textarea name="comment" style="width:30%" rows="7"> コメントを書く</textarea>
       　<div class="submit">
      　　 <input type="submit" value="コメントする" >
     　　</div>
      </form>
    </div>
 

   <hr>
   
   
   <hr>
   <!--
   <div class="contents">
     <p>最新の投稿</P>
      <h3>
         <?php echo $DATA[1]; ?>
      </h3>
      <p>
         <?php echo $DATA[2]; ?>
      </p>
      <p style= "text-align : right ;"><?php echo strlen ("$text") ?>字</p>
      　文字数カウント
   </div>
     -->

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
       <br>
     <?php endforeach; ?>
   </div>


  
　　　
 
  
  </body>
</html>
    
    
