<?php 
function head($title) 
{ 
   session_start();
   $html = "<html> 
   <head>
     <title>" . htmlspecialchars($title) . "</title>
     <meta name=\"description\", Content=\"eMarketting\">
     <link rel=\"stylesheet\" href=\"./styles.css\" media=\"screen\" />
   </head> 
   <body leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">
      <table width=\"100%\" height=\"100%\"  border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
      <tr height=\"65\">
 	<td width=\"207\">
	    <div id=\"logo\">
	    <img src=./graphics/logo.png width=\"207\" height=\"50\"> 
	    </div>
	</td>

	<td>
	<div id=\"navigation\">
	 <div class=\"inner\">
	  <div id=\"searcher\">
	   <form method=\"GET\" action=\"./search.php\">
	    <div><label class=\"netscape4\" for=\"phrase\">Search:</label>
	    <input name=\"phrase\" id=\"phrase\" type=\"text\" size=\"18\" accesskey=\"s\"
		   value=\"e-mart search\" onfocus=\"this.value=''\" />
	    <input type=\"submit\" value=\"Go\" />
	    <a href=\"./advanced.php\">Adv. Search</a>";
   if (session_is_registered(myusername)) {
	   $html .= "<a href=\"./profile.php\">". htmlspecialchars($_SESSION['user_name']) ."</a>";
   }
	    $html .= "</div><!-- unnamed label -->
	   </form>
	  </div><!-- /searcher -->

	  <ul>
	   <li id=\"tabHome\"><a href=\"./home.php\">Home</a></li>
	   <li id=\"tabHotDeals\"><a href=\"./HotDeals.php?cat=-1\">Hot Deals</a></li>
	   <li id=\"tabCart\"><a href=\"./Cart.php\">My Cart</a></li>
	   <li id=\"tabHelp\"><a href=\"./help.php\">Help</a></li>";
if(session_is_registered(myusername)){
	   $html .= "<li id=\"tabLogout\"><a href=\"./logout.php\">Logout</a></li>";
}
else {
	   $html .= "<li id=\"tabLogin\"><a href=\"./login.php\">Login</a></li>";
}	   
	  $html .= "</ul>

	 </div><!-- /inner -->
	</div><!--  /navigation -->
	</td>
      </tr>

      <tr>
      <td height=\"100%\" valign=\"top\">
	<div id=\"sidecol\">";
/*In this section we will populate the categories*/
	$html .= SideColHTML();
	$html .= "</div>
      </td>
      <td height=\"100%\" valign=\"top\">
       <div id=\"mainwindow\">
   ";
   return $html; 
} 

function SideColHTML()
{
  $thtml="<ul>";
  require 'orcl_user_passwd.php';
  $connection = oci_connect($username = $orcl_username,
			  $password = $orcl_password,
			  $connection_string = '//oracle.cise.ufl.edu/orcl');
  if(!$connection) {
	echo "oci_connect failure";
  }

  $statement = oci_parse($connection, 'SELECT * FROM cat');
  oci_execute($statement);
  while (($row = oci_fetch_object($statement))) {
	  $thtml .= '<li><a href="./category.php?cat='.$row->CATEGORYID.'&start=1">'. $row->CATEGORYNAME .'</a></li><br><br>';
  }
  $thtml .= "</ul>";
  //close database
  oci_free_statement($statement);
  oci_close($connection);
  return $thtml;
}

function foot() 
{ 
  $html = "</div>  
  	   </td>
	</tr>
  <tr height=\"40\">
  <td>
  <div id=\"footer\">
  <ul><li></li></ul>
  </div>
  </td>
  <td>
  	<div id=\"footer\">
	   <ul>
             <li id=\"tabAbout\"><a href=\"./About.php\">About</a></li>
             <li id=\"tabCareers\"><a href=\"./Careers.php\">Careers</a></li>
             <li id=\"tabContact\"><a href=\"./Contact.php\">Contact Us</a></li>
             <li id=\"tabLicense\"><a href=\"http://creativecommons.org/licenses/by-nc/3.0/\">License</a></li>
	   </ul>
	</div>
  </td>
  </tr>
  </table>
  </body> 
  </html>"; 
  return $html; 
}

