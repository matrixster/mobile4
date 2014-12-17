<?php
session_start();
require_once('../../bin/w_init.php');

$id = -1;
if (isset($_GET['id'])) $id = intval($_GET['id']);
if (isset($_POST['id'])) $id = intval($_POST['id']);

$oVIP->selfurl = 'org.php';
$oVIP->selfname = 'Profile Management';
$_SESSION[QS]['site_name'] = $oVIP->selfname;

$oDB->Query('SELECT *, O.Contact_ID AS ContactID, I.Industry_ID AS IndustryID FROM organization O 
LEFT JOIN contact C ON O.Contact_ID = C.Contact_ID
LEFT JOIN industry I ON O.Industry_ID = I.Industry_ID
LEFT JOIN user U ON O.Contact_User = U.User_ID 
WHERE O.Org_ID='.$oVIP->orgid);
$row = $oDB->Getrow();

if ( isset($_POST['Save']) )
{
  // check form
	  $strN = trim($_POST['name']); if ( get_magic_quotes_gpc() ) $strN = stripslashes($strN);
	  $strI = intval($_POST['industry']);
	  $strD = trim($_POST['ind']); if ( get_magic_quotes_gpc() ) $strD = stripslashes($strD);
	  $strPd = trim($_POST['pad']); if ( get_magic_quotes_gpc() ) $strPd = stripslashes($strPd);
  	  $strCd = trim($_POST['cad']); if ( get_magic_quotes_gpc() ) $strCd = stripslashes($strCd);
	  $strT = trim($_POST['tel']); if ( get_magic_quotes_gpc() ) $strT = stripslashes($strT);
	  $strF = trim($_POST['city']); if ( get_magic_quotes_gpc() ) $strF = stripslashes($strF);
	  $strCnt = intval($_POST['con']);
	  $strE = trim($_POST['email']); if ( get_magic_quotes_gpc() ) $strE = stripslashes($strE);
	  $strW = trim($_POST['website']); if ( get_magic_quotes_gpc() ) $strW = stripslashes($strW);
	  $strAs = trim($_POST['contact']); if ( get_magic_quotes_gpc() ) $strAs = stripslashes($strAs);
	  $strCmt = trim($_POST['comment']); if ( get_magic_quotes_gpc() ) $strCmt = stripslashes($strCmt);
	  if ( $_POST['active'] == TRUE ) {$strA = '1'; } ELSE { $strA = '0'; }
	  
	  if ( empty($qti_error) )
	  {
		$oDB->Query('UPDATE organization SET 
			Name="'.addslashes($strN).'",
			Industry_ID='.intval($strI).', 
			Industry_="'.addslashes($strD).'",
			Contact_User = '.intval($strAs).',
			Description="'.addslashes($strCmt).'", 
			ModBy='.$oVIP->id.', 
			ModDt="'.date('Y-m-d H:i:s').'"
			WHERE Org_ID='.$oVIP->orgid);
			$oDB->Query('UPDATE contact SET Address_1="'.addslashes($strPd).'", Address_2="'.addslashes($strCd).'", City="'.addslashes($strF).'", Email="'.addslashes($strE).'", Tel_1="'.addslashes($strT).'", Website="'.addslashes($strW).'" WHERE Contact_ID='.intval($strCnt));	
		// exit
	
		unset($_SESSION['qtiGoto']);
		$oVIP->exiturl = "org.php";
		$oVIP->exitname = '';
		$oVIP->EndMessage(NULL,"Profile details saved",$_SESSION[QT]['skin_dir'],2);
  }
}
require_once('../../header.php');
?>
<form id="form1" name="form1" method="post" action="" >
  <table width="100%" border="0" cellspacing="0" cellpadding="4" class="ta ta_o">
    <tr>
      <td width="20%"  class="th_o th_o_first">*Organization Name </td>
      <td width="30%" class="td_o" colspan="3"><input name="name" size="50" type="text" id="name" value="<?php echo $row['Name']; ?>" /></td>
    </tr>
	<tr>
      <td class="th_o th_o_first">Industry</td>
      <td class="td_o" colspan="2"><select name="industry" id="industry">
          <option value="<?php echo $row['IndustryID'];?>"><?php echo $row['Industry'];?></option>
          <?php 
				$oDB->Query('SELECT * FROM industry WHERE ActiveInd=1');
				$row2 = $oDB->Getrow();
				do
				{
					if ($row['IndustryID'] != $row2['Industry_ID']){
						echo '<option value=',$row2['Industry_ID'].'>',$row2['Industry'],'</option>',N;
					}
				}while ( $row2 = $oDB->Getrow() );
				?>
      </select></td>
	  <td class="td_o"><input name="ind" type="text" id="ind" value="<?php echo $row['Industry_']; ?>" /></td>
    </tr>
    <tr>
      <td valign="top" class="th_o th_o_first">Physical Address </td>
      <td class="td_o"><textarea name="pad"><?php echo $row['Address_1']; ?></textarea></td>
      <td valign="top" class="th_o th_o_first">Contact Address </td>
      <td class="td_o"><textarea name="cad"><?php echo $row['Address_2']; ?></textarea><input name="contact" type="hidden" value="<?php echo $row['ContactID']; ?>" /></td>
    </tr>
    <tr>
      <td class="th_o th_o_first">Telephone</td>
      <td class="td_o"><input name="tel" type="text" id="tel" value="<?php echo $row['Tel_1']; ?>" /></td>
      <td class="th_o th_o_first">City</td>
      <td class="td_o"><input name="city" type="text" id="city" value="<?php echo $row['City']; ?>" /></td>
    </tr>
    <tr>
      <td class="th_o th_o_first">Email</td>
      <td class="td_o"><input name="email" type="text" id="email" value="<?php echo $row['Email']; ?>" /></td>
      <td class="th_o th_o_first">Website</td>
      <td class="td_o"><input name="website" type="text" id="website" value="<?php echo $row['Website']; ?>" /></td>
    </tr>
    <tr>
      <td class="th_o th_o_first">Contact Person</td>
      <td class="td_o" colspan="3"><select name="contact" id="contact">
          <option value="<?php echo $row['Contact_User'];?>"><?php echo $row['User'];?></option>
          <?php 
				$oDB->Query('SELECT * FROM user WHERE Closed=0');
				$row2 = $oDB->Getrow();
				do
				{
					if ($row['UserID'] != $row2['User_ID']){
						echo '<option value=',$row2['User_ID'].'>',$row2['User'],'</option>',N;
					}
				}while ( $row2 = $oDB->Getrow() );
				?>
      </select></td>
    </tr>
	<tr>
      <td valign="top" class="th_o th_o_first">Comments</td>
      <td valign="top" class="td_o" colspan="3"><textarea cols="50" name="comment" cols="20" rows="3" id="comment"><?php echo $row['Description']; ?></textarea></td>
    </tr>
    <tr>
      <td class="th_o th_o_first">&nbsp; </td>
      <td class="td_o" colspan="3">
	  <?php //if ($oVIP->CanSave($oVIP->selfurl)==true) {?>
	  <input type="submit" name="Save" value="Save Details"></td>
	  <?php //}?>
	  <input name="con" type="hidden" id="con" value="<?php echo $row['ContactID']; ?>"></td>
    </tr>
  </table>
</form>

<?php 
require_once('../../footer.php');
?>