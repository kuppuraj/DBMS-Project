#!/usr/local/bin/php
<?php 
  require_once 'template.php'; 
  echo head('Home Page'); 
  Print_r($_SESSION);
?>
<p>This is where the dynamic content goes for this page.</p> 
<?php 
  echo foot(); 
?>
