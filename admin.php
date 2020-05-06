<link rel="stylesheet" href="style.css">
<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/
$user = 'u20385';
$pas = '9967441';
$db = new PDO('mysql:host=localhost;dbname=u20385', $user, $pas,
    array(PDO::ATTR_PERSISTENT => true));

try {
    
    $stmt = $db->prepare("SELECT login FROM admin");
    $stmt->execute();
    $values['loginadmin'] = $stmt->fetchColumn();
    
    $stmt = $db->prepare("SELECT pass FROM admin");
    $stmt->execute();
    $values['passadmin'] = $stmt->fetchColumn();
    
    
}
catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
}

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != $values['loginadmin'] ||
    md5($_SERVER['PHP_AUTH_PW']) != $values['passadmin']) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}

{
    
    ?>
    <button class="zzz" id="z" name="submit"  onclick="document.location.replace('exit.php');">Exit</button><br>  
    <form action="" method="POST">
   
    <p> Delete by login </p>
    <input name="login"  class="zzz">
     <input type="submit" value="ok" id="z" class="zzz"/>
   </form>
   
   <?php    
 
   if (!empty($_POST['login'])) {
        
        $user = 'u20385';
        $pas = '9967441';
        $db = new PDO('mysql:host=localhost;dbname=u20385', $user, $pas,
            array(PDO::ATTR_PERSISTENT => true));
        
        // Подготовленный запрос. Не именованные метки.
        
        try {
            $login=$_POST['login'];
            $stmt = $db->prepare("DELETE FROM application WHERE login = ?");
            $stmt->execute([$login]);
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
        
   
   
       }
   
   
   /* 
 
        $user = 'u20385';
        $pas = '9967441';
        $db = new PDO('mysql:host=localhost;dbname=u20385', $user, $pas,
            array(PDO::ATTR_PERSISTENT => true));
        
        
        
        
        try {
            $stmt = $db->prepare("SELECT COUNT(*) FROM application");
            $stmt->execute();
            $b = $stmt->fetch();                             //узнаёт число строк в таблице
            printf("<div>%s</div>", $b[0]);
          
            
             
            for($i=1;$i<=$b[0];$i++)                      //выводит всё на экран
            {
            
            $stmt = $db->prepare("SELECT fio FROM application WHERE id = ?");
            $stmt->execute([$i]);
            $values['fio'] = $stmt->fetchColumn();
            printf("<div>%s</div>", $values['fio']);
            
            $stmt = $db->prepare("SELECT email FROM application WHERE id = ?");
            $stmt->execute([$i]);
            $values['email'] = $stmt->fetchColumn();
            printf("<div>%s</div>", $values['email']);
            
            $stmt = $db->prepare("SELECT date FROM application WHERE id = ?");
            $stmt->execute([$i]);
            $values['date'] = $stmt->fetchColumn();
            printf("<div>%s</div>", $values['date']);              
            
            $stmt = $db->prepare("SELECT sex FROM application WHERE id = ?");
            $stmt->execute([$i]);
            $values['sex'] = $stmt->fetchColumn();
            printf("<div>%s</div>", $values['sex']);
            
            $stmt = $db->prepare("SELECT limbs FROM application WHERE id = ?");
            $stmt->execute([$i]);
            $values['limbs'] = $stmt->fetchColumn();
            printf("<div>%s</div>", $values['limbs']);
            
            $stmt = $db->prepare("SELECT bio FROM application WHERE id = ?");
            $stmt->execute([$i]);
            $values['bio'] = $stmt->fetchColumn();
            printf("<div>%s</div>", $values['bio']);
            }
            
            
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
        
      */
        
        $link = mysqli_connect('localhost', 'u20385', '9967441', 'u20385');
    
        
        
        
        $query1 = mysqli_query($link, "SELECT * FROM application");
        
        $myrow = mysqli_fetch_array($query1);
        ?>
        <table class="xxx" style="border-collapse: separate; border-spacing: 30px 20px;">
        <?php 
        while($row=mysqli_fetch_array($query1))
        {
            echo  "<tr>
            <th>", $row['fio']," </th> <th>", $row['email'],"</th><th> ", $row['date'],"</th><th> ", $row['sex'],"</th><th> ", $row['limbs'],"</th><th>", $row['bio'], "</th><th>", $row['login'],"</th><th>", $row['pass']. "</th>";
        }
        ?>
        </table>
        <?php 
        
        
}
?>

