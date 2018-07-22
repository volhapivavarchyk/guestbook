<!DOCTTYPE>
<html>
<head>
  <title><?=$title; ?> </title>
  <meta name='' content=''>
</head>
<body>
  <h2>HEADER</h2>
  <hr>
  <? foreach($text as $item) :?>
    <h2>
      <a href="index.php?option=view&id=<?=$item['id']; ?>">
        <?= $item['title']; ?>
      </a>
    </h2>
    <p>
      <?= $item['description']; ?>
    </p>
  <? endforeach; ?>
  <hr>
  <h3>FOOTER</h3>
</body>
</html>
