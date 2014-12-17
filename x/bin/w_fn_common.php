<?php

// QR build:20090101

function AsEmails($strEmails,$strId,$strSection='0',$strRender='txt',$bFirst=false,$strSkin='skin/default',$strNojava='Java protected email',$strEmpty='&nbsp;')
{
  if ( !is_string($strEmails) ) return $strEmpty;
  if ( empty($strEmails) ) return $strEmpty;
  // get list of Emails
  if ( strstr($strEmails,' ; ') ) { $arrEmails = explode(' ; ',$strEmails); } else { $arrEmails = array($strEmails); }
  // get first Email
  $strFirst = $arrEmails[0];
  // only one email
  if ( $bFirst ) $arrEmails = array($strFirst);
  // build expression
  $strReturn = '';
  switch ($strRender)
  {
  case 'txt':
    $strReturn .= '<a id="href'.$strId.'s'.$strSection.'" class="small" href="mailto:'.implode(';',$arrEmails).'">';
    $strReturn .= implode(' ; ',$arrEmails);
    $strReturn .= '</a>';
    break;
  case 'img':
    $strReturn .= '<a id="href'.$strId.'s'.$strSection.'" class="small" href="mailto:'.implode(';',$arrEmails).'">';
    $strReturn .= '<img class="ico ico_user" id="img'.$strId.'s'.$strSection.'" src="'.$strSkin.'/ico_user_e_1.gif" alt="email" title="'.$strFirst.'"/>';
    $strReturn .= '</a>';
    break;
  case 'txtjava':
    $strReturn .= '<script type="text/javascript">';
    foreach ($arrEmails as $strEmail)
    {
    $arr = explode('@',$strEmail);
    $strReturn .= 'writemailto("'.$arr[0].'","'.$arr[1].'"," ");';
    }
    $strReturn .= '</script><noscript class="small">'.$strNojava.'</noscript>';
    break;
  case 'imgjava':
    $str = implode(';',$arrEmails);
    $str = str_replace('@','-at-',$str);
    $str = str_replace('.','-dot-',$str);
    $strFirst = str_replace('@','-at-',$strFirst);
    $strFirst = str_replace('.','-dot-',$strFirst);
    $strReturn .= '<a id="href'.$strId.'s'.$strSection.'" onmouseover="vmail(\''.$strId.'s'.$strSection.'\');" onmouseout="hmail(\''.$strId.'s'.$strSection.'\');" class="small" href="javamail:'.$str.'">';
    $strReturn .= '<img class="ico ico_user" id="img'.$strId.'s'.$strSection.'" src="'.$strSkin.'/ico_user_e_1.gif" alt="email" title="'.$strFirst.'"/>';
    $strReturn .= '</a>';
    break;
  }

  return $strReturn;
}

// --------

function AsImg($strSrc,$strAlt='',$strTitle='',$strClass='',$strStyle='',$strHref='')
{
  if ( !isset($strSrc) ) return ' ';
  if ( !is_string($strSrc) || empty($strSrc) ) return ' ';
  Return ( !empty($strHref) ? '<a href="'.$strHref.'">' : '' ).'<img src="'.$strSrc.'" alt="'.(isset($strAlt) ? QTconv($strAlt) :'').'" title="'.(isset($strTitle) ? QTconv($strTitle) :'').'"'.(!empty($strClass) ? ' class="'.$strClass.'"' : '').(!empty($strStyle) ? ' style="'.$strStyle.'"' : '').'/>'.( !empty($strHref) ? '</a>' : '' );
}

// --------
// $oCaption can be a user array (name,role,location) or a string

