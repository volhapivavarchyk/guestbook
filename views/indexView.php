<!DOCTTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="гостевая книга, сообщения" />
  <meta name="description" content="Гостевая книга" />
  <title> Гостевая книга </title>
  <link rel="stylesheet" type="text/css" href="views/css/style.css">
  <link rel="stylesheet" type="text/css" href="views/css/lightbox.min.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="views/js/lightbox-plus-jquery.min.js"></script>
  <script type="text/javascript" src="views/js/functions.js"></script>
</head>
<body>

  <div class="grid">
    <!-- Заголовок -->
    <div class="box header">
      <h1>Гостевая книга</h1>
    </div>

    <!-- Форма для ввода нового сообщения -->
    <div class="box add-message">
      <form method="post" action="" class="add-message" enctype="multipart/form-data">
        <p><label for="name">Имя пользователя * </label>
        <input type="text" name="name" id="name" placeholder="name" minlength="1" maxlength="150" pattern="[A-Za-z0-9]" required /></p>
        <p><label for="email">E-mail * </label>
        <input type="email" name="email" id="email" placeholder="mailbox@hostname" required /></p>
        <p><label for="theme">Тема *</label>
        <input type="text" name="theme" id="theme" placeholder="тема сообщения" required/></p>
        <p><label for="text">Содержание * </label>
        <textarea name="text" id="text" placeholder="содержание сообщения" rows="8" cols="46" pattern="[/<\/?[a-z][a-z0-9]*>/i]" onkeyup="viewText()" onfocus="previewMessage()" required ></textarea>
        <div id="preview-message" style="display:none">11</div>
        <br />
        <input type="button" value="link" onClick="formatTextArea('a')" style="margin-left:205px;" />
        <input type="button" value="code" onClick="formatTextArea('code')" />
        <input type="button" value="italic" onClick="formatTextArea('i')" />
        <input type="button" value="strike" onClick="formatTextArea('strike')" />
        <input type="button" value="strong" onClick="formatTextArea('strong')" />
        <input type="button" value="preview" id="preview-button" />
        </p>
        <p><label for="pictures">Изображение </label>
        <input type='file' name="pictures" id="pictures" value="" onchange="isFileImg()"/>
        <span id="fileinfo-img"></span></p>
        <p><label for="filepath">Файл </label>
        <input type='file' name="filepath" id="filepath" value="" onchange="isFileTxt()" accept=".txt"/>
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
            <div><input type="image" src=<?=$sort == "name_desc" ? "views/images/double-up.png": "views/images/double-up-not.png" ?>  name = "sort" value="name_desc" width="10" height="10"/></div>
            <div><input type="image" src=<?=$sort == "name_asc" ? "views/images/double-down.png":"views/images/double-down-not.png" ?> name = "sort" value="name_asc" width="10" height="10" /></div>
          </div>

          <h4> E-mail </h4>
          <div class="arrows-title-message">
            <div><input type="image" src=<?= $sort == "email_desc" ? "views/images/double-up.png":"views/images/double-up-not.png" ?>  name = "sort" value="email_desc" width="10" height="10"/></div>
            <div><input type="image" src=<?= $sort == "email_asc" ? "views/images/double-down.png":"views/images/double-down-not.png" ?> name = "sort" value="email_asc" width="10" height="10" /></div>
          </div>

          <h4> Дата добавления </h4>
          <div class="arrows-title-message">
            <div><input type="image" src=<?= $sort == "date_desc" ? "views/images/double-up.png":"views/images/double-up-not.png" ?>  name = "sort" value="date_desc" width="10" height="10"/></div>
            <div><input type="image" src=<?= $sort == "date_asc" ? "views/images/double-down.png":"views/images/double-down-not.png" ?> name = "sort" value="date_asc" width="10" height="10" /></div>
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
            <p>
              <a class="example-image-link" href="upload/img/<?= htmlentities($message['pictures']) ?>" data-lightbox="example-1">
              <img class="example-image"  src="upload/img/small/<?= htmlentities($message['pictures']) ?>" alt=" <?= htmlentities($message['pictures']) ?> " />
              </a>
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
