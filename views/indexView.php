<!DOCTTYPE html>
<html>
<head>
  <title> Гостевая книга </title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="гостевая книга, сообщения" />
  <meta name="description" content="Гостевая книга" />
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

  <div class="grid">
    <!-- Заголовок -->
    <div class="box header">
      <h1>Гостевая книга</h1>
    </div>

    <!-- Форма для ввода нового сообщения -->
    <div class="box add-message">
      <form method="post" action="" class="add-message">
        <p><label for="name">Имя пользователя * </label>
        <input type="text" name="name" id="name" /></p>
        <p><label for="email">E-mail * </label>
        <input type="email" name="email" id="email" /></p>
        <p><label for="homepage">Домашняя страница </label>
        <input type="url" name="homepage" id="homepage" /></p>
        <p><label for="text">Текст * </label>
        <input type="text" name="text" id="text" values="<?php //htmlentities($oldtext); ?>" /></p>
        <p><label for="pictures">Изображение </label>
        <input type='file' name="pictures" id="pictures"/></p>
        <p><label for="filepath">Файл </label>
        <input type='file' name="filepath" id="filepath"/></p>
        <p><label for="captcha">Captcha </label>
        <input type='text' name="captcha" id="captcha"/></p>
        <input type='hidden' name="ip" id="ip" value="<?php echo $_SERVER['REMOTE_ADDR']?>"/>
        <input type='hidden' name="browser" id="browser" value="<?php echo $_SERVER['HTTP_USER_AGENT']?>"/>
        <input type='hidden' name="date" id="date" value="<?php echo date("m.d.y H:i:s") ?>"/>
        <div class="button">
          <input type='submit' value='Отравить' name="send" />
          <input type='submit' value='Сбросить' name="throw" />
        </div>
    </form>
    </div>

    <!-- Вывод списка сообщений с учетом заданной сортировки -->
    <div class="box list-messages">
      <form>
        <div class="title-message">
          <h4> Имя </h4>
          <div class="arrows-title-message">
            <div><input type="image" src=<?php echo $sort=="name_desc" ? "images/double-up.png": "images/double-up-not.png"; ?>  name = "sort" value="name_desc" width="10" height="10"/></div>
            <div><input type="image" src=<?php echo $sort=="name_asc" ? "images/double-down.png":"images/double-down-not.png"; ?> name = "sort" value="name_asc" width="10" height="10" /></div>
          </div>

          <h4> E-mail </h4>
          <div class="arrows-title-message">
            <div><input type="image" src=<?php echo $sort=="email_desc" ? "images/double-up.png":"images/double-up-not.png"; ?>  name = "sort" value="email_desc" width="10" height="10"/></div>
            <div><input type="image" src=<?php echo $sort=="email_asc" ? "images/double-down.png":"images/double-down-not.png"; ?> name = "sort" value="email_asc" width="10" height="10" /></div>
          </div>

          <h4> Дата добавления </h4>
          <div class="arrows-title-message">
            <div><input type="image" src=<?php echo $sort=="date_desc" ? "images/double-up.png":"images/double-up-not.png"; ?>  name = "sort" value="date_desc" width="10" height="10"/></div>
            <div><input type="image" src=<?php echo $sort=="date_asc" ? "images/double-down.png":"images/double-down-not.png"; ?> name = "sort" value="date_asc" width="10" height="10" /></div>
          </div>
        </div>
      </form>
     <?php foreach($messages as $message): ?>
        <div class="box-message">
          <div class="title-message">
            <div><?php echo $message['theme'];?></div>
            <div class="push"><?php echo $message['name'];?></div>
            &nbsp;&brvbar;&nbsp;
            <div><?php echo $message['email'];?></div>
            &nbsp;&brvbar;&nbsp;
            <div><?php echo $message['date'];?></div>
          </div>
          <div class="text-message">
            <p><?php echo $message[text]; ?></p>
            <p> <img src=" <?php echo $message['pictures']; ?> " alt=" <?php echo $message['pictures']; ?> ">
                &nbsp;&brvbar;&nbsp;
                <?php echo $message['filepatn']; ?>
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Подвал -->
    <div class="box footer">
      <h3>контакты: иван иванов +111 11 1111111</h3>
    </div>
  </div>

</body>
</html>
