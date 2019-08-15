$(document).ready(function() {
  const $text = $('#text');
  const $previewMessage = $('#preview-message');
  const $previewButton = $('#preview-button');
  let $textMessage;

  $text.on('focusin', () => {
    console.log($previewMessage.css('opacity'));
      $previewMessage.show().animate({opacity:1});
      $('#preview-button').val('   скрыть   ');
  });

  $text.on('focusout', () => {
    console.log($previewMessage.css('opacity'));
      $previewMessage.hide().animate({opacity:0});
      $('#preview-button').val('отобразить');
  });

  $text.on('change keyup paste', () => {
      $textMessage = $text.val()
          .replace(/\[italic\](.+?)\[\/italic\]/g, '<i>$1</i>')
          .replace(/\[code\](.+?)\[\/code\]/g, '<code>$1</code>')
          .replace(/\[strike\](.+?)\[\/strike\]/g, '<strike>$1</strike>')
          .replace(/\[strong\](.+?)\[\/strong\]/g, '<strong>$1</strong>')
          .replace(/\[a\s*(\w+\s*=\s*(?:".*?"|'.*?'))\s*\](.*?)\[\s*\/a\s*\]/g, '<a $1>$2</a>');
      $previewMessage.html($textMessage);
  });

  $previewButton.on('click', () => {
      $textMessage = $text.val().replace(/\[italic\](.+?)\[\/italic\]/g, '<i>$1</i>')
          .replace(/\[code\](.+?)\[\/code\]/g, '<code>$1</code>')
          .replace(/\[strike\](.+?)\[\/strike\]/g, '<strike>$1</strike>')
          .replace(/\[strong\](.+?)\[\/strong\]/g, '<strong>$1</strong>')
          .replace(/\[a\s*(\w+\s*=\s*(?:".*?"|'.*?'))\s*\](.*?)\[\s*\/a\s*\]/g, '<a $1>$2</a>');
      $previewMessage.html($textMessage);
      if ($previewMessage.css('opacity') == 0) {
          $previewMessage.show().animate({opacity:1});
          $('#preview-button').val('   скрыть   ');
      } else {
          $previewMessage.hide().animate({opacity:0});
          $('#preview-button').val('отобразить');
      }
  });
});
/*
форматирование текста сообщения тэгами
(тэг)
*/
function formatTextArea(tag)
{
var field = document.getElementById('text');
var value  = field.value;
var selected = value.substring(field.selectionStart, field.selectionEnd);
var before = value.substring(0, field.selectionStart);
var after = value.substring(field.selectionEnd, field.length);
if (tag === 'a') {
field.value = before + '[' + tag + ' href = \"\" title = \"\"]' + selected + '[/'+ tag +']' + after;
} else {
field.value = before + '[' + tag + ']' + selected + '[/'+ tag +']' + after;
}
}
