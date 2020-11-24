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
    //名前の追加用のQueryを書く。
    $title = $_POST['title'];
    $article = $_POST['article'];

    $insert_query = "INSERT INTO `date`(`id`, `title`, `article`) VALUES (['$id'],['$title'],['$article'])";
    mysqli_query($link, $insert_query);
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
    exit;
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
    
    
