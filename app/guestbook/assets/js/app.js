import '../css/app.scss';

import $ from 'jquery';
global.$ = global.jQuery = $;
import 'bootstrap';
import 'popper.js';
import 'ekko-lightbox';

$(function() {
    $.fn.addTag = function (tag, text) {
        var value ;
        var selected = text.val().substr(text.prop('selectionStart'), text.prop('selectionEnd'));
        var before = text.val().substr(0, text.prop('selectionStart'));
        var after = text.val().substr(text.prop('selectionEnd'), text.length);

        tag = (tag === 'link') ? 'a' : tag;
        value = before + '[' + tag;
        value += (tag === 'a') ? ' href = \"\" title = \"\"]' : ']';
        value += selected + '[/'+tag+']' + after;
        text.val(value);
    };
    $.fn.showPreviewMessage = function(previewMessage, previewButton) {
        previewMessage.show().animate({
          opacity: 1
        });
        previewButton.val('   скрыть   ');
    };
    $.fn.hidePreviewMessage = function(previewMessage, previewButton) {
        previewMessage.hide().animate({
          opacity: 0
        });
        previewButton.val('отобразить');
    };
});

$(document).ready(function() {

    let $textMessage;
    const $text = $('#text');
    const $previewMessage = $('#preview-message');
    const $previewButton = $('#preview-button');

    $text.on('focusin', () => {
        $(this).showPreviewMessage($previewMessage, $previewButton);
    });

    $text.on('focusout', () => {
        $(this).hidePreviewMessage($previewMessage, $previewButton);
    });

    $text.on('change keyup paste', () => {
        $textMessage = $text.val()
              .replace(/\[italic\](.*?)\[\/italic\]/g, '<i>$1</i>')
              .replace(/\[code\](.*?)\[\/code\]/g, '<code>$1</code>')
              .replace(/\[strike\](.*?)\[\/strike\]/g, '<strike>$1</strike>')
              .replace(/\[strong\](.*?)\[\/strong\]/g, '<strong>$1</strong>')
              .replace(/\[a\s*(\w+\s*=\s*(?:".*?"|'.*?'))\s*\](.*?)\[\s*\/a\s*\]/g, '<a $1>$2</a>');
        $previewMessage.html($textMessage);
    });

    $previewButton.on('click', () => {
      $textMessage = $text.val().replace(/\[italic\](.+?)\[\/italic\]/g, '<i>$1</i>')
              .replace(/\[code\](.*?)\[\/code\]/g, '<code>$1</code>')
              .replace(/\[strike\](.*?)\[\/strike\]/g, '<strike>$1</strike>')
              .replace(/\[strong\](.*?)\[\/strong\]/g, '<strong>$1</strong>')
              .replace(/\[a\s*(\w+\s*=\s*(?:".*?"|'.*?'))\s*\](.*?)\[\s*\/a\s*\]/g, '<a $1>$2</a>');
        $previewMessage.html($textMessage);
        if ($previewMessage.css('opacity') == 0) {
              $(this).showPreviewMessage($previewMessage, $previewButton);
        } else {
              $(this).hidePreviewMessage($previewMessage, $previewButton);
        }
    });

    $('#link-button, #code-button, #italic-button, #strike-button, #strong-button').on('mousedown', function (event) {
      // for event onClick
      //var tag = $(this)[0].activeElement.attributes[1].nodeValue;
      // for event mousedown
        var tag = $(event.target)[0].attributes[1].nodeValue;
        if (event.which === 1) {
              $(this).addTag(tag, $text);
        }
    });

    $('#link-button, #code-button, #italic-button, #strike-button, #strong-button').on('mouseup', function (event) {
        $(this).showPreviewMessage($previewMessage, $previewButton);
    });

    $('[data-toggle="lightbox"]').on('click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
});
