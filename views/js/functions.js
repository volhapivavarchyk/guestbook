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
  field.value = before + '[' + tag + ']' + selected + '[/'+ tag +']';
}


/* Предпросмотр комментария*/
$(document).ready(function() {
	$('#text').on('focus',function() {
		$('#text').parent().after('<div id="ctext"></div>');
	});

	//var a = document.documentElement.innerHTML; - ýòî âðîäå êàê äëÿ èñõîäíîãî êîäà, íî òî÷íî íå çíàþ, êòî ïðèäóìàåò êàê ñäåëàòü ïðåäïðîñìîòð èñõîäíîãî êîäà - îòïèøèòå â ICQ 817233

	var comment = '';
	$('#text').keyup(function() {
		comment = $j(this).val();
		comment = comment.
		.replace(/\[code\](.+?)\[\/code\]/g, '<code>$1</code>')
		.replace(/\[i\](.+?)\[\/i\]/g, '<i>$1</i>')
		.replace(/\[strike\](.+?)\[\/strike\]/g, '<strike>$1</strike>')
		.replace(/\[strong\](.+?)\[\/strong\]/g, '<strong>$1</strong>');
		$('#ctext').html(comment);
	});
