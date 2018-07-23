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
      <form>
        <h4>Имя пользователя *</h4>
        <input class='username' />
        <h4>e-mail*</h4>
        <input class='email' />
        <h4>Текст *</h4>
        <input class='text' />
        <input class='captcha' />
        <h4>Изображение </h4>
        <input class='image' />
        <h4>Файл </h4>
        <input class='file' type='file' />
        <input class='sign-in-button' type='submit' value='Sign In' />
      </form>
    </div>

    <!-- Вывод списка сообщений с учетом заданной сортировки -->
    <div class="box list-messages">
        <div class="title">
          <form>
            <h4> Имя </h4>
            <input class="ascending" type="image" src="images/double-down.png" name = "sort" value="name_ascending" width="10" height="10" />
            <input class="descending" type="image" src="images/double-up.png"  name = "sort" value="name_descending" width="10" height="10"/>
            <h4> E-mail </h4>
            <input class="ascending" type="image" src="images/double-down.png" name = "sort" value="mail_ascending" width="10" height="10" />
            <input class="descending" type="image" src="images/double-up.png"  name = "sort" value="mail_descending" width="10" height="10"/>
            <h4> Дата добавления </h4>
            <input class="ascending" type="image" src="images/double-down.png" name = "sort" value="date_ascending" width="10" height="10" />
            <input class="descending" type="image" src="images/double-up.png"  name = "sort" value="date_descending" width="10" height="10"/>
          </form>
        </div>
     <? //foreach($messages as message) :?>
        <div class="text-message">
          <div class="title-message"><? //=$message[title]; ?></div>
          <div class="title-message">
            <? //=$message[name]; ?>&nbsp;&brvbar;&nbsp;
            <? //=$message[email]; ?>&nbsp;&brvbar;&nbsp;
            <? //=$message[date]; ?>
          </div>
          <div>
            <p><? //=$message['fulltext']; ?></p>
            <p> <img src=" <? //=$message[imgpath]; ?> " alt=" <? //=$message[imgpath]]; ?> ">
                &brvbar;
                <? //=$message[filepatn]; ?>
            </p>
          </div>
        </div>
      <? //endforeach; ?>

    </div>

    <!-- Подвал -->
    <div class="box footer">
      <h3>контакты: иван иванов +111 11 1111111</h3>
    </div>
  </div>

</body>
</html>
