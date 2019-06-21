<!DOCTTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="гостевая книга, сообщения" />
    <meta name="description" content="Гостевая книга" />
    <title> Гостевая книга </title>
    <link rel="stylesheet" type="text/css" href="<?= DIR_PUBLIC ?>css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= DIR_PUBLIC ?>css/lightbox.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="<?= DIR_PUBLIC ?>js/lightbox.js"></script>
    <script type="text/javascript" src="<?= DIR_PUBLIC ?>js/functions.js"></script>
    <script type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
    <div class="grid">
        <!-- Заголовок -->
        <div class="box grid-header">
            <div class = "header">
                <h1>Гостевая книга</h1>
            </div>
        </div>
        <!-- Форма для ввода нового сообщения -->
        <div class="box grid-add-message">
            <h2>Отправить сообщение</h2>
            <form method="post" action="" class="add-message" enctype="multipart/form-data">
                <div class = "add-message-field">
                    <div class="tooltip">
                        <label for="name">Имя пользователя * </label>
                        <input type="text" name="name" id="name" placeholder="name" minlength="1" maxlength="150" pattern="[A-Za-z0-9\s]*" required />
                        <span class="tooltiptext">Латинские буквы и цифры </span>
                    </div>
                </div>
                <div class = "add-message-field">
                    <div class="tooltip">
                        <label for="email">E-mail * </label>
                        <input type="email" name="email" id="email" placeholder="mailbox@hostname" required />
                        <span class="tooltiptext">Введите e-mail</span>
                    </div>
                </div>
                <div class = "add-message-field">
                    <div class="tooltip">
                        <label for="theme">Тема *</label>
                        <input type="text" name="theme" id="theme" placeholder="тема сообщения" required/>
                        <span class="tooltiptext">Не более 20 символов</span>
                    </div>
                </div>
                <div class="add-message-box-field">
                    <div class = "add-message-field">
                        <div class="tooltip">
                            <label for="text">Текст сообщения * </label>
                            <textarea name="text" id="text" placeholder="текст сообщения" rows="8" cols="46" pattern="[/<\/?[a-z][a-z0-9]*>/i]" required ></textarea><br />
                            <input type="button" value="link" onClick="formatTextArea('a')" style="margin-left:205px; margin-top: 3px;" />
                            <input type="button" value="code" onClick="formatTextArea('code')" />
                            <input type="button" value="italic" onClick="formatTextArea('italic')" />
                            <input type="button" value="strike" onClick="formatTextArea('strike')" />
                            <input type="button" value="strong" onClick="formatTextArea('strong')" />&nbsp;&nbsp;
                            <input type="button" value="отобразить" id="preview-button" />
                            <span class="tooltiptext">Не более 2000 символов</span>
                        </div>
                    </div>
                    <div id="preview-message" class = "add-message-field preview-message"></div>
                </div>
                <div class = "add-message-field">
                    <label for="pictures">Изображение </label>
                    <input type='file' name="pictures" id="pictures" value="" />
                    <span id="fileinfo-img"></span>
                </div>
                <div class = "add-message-field">
                    <label for="filepath">Файл </label>
                    <input type='file' name="filepath" id="filepath" value="" accept=".txt"/>
                    <span id="fileinfo-file"></span>
                </div>
                <div class="g-recaptcha add-message-captcha" data-sitekey="6LfK42cUAAAAAA6G9e1OYjtvCv66ttUqdrU4R3EA"></div>
                <div class="add-message-button">
                    <input type='submit' value='Отравить' name="send" />
                    <input type='submit' value='Сбросить' name="throw" />
                </div>
                <div class = "add-message-field service-info"><?= $added_message ?></div>
            </form>
        </div>
    <!-- Вывод списка сообщений с учетом заданной сортировки -->
        <div class="box grid-list-messages">
            <form>
                <div class="title-message">
                    <h4 class = "title-message-fields"> Имя </h4>
                    <div class="arrows-title-message">
                        <div><input type="image" src=<?= DIR_PUBLIC ?><?=$sort == "name_desc" ? "images/double-up.png": "images/double-up-not.png" ?>  name = "sort" value="name_desc" width="10" height="10"/></div>
                        <div><input type="image" src=<?= DIR_PUBLIC ?><?=$sort == "name_asc" ? "images/double-down.png":"images/double-down-not.png" ?> name = "sort" value="name_asc" width="10" height="10" /></div>
                    </div>
                    <h4 class = "title-message-fields"> E-mail </h4>
                    <div class="arrows-title-message">
                        <div><input type="image" src=<?= DIR_PUBLIC ?><?= $sort == "email_desc" ? "images/double-up.png":"images/double-up-not.png" ?>  name = "sort" value="email_desc" width="10" height="10"/></div>
                        <div><input type="image" src=<?= DIR_PUBLIC ?><?= $sort == "email_asc" ? "images/double-down.png":"images/double-down-not.png" ?> name = "sort" value="email_asc" width="10" height="10" /></div>
                    </div>
                    <h4 class = "title-message-fields"> Дата добавления </h4>
                    <div class="arrows-title-message">
                        <div><input type="image" src=<?= DIR_PUBLIC ?><?= $sort == "date_desc" ? "images/double-up.png":"images/double-up-not.png" ?>  name = "sort" value="date_desc" width="10" height="10"/></div>
                        <div><input type="image" src=<?= DIR_PUBLIC ?><?= $sort == "date_asc" ? "images/double-down.png":"images/double-down-not.png" ?> name = "sort" value="date_asc" width="10" height="10" /></div>
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
                        <a href=# onClick=viewMessages(<?=$i ?>,<?=count($blocksOfMessages)?>) style = "color:unset; text-decoration:none;"><?= $i; ?></a>&nbsp;&nbsp;
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
                               <div class = "title-message-fields" style = "margin-left: auto;"><?= htmlentities($message['name']) ?></div>&nbsp;&brvbar;&nbsp;
                               <div class = "title-message-fields"><?= htmlentities($message['email']) ?></div>&nbsp;&brvbar;&nbsp;
                               <div class = "title-message-fields"><?= htmlentities($message['date']) ?></div>
                           </div>
                           <div class="text-message">
                               <p><?= $message['text'] ?></p>
                               <?php if ($message['pictures'] || $message['filepath']): ?>
                                   <p style = "padding: 2px; margin: 0px;">
                                       <?php if ($message['pictures']): ?>
                                           <a href="<?= DIR_PUBLIC ?>upload/img/<?= htmlentities($message['pictures']) ?>" class="example-image-link" data-lightbox="image-1">
                                           <img class="example-image" src="<?= DIR_PUBLIC ?>upload/img/small/<?= htmlentities($message['pictures'])?>" alt="<?= htmlentities($message['pictures'])?>" /></a>&nbsp;&nbsp;
                                       <?php endif; ?>
                                       <?php if ($message['filepath']): ?>
                                           <a href = "<?= DIR_PUBLIC ?><?= htmlentities($message['filepath']) ?>" type="application/file" style = "text-decoration: none;"><?= htmlentities(basename($message['filepath'])) ?></a>
                                       <?php endif; ?>
                                   </p>
                              <?php endif; ?>
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
                           <a href=# onClick=viewMessages(<?= $i ?>,<?= count($blocksOfMessages) ?>) style = "color:unset; text-decoration:none;"><?= $i; ?></a>&nbsp;&nbsp;
                           </div>
                   <?php endfor;?>
               </div>
           <!-- End Номера страниц для отображения выборки постранично -->
           </form>
        </div>

        <!-- Подвал -->
        <div class="box grid-footer">
           <p class = "text-footer">администратор: иван иванов +111 11 1111111</p>
        </div>
    </div>
</body>
</html>
