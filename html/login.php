<?php 
  require_once 'template.php'; 
  echo head('Login'); 
?>
<div id="content">
<form name="loginform" action="login_page.php" onsubmit="return validateForm()" method="POST">
  <table border="3" cellpadding="10" bgcolor=#f5f5f5>
    <tr><td>
    <b><i><font color=blue> Sign in </font></i></b><br></br>
    <table border="0">
      <tr>
        <td><b><font size="2">Username</font></b></td>
      </tr>
      <tr>
        <td><input type="text" name="uname" maxlength="30" style="font-size: 12px;background: #F0F6D6; height: 25px; width: 300px;"/></td>
      </tr>

      <tr height="1"></tr>
      <tr>
        <td><b><font size="2">Password </font></b></td>
      </tr>
      <tr>
        <td><input type="password" name="passwd" maxlength="30" style="font-size: 12px;background: #F0F6D6;height: 25px; width: 300px;"/></td>
      </tr>

      <tr height="1"></tr>
      <tr>
        <td colspan="2">
        <input type="submit" name="login" value="Sign in" style="font-size: 12px;background: #C5C6C9; height: 25px; width: 65px; color:blue; font-color:white; "/>
        </td>
      </tr>
        <td colspan="2">
        <a href="/recover_account.php"><font size="2">Forgot username or password?</font></a>
        </td>
      <tr>
      </tr>
    </table>
    </td></tr>
  </table>
</form>
</div>
<?php 
  echo foot(); 
?>