function AsImgBox($strImg,$strClass,$strStyle,$oCaption,$strHref='')
{
  if ( !is_string($strImg) ) die('AsImgBox: Missing image');
  if ( is_array($oCaption) )
  {
    $strCaption = QTconv($oCaption[0],'5');
    if ( !empty($strHref) ) $strCaption = '<a href="'.$strHref.'">'.$strCaption.'</a>';
    if ( !empty($oCaption[1]) ) $strCaption .= '<br/>('.QTconv($oCaption[1],'5').')';
    if ( !empty($oCaption[2]) ) $strCaption .= '<br/>'.QTconv($oCaption[2],'5');
  }
  else
  {
    $strCaption = QTconv(strval($oCaption),'5');
    if ( !empty($strHref) ) $strCaption = '<a href="'.$strHref.'">'.$strCaption.'</a>';
  }
  return '<div'.(isset($strClass) ? ' class="'.$strClass.'"' : '').(isset($strStyle) ? ' style="'.$strStyle.'"' : '').'>'.$strImg.(isset($strCaption) ? '<span class="small"><br/>'.$strCaption.'</span>' : '').'</div>';
}

// --------

function DateAdd($d='0',$i=-1,$str='year')
{
   if ( $d=='0' ) die('DateAdd: Argument #1 must be a string');
   if ( !is_string($d) ) die('DateAdd: Argument #1 must be a string');
   if ( !is_integer($i) ) die('DateAdd: Argument #2 must be an integer');
   if ( !is_string($str) ) die('DateAdd: Argument #3 must be a string');
   $intY = intval(substr($d,0,4));
   $intM = intval(substr($d,4,2));
   $intD = intval(substr($d,6,2));
   switch($str)
   {
   case 'year': $intY += $i; break;
   case 'month': $intM += $i; break;
   case 'day': $intD += $i; break;
   }
   if ( $intD>30 ) { $intM++; $intD -= 30; }
   if ( $intD<1 ) { $intM--; $intD += 30; }
   if ( $intM>12 ) { $intY++; $intM -= 12; }
   if ( $intM<1 ) { $intY--; $intM += 12; }
   if ( $intM==2 && $intD>28 ) { $intM++; $intD -= 28; }
   return strval($intY*10000+$intM*100+$intD).(strlen($d)>8 ? substr($d,8) : '');
}

// --------

function CanPerform($strParam,$strRole='V')
{
  // valid parameter are: upload, show_calendar, show_stats
  if ( empty($strParam) || !isset($_SESSION[QT][$strParam]) ) return false;
  if ( $_SESSION[QT][$strParam]=='A' && $strRole=='A' ) return true;
  if ( $_SESSION[QT][$strParam]=='M' && ($strRole=='A' || $strRole=='M') ) return true;
  if ( $_SESSION[QT][$strParam]=='U' && $strRole!='V' ) return true;
  if ( $_SESSION[QT][$strParam]=='V' ) return true;
  return false;
}

// --------
// Register and Returns an array of [key] id, [value] title (and store in a session variable)

function GetDomains()
{
  global $oDB;
  $arr = array();
  $oDB->Query( 'SELECT id,title FROM '.TABDOMAIN.' ORDER BY titleorder' );
  while ( $row = $oDB->Getrow() )
  {
    $arr[$row['id']] = $row['title'];
  }
  // search translation
  $arrL = cLang::GetName('domain',$_SESSION[QT]['lang_iso'],'*');
  if ( count($arrL)>0)
  {
    foreach ($arr as $id => $str)
    {
      if ( array_key_exists('d'.$id,$arrL) )
      {
      if ( !empty($arrL['d'.$id]) ) $arr[$id]=$arrL['d'.$id];
      }
    }
  }
  return $arr;
}

// --------
// Returns an array of [key] section id, [value] section title

