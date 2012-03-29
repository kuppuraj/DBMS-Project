#!/usr/local/bin/php
<?php 
  require_once 'template.php'; 
  echo head('Search Results');
  $input=strtoupper($_GET["phrase"]);
  if ($_GET["start"])
     $start=$_GET["start"];
  else
     $start=1;

  $command='SELECT PID as ID, Name as N, Price as P, Description as D, Image as I  FROM products WHERE UPPER(Name) like \'%'  .$input.  '%\' OR UPPER(Description) like \'%'  .$input.  '%\'';

  //echo $command;
  //echo $start;
  echo list_products($command, $start, './search.php?phrase='.$input.'&start=', 9);
?>
<?php 
  echo foot(); 
?>
