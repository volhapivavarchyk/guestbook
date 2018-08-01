<!DOCTTYPE html>
<html>
<head>
  <title> Гостевая книга </title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="гостевая книга, сообщения" />
  <meta name="description" content="Гостевая книга" />
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script>
  function isFileImg(){
    var pictures = document.getElementById("pictures").files[0];
    if (!(pictures.type == "image/jpeg") && !(pictures.type == "image/png") && !(pictures.type == "image/gif")){
      event.target.value='';
      document.getElementById("fileinfo-img").innerHTML = "<span style='color: red; font-size: 10px;'>Допустимые форматы файлов jpg, gif, png</span> ";
    }
  }

  function isFile(){
    var filepath = document.getElementById("filepath").files[0];
    if (!(filepath.type == "text/plain")){
      event.target.value='';
      document.getElementById("fileinfo-file").innerHTML = "<span style='color: red; font-size: 10px;'>Допустимый формат файла txt.</span> ";
    }
    if (!(filepath.size >100*1024)){
      event.target.value='';
      document.getElementById("fileinfo-file").innerHTML += "<span style='color: red; font-size: 10px;'>Допустимый размер файла 100 Кб</span> ";
    }
  }
  </script>

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
        <input type="text" name="name" id="name" required  /></p>
        <p><label for="email">E-mail * </label>
        <input type="email" name="email" id="email" required /></p>
        <p><label for="theme">Тема *</label>
        <input type="text" name="theme" id="theme" required/></p>
        <p><label for="text">Текст * </label>
        <textarea rows="8" cols="46" name="text" id="text" required ></textarea></p>
        <p><label for="pictures">Изображение </label>
        <input type='file' name="pictures" id="pictures" value="" onchange="isFileImg()"/>
        <div id="fileinfo-img" style="margin-left: 200px;"></div></p>
        <p><label for="filepath">Файл </label>
        <input type='file' name="filepath" id="filepath" value="" onchange="isFile()"/>
        <div id="fileinfo-file" style="margin-left: 200px;"></div></p>
        <p><label for="captcha">Текст на изображении *</label>
        <input type='text' name="captcha" id="captcha" /></p>
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
            <div><input type="image" src=<?=$sort == "name_desc" ? "images/double-up.png": "images/double-up-not.png" ?>  name = "sort" value="name_desc" width="10" height="10"/></div>
            <div><input type="image" src=<?=$sort == "name_asc" ? "images/double-down.png":"images/double-down-not.png" ?> name = "sort" value="name_asc" width="10" height="10" /></div>
          </div>

          <h4> E-mail </h4>
          <div class="arrows-title-message">
            <div><input type="image" src=<?= $sort == "email_desc" ? "images/double-up.png":"images/double-up-not.png" ?>  name = "sort" value="email_desc" width="10" height="10"/></div>
            <div><input type="image" src=<?= $sort == "email_asc" ? "images/double-down.png":"images/double-down-not.png" ?> name = "sort" value="email_asc" width="10" height="10" /></div>
          </div>

          <h4> Дата добавления </h4>
          <div class="arrows-title-message">
            <div><input type="image" src=<?= $sort == "date_desc" ? "images/double-up.png":"images/double-up-not.png" ?>  name = "sort" value="date_desc" width="10" height="10"/></div>
            <div><input type="image" src=<?= $sort == "date_asc" ? "images/double-down.png":"images/double-down-not.png" ?> name = "sort" value="date_asc" width="10" height="10" /></div>
          </div>
        </div>
      </form>
     <?php foreach($messages as $message): ?>
        <div class="box-message">
          <div class="title-message">
            <div><?= $message['theme']?></div>
            <div class="push"><?= $message['name']?></div>
            &nbsp;&brvbar;&nbsp;
            <div><?= $message['email'] ?></div>
            &nbsp;&brvbar;&nbsp;
            <div><?= $message['date'] ?></div>
          </div>
          <div class="text-message">
            <p><?= $message['text'] ?></p>
            <p> <img src=" <?= $message['pictures'] ?> " alt=" <?= $message['pictures'] ?> ">
                &nbsp;&brvbar;&nbsp;
                <?= $message['filepath'] ?>
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