function GetSectionTitles($strRole='V',$intDomain=-1,$intReject=-1,$strExtra='',$bAddDomain=false)
{
  if ( !is_string($strRole) ) die('GetSectionTitles: Argument #1 must be a string');
  if ( !is_integer($intDomain) ) die('GetSectionTitles: Argument #2 must be an integer');

  global $oDB;

  if ( $intDomain>=0 ) { $strWhere = 'domainid='.$intDomain; } else { $strWhere = 'domainid>=0'; }
  if ( $strRole=='V' || $strRole=='U' ) $strWhere .= ' AND type<>"1"';
  if ( !empty($strExtra) ) $strWhere .= ' AND '.$strExtra;

  $arr = array();

  // search translation
  //$arrL = cLang::GetName('sec',$_SESSION[QT]['lang_iso'],'*');

  $oDB->Query( 'SELECT id,title FROM '.TABSECTION.' WHERE '.$strWhere.' ORDER BY titleorder' );
  while ( $row = $oDB->Getrow() )
  {
    $id = intval($row['id']);
    $arr[$id] = stripslashes($row['title']);
    if ( array_key_exists('s'.$id,$arrL) ) {
    if ( !empty($arrL['s'.$id]) ) {
      $arr[$id] = $arrL['s'.$id];
    }}
    if ( $bAddDomain ) {
    if ( isset($_SESSION['qtiDomains']) ) {
    if ( isset($_SESSION['qtiDomains'][$id]) ) {
    if ( !empty($_SESSION['qtiDomains'][$id]) ) {
      $arr[$id] = $_SESSION['qtiDomains'][$id].': '.$arr[$id];
    }}}}
  }

  if ( count($arr)>0 )
  {
    // reject
    if ( $intReject>=0 ) unset($arr[$intReject]);
  }
  return $arr;
}

// --------
// Returns an array of [key] section id, array of [values] section

function GetSections($strRole='V',$intDomain=-1,$intReject=-1,$strExtra='')
{
  if ( !is_string($strRole) ) die('GetSectionTitles: Argument #1 must be a string');
  if ( !is_integer($intDomain) ) die('GetSectionTitles: Argument #2 must be an integer');

  global $oDB;

  if ( $intDomain>=0 ) { $strWhere = 'domainid='.$intDomain; } else { $strWhere = 'domainid>=0'; }
  if ( $strRole=='V' || $strRole=='U' ) $strWhere .= ' AND type<>"1"';
  if ( !empty($strExtra) ) $strWhere .= ' AND '.$strExtra;

  $arr = array();
  $oDB->Query( 'SELECT * FROM '.TABSECTION.' WHERE '.$strWhere.' ORDER BY titleorder' );
  while ( $row = $oDB->Getrow() )
  {
    $arr[intval($row['id'])] = $row;
  }

  if ( count($arr)>0 )
  {
    // search translation
    $arrL = cLang::GetName('sec',$_SESSION[QT]['lang_iso'],'*');
    if ( count($arrL)>0)
    {
      foreach ($arr as $id => $str)
      {
        if ( array_key_exists('s'.$id,$arrL) )
        {
        if ( !empty($arr['s'.$id]) ) $arr[$id]['title']=$arrL['s'.$id];
        }
      }
    }
    // reject
    if ( $intReject>=0 ) unset($arr[$intReject]);
  }
  return $arr;
}

// --------

function GetParam($bRegister=false,$strWhere='loaded<>"9"')
{
  global $oDB;
  $arrParam = array();
  $oDB->Query('SELECT param,setting FROM '.TABSETTING.' WHERE '.$strWhere);
  while ($row = $oDB->Getrow())
  {
  $arrParam[$row['param']]=$row['setting'];
  if ( $bRegister ) $_SESSION[QT][$row['param']]=$row['setting'];
  }

  Return $arrParam;
}

/**
 *
 * GetUserInfo
 *
 * Options supported for the $intUser:
 * i [int] a userid,
 * "S" [string] all staff members,
 * "A" [string] all administrators,
 * "i" [string] the coordinator of section i
 * will return a list of values (as string)
 *
 **/
function GetUserInfo($intUser=null,$strField='name',$oSEC=null)
{
  global $oDB;

  if ( is_string($intUser) )
  {
    if ( $intUser=='A' || $intUser=='S' )
    {
      $lst = array();
      $oDB->Query('SELECT '.$strField.' FROM '.TABUSER.' WHERE role="'.$intUser.'"');
      while( $row=$oDB->Getrow() )
      {
      $lst[] = $row[$strField];
      }
      return $lst;
    }
    if ( is_numeric($intUser) )
    {
      if ( !isset($oSEC) ) $oSEC = new cSection(intval($intUser));
      $oDB->Query('SELECT '.$strField.' FROM '.TABUSER.' WHERE id='.$oSEC->modid);
      $row=$oDB->Getrow();
      return $row[$strField];
    }
  }
  if ( is_int($intUser) )
  {
    if ( $intUser<0 ) { if ( isset($onerror) ) return $onerror; die ('GetUserInfo: Missing user id'); }
    $oDB->Query('SELECT '.$strField.' FROM '.TABUSER.' WHERE id='.$intUser);
    $row = $oDB->Getrow();
    return $row[$strField];
  }
  die ('GetUserInfo: Invalid argument #1 '.var_dump($intUser));
}

