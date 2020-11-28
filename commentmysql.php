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

  $getid = "" ;//パラメータ経由で取得したID
  $id = "";
  $title = "";
  $article = "";
  $thistitle = "";
  $thisarticle = "";
  $thiscom = "";

  $com_id = uniqid ();//コメントID
  $COM_BOARD = [];//コメント配列

 
  $getid = $_GET["id"]; 
  //パラメータから送られた記事IDを取得

  //MySQLから記事データを取得
  $query = "SELECT * FROM `date` WHERE id = '$getid' " ;
  if ($success) {
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
      $BOARD[] = [$row['id'], $row['title'], $row['article']];
   }
  } 
 
  //コメントをMYSQLに送る
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['comment'])) {
      //コメントが空でない時
  
      //追加用のQueryを書く。
      $comment = $_POST['comment'];

      $insert_query = "INSERT INTO `comment`(`com_id`, `id`, `comment`) VALUES ('$com_id', '$getid', '$comment')";
      mysqli_query($link, $insert_query);
      header('Location: ' . $_SERVER['REQUEST_URI']);

      exit;
    }else if (isset($_POST['del'])) {
    //削除ボタンを押したときの処理を書く。
    $delete_query = "DELETE FROM `comment` WHERE `com_id` = '{$_POST['del']}'";
    mysqli_query($link, $delete_query);
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
    }
  }
  //ここまでできてる

  //コメント用のデータを取得
  $query = "SELECT * FROM `comment` WHERE id = '$getid'" ;
  if ($success) {
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
      $COM_BOARD[] = [$row['com_id'], $row['id'], $row['comment']];
   }
  } 
    
  //できてる

  
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
     <?php echo $getid; 
      foreach ((array)$BOARD as $ARTICLE){
        if("$getid" == "$ARTICLE[0]"){
          $thistitle = $ARTICLE[1]; 
          $thisarticle = $ARTICLE[2];
          }
      }
     ?>
   </p>
   

    <div>
        <h3><!--※タイトル-->
        <?php echo $thistitle; ?></h3>

        <p><!--※記事の内容-->
        <?php echo $thisarticle; ?></P>
    </div>
 
   

  <hr>

    <div>
      <h3>コメント</h3>
      <form method="post"?>
        <textarea name="comment" style="width:30%" rows="7"> コメントを書く</textarea>
        
        <div class="submit">
      　　 <input type="submit" value="コメントする" >

     　　</div>
      </form>

      <form action = "commentmysql.php" method = "get">
          <!--このformの内容をcommentmysql.phpに送る、方法はget-->
          <textarea name ="id" hidden><?php echo $getid ?></textarea>
          <!--この記事IDをテキストエリア内に表示、このテキストエリアは非表示-->
          <input type = "submit" value ="詳細ページへ">
          <!--サブミットボタンでformの内容を送る-->
      </form>
    </div>
    <p class="error"> 
    <?php echo $error ?>
   </p>

   <hr>
   <!--ここからコメントの表示-->
   <div class="comments">
     <?php $COM_BOARD = array_reverse($COM_BOARD); ?>
     <?php foreach ((array)$COM_BOARD as $COMMENT) :?>
       　<div >
          <p>
            <?php 
             echo $COMMENT[2];//コメント
             //echo $COMMENT[1];//記事ID
             //echo $COMMENT[0]; //コメントID
              ?>
          </p>
         </div>
         <form method="post">
          <input type="hidden" name="del" value="<?php echo $COMMENT[0] ?>">
          <input type="submit" value="削除" class="deleteComment">
         </form>
         <?php endforeach ?> 
       <br>
   
   </div>
   <!--コメント表示ここまで-->
   
   <hr>
   
 
  
  </body>
</html>
    
    