/*
 * Command is expected to provide a table with colums in following order
 * 1. Product Name, varchar
 * 2. Price, int
 * 3. Description
 * 4. Image name
 * 
 * Parameters:
 *	$command: Usual SQL command that should be populated to list
 *	$start:   Refers to starting record number
 *	$link:	  The next and prev links will be <contents of $link>NUMBER
 *		  Where NUMBER will be dynamically generated
 *	#elems:	  Number of records to display
 */
function list_products($command, $start, $link, $elems)
{
  require 'orcl_user_passwd.php';
  $connection = oci_connect($username = $orcl_username,
			  $password = $orcl_password,
			  $connection_string = '//oracle.cise.ufl.edu/orcl');
  if(!$connection) {
    $e = oci_error();
    echo $e['message'];
  }

  /*Augument command reference: http://stackoverflow.com/questions/470542/how-do-i-limit-the-number-of-rows-returned-by-an-oracle-query
   */
  $newcommand='SELECT * FROM ( SELECT a.*, ROWNUM rnum FROM ('   .$command.    ')a WHERE ROWNUM <= '   .($start+$elems-1).  ' ) WHERE rnum  >= ' .$start;

  //var_dump($newcommand);
  $statement = oci_parse($connection, $newcommand);
  oci_execute($statement);

  $html='<div id="list_products">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="5">';
  $color=False;
  $count=0;
  while (($row=oci_fetch_object($statement))) {
    $count=$count+1;
    $color=!$color;
    if ($color) {
      $html .= '<tr style="background-color:#f5f5f5;">';
    } else {
      $html .= '<tr style="background-color:#fff;">';
    }
    $html .= '<td width="50px">
          <img src="./graphics/products/'.$row->I.'" width="50" height="50" style="top">
        </td>
        <td>
          <p class="h1"><a href="./product.php?id='.$row->ID.'">'.$row->N.'</a> </p>
          <p class="h1">'. substr($row->D,0,30).'</p>
          <p class="h2">Price: <font color=#b22222>$'.$row->P.'</font> &nbsp;&nbsp;&nbsp; Customer Rating: <font color=#b8860b>'.(rand(50,100)/20).'</font></p>

        </td>
      </tr>';
  }
  $html .= '<tr><td colspan="2" > <P align="center">';

  if ($start >= $elems) { //populate prev
     $newstart = $start-$elems;
     $html .= '<a href="'.$link.$newstart.'">Prev</a> &nbsp; |';
  }
 
  if ($count >= $elems) { //populate next
     $newstart = $start+$elems;
     $html .= '| &nbsp;<a href="'.$link.$newstart.'">Next</a>';
  }

  $html .= '</p></td></tr></table></div>';

  // VERY important to close Oracle Database Connections and free statements!
  oci_free_statement($statement);
  oci_close($connection);
  return $html;
}


/*
 * while this function generates the catelogy dropdown menu for you 
 * It is YOUR responsibility to write the required javascript named "optionchange(this)"
 * value set to """categoryID""", if all (all categories) is chosen value is set to """-1"""
 *
 * $title:  Page title variable
 */
function category_dropdown($title)
{
  require 'orcl_user_passwd.php';
  $connection = oci_connect($username = $orcl_username,
			  $password = $orcl_password,
			  $connection_string = '//oracle.cise.ufl.edu/orcl');
  if(!$connection) {
    $e = oci_error();
    echo $e['message'];
  }
  $html='<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  	 <td width="200px"><div id="pagetitle">'  .$title.  '</div></td>
	 <td>
	   <div id="dropdown">
	   <label for="sort" class="netscape4" style="font-size:12px;">Sort By: &nbsp;</label>
	   <select id="sort" title="sort" name="sort" onchange="optionchange(this)">
             <option value="-1">ALL</option>';

  $statement = oci_parse($connection, 'SELECT * FROM cat');
  oci_execute($statement);

  while (($row = oci_fetch_object($statement))) {
	  $html .= '<option value="'  .$row->CATEGORYID.  '">'  .$row->CATEGORYNAME.  '</option>';
  }

  $html.='</select></div></td></table>';

  // VERY important to close Oracle Database Connections and free statements!
  oci_free_statement($statement);
  oci_close($connection);
  return $html;
}
?>