/**
 *
 * GetUsers
 *
 * Return an array of (maximum 200) users id/name
 * number = returns 1 user [id][name]
 * 'A'    = returns administrators (default)
 * 'M'    = returns moderators (+Admin)
 * 'M-'   = returns moderators (-Admin)
 * 'name' = return the user having the name [strValue]
 * 'A*'   = returns names beginning by A
 *
 * Attention: names are htmlquoted in the db, no need to stripslashes
 *
 **/
function GetUsers($strRole='A',$strValue='',$strOrder='name')
{
  global $oDB;
  
  $strQ = 'SELECT id,name FROM '.TABUSER.' WHERE role="A" ORDER BY '.$strOrder;

  if ( $strRole=='M' ) $strQ = 'SELECT id,name FROM '.TABUSER.' WHERE role="A" OR role="M" ORDER BY '.$strOrder;
  if ( $strRole=='M-' ) $strQ = 'SELECT id,name FROM '.TABUSER.' WHERE role="M" ORDER BY '.$strOrder;
  if ( $strRole=='name') $strQ = 'SELECT id,name FROM '.TABUSER.' WHERE name="'.$strValue.'" ORDER BY '.$strOrder;
  if ( substr($strRole,-1,1)=='*' )
  {
    $like = 'LIKE'; if ( $oDB->type=='pg' ) $like = 'ILIKE';
    $strQ = 'SELECT id,name FROM '.TABUSER.' WHERE name '.$like.' "'.substr($strRole,0,-1).'%" ORDER BY '.$strOrder;
  }

  $oDB->Query($strQ);

  $arrUsers = array();
  $i=1;
  while ($row=$oDB->Getrow())
  {
    $arrUsers[$row['id']]=$row['name'];
    $i++;
    if ( $i>200 ) break;
  }
  return $arrUsers;
}

// LangS
//  Returns the plural.
//  Returns the orignial word if $intVal<2, or if plural word is not existing.
//  The variable $strVar can be composed of 2 strings (comma separated)
//  ex: LangS['userrole,A',25] returns $L['Userroles']['A']

// LangS
// Returns the plural.
// - Returns the orignial word if $intVal<2, or if plural word is not existing.
// - If the last argument is true, returns the number + space + the word
// - The variable $strVar can be composed of 2 strings (comma separated)
// ex: LangS['userrole,A',25] returns $L['Userroles']['A']

function LangS($strVar,$intVar,$bInclude=true)
{
  global $L;
  if ( !strstr($strVar,',') )
  {
    if ( $intVar>1 && isset($L[$strVar.'s']) )
    {
      Return ($bInclude ? $intVar.' ' : '').$L[$strVar.'s'];
    }
    else
    {
      Return ($bInclude ? $intVar.' ' : '').$L[$strVar];
    }
  }
  else
  {
    $lstVar = explode(',',$strVar);
    if ( $intVar>1 && isset($L[$lstVar[0].'s'][$lstVar[1]]) )
    {
      Return ($bInclude ? $intVar.' ' : '').$L[$lstVar[0].'s'][$lstVar[1]];
    }
    else
    {
      Return ($bInclude ? $intVar.' ' : '').$L[$lstVar[0]][$lstVar[1]];
    }
  }
}

// --------

