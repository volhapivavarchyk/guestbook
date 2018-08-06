<!DOCTTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="гостевая книга, сообщения" />
  <meta name="description" content="Гостевая книга" />
  <title> Гостевая книга </title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
<script>
  function isFileImg()
  {
    var pictures = document.getElementById("pictures").files[0];
    if (!(pictures.type == "image/jpeg") && !(pictures.type == "image/png") && !(pictures.type == "image/gif")){
      event.target.value='';
      document.getElementById("fileinfo-img").innerHTML = "<span style='color: red; font-size: 10px;'>Допустимые форматы файлов jpg, gif, png</span> ";
    }
  }

  function isFile()
  {
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

  function viewMessages(rank, count)
  {
    for (i=1; i<=count; i++) {
      if (i != rank) {
        document.getElementById('visability'+i).className = 'displayNone';
        document.getElementById('number'+i).style.color = 'black';
        document.getElementById('number_foot'+i).style.color = 'black';
      } else {
        document.getElementById('visability'+i).className = '';
        document.getElementById('number'+i).style.color = '#006699';
        document.getElementById('number_foot'+i).style.color = '#006699';
      }
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
        <input type="text" name="name" id="name" required minlength="1" maxlength="150" pattern="[A-Za-z0-9]" /></p>
        <p><label for="email">E-mail * </label>
        <input type="email" name="email" id="email" required /></p>
        <p><label for="theme">Тема *</label>
        <input type="text" name="theme" id="theme" required/></p>
        <p><label for="text">Содержание * </label>
        <textarea rows="8" cols="46" name="text" id="text" required ></textarea></p>
        <p><label for="pictures">Изображение </label>
        <input type='file' name="pictures" id="pictures" value="" onchange="isFileImg()"/>
        <span id="fileinfo-img"></span></p>
        <p><label for="filepath">Файл </label>
        <input type='file' name="filepath" id="filepath" value="" onchange="isFile()"/>
        <span id="fileinfo-file"></span></p>
        <div class="g-recaptcha" style="margin-left: 200px; margin-bottom: 10px;" data-sitekey="6LfK42cUAAAAAA6G9e1OYjtvCv66ttUqdrU4R3EA"></div>
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

      <!-- Номера страниц для отображения выборки постранично -->
      <div class="title-message">
       <?php for($i=1; $i<=count($blocksOfMessages); $i++): ?>
         <?php if ($i == 1): ?>
           <div id="number<?= $i; ?>" style="color:#006699; font-size: 0.8em; font-weight: bold; ">
         <?php else: ?>
            <div id="number<?= $i; ?>" style="color:black; font-size: 0.8em; font-weight: bold;">
         <?php endif;?>
         <a href=# onClick=viewMessages(<?=$i ?>,<?=count($blocksOfMessages)?>) style = "color:unset; text-decoration:none;">
            <?= $i; ?>
         </a>
         &nbsp;&nbsp;
         </div>
       <?php endfor;?>
      </div>
      <!-- End Номера страниц для отображения выборки постранично -->

     <?php
         $i=1;
         $visable="";
     ?>
     <?php foreach($blocksOfMessages as $blockOfMessages): ?>
        <div id="visability<?= $i; ?>" <?= $visable; ?>>
        <?php foreach ($blockOfMessages as $message): ?>
          <div class = "box-message">
          <div class="title-message">
            <div><?= htmlentities($message['theme']) ?></div>
            <div class="push"><?= htmlentities($message['name']) ?></div>
            &nbsp;&brvbar;&nbsp;
            <div><?= htmlentities($message['email']) ?></div>
            &nbsp;&brvbar;&nbsp;
            <div><?=htmlentities($message['date']) ?></div>
          </div>
          <div class="text-message">
            <p><?= htmlentities($message['text']) ?></p>
            <p> <img src=" <?= htmlentities($message['pictures']) ?> " alt=" <?= htmlentities($message['pictures']) ?> ">
                &nbsp;&brvbar;&nbsp;
                <?= htmlentities($message['filepath']) ?>
            </p>
          </div>
          </div>
        <?php endforeach; ?>
        <?php
            $i += 1;
            $visable = "class = 'displayNone'";
        ?>
        </div>
      <?php endforeach; ?>
      <form>
        <!-- Номера страниц для отображения выборки постранично -->
        <div class="title-message">
         <?php for($i=1; $i<=count($blocksOfMessages); $i++): ?>
           <?php if ($i == 1): ?>
             <div id="number_foot<?= $i; ?>" style="color:#006699; font-size: 0.8em; font-weight: bold; ">
           <?php else: ?>
              <div id="number_foot<?= $i; ?>" style="color:black; font-size: 0.8em; font-weight: bold;">
           <?php endif;?>
           <a href=# onClick=viewMessages(<?= $i ?>,<?= count($blocksOfMessages) ?>) style = "color:unset; text-decoration:none;">
              <?= $i; ?>
           </a>
           &nbsp;&nbsp;
           </div>
         <?php endfor;?>
        </div>
        <!-- End Номера страниц для отображения выборки постранично -->
      </form>
    </div>

    <!-- Подвал -->
    <div class="box footer">
      <h3>контакты: иван иванов +111 11 1111111</h3>
    </div>
  </div>

</body>

<script src='https://www.google.com/recaptcha/api.js'></script>
</html>
