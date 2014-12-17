<?php
session_start();
require_once('../../bin/w_init.php');

$id = -1;
if (isset($_GET['id'])) $id = intval($_GET['id']);
if (isset($_POST['id'])) $id = intval($_POST['id']);

if ($id==-1) {
	$orgid = $oVIP->orgid;
}else{
	$orgid = $id;
}
$parent=0;

$oVIP->selfurl = 'profile.php';
$oVIP->selfname = 'Organization profile';
$_SESSION[QS]['site_name'] = $oVIP->selfname;

if ($oVIP->id==0) $oVIP->EndMessage('!','Please login to view this page',$_SESSION[QT]['skin_dir'],0);

$oDB->Query('SELECT * FROM sf_credentials WHERE Org_ID='.$oVIP->orgid);
$row2 = $oDB->Getrow();

$oDB->Query('SELECT *, A.Contact_ID AS ContactID, A.Industry_ID AS IndustryID FROM organization A 
LEFT JOIN industry I ON A.Industry_ID = I.Industry_ID
LEFT JOIN contact C ON A.Contact_ID = C.Contact_ID
WHERE Org_ID='.$orgid);
$row = $oDB->Getrow();

$oDC->Query('SELECT count(Org_ID) AS Parent FROM `organization` WHERE Parent_ID = '.$oVIP->orgid);
$row1 = $oDC->Getrow();
if ($row1['Parent'] > 0) $parent=1;

// AND A.CreateBy IN (SELECT User_ID FROM `user` WHERE Org_ID='.$oVIP->orgid.')
if ( isset($_POST['Save']) )
{
  // check form
	  $strN = trim($_POST['name']); if ( get_magic_quotes_gpc() ) $strN = stripslashes($strN);
	  $strI = trim($_POST['industry']); if ( get_magic_quotes_gpc() ) $strI = stripslashes($strI);
	  $strR = trim($_POST['location']); if ( get_magic_quotes_gpc() ) $strR = stripslashes($strR);
	  $strCmt = trim($_POST['comment']); if ( get_magic_quotes_gpc() ) $strCmt = stripslashes($strCmt);
	  $strPd = trim($_POST['pad']); if ( get_magic_quotes_gpc() ) $strPd = stripslashes($strPd);
  	  $strCd = trim($_POST['cad']); if ( get_magic_quotes_gpc() ) $strCd = stripslashes($strCd);
	  $strT = trim($_POST['tel']); if ( get_magic_quotes_gpc() ) $strT = stripslashes($strT);
	  $strF = trim($_POST['city']); if ( get_magic_quotes_gpc() ) $strF = stripslashes($strF);
	  $strCnt = trim($_POST['contact']); if ( get_magic_quotes_gpc() ) $strCnt = stripslashes($strCnt);
	  $strE = trim($_POST['email']); if ( get_magic_quotes_gpc() ) $strE = stripslashes($strE);
	  $strW = trim($_POST['website']); if ( get_magic_quotes_gpc() ) $strW = stripslashes($strW);
	  $strAs = trim($_POST['assigned']); if ( get_magic_quotes_gpc() ) $strAs = stripslashes($strAs);
	  $strS = trim($_POST['status']); if ( get_magic_quotes_gpc() ) $strS = stripslashes($strS);
	  $strL = trim($_POST['perioda']); if ( get_magic_quotes_gpc() ) $strL = stripslashes($strL);
	  $strNf = trim($_POST['username']); if ( get_magic_quotes_gpc() ) $strNf = stripslashes($strNf);
	  $strPf = trim($_POST['password']); if ( get_magic_quotes_gpc() ) $strPf = stripslashes($strPf);
	  $strTf = trim($_POST['token']); if ( get_magic_quotes_gpc() ) $strTf = stripslashes($strTf);
	  
	  if ( $_POST['active'] == TRUE ) {$strA = '1'; } ELSE { $strA = '0'; }
	  
	  if ( empty($qti_error) )
	  {
		$oDB->Query('UPDATE organization SET 
			Name="'.addslashes($strN).'",
			Industry_ID='.$strI.', 
			Regularity="'.addslashes($strL).'", 
			Location="'.addslashes($strR).'",
			Description="'.addslashes($strCmt).'", 
			ModBy='.$oVIP->id.', 
			ModDt="'.date('Y-m-d H:i:s').'"
			WHERE Org_ID='.$orgid);
			$oDB->Query('UPDATE contact SET Address_1="'.addslashes($strPd).'", Address_2="'.addslashes($strCd).'", City="'.addslashes($strF).'", Email="'.addslashes($strE).'", Tel_1="'.addslashes($strT).'", Website="'.addslashes($strW).'" WHERE Contact_ID='.intval($strCnt));
		// exit
	
		if($row2)
		{
			$oDB->Query('UPDATE sf_credentials SET Username="'.addslashes($strNf).'",  Password="'.addslashes($strPf).'", Token="'.addslashes($strTf).'", Descr="'.addslashes($strD).'", ModDt="'.date('Y-m-d H:i:s').'" WHERE Org_ID='.$oVIP->orgid);
		} else {
			$oDB->Query('INSERT sf_credentials (Org_ID, `Username`, `Password`, `Token`, ModDt) VALUES('.$oVIP->orgid.', "'.addslashes($strNf).'", "'.addslashes($strPf).'", "'.addslashes($strTf).'", "'.date('Y-m-d H:i:s').'")');
		}		
	
		unset($_SESSION['qtiGoto']);
		$oVIP->exiturl = "profile.php";
		$oVIP->exitname = '';
		$oVIP->EndMessage(NULL,"Organization profile details saved",$_SESSION[QT]['skin_dir'],2);
  }
}
require_once('../../header.php');
?>
<form id="form1" name="form1" method="post" action="" >
  <table width="100%" border="0" cellspacing="0" cellpadding="4" class="ta ta_o">
    <tr>
      <td class="th_o th_o_first">*Organization Name </td>
      <td class="td_o" colspan="3"><input name="name" size="50" type="text" id="name" value="<?php echo $row['Name']; ?>" /></td>
    </tr>
	<tr>
      <td width="23%" class="th_o th_o_first">Industry</td>
      <td colspan="3" class="td_o"><select name="industry" id="industry" class="required">
          <option value="<?php echo $row['IndustryID'];?>"><?php echo $row['Industry'];?></option>
          <?php 
				$oDB->Query('SELECT * FROM industry WHERE ActiveInd=1 ORDER BY Industry ASC');
				$row2 = $oDB->Getrow();
				do
				{
					if ($row['IndustryID'] != $row2['Industry_ID']){
						echo '<option value=',$row2['Industry_ID'].'>',$row2['Industry'],'</option>',N;
					}
				}while ( $row2 = $oDB->Getrow() );
				?>
        </select></td>
    </tr>
    <tr>
      <td class="th_o th_o_first">Location</td>
      <td colspan="3" class="td_o"><input name="location" type="text" id="location" value="<?php echo $row['Location']; ?>" /></td>
    </tr>
    <tr>
      <td valign="top" class="th_o th_o_first">Description</td>
      <td colspan="3" class="td_o"><textarea cols="50" name="comment" cols="20" rows="3" id="comment"><?php echo $row['Description']; ?></textarea></td>
    </tr>
    <tr>
      <td valign="top" class="th_o th_o_first">Physical Address </td>
      <td width="27%" class="td_o"><textarea name="pad"><?php echo $row['Address_1']; ?></textarea></td>
      <td width="21%" valign="top" class="th_o th_o_first">Contact Address </td>
      <td width="29%" class="td_o"><textarea name="cad"><?php echo $row['Address_2']; ?></textarea><input name="contact" type="hidden" value="<?php echo $row['ContactID']; ?>" /></td>
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
      <td class="th_o th_o_first">&nbsp;</td>
      <td class="td_o">&nbsp;</td>
      <td class="td_o">&nbsp;</td>
      <td class="td_o">&nbsp;</td>
    </tr>
    <?php 
	$oDB->Query('SELECT * FROM sf_credentials WHERE Org_ID='.$oVIP->orgid);
	$row2 = $oDB->Getrow();
	?>
    <tr>
      <td class="th_o th_o_first">SF username</td>
      <td class="td_o"><label>
        <input name="username" type="text" id="type" value="<?php echo $row2['Username'];?>"/>
      </label></td>
      <td class="td_o">&nbsp;</td>
      <td class="td_o">&nbsp;</td>
    </tr>
    <tr>
      <td class="th_o th_o_first">SF password</td>
      <td class="td_o"><label>
        <input name="password" type="password" id="password" value="<?php echo $row2['Password'];?>"/>
      </label></td>
      <td class="td_o">&nbsp;</td>
      <td class="td_o">&nbsp;</td>
    </tr>
    <tr>
      <td class="th_o th_o_first">Security token</td>
      <td class="td_o"><label>
        <input name="token" type="text" id="token" value="<?php echo $row2['Token'];?>"/>
      </label></td>
      <td class="td_o">&nbsp;</td>
      <td class="td_o">&nbsp;</td>
    </tr>
    <tr>
      <td class="th_o th_o_first">Auto indent period</td>
      <td class="td_o">
        <select name="perioda" id="perioda">
        	<option value="<?php echo $row['Regularity']; ?>"><?php echo $row['Regularity']; ?></option>
        	<option value="Daily">Daily</option>
            <option value="Weekly">Weekly</option>
            <option value="Monthly">Monthly</option>
        </select>
      </td>
      <td class="td_o">&nbsp;</td>
      <td class="td_o">&nbsp;</td>
    </tr>
    <tr>
      <td class="th_o th_o_first">&nbsp; </td>
      <td class="td_o">
      <input type="hidden" name="contact" value="<?php echo $row['ContactID'];?>"/>
	  <?php //if ($oVIP->CanSave($oVIP->selfurl)==true) {?>
	  <input type="submit" name="Save" value="Save Details"></td>
	  <?php //}?>
	  <td class="td_o">&nbsp; </td>
      <td class="td_o">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" class="th_o th_o_first">&nbsp;
			<?php
			$strQ = 'SELECT * FROM organization WHERE Parent_ID ='.$oVIP->orgid;
			$oDB->Query($strQ);
			if ($parent!=0) {
				echo '<table class="ta ta_t" cellspacing="0">',N;
				
				echo '<tr class="tr_t">',N;
				echo '<th class="th_t th_t_sta"  style="" colspan="3">Child Profile(s)</th>',N;
				echo '</tr>',N;
				$strAlt='1';
				For ($i=0;$i<100;$i++)
				{
				$row = $oDB->Getrow();
				if ( !$row ) break;
				echo '<tr>'.N;
				echo '<td width="40%" class="td_t td_t_sta',$strAlt,'"><a href="profile.php?id='.$row['Org_ID'].'">',$row['Name'],' </a></td>',N;
				echo '<td width="30%" class="td_t td_t_ref',$strAlt,'">',$row['Location'],'</td>',N;
				echo '<td width="30%" class="td_t td_t_sta',$strAlt,'"><span class="small">',$row['Description'],'</span></td>',N;
				echo '</tr>',N;
			
				if ( $strAlt=='1' ) { $strAlt='2'; } else { $strAlt='1'; }
				
				}
				echo '</table>',N;
			}
			?>		</td>
    </tr>
  </table>
</form>

<?php 
require_once('../../footer.php');
?>