function MakePager($uri, $count, $intPagesize=50, $currentpage=1)
{
  global $L;
  $arrUri = parse_url($uri);
  $uri = $arrUri['path'];
  $arg = $arrUri['query'];
  $arg = str_replace('&amp;','&',$arg);
  $arrArg = explode('&',$arg);
  $arrNew = array();
  foreach ($arrArg as $strValue)
  {
    if ( substr($strValue,0,4)=='page' ) continue;
    $arrNew[]=$strValue;
  }
  $arg = implode('&amp;',$arrNew);

  $strPager='';
  if ( $count>($intPagesize*5) )
  {
    // firstpage
    if ( $currentpage==1 )
    {
      $strFirstpage = ' &laquo;';
    }
    else
    {
      $strFirstpage = ' <a class="a_pager" href="'.$uri.'?'.$arg.'&amp;page=1" title="'.$L['First'].'">&laquo;</a>';
    }
    // lastpage
	//$il = ceil($count/$intPagesize); will revert to this later
    $il = ceil($count/1);
    if ( $currentpage==$il )
    {
      $strLastpage = ' &raquo;';
    }
    else
    {
      $strLastpage = ' <a class="a_pager" href="'.$uri.'?'.$arg.'&amp;page='.$il.'" title="'.$L['Last'].': '.$il.'">&raquo;</a>';
    }
    // 3 pages
    if ( $currentpage==1 )
    {
       $strThesepages = ' <b>'.$currentpage.'</b> <a class="a_pager" href="'.$uri.'?'.$arg.'&amp;page='.($currentpage+1).'" title="'.$L['Next'].'">'.($currentpage+1).'</a> <a class="a_pager" href="'.$uri.'?'.$arg.'&amp;page='.($currentpage+2).'" title="'.$L['Next'].'">'.($currentpage+2).'</a>';
    }
    elseif ( $currentpage==$il )
    {
       $strThesepages = ' <a class="a_pager" href="'.$uri.'?'.$arg.'&amp;page='.($currentpage-2).'" title="'.$L['Previous'].'">'.($currentpage-2).'</a> <a class="a_pager" href="'.$uri.'?'.$arg.'&amp;page='.($currentpage-1).'" title="'.$L['Previous'].'">'.($currentpage-1).'</a> <b>'.$currentpage.'</b> ';
    }
    else
    {
       $strThesepages = ' <a class="a_pager" href="'.$uri.'?'.$arg.'&amp;page='.($currentpage-1).'" title="'.$L['Previous'].'">'.($currentpage-1).'</a> <b>'.$currentpage.'</b> <a class="a_pager" href="'.$uri.'?'.$arg.'&amp;page='.($currentpage+1).'" title="'.$L['Next'].'">'.($currentpage+1).'</a>';
    }
    // finish
    $strPager .= $strFirstpage.$strThesepages.$strLastpage;
  }
  elseif ($count>$intPagesize)
  {
    for ($i=0; $i<$count; $i+=$intPagesize)
    {
      $page = $i/$intPagesize+1;
      if ( $currentpage==$page )
      {
        $strPager .= ' <b>'.$page.'</b>';
      }
      else
      {
        $strPager .= ' <a class="a_pager" href="'.$uri.'?'.$arg.'&amp;page='.$page.'">'.$page.'</a>';
      }
    }
  }
  return $strPager;
}

// --------

function Nextid($strTable,$strField='id',$strWhere='',$onerror=null)
{
  // Check

  if ( !is_string($strTable) ) { if ( isset($onerror) ) return $onerror; die('Nextid: arg #2 must be an string'); }
  if ( !is_string($strField) ) { if ( isset($onerror) ) return $onerror; die('Nextid: arg #3 must be an string'); }
  if ( !is_string($strWhere) ) { if ( isset($onerror) ) return $onerror; die('Nextid: arg #4 must be an string'); }
  if ( empty($strTable) ) { if ( isset($onerror) ) return $onerror; die('Nextid: arg #2 must be an string'); }
  if ( empty($strField) ) { if ( isset($onerror) ) return $onerror; die('Nextid: arg #3 must be an string'); }

  // Process

  global $oDB;
  
  $oDB->Query("SELECT max($strField)+1 as newnum FROM $strTable $strWhere");
  $row = $oDB->Getrow();
  $intId = $row['newnum'];
  if ( empty($intId) ) $intId=1;

  return intval($intId);
}

// --------

