(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app"],{

/***/ "./assets/css/app.css":
/*!****************************!*\
  !*** ./assets/css/app.css ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ "./assets/js/app.js":
/*!**************************!*\
  !*** ./assets/js/app.js ***!
  \**************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ../css/app.css */ "./assets/css/app.css");

$(document).ready(function () {
  var $text = $('#text');
  var $previewMessage = $('#preview-message');
  var $previewButton = $('#preview-button');
  var $textMessage;
  $text.on('focusin', function () {
    console.log($previewMessage.css('opacity'));
    $previewMessage.show().animate({
      opacity: 1
    });
    $('#preview-button').val('   скрыть   ');
  });
  $text.on('focusout', function () {
    console.log($previewMessage.css('opacity'));
    $previewMessage.hide().animate({
      opacity: 0
    });
    $('#preview-button').val('отобразить');
  });
  $text.on('change keyup paste', function () {
    $textMessage = $text.val().replace(/\[italic\](.+?)\[\/italic\]/g, '<i>$1</i>').replace(/\[code\](.+?)\[\/code\]/g, '<code>$1</code>').replace(/\[strike\](.+?)\[\/strike\]/g, '<strike>$1</strike>').replace(/\[strong\](.+?)\[\/strong\]/g, '<strong>$1</strong>').replace(/\[a\s*(\w+\s*=\s*(?:".*?"|'.*?'))\s*\](.*?)\[\s*\/a\s*\]/g, '<a $1>$2</a>');
    $previewMessage.html($textMessage);
  });
  $previewButton.on('click', function () {
    $textMessage = $text.val().replace(/\[italic\](.+?)\[\/italic\]/g, '<i>$1</i>').replace(/\[code\](.+?)\[\/code\]/g, '<code>$1</code>').replace(/\[strike\](.+?)\[\/strike\]/g, '<strike>$1</strike>').replace(/\[strong\](.+?)\[\/strong\]/g, '<strong>$1</strong>').replace(/\[a\s*(\w+\s*=\s*(?:".*?"|'.*?'))\s*\](.*?)\[\s*\/a\s*\]/g, '<a $1>$2</a>');
    $previewMessage.html($textMessage);

    if ($previewMessage.css('opacity') == 0) {
      $previewMessage.show().animate({
        opacity: 1
      });
      $('#preview-button').val('   скрыть   ');
    } else {
      $previewMessage.hide().animate({
        opacity: 0
      });
      $('#preview-button').val('отобразить');
    }
  });
});
/*
 * функция форматирует текст сообщения
 */

function formatTextArea(tag) {
  var field = document.getElementById('text');
  var value = field.value;
  var selected = value.substring(field.selectionStart, field.selectionEnd);
  var before = value.substring(0, field.selectionStart);
  var after = value.substring(field.selectionEnd, field.length);

  if (tag === 'a') {
    field.value = before + '[' + tag + ' href = \"\" title = \"\"]' + selected + '[/' + tag + ']' + after;
  } else {
    field.value = before + '[' + tag + ']' + selected + '[/' + tag + ']' + after;
  }
}

