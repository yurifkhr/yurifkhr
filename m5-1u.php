<!DOCTYPE html> 

<html lang="ja">
    <head>
    <meta charset = "UTF-8">
    <title>mission5-1</title>
    </head>
    <body>
    <?php
    $dsn='データベース名';
    $user = 'ユーザー名';
    $password = 'パスワードパスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        //編集
        if(isset($_POST["edit"],$_POST["editpass"])&&$_POST["edit"]!=""&&$_POST["editpass"]!=""){
            $sql = 'SELECT * FROM テーブル名';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                if($row["id"]==$_POST["edit"]&&$row["password"]==$_POST["editpass"]){
                    $edit_name=$row["name"];
                    $edit_comment=$row["comment"];
                    $edit_line=$row["id"];
                }
            }    
        }
        
    ?>
    <div style = "background-color: #f6efdb">
    <form action="" method="post">
        <span style = "color: #691c0d">【新規投稿】</span><br>
        <input type="text" name="name" placeholder="名前" value="<?php if(isset($edit_name)){echo $edit_name;}?>"><br>
        <input type="text" name="comment" placeholder="コメント" value="<?php if(isset($edit_comment)){echo $edit_comment;}?>"><br>
        <input type="password" name="password" placeholder="パスワード">
        <input type="hidden" name="editline" value="<?php if(isset($edit_line)){echo $edit_line;}?>">
        <input type ="submit"><br><hr>
        <span style = "color: #691c0d">【削除フォーム】</span><br>
        <input type="text" name="delete" placeholder="削除したい行"><br>
        <input type="password" name="delpass" placeholder="パスワード">
        <input type="submit" value="削除"><br><hr>
        <span style = "color: #691c0d">【編集フォーム】</span><br>
        <input type="text" name="edit" placeholder="編集したい行"><br>
        <input type="password" name="editpass" placeholder="パスワード">
        <input type="submit" value="編集">
    </form>
    
    <?php
    $dsn='データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $sql1 = "CREATE TABLE IF NOT EXISTS テーブル名"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT,"
        . "date TEXT,"
        . "password TEXT"
        .");";
        
        echo "<hr>";
        //新規投稿
        if(isset($_POST["name"],$_POST["comment"],$_POST["password"])&&$_POST["name"]!=""&&$_POST["comment"]!=""&&$_POST["password"]!=""&&$_POST["editline"]==""){
            $sql2 = $pdo -> prepare("INSERT INTO テーブル名 (name,comment,date,password) VALUES (:name,:comment,:date,:password)");
            $sql2 -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql2 -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql2 -> bindParam(':date', $date, PDO::PARAM_STR);
            $sql2 -> bindParam(':password', $password, PDO::PARAM_STR);
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $date = date("Y年m月d日 H:i:s");
            $password = $_POST["password"];
            $sql2 -> execute();
        }
        //編集のとき
        if(isset($_POST["name"],$_POST["comment"],$_POST["password"])&&$_POST["name"]!=""&&$_POST["comment"]!=""&&$_POST["password"]!=""&&$_POST["editline"]!=""){
            $id=$_POST["editline"];
            $name=$_POST["name"];
            $comment=$_POST["comment"];
            $date=date("Y年m月d日 H:i:s");
            $password=$_POST["password"];
            $sql = 'UPDATE テーブル名 SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        //削除のとき
        if(isset($_POST["delete"],$_POST["delpass"])&&$_POST["delete"]!=""&&$_POST["delpass"]!=""){
            $sql = 'SELECT * FROM テーブル名';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                if($row["id"]==$_POST["delete"]&&$row["password"]==$_POST["delpass"]){
                    $id=$_POST["delete"];
                    $sql = 'delete from テーブル名 where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }    
        }
        //ブラウザに表示
        $sql = 'SELECT * FROM テーブル名';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            echo $row['id'].' '.$row['name'].' '.$row['comment'].' '.$row['date'].'<br>';
            echo "<hr>";
        }
    ?>
    </div>
    </body>
</html>