function ObjectName($strType,$strId,$bGenerate=true,$intMax=0,$strTrunc='...')
{
  // This function return the translation of the objid
  // When translation is not defined and generate is true, returns the ucfirst(objid)
  // otherwise, returns ''
  // When $intMax>1, the text is truncated to intMax characters and the $strTrunc is added.

  $str = '';
  if ( isset($_SESSION['L'][$strType][$strId]) ) $str = $_SESSION['L'][$strType][$strId];
  if ( empty($str) && $bGenerate )
  {
    switch($strType)
    {
    case 'field': $str = ucfirst(str_replace('_',' ',$strId)); break;
    case 'tabdesc': $str = $bGenerate ;
    case 'tab': $str = ucfirst(str_replace('_',' ',$strId)); break;
    case 'tabdesc': $str = $bGenerate; break;
    case 'index': $str = $_SESSION[QT]['index_name']; break;
    case 'domain': $str = $bGenerate; break;
    case 'sec': $str = $bGenerate; break;
    case 'secdesc': $str = $bGenerate; break;
    }
  }
  if ( $intMax>1 && strlen($str)>$intMax ) return substr($str,0,$intMax).$strTrunc;
  return $str;
}

/**
 *
 * SysStats
 *
 **/

function SysStats($str='all')
{
  global $oDB;
  if ( $str=='all' || $str=='notifysections')
  {
    $arrSections = array();
    $oDB->Query('SELECT id FROM '.TABSECTION.' WHERE notify="1"');
    while ( $row=$oDB->Getrow() )
    {
      $arrSections[]=$row['id'];
    }
    $_SESSION[QT]['sys_notifysections'] = $arrSections;
  }
  if ( $str=='all' || $str=='t')
  {
    $oDB->Query('SELECT count(id) as countid FROM '.TABTOPIC);
    $row = $oDB->Getrow();
    $_SESSION[QT]['sys_topics'] = $row['countid'];
  }
  if ( $str=='all' || $str=='p')
  {
  $oDB->Query('SELECT count(id) as countid FROM '.TABPOST);
  $row = $oDB->Getrow();
  $_SESSION[QT]['sys_messages'] = $row['countid'];
  }
  if ( $str=='all' || $str=='u')
  {
  $oDB->Query('SELECT count(id) as countid FROM '.TABUSER);
  $row = $oDB->Getrow();
  $_SESSION[QT]['sys_members'] = $row['countid'];
  }
  if ( $str=='all' || $str=='n')
  {
  $oDB->Query('SELECT max(id) as countid FROM '.TABUSER);
  $row = $oDB->Getrow();
  $_SESSION[QT]['sys_newuserid'] = $row['countid'];
  $oDB->Query('SELECT name FROM '.TABUSER.' WHERE id='.$_SESSION[QT]['sys_newuserid']);
  $row = $oDB->Getrow();
  $_SESSION[QT]['sys_newusername'] = $row['name'];
  }
}

/**
 *
 * TableHeader
 *
 * @arrField array(Sortable,Text,Class,Style)
 * @intCount number of row (if <=2, columns are not sortable)
 * @strOrder initial order field
 * @strDirec initial order direction
 * @strUrl   sorting url (without order nor dir arguments)
 *
 **/

function TableHeader($arrFields,$intCount=0,$strUrl='',$strOrder='lastpostdate',$strDir='',$strTabClass='t')
{
  $arrSortable = array('status'=>'ASC','numid'=>'DESC','title'=>'ASC','forum'=>'DESC','sectiontitle'=>'ASC','name'=>'ASC','role'=>'ASC','location'=>'ASC','firstdate'=>'DESC','firstpostname'=>'ASC','lastpostdate'=>'DESC','replies'=>'DESC','views'=>'DESC','id'=>'ASC','numpost'=>'DESC','actorname'=>'ASC','wisheddate'=>'DESC','notifiedname'=>'ASC');
  if ( empty($strDir) ) $strDir=$arrSortable[$strOrder];
  $img['ASC'] = ' <img class="ico_sort" src="'.$_SESSION[QT]['skin_dir'].'/sort_asc.gif" alt="+"/>';
  $img['DESC']= ' <img class="ico_sort" src="'.$_SESSION[QT]['skin_dir'].'/sort_desc.gif" alt="-"/>';
  Foreach ($arrFields as $strFld => $arr)
  {
  $strCol = $arr[1]; if ( $strFld=='ico_status' ) $strFld='status';
  if ( $arr[0] && $intCount>2 ) $strCol = '<a href="'.$strUrl.'&amp;order='.$strFld.'&amp;dir='.($strOrder==$strFld ? QTinvert($strDir) : $arrSortable[$strFld]).'" class="a_ta_'.$strTabClass.'_head">'.$strCol.'</a>'.($strOrder==$strFld ? $img[$strDir] : '');
  echo '<th class="',$arr[2],'" style="',$arr[3],'">',$strCol,'</th>',N;
  }
}