/***/ })

},[["./assets/js/app.js","runtime"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY3NzL2FwcC5jc3MiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2pzL2FwcC5qcyJdLCJuYW1lcyI6WyJyZXF1aXJlIiwiJCIsImRvY3VtZW50IiwicmVhZHkiLCIkdGV4dCIsIiRwcmV2aWV3TWVzc2FnZSIsIiRwcmV2aWV3QnV0dG9uIiwiJHRleHRNZXNzYWdlIiwib24iLCJjb25zb2xlIiwibG9nIiwiY3NzIiwic2hvdyIsImFuaW1hdGUiLCJvcGFjaXR5IiwidmFsIiwiaGlkZSIsInJlcGxhY2UiLCJodG1sIiwiZm9ybWF0VGV4dEFyZWEiLCJ0YWciLCJmaWVsZCIsImdldEVsZW1lbnRCeUlkIiwidmFsdWUiLCJzZWxlY3RlZCIsInN1YnN0cmluZyIsInNlbGVjdGlvblN0YXJ0Iiwic2VsZWN0aW9uRW5kIiwiYmVmb3JlIiwiYWZ0ZXIiLCJsZW5ndGgiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7OztBQUFBLHVDOzs7Ozs7Ozs7OztBQ0FBQSxtQkFBTyxDQUFDLDRDQUFELENBQVA7O0FBRUFDLENBQUMsQ0FBQ0MsUUFBRCxDQUFELENBQVlDLEtBQVosQ0FBa0IsWUFBVztBQUMzQixNQUFNQyxLQUFLLEdBQUdILENBQUMsQ0FBQyxPQUFELENBQWY7QUFDQSxNQUFNSSxlQUFlLEdBQUdKLENBQUMsQ0FBQyxrQkFBRCxDQUF6QjtBQUNBLE1BQU1LLGNBQWMsR0FBR0wsQ0FBQyxDQUFDLGlCQUFELENBQXhCO0FBQ0EsTUFBSU0sWUFBSjtBQUVBSCxPQUFLLENBQUNJLEVBQU4sQ0FBUyxTQUFULEVBQW9CLFlBQU07QUFDeEJDLFdBQU8sQ0FBQ0MsR0FBUixDQUFZTCxlQUFlLENBQUNNLEdBQWhCLENBQW9CLFNBQXBCLENBQVo7QUFDRU4sbUJBQWUsQ0FBQ08sSUFBaEIsR0FBdUJDLE9BQXZCLENBQStCO0FBQUNDLGFBQU8sRUFBQztBQUFULEtBQS9CO0FBQ0FiLEtBQUMsQ0FBQyxpQkFBRCxDQUFELENBQXFCYyxHQUFyQixDQUF5Qixj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R0FBY0ssTUFBTSxHQUFHLEdBQVQsR0FBZVIsR0FBZixHQUFxQixHQUFyQixHQUEyQkksUUFBM0IsR0FBc0MsSUFBdEMsR0FBNENKLEdBQTVDLEdBQWlELEdBQWpELEdBQXVEUyxLQUFyRTtBQUNIO0FBQ0osQyIsImZpbGUiOiJhcHAuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW4iLCJyZXF1aXJlKCcuLi9jc3MvYXBwLmNzcycpO1xyXG5cclxuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XHJcbiAgY29uc3QgJHRleHQgPSAkKCcjdGV4dCcpO1xyXG4gIGNvbnN0ICRwcmV2aWV3TWVzc2FnZSA9ICQoJyNwcmV2aWV3LW1lc3NhZ2UnKTtcclxuICBjb25zdCAkcHJldmlld0J1dHRvbiA9ICQoJyNwcmV2aWV3LWJ1dHRvbicpO1xyXG4gIGxldCAkdGV4dE1lc3NhZ2U7XHJcblxyXG4gICR0ZXh0Lm9uKCdmb2N1c2luJywgKCkgPT4ge1xyXG4gICAgY29uc29sZS5sb2coJHByZXZpZXdNZXNzYWdlLmNzcygnb3BhY2l0eScpKTtcclxuICAgICAgJHByZXZpZXdNZXNzYWdlLnNob3coKS5hbmltYXRlKHtvcGFjaXR5OjF9KTtcclxuICAgICAgJCgnI3ByZXZpZXctYnV0dG9uJykudmFsKCcgICDRgdC60YDRi9GC0YwgICAnKTtcclxuICB9KTtcclxuXHJcbiAgJHRleHQub24oJ2ZvY3Vzb3V0JywgKCkgPT4ge1xyXG4gICAgY29uc29sZS5sb2coJHByZXZpZXdNZXNzYWdlLmNzcygnb3BhY2l0eScpKTtcclxuICAgICAgJHByZXZpZXdNZXNzYWdlLmhpZGUoKS5hbmltYXRlKHtvcGFjaXR5OjB9KTtcclxuICAgICAgJCgnI3ByZXZpZXctYnV0dG9uJykudmFsKCfQvtGC0L7QsdGA0LDQt9C40YLRjCcpO1xyXG4gIH0pO1xyXG5cclxuICAkdGV4dC5vbignY2hhbmdlIGtleXVwIHBhc3RlJywgKCkgPT4ge1xyXG4gICAgICAkdGV4dE1lc3NhZ2UgPSAkdGV4dC52YWwoKVxyXG4gICAgICAgICAgLnJlcGxhY2UoL1xcW2l0YWxpY1xcXSguKz8pXFxbXFwvaXRhbGljXFxdL2csICc8aT4kMTwvaT4nKVxyXG4gICAgICAgICAgLnJlcGxhY2UoL1xcW2NvZGVcXF0oLis/KVxcW1xcL2NvZGVcXF0vZywgJzxjb2RlPiQxPC9jb2RlPicpXHJcbiAgICAgICAgICAucmVwbGFjZSgvXFxbc3RyaWtlXFxdKC4rPylcXFtcXC9zdHJpa2VcXF0vZywgJzxzdHJpa2U+JDE8L3N0cmlrZT4nKVxyXG4gICAgICAgICAgLnJlcGxhY2UoL1xcW3N0cm9uZ1xcXSguKz8pXFxbXFwvc3Ryb25nXFxdL2csICc8c3Ryb25nPiQxPC9zdHJvbmc+JylcclxuICAgICAgICAgIC5yZXBsYWNlKC9cXFthXFxzKihcXHcrXFxzKj1cXHMqKD86XCIuKj9cInwnLio/JykpXFxzKlxcXSguKj8pXFxbXFxzKlxcL2FcXHMqXFxdL2csICc8YSAkMT4kMjwvYT4nKTtcclxuICAgICAgJHByZXZpZXdNZXNzYWdlLmh0bWwoJHRleHRNZXNzYWdlKTtcclxuICB9KTtcclxuXHJcbiAgJHByZXZpZXdCdXR0b24ub24oJ2NsaWNrJywgKCkgPT4ge1xyXG4gICAgICAkdGV4dE1lc3NhZ2UgPSAkdGV4dC52YWwoKS5yZXBsYWNlKC9cXFtpdGFsaWNcXF0oLis/KVxcW1xcL2l0YWxpY1xcXS9nLCAnPGk+JDE8L2k+JylcclxuICAgICAgICAgIC5yZXBsYWNlKC9cXFtjb2RlXFxdKC4rPylcXFtcXC9jb2RlXFxdL2csICc8Y29kZT4kMTwvY29kZT4nKVxyXG4gICAgICAgICAgLnJlcGxhY2UoL1xcW3N0cmlrZVxcXSguKz8pXFxbXFwvc3RyaWtlXFxdL2csICc8c3RyaWtlPiQxPC9zdHJpa2U+JylcclxuICAgICAgICAgIC5yZXBsYWNlKC9cXFtzdHJvbmdcXF0oLis/KVxcW1xcL3N0cm9uZ1xcXS9nLCAnPHN0cm9uZz4kMTwvc3Ryb25nPicpXHJcbiAgICAgICAgICAucmVwbGFjZSgvXFxbYVxccyooXFx3K1xccyo9XFxzKig/OlwiLio/XCJ8Jy4qPycpKVxccypcXF0oLio/KVxcW1xccypcXC9hXFxzKlxcXS9nLCAnPGEgJDE+JDI8L2E+Jyk7XHJcbiAgICAgICRwcmV2aWV3TWVzc2FnZS5odG1sKCR0ZXh0TWVzc2FnZSk7XHJcbiAgICAgIGlmICgkcHJldmlld01lc3NhZ2UuY3NzKCdvcGFjaXR5JykgPT0gMCkge1xyXG4gICAgICAgICAgJHByZXZpZXdNZXNzYWdlLnNob3coKS5hbmltYXRlKHtvcGFjaXR5OjF9KTtcclxuICAgICAgICAgICQoJyNwcmV2aWV3LWJ1dHRvbicpLnZhbCgnICAg0YHQutGA0YvRgtGMICAgJyk7XHJcbiAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAkcHJldmlld01lc3NhZ2UuaGlkZSgpLmFuaW1hdGUoe29wYWNpdHk6MH0pO1xyXG4gICAgICAgICAgJCgnI3ByZXZpZXctYnV0dG9uJykudmFsKCfQvtGC0L7QsdGA0LDQt9C40YLRjCcpO1xyXG4gICAgICB9XHJcbiAgfSk7XHJcbn0pO1xyXG4vKlxyXG4gKiDRhNGD0L3QutGG0LjRjyDRhNC+0YDQvNCw0YLQuNGA0YPQtdGCINGC0LXQutGB0YIg0YHQvtC+0LHRidC10L3QuNGPXHJcbiAqL1xyXG5mdW5jdGlvbiBmb3JtYXRUZXh0QXJlYSh0YWcpXHJcbntcclxuICAgIHZhciBmaWVsZCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCd0ZXh0Jyk7XHJcbiAgICB2YXIgdmFsdWUgID0gZmllbGQudmFsdWU7XHJcbiAgICB2YXIgc2VsZWN0ZWQgPSB2YWx1ZS5zdWJzdHJpbmcoZmllbGQuc2VsZWN0aW9uU3RhcnQsIGZpZWxkLnNlbGVjdGlvbkVuZCk7XHJcbiAgICB2YXIgYmVmb3JlID0gdmFsdWUuc3Vic3RyaW5nKDAsIGZpZWxkLnNlbGVjdGlvblN0YXJ0KTtcclxuICAgIHZhciBhZnRlciA9IHZhbHVlLnN1YnN0cmluZyhmaWVsZC5zZWxlY3Rpb25FbmQsIGZpZWxkLmxlbmd0aCk7XHJcbiAgICBpZiAodGFnID09PSAnYScpIHtcclxuICAgICAgICBmaWVsZC52YWx1ZSA9IGJlZm9yZSArICdbJyArIHRhZyArICcgaHJlZiA9IFxcXCJcXFwiIHRpdGxlID0gXFxcIlxcXCJdJyArIHNlbGVjdGVkICsgJ1svJysgdGFnICsnXScgKyBhZnRlcjtcclxuICAgIH0gZWxzZSB7XHJcbiAgICAgICAgZmllbGQudmFsdWUgPSBiZWZvcmUgKyAnWycgKyB0YWcgKyAnXScgKyBzZWxlY3RlZCArICdbLycrIHRhZyArJ10nICsgYWZ0ZXI7XHJcbiAgICB9XHJcbn1cclxuIl0sInNvdXJjZVJvb3QiOiIifQ==