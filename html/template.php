<?php 
function head($title) 
{ 
   $html = "<html> 
   <head>
     <title>" . htmlspecialchars($title) . "</title>
     <meta name=\"description\", Content=\"eMarketting\">
     <link rel=\"stylesheet\" href=\"/styles.css\" media=\"screen\" />
   </head> 
   <body leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">
      <table width=\"100%\" height=\"100%\"  border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
      <tr height=\"65\">
 	<td width=\"207\">
	    <div id=\"logo\">
	    <img src=graphics/logo.png width=\"207\" height=\"50\"> 
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
	    <input type=\"submit\" value=\"Search\" />
	    <a href=\"Advanced\">Advanced Search</a>
	    </div><!-- unnamed label -->
	   </form>
	  </div><!-- /searcher -->

	  <ul>
	   <li id=\"tabHome\"><a href=\"/home.php\">My Home</a></li>
	   <li id=\"tabHotDeals\"><a href=\"/HotDeals.php\">Hot Deals</a></li>
	   <li id=\"tabProfile\"><a href=\"/profile.php\">Profile</a></li>
	   <li id=\"tabCart\"><a href=\"/Cart.php\">My Cart</a></li>
	   <li id=\"tabHelp\"><a href=\"/help.php\">Help</a></li>
	   <li id=\"tabLogout\"><a href=\"/logout.php\">Logout</a></li>
	  </ul>

	 </div><!-- /inner -->
	</div><!--  /navigation -->
	</td>
      </tr>

      <tr>
      <td height=\"100%\" valign=\"top\">
	<div id=\"sidecol\">
	side column
	</div>
      </td>
      <td height=\"100%\" valign=\"top\">
   "; 
   return $html; 
} 

function foot() 
{ 
  $html = "  </td>
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
             <li id=\"tabAbout\"><a href=\"/About.php\">About</a></li>
             <li id=\"tabCorporate\"><a href=\"/Corporate.php\">Corporate Information</a></li>
             <li id=\"tabCareers\"><a href=\"/Careers.php\">Careers</a></li>
             <li id=\"tabContact\"><a href=\"/Contact.php\">Contact Us</a></li>
             <li id=\"tabLicense\"><a href=\"/License.php\">License</a></li>
	   </ul>
	</div>
  </td>
  </tr>
  </table>
  </body> 
  </html>"; 
  return $html; 
}
?>
