<?php
/**
 * Реализовать возможность входа с паролем и логином с использованием
 * сессии для изменения отправленных данных в предыдущей задаче,
 * пароль и логин генерируются автоматически при первоначальной отправке формы.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

function shapeSpace_randomizer() {
    return rand(1000,9999);
}

function generatePassword($length = 8){
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string;
}


$random_number = shapeSpace_randomizer();
$random_word = generatePassword(5);
// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
   // setcookie('login', '', 100000);        чищу их в login, потому что нужно их запоминать для заполнения
   // setcookie('pass', '', 100000);
    // Выводим сообщение пользователю.
    $messages[] = 'thank you, your results have been saved';
  }
  
    // Если в куках есть пароль, то выводим сообщение.
    if (!empty($_COOKIE['pass'])) {
      $messages[] = sprintf('you can <a href="login.php">enter</a> with login <strong>%1$s</strong>
        and password <strong>%2$s</strong> for changing your data.',$_COOKIE['login'], $_COOKIE['pass'] ,
        );
    }
  

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['date'] = !empty($_COOKIE['date_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['agree'] = !empty($_COOKIE['agree_error']);

  if ($errors['fio']) {
      // Удаляем куки, указывая время устаревания в прошлом.
      setcookie('fio_error', '', 100000);
      // Выводим сообщение.
      if ($errors['fio'] == 'empty') $messages['fio'] = '<div class="errors">FIO is required.</div>';
      else $messages['fio'] = '<div class="errors">Only letters and white space allowed.</div>';
  }
  if ($errors['email']) {
      setcookie('email_error', '', 100000);
      if($errors['email'] == 'empty') $messages['email'] = '<div class="errors">Email is required.</div>';
      else $messages['email'] = '<div class="errors">Invalid email format.</div>';
  }
  if ($errors['date']) {
      setcookie('date_error', '', 100000);
      $messages['date'] = '<div class="errors">Date is required.</div>';
  }
  if ($errors['sex']) {
      setcookie('sex_error', '', 100000);
      $messages['sex'] = '<div class="errors">Sex is required.</div>';
  }
  
  if ($errors['bio']) {
      setcookie('bio_error', '', 100000);
      $messages['bio'] = '<div class="errors">Biography is required.</div>';
  }
  if ($errors['agree']) {
      setcookie('agree_error', '', 100000);
      $messages['agree'] = '<div class="errors">Agreement is required.</div>';
  }
 
  // Складываем предыдущие значения полей в массив, если есть.
  // При этом санитизуем все данные для безопасного отображения в браузере.
  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : strip_tags($_COOKIE['fio_value']); // stript_tags Эта функция возвращает строку str, из которой удалены HTML и PHP тэги.
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
  $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['agree'] = empty($_COOKIE['agree_value']) ? '' : $_COOKIE['agree_value'];
  

  // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
  // ранее в сессию записан факт успешного логина.
  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login']))
    
  {
      $user = 'u20385';
      $pas = '9967441';
      $db = new PDO('mysql:host=localhost;dbname=u20385', $user, $pas,
          array(PDO::ATTR_PERSISTENT => true));
      
      
      
      
      try {
          
          $login=$_SESSION['login'];
          $stmt = $db->prepare("SELECT fio FROM application WHERE login = ?");
          $stmt->execute([$_SESSION['login']]);
          $values['fio'] = $stmt->fetchColumn();
          
          $stmt = $db->prepare("SELECT email FROM application WHERE login = ?");
          $stmt->execute([$_SESSION['login']]);
          $values['email'] = $stmt->fetchColumn();
          
          $stmt = $db->prepare("SELECT date FROM application WHERE login = ?");
          $stmt->execute([$_SESSION['login']]);
          $values['date'] = $stmt->fetchColumn();
          
          $stmt = $db->prepare("SELECT sex FROM application WHERE login = ?");
          $stmt->execute([$_SESSION['login']]);
          $values['sex'] = $stmt->fetchColumn();
          
          $stmt = $db->prepare("SELECT limbs FROM application WHERE login = ?");
          $stmt->execute([$_SESSION['login']]);
          $values['limbs'] = $stmt->fetchColumn();
          
          $stmt = $db->prepare("SELECT bio FROM application WHERE login = ?");
          $stmt->execute([$_SESSION['login']]);
          $values['bio'] = $stmt->fetchColumn();
              
              
      }
      catch(PDOException $e){
          print('Error : ' . $e->getMessage());
          exit();
      }
          
    // TODO: загрузить данные пользователя из БД!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    // и заполнить переменную $values,
    // предварительно санитизовав.
  }

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
  
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  // Проверяем ошибки.
    $errors = FALSE;
    
    if (empty($_POST['fio'])) {
        setcookie('fio_error', 'empty');
        $errors = TRUE;
    }
    else if (!preg_match('/^[a-zA-Z]+$/u', $_POST['fio'])) {
        setcookie('fio_error', 'invalid');
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на год.
        if (empty($_COOKIE[session_name()]) || empty($_SESSION['login']))
        setcookie('fio_value', $_POST['fio'], time() + 365 * 24 * 60 * 60);
    }
    
    
    
    if (empty($_POST['email'])) {
        setcookie('email_error', 'empty');
        $errors = TRUE;
        
    }
    else {
        setcookie('email_value', $_POST['email'], time() + 365 * 24 * 60 * 60);
    }
    
    
    
    
    
    if (empty($_POST['date'])) {
        setcookie('date_error', 'empty');
        $errors = TRUE;
    }
    else {
        setcookie('date_value', $_POST['date'], time() + 365 * 24 * 60 * 60);
    }
    
    if (!empty($_POST['sex']))
    { switch($_POST['sex']) {
        case 'man': {
            $sex='man';
            break;
        }
        case 'woman':{
            $sex='woman';
            break;
        }
    };
    
    }
    
    if(empty($_POST['agree']))
    {
        setcookie('agree_error', 'empty');
        $errors = TRUE;
    }
    
    
    
    if (!empty($_POST['limbs']))
    {
    switch($_POST['limbs']) {
        case '1': {
            $limbs='1';
            break;
        }
        case '2':{
            $limbs='2';
            break;
        }
        case '3':{
            $limbs='3';
            break;
        }
        case '4':{
            $limbs='4';
            break;
        }
    };
    
    }   
    
    
    
    if ($errors) {
        // При наличии ошибок завершаем работу скрипта.
        
        $new_url = 'index.php';
        header('Location: '.$new_url);
        exit();                               // если был просто exit без перенаправления, то он отображал пустую страницу
    }
    else {
        
        
        // Удаляем Cookies с признаками ошибок.
        setcookie('fio_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('date_error', '', 100000);
        setcookie('sex_error', '', 100000);
        setcookie('limbs_error', '', 100000);
        setcookie('bio_error', '', 100000);
        setcookie('agree_error', '', 100000);
        
    }

  // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
    // TODO: перезаписать данные в БД новыми данными,
    // кроме логина и пароля.
          $user = 'u20385';
          $pas = '9967441';
          $db = new PDO('mysql:host=localhost;dbname=u20385', $user, $pas,
              array(PDO::ATTR_PERSISTENT => true));
          
          // Подготовленный запрос. Не именованные метки.
          try {
              $stmt = $db->prepare("UPDATE application SET fio=?, email=?, date=?, sex=?, limbs=?, bio=? WHERE login = ?");
              $stmt->execute([$_POST['fio'],$_POST['email'],$_POST['date'], $_POST['sex'],$_POST['limbs'],$_POST['bio'],$_POST['login'] = $_SESSION['login']]);
              
          }
          catch(PDOException $e){
              print('Error : ' . $e->getMessage());
              exit();
          }
          
          
  }
  else {
    // Генерируем уникальный логин и пароль.
    // TODO: сделать механизм генерации, например функциями rand(), uniquid(), md5(), substr().
    $login = $random_number;
    $pass = $random_word;
    // Сохраняем в Cookies.
    setcookie('login', $login);
    setcookie('pass', $pass);
    $_POST['login'] = $login;
    $_POST['pass'] = md5($pass);
    $_COOKIE['login'] = $login;
    $_COOKIE['pass'] = $pass;
    

    // TODO: Сохранение данных формы, логина и хеш md5() пароля в базу данных.
    // ...
    // Сохранение в базу данных.
    
    $user = 'u20385';
    $pas = '9967441';
    $db = new PDO('mysql:host=localhost;dbname=u20385', $user, $pas,
        array(PDO::ATTR_PERSISTENT => true));
    
    // Подготовленный запрос. Не именованные метки.
    try {
        
        $stmt = $db->prepare("INSERT INTO application SET fio = ?, email = ?, date = ?, sex = ?, limbs = ?, bio = ?, login = ?, pass = ?");
        $stmt->execute([$_POST['fio'],$_POST['email'],$_POST['date'], $_POST['sex'],$_POST['limbs'],$_POST['bio'],$_POST['login'],$_POST['pass']]);
    }
    catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
    }
    
  }

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
 // header('Location: ./'); // этот способ лагает
  $new_url = 'index.php';
  header('Location: '.$new_url);
}

