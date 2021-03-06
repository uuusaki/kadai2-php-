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

  $title = '';
  $article = '';
  $id = uniqid() ; //記事ごとに被りがない文字列のIDを作成
  $DATA = []; //一回分の情報を入れる配列
  $BOARD = []; //すべての投稿の情報を入れる配列
  $error = "";
  
// MySQLからデータを取得
$query = "SELECT * FROM `date`";
if ($success) {
  $result = mysqli_query($link, $query);
  while ($row = mysqli_fetch_array($result)) {
    $BOARD[] = [$row['id'], $row['title'], $row['article']];
  }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!empty($_POST['title']) && !empty($_POST['article']) ) {
    //タイトルがからでない　かつ　アーティクルが空でない時

    //名前の追加用のQueryを書く。
    $title = $_POST['title'];
    $article = $_POST['article'];

    $DATA = [$id, $title, $text];

    $insert_query = "INSERT INTO `date`(`id`, `title`, `article`) VALUES ('$id','$title','$article')";
    mysqli_query($link, $insert_query);
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
    exit;

  }else if (isset($_POST['del'])) {
    //削除ボタンを押したときの処理を書く。
    $delete_query = "DELETE FROM `date` WHERE `id` = '{$_POST['del']}'";
    mysqli_query($link, $delete_query);
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
    exit;
  }elseif(empty($_POST['title']) && empty($_POST['article'])){
    //post"title"が空の時 かつ　post"article"が空の時

    $error = 'タイトルと記事を入力してください';
    //'error'に代入

  }elseif(!empty($_POST['title']) && empty($_POST['article'])){
    //post"title"が空でない、"article"が空
  
    $error = '記事を入力してください';
    //'error'に代入

  }elseif(empty($_POST['title']) && !empty($_POST['article'])){
    //post"title"が空、"article"が空でないのとき

    $error = 'タイトルを入力してください';
  } 
}
?>

<!DOCTYPE html>
<html lang="ja">
 <head>
    <meta charset="utf-8" />
    <title>課題2 Lalavel News</title>
    <link rel="stylesheet" href="stylesmysql.css">
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
       <input type="text" name="title" style="width:100%"> 
     </div><br>
     <div class="article">
       <p>記事：</p>
       <textarea name="article" rows="10" style="width:100%"></textarea>
     </div><br>
     <div class="submit">
       <input type="submit" value="投稿する" >
     </div>
   </form>
 
    <p>
     <?php 
     date_default_timezone_set('Asia/Tokyo');
     echo date("Y/m/d h:i:s") ?>
    </p>
    <!--特に意味のない時刻表示（やってみたかっただけ）-->
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

         <form action = "commentmysql.php" method = "get">
          <!--このformの内容をcommentmysql.phpに送る、方法はget-->
          <textarea name ="id" hidden><?php echo $ARTICLE[0] ?></textarea>
          <!--この記事IDをテキストエリア内に表示、このテキストエリアは非表示-->
          <input type = "submit" value ="詳細ページへ">
          <!--サブミットボタンでformの内容を送る-->
         </form>
         <form method="post">
          <input type="hidden" name="del" value="<?php echo $ARTICLE[0] ?>">
          <input type="submit" value="削除" class="deleteComment">
         </form>
        <br>
     <?php endforeach; ?>
   </div>


  
　　　
 
  
  </body>
</html>
    
    