// --------

function Translate($strFile)
{
  if ( file_exists($_SESSION[QT]['language'].'/'.$strFile) ) Return $_SESSION[QT]['language'].'/'.$strFile;
  Return 'language/english/'.$strFile;
}

// --------

function UpdateSectionStats($intSection=-1,$intMax=-1,$bLastPostDate=false,$bReplies=false)
{
  if ( $intSection<0 ) die('UpdateSectionStats: Wrong id');

  global $oDB;

  // query topics (all types)
  $oDB->Query( 'SELECT count(id) as countid FROM '.TABTOPIC.' WHERE forum='.$intSection );
  $row = $oDB->Getrow();
  $intTopics = intval($row['countid']);

  // query replies (type R and F)
  $oDB->Query( 'SELECT count(id) as countid FROM '.TABPOST.' WHERE forum='.$intSection.' AND (type="R" OR type="F")' );
  $row = $oDB->Getrow();
  $intReplies = intval($row['countid']);

  // save stats
  $oDB->Query( 'UPDATE '.TABSECTION.' SET topics='.$intTopics.', replies='.$intReplies.' WHERE id='.$intSection );

  // check maximum topics in section
  if ( $intMax>0 )
  {
    if ( $intTopics>$intMax )
    {
      $oDB->Query( 'UPDATE '.TABSECTION.' SET status="1" WHERE id='.$intSection );
      // notify administrator
      $strMails = GetUserInfo(1,'mail');
      // send mail
      include('bin/qt_lib_smtp.php');
      QTmail($strMails,$_SESSION[QT]['site_name'].': important notification',"Section $intSection is closed (>$intMax items)",QTI_HTML_CHAR);
    }
  }

  //re-compute lastpostdate (used after import)
  if ( $bLastPostDate )
  {
    if ( in_array($oDB->type,array('sqlite','mssql','pg','access','db2','ifx')) )
    {
    $oDB->Query( 'UPDATE '.TABTOPIC.' SET lastpostdate=(SELECT MAX(issuedate) FROM '.TABPOST.' p, '.TABTOPIC.' t WHERE t.id=p.topic) WHERE forum='.$intSection );
    }
    else
    {
    $oDB->Query( 'UPDATE '.TABTOPIC.' t SET t.lastpostdate=(SELECT MAX(p.issuedate) FROM '.TABPOST.' p WHERE t.id=p.topic) WHERE t.forum='.$intSection );
    }
  }
  //re-compute replies (used after import)
  if ( $bReplies )
  {
    if ( in_array($oDB->type,array('sqlite','mssql','pg','access','db2','ifx')) )
    {
    $oDB->Query( 'UPDATE '.TABTOPIC.' SET replies=(SELECT COUNT(*) FROM '.TABPOST.' p, '.TABTOPIC.' t WHERE t.id=p.topic) WHERE forum='.$intSection );
    }
    else
    {
    $oDB->Query( 'UPDATE '.TABTOPIC.' t SET t.replies=(SELECT COUNT(p.id) FROM '.TABPOST.' p WHERE t.id=p.topic AND p.type<>"P") WHERE t.forum='.$intSection );
    }
  }

  // Unregister global sys (will be recomputed on next page)
  Unset($_SESSION[QT]['sys_topics']);
  Unset($_SESSION[QT]['sys_messages']);
}

// --------

function UseModule($strName=null,$onerror=null)
{
  if ( !is_string($strName) ) { if ( isset($onerror) ) return $onerror; die('UseModule: arg #1 must be an string'); }
  if ( isset($_SESSION[QT]['module_'.$strName]) ) return TRUE;
  return FALSE;
}

?>