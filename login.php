<link rel="stylesheet" href="style.css">
<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Начинаем сессию, создаем или открываем существующее соединение
session_start();

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
if (!empty($_SESSION['login'])) {
  // Если есть логин в сессии, то пользователь уже авторизован.
   
  // TODO: Сделать выход (окончание сессии вызовом session_destroy()                                  //ЧТО СИНИЦА ХОТЕЛ УВИДЕТЬ В ЭТОМ БЛОКЕ?
  //при нажатии на кнопку Выход).
  // Делаем перенаправление на форму.
  header('Location:/form.php');
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>

<form action="" method="post">
<p> Enter your login </p>
  <input name="login" class="zzz" value="<?php print $_COOKIE['login']; ?>">
  <p> Enter your password </p>
  <input name="pass" class="zzz" value="<?php print $_COOKIE['pass']; ?>"/>
  <p>  </p>
  <input type="submit" value="Enter" class="zzz"/>
  
   
  
</form>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
 
  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках.

    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    
    $user = 'u20385';
    $pas = '9967441';
    $db = new PDO('mysql:host=localhost;dbname=u20385', $user, $pas,
        array(PDO::ATTR_PERSISTENT => true));
    
    
  
    
    // Подготовленный запрос. Не именованные метки.
    try {
        
        $log=$_POST['login'];
        $stmt = $db->prepare("SELECT pass FROM application WHERE login = ?");
        $stmt->execute([$_POST['login']]);
        $result = $stmt->fetchColumn();   //Возвращает данные одного столбца следующей строки результирующего набора
        if($result==NULL) (die("user has not been found"));
        else if (md5($_POST['pass']) !== $result)
            die('invalid password');
        //    die("pass = $result\n");
       
        else $_SESSION['login'] = $_POST['login'];
        
       
    }
    catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
    
      
        
}

 // $user = get_user_by_login($_POST['login']); //get_user_by() Получает пользователя по указанному полю и значению этого поля


  // Делаем перенаправление.
  header('Location: ./');
}
