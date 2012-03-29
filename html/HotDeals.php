#!/usr/local/bin/php

<script type="text/javascript">
function getUrlVars() {
       var vars = {};
       var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
 		   vars[key] = value;
       });
       return vars;
}

function optionchange(selectObj) { 
	// get the index of the selected option 
	var idx = selectObj.selectedIndex; 
	// get the value of the selected option 
	var val = selectObj.options[idx].value; 
	window.location="./HotDeals.php?" +  "cat=" + val;

}
</script>

<?php 
  require_once 'template.php'; 
  echo head('Hot Deals');


  if ($_GET["start"])
     $start=$_GET["start"];
  else
     $start=1;


  $cat=$_GET["cat"];

  
  if ($cat == -1)
     $command='SELECT PID as ID, Name as N, Price as P, Description as D, Image as I  FROM products';
  else
     $command='SELECT PID as ID, Name as N, Price as P, Description as D, Image as I  FROM products WHERE CID='  .$cat;
  
  echo $command;
  echo category_dropdown('Hot Deals!!');
  //echo $start;
  echo list_products($command, $start, './HotDeals.php?cat='  .$cat.  '&start=', 9);
?>

<?php 
  echo foot(); 
?>
