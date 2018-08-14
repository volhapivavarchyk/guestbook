function isFileImg()
{
  var pictures = document.getElementById("pictures").files[0];
  if (!(pictures.type == "image/jpeg") && !(pictures.type == "image/png") && !(pictures.type == "image/gif")){
    event.target.value='';
    document.getElementById("fileinfo-img").innerHTML = "<span style='color: red; font-size: 10px;'>Допустимые форматы файлов jpg, gif, png</span> ";
  }
}

function isFileTxt()
{
  var filepath = document.getElementById("filepath").files[0];
  if (filepath.type != "text/plain"){
    event.target.value='';
    document.getElementById("fileinfo-file").innerHTML = "<span style='color: red; font-size: 10px;'>Допустимый формат файла txt.</span> ";
  }
  if (filepath.size > 100*1024){
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

function formatTextArea(tag)
{
  var field = document.getElementById('text');
  var value  = field.value;
  var selected = value.substring(field.selectionStart, field.selectionEnd);
  var before = value.substring(0, field.selectionStart);
  var after = value.substring(field.selectionEnd, field.length);
  if (tag == 'a') {
    field.value = before + '[' + tag + ' href = \"\" title = \"\"]' + selected + '[/'+ tag +']';
    //field.value = '${before} [${tag} href = "" title = ""] ${selected} [/${tag}]';
  } else {
    field.value = before + '[' + tag + ']' + selected + '[/'+ tag +']';
    //field.value = '${before} [${tag}] ${selected} [/${tag}]';
  }
}

/* Предпросмотр комментария*/
function previewMessage()
{
  var $text = document.getElementById('text');
  $text.parent().after('<div id="viewtext"></div>');
}

function viewText()
{
  var $viewtext = document.getElementById('viewtext');
  var $text = document.getElementById('text').value;
  $viewtext.innerHTML = $text;
  /*
  $viewtext.innerHTML = $text
    .replace(/\[code\](.+?)\[\/code\]/g, '<code>$1</code>')
    .replace(/\[i\](.+?)\[\/i\]/g, '<i>$1</i>')
    .replace(/\[strike\](.+?)\[\/strike\]/g, '<strike>$1</strike>')
    .replace(/\[strong\](.+?)\[\/strong\]/g, '<strong>$1</strong>');
  */
}

function preview()
{
  var $viewtext = document.getElementById('preview-message');
  var $text = document.getElementById('text').value;
  console.log($text);
  $viewtext.innerHTML = $text
    .replace(/\[code\](.+?)\[\/code\]/g, '<code>$1</code>')
    .replace(/\[i\](.+?)\[\/i\]/g, '<i>$1</i>')
    .replace(/\[strike\](.+?)\[\/strike\]/g, '<strike>$1</strike>')
    .replace(/\[strong\](.+?)\[\/strong\]/g, '<strong>$1</strong>');

}

$(document).ready(() => {
  const $previewButton = $('#preview-button');
  const $previewMessage = $('.preview-message');

  $previewButton.on('click', () => {
    $text = $('#text').val()
      .replace(/\[i\](.+?)\[\/i\]/g, '<i>$1</i>')
      .replace(/\[code\](.+?)\[\/code\]/g, '<code>$1</code>')
      .replace(/\[strike\](.+?)\[\/strike\]/g, '<strike>$1</strike>')
      .replace(/\[strong\](.+?)\[\/strong\]/g, '<strong>$1</strong>')
      .replace(/\[a\s*(\w+\s*=\s*(?:".*?"|'.*?'))\s*\](.*?)\[\s*\/a\s*\]/g, '<a $1>$2</a>');
    $previewMessage.html($text);
    if ($previewMessage.css('opacity') == 0) {
      $previewMessage.toggle().animate({opacity:1});
    } else {
      $previewMessage.toggle().animate({opacity:0});
    }
  });
});
