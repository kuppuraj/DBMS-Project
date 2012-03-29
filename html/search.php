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
	var phrase=getUrlVars()["phrase"];
	window.location="./search.php?phrase="+phrase+"&sortby="+val;

}
</script>

<?php 
  require_once 'template.php'; 
  echo head('Search Results');

  $input=strtoupper($_GET["phrase"]);

  if ($_GET["start"])
     $start=$_GET["start"];
  else
     $start=1;

  if ($_GET["sortby"])
     $sortby=$_GET["sortby"];

  
  if ($sortby == "price-min") {
       $command='SELECT PID as ID, Name as N, Price as P, Description as D, Image as I  FROM products WHERE UPPER(Name) like \'%'  .$input.  '%\' OR UPPER(Description) like \'%'  .$input.  '%\' order by Price ASC';
  }
  else if ($sortby == "price-max") {
       $command='SELECT PID as ID, Name as N, Price as P, Description as D, Image as I  FROM products WHERE UPPER(Name) like \'%'  .$input.  '%\' OR UPPER(Description) like \'%'  .$input.  '%\' order by Price DESC';
  }
  else {
       $command='SELECT PID as ID, Name as N, Price as P, Description as D, Image as I  FROM products WHERE UPPER(Name) like \'%'  .$input.  '%\' OR UPPER(Description) like \'%'  .$input.  '%\'';
  }
  

echo '<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <td width="200px"><div id="pagetitle">Search Results</div></td>
  <td>
   <div id="dropdown">
   <label for="sort" class="netscape4" style="font-size:12px;">Sort By: &nbsp;</label>
   <select id="sort" title="sort" name="sort" onchange="optionchange(this)">
     <option value="none">None</option>
     <option value="price-min">Price: Low to high</option>
     <option value="price-max">Price: High to Low</option>
     <option value="cust">Customer rating</option>
   </select></div></td></table>';

  //echo $command;
  //echo $start;
  echo list_products($command, $start, './search.php?phrase='  .$input.  '&sortby='  .$sortby.  '&start=', 9);
?>

<?php 
  echo foot(); 
?>
