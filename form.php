<html>
  <head>
    <style>
/* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
.error {
  border: 2px solid red;
}
    </style>
  </head>
  <body>

<?php
if (!empty($messages)) {
  print('<div class="xxx" id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>
<link rel="stylesheet" href="style.css">



<?php
if (!empty($_SESSION['login'])) {
    ?>
   <button class="zzz" id="z" name="submit"  onclick="document.location.replace('exit.php');">Exit</button><br> 
    <?php
} else {
    ?><button class="zzz" id="z" name="submit"  onclick="document.location.replace('admin.php');">enter as admin</button><br> 
   
    <?php
}
?>
<form action="" method="POST">



<p> Name </p>
  <input name="fio"  class="zzz"
   <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>">
   <?php if (!empty($messages['fio'])) {print($messages['fio']);} ?> <br> 
 
 
  <p> e-mail </p>
  <input name="email"  class="zzz"
  <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" > 
   <?php if (!empty($messages['email'])) {print($messages['email']);} ?>
 <br>
 

  <p>Year of birth </p>
 <input name="date" class="zzz" <?php if ($errors['date']) {print 'class="error"';} ?> value="<?php print $values['date']; ?>" type="date" min="1950-01-01" max="2002-01-01">
 <?php if (!empty($messages['date'])) {print($messages['date']);} ?> 

  
    <p>Sex: <br> 
<input type="radio" name="sex" value="man"
<?php if ($errors['sex']) {print 'class="error"';} ?> checked="<?php if($values['sex'] == 'man'){print 'checked';} ?>"/> 
Man <br>
<input type="radio" name="sex" value="woman" 
 <?php if ($errors['sex']) {print 'class="error"';} ?> checked="<?php if($values['sex'] == 'woman'){print 'checked';} ?>">
  Woman 
  <?php if (!empty($messages['sex'])) {print($messages['sex']);} ?>
 </p>
 
 
  <p>Number of courses: <br> 
<input type="radio" name="limbs" value="1" checked="<?php if($values['limbs'] == '1') {print 'checked';} ?>"/> One <br>
<input type="radio" name="limbs" value="2" checked="<?php if($values['limbs'] == '2') {print 'checked';} ?>"/> Two <br>
<input type="radio" name="limbs" value="3" checked="<?php if($values['limbs'] == '3') {print 'checked';} ?>"/> Three <br>
<input type="radio" name="limbs" value="4" checked="<?php if($values['limbs'] == '4') {print 'checked';} ?>"/> Four </p>

 
 
 <p>Biography: <br>
<textarea name="bio" maxlength="200" <?php if ($errors['bio']) {print 'class="error"';} ?>><?php print $values['bio']; ?></textarea></p>

  
  <p> I read the rulelist  <input type="checkbox" name="agree" value="Yes" 
  <?php if ($errors['agree']) {print 'class="error"';} ?> checked="<?php if($values['agree']) print 'checked'; ?>"/></p>
 
  
  <input type="submit" value="ok" class="zzz"/>
  
</form>
 

  

  </body>
</html>
