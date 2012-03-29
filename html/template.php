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
	   <form method=\"get\" action=\"http://www.gnu.org/cgi-bin/estseek.cgi\">
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
	   <li id=\"tabHotDeals\"><a href=\"./HotDeals.php\">Hot Deals</a></li>
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
	  $thtml .= '<li><a href="./category.php?cat='.$row->CATEGORYID.'&start=0">'. $row->CATEGORYNAME .'</a></li><br><br>';
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
 */
function list_products($command)
{
  require 'orcl_user_passwd.php';
  $connection = oci_connect($username = $orcl_username,
			  $password = $orcl_password,
			  $connection_string = '//oracle.cise.ufl.edu/orcl');
  if(!$connection) {
    $e = oci_error();
    echo $e['message'];
  }

  $statement = oci_parse($connection, $command);
  oci_execute($statement);

  $html='<div id="list_products">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="5">';
  $color=False;
  while (($row=oci_fetch_object($statement))) {
    $color=!$color;
    if ($color) {
      $html .= '<tr style="background-color:#fAfAfA;">';
    } else {
      $html .= '<tr style="background-color:#fff;">';
    }
    $html .= '<td width="50px">
          <img src="./graphics/products/'.$row->I.'" width="50" height="50" style="top">
        </td>
        <td>
          <p class="h1"><a href="./product.php?id='.$row->ID.'">'.$row->N.'</a> </p>
          <p class="h1">'. substr($row->D,0,30).'</p>
          <p class="h2">Price: <font color=#b22222>$'.$row->P.'</font></p>

        </td>
      </tr>';
  }

  $html .= '</table></div>';

  // VERY important to close Oracle Database Connections and free statements!
  oci_free_statement($statement);
  oci_close($connection);
  return $html;
}

?>
