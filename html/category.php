#!/usr/local/bin/php
<?php 
  require_once 'template.php'; 
  echo head('Category');
  $catid=$_GET["cat"];
  $start=$_GET["start"];
  $command='SELECT PID as ID, Name as N, Price as P, Description as D, Image as I  FROM products WHERE CID='.$catid;
  //echo $command;
  //echo $start;
  echo list_products($command, $start, './category.php?cat='.$catid.'&start=', 9);
?>

<?php 
  echo foot(); 
?>
