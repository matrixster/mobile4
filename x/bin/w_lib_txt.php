<?php

/* ============
 
 * ============ */

// AsTags
//
// Returns html blocks (ex: <option></option>) based on an array.
// @$arr, the array
// @$strFormat, a formatting string for the texts
// @$strSelectedValue, the value that must be selected
// @$strSelectedClass
// @$strCurrentValue, defines a current value (to apply a class)
// @$strCurrentClass
// @$strAllClass, a class that must be added to all tag.
// @$strTag, the tag (option by default)
// @$strName, the name attribute (for checkbox only)
// Note: If the array is an array of arrays, the option text will be the first element of the array

function QTastags($arr,$strFormat=null,$strSelectedValue=null,$strSelectedClass=null,$strCurrentValue=null,$strCurrentClass=null,$strAllClass=null,$strTag='option',$strName='',$onerror=null)
{
  // check

  if ( !is_array($arr) ) { if ( isset($onerror) ) return $onerror; die('QTastags: arg #1 must be an array'); }

  // process

  $strReturn = '';

  foreach ($arr as $strKey => $strValue)
  {
    $arrClasses = array();
    // value type and format
    if ( is_array($strValue) ) $strValue = reset($strValue);
    if ( isset($strFormat) ) $strValue = sprintf($strFormat,$strValue);
    // classes
    if ( isset($strAllClass) ) $arrClasses[] = $strAllClass;
    if ( isset($strSelectedValue) && $strSelectedValue==$strKey && isset($strSelecedClass) ) $arrClasses[] = $strSelectedClass;
    if ( isset($strCurrentValue) && $strCurrentValue==$strKey && isset($strCurrentClass) ) $arrClasses[]=$strCurrentClass;
    if ( count($arrClasses)>0 ) { $strClasses=' class="'.implode(' ',$arrClasses).'"'; } else { $strClasses=''; }
    // builder
    switch($strTag)
    {
    case 'option':
      if ( !isset($strSelectedValue) )
      {
      $strReturn .= '<option value="'.$strKey.'"'.$strClasses.'>'.$strValue.'</option>';
      }
      else
      {
      $strReturn .= '<option value="'.$strKey.'"'.$strClasses.($strSelectedValue==$strKey ? ' selected="selected"' : '').'>'.$strValue.'</option>';
      }
      break;
    case 'checkbox':
      if ( !isset($strSelectedValue) )
      {
      $strReturn .= '<input type="checkbox" name="'.$strName.'" value="'.$strKey.'"'.$strClasses.'/>'.$strValue;
      }
      else
      {
      $strReturn .= '<input type="checkbox" name="'.$strName.'" value="'.$strKey.'"'.$strClasses.($strSelectedValue==$strKey ? ' checked="checked"' : '').'/>'.$strValue;
      }
      break;
    case 'hidden':
      $strReturn .= '<input type="hidden" name="'.$strKey.'" value="'.$strValue.'"/>';
      break;
    default: die('QTastags only support option, and checkbox');
    }
  }
  return $strReturn;
}

// QTcompactline

function QTcompactline($str,$max=0,$onerror=null)
{
  // check

  if ( !is_string($str) ) { if ( isset($onerror) ) return $onerror; die('QTcompactline: arg #1 must be a string'); }
  if ( !is_numeric($max) ) { if ( isset($onerror) ) return $onerror; die('QTcompactline: arg #2 must be a number (or a number as string'); }

  // process

  if ($max>0) $str=substr($str,0,$max);
  $str = str_replace("\r\n\r\n\r\n", "\r\n", $str);
  $str = str_replace("\r\n\r\n", "\r\n", $str);
  if ( strpos($str,'[')!==FALSE )
  {
  $str = str_replace("[/quote]\r\n", '[/quote]', $str);
  $str = str_replace("[/code]\r\n", '[/code]', $str);
  }
  return $str;
}

/* ============
 * QTdate
 * ------------
 * Convert a source date (several input date types) to a formatted string (several output formats).
 * Return FALSE in case of wrong date.
 * The second argument is in fact an array of 5 formatting parameters.
 * This allows you to define the format separately (or globaly) avoiding to re-type all format parameters each time.
 * ------------
 * $d : a date as number or as string (see $arg[0] for detail on the supported source formats)
 * $arg[0]: s = the source is a php string date
 *        : u = the source is a unix date
 *        : n = the source is a numeric date or datetime
 * $arg[1]: date = the output will be a date (without time)
 *        : time = the output will be a time (without date)
 *        : datetime = the output will be a date + time
 *        : todaytime = the output will be a date + time AND, when applicable, the date will be replaced by 'Today' or 'Yesterday'
 *        : today = Idem (without time)
 *        : todaytodaytime = the output will be a date AND, when applicable, the date will be replaced by 'Today' or 'Yesterday' + Time
 *        : RFC-3339 = the output format generaly used in xml (in this case, other args  are not used)
 * $arg[2]: format for the date (uses php format)
 * $arg[3]: format for the time (uses php format)
 * $arg[4]: an array for translation, where the keys are the english words, and the translations as values (ex: $arr["Today"]="Aujourd'hui")
 * ------------
 * Remarques:
 * 1) When using the 'n' type (numeric format), the date can be:
 *    8 digits integer   : YYYYMMDD
 *    8 digits string    : 'YYYMMDD'
 *    14 digits integer  : YYYYMMDDHHMMSS
 *    14 ditits string   : 'YYYYMMDDHHMMSS'
 *    15 digits floating : YYYYMMDD.HHMMSS
 *    15 digits string   : 'YYYYMMDD.HHMMSS' (point can be replaced by any other character)
 *    BUT 12 digits (missing seconds) will NOT be correctly interpreted !
 * 2) When using the ouput format RFC-3339,the 3 last arguments are useless.
 * 3) If you provide an incomplete translation array, missing words will remains in the orignial language (the php english notation)
 * 4) When the date cannot be understoud (or is wrong), the function returns FALSE
 * ------------
 * Examples :
 * QTdate()                                                      --> Today 20:15
 * QTdate('now',     array('s','todaytime','j M Y','G:i',false)) --> Today 20:15
 * QTdate('20070130',array('n','today',    'j M Y','G:i',false)) --> 30 Jan 2007
 * QTdate(20070130,  array('n','datetime', 'j F Y','G:i',false)) --> 30 January 2007 00:00
 * ============ */

function QTdate($d='now',$arg=array('s','todaytime','j M Y','G:i',null),$onerror=null)
{

  if ( isset($arg[0]) ) { $from = $arg[0]; } else { $from = 's'; }
  if ( isset($arg[1]) ) { $to   = $arg[1]; } else { $to   = 'todaytime'; }
  if ( isset($arg[2]) ) { $fdate= $arg[2]; } else { $fdate= 'j M Y'; }
  if ( isset($arg[3]) ) { $ftime= $arg[3]; } else { $ftime= 'G:i'; }
  if ( isset($arg[4]) ) { $arr  = $arg[4]; } else { $arr  = null; }

  // read the convertion options
  if ( !is_string($from) ) { if ( isset($onerror) ) return $onerror; die('QTdate: arg #1 must be a string'); }
  if ( !is_string($to) ) { if ( isset($onerror) ) return $onerror; die('QTdate: arg #3 must be a string'); }
  if ( !in_array($from,array('s','u','n')) ) { if ( isset($onerror) ) return $onerror; die('QTdate: arg #1 must be "s", "u" or "n"'); }
  if ( !in_array($to,array('RFC-3339','date','time','datetime','todaytime','todaytodaytime','today')) )  { if ( isset($onerror) ) return $onerror; die('QTdate: arg #2 must be "RFC-3339", "date", "time", "datetime", "todaytime" or "today"'); }

  // read input and make a datetime

  $intDate = FALSE;

  switch($from)
  {
  case 's':
    $str = $d;
    if ( strrchr($str,'.00') ) $str = rtrim(rtrim($str,'0'),'.'); // drop extra decimal (than can occure with date string comming from odbc query)
    $intDate = strtotime($str);
    break;
  case 'u':
    $intDate = $d;
    break;
  case 'n':
    $str = strval($d);
    if ( strlen($str)==8 ) $intDate = mktime(0,0,0,substr($str,4,2),substr($str,6,2),substr($str,0,4));
    if ( strlen($str)>=14 ) $intDate = mktime(substr($str,-6,2),substr($str,-4,2),substr($str,-2,2),substr($str,4,2),substr($str,6,2),substr($str,0,4));
    break;
  }

  // check if input successful

  if ( $intDate===FALSE ) return "Cannot make date from [$d]";

  // Format the result

  $strDate = date($fdate.' '.$ftime,$intDate); //datetime
  switch($to)
  {
    case 'date':
      $strDate = date($fdate,$intDate);
      break;
    case 'time':
      $strDate = date($ftime,$intDate);
      break;
    case 'todaytime':
      $strT = date('Y-m-d',$intDate);
      $strY = date('Y-m-d',$intDate+86400);
      if ( date('Y-m-d')==$strT ) $strDate = 'Today '.date($ftime,$intDate);
      if ( date('Y-m-d')==$strY ) $strDate = 'Yesterday '.date($ftime,$intDate);
      break;
    case 'todaytodaytime':
      $strT = date('Y-m-d',$intDate);
      $strY = date('Y-m-d',$intDate+86400);
      $strDate = date($fdate,$intDate);
      if ( date('Y-m-d')==$strT ) $strDate = 'Today '.date($ftime,$intDate);
      if ( date('Y-m-d')==$strY ) $strDate = 'Yesterday '.date($ftime,$intDate);
      break;
    case 'today':
      $strT = date('Y-m-d',$intDate);
      $strY = date('Y-m-d',$intDate+86400);
      if ( date('Y-m-d')==$strT ) $strDate = 'Today';
      if ( date('Y-m-d')==$strY ) $strDate = 'Yesterday';
      break;
    case 'RFC-3339':
      $strDate = date('Y-m-d\TH:i:s',$intDate);
      $strGMT = date('O',$intDate);
      $strGMT = substr($strGMT,0,3).':'.substr($strGMT,-2,2);
      $strDate = $strDate.$strGMT;
      break;
  }

  // Translating

  if ( isset($arr) )
  {
    if ( is_array($arr) )
    {
    $strDate = str_replace(array_keys($arr),array_values($arr),$strDate);
    }
  }

  return $strDate;
}

function QTtime($d='now',$ftime='G:i',$onerror=null)
{

  // check input
  if ( !is_string($ftime) || empty($ftime) ) { if ( isset($onerror) ) return $onerror; die('QTdate: arg #2 must be a string'); }
  if ( $d=='now' ) $d = date('Hi');

  // convert
  $d = QTconv(strval($d),'T');

  // check if successful

  if ( !QTisvalidtime($d) ) return "Cannot make time from [$d]";

  // Format the result (first create a unix timestamp)
  $d = mktime( intval(substr($d,0,2)),intval(substr($d,2,2)),intval(substr($d,4,2)) );
  return date($ftime,$d);
}

/* ============
 * QTbbc
 * ------------
 * Convert bbc to html (or drop bbc).
 * Attention: It also converts < and >, and does NOT perform a striptags (html code will remains "readable")
 * ------------
 * $str       : [mandatory] a string than can contains bbc tags
 * $output    : 'html' to convert the bbc tags to html tags
 *            : 'drop' to remove the bbc tags (and smiles)
 *            : 'deepdrop' to remove the bbc tags and the Cite/Code tags arround the Quote/Code blocs
 * $nl        : convert \r\n, \r or \n to $nl. Use FALSE to not convert.
 * $length    : truncate at length $length. Use 0 to not truncate.
 * $beforediv : (optional) tag to use before a bloc ([quote] or [code])
 * $afterdiv  : (optional) tag to use after a bloc ([quote] or [code])
 * ------------
 * Examples
 * QTbbc( '[b]Text[/b]',       'html' )  -->   <b>Text</b>
 * QTbbc( '[i]<b>Text<b>[/i]', 'html' )  -->   <i>&lt;b&gt;Text&lt;/b&gt;</i>
 * QTbbc( '[u]Text[/u]',       'drop' )  -->   Text
 * QTbbc( '[u]<b>Text<b>[/u]', 'drop' )  -->   &lt;b&gt;Text&lt;/b&gt;
 * ------------
 * Remarks
 * 'drop'     will convert '[quote]hello[/quote]' into 'Quotation: <cite>hello</cite>'
 * 'deepdrop' will convert '[quote]hello[/quote]' into 'hello'
 * Same principle for for the bbc [code]
 * For css users, output 'html' will convert the bbc quote,code,smile into a object having classes named div_quote, div_code and img_smile.
 * ============ */

function QTbbc($str,$output='html',$nl='<br/>',$length=0, $beforediv='', $afterdiv='', $onerror=null)
{
  // check

  if ( !is_string($str) ) { if ( isset($onerror) ) return $onerror; die('QTbbc: arg #1 must be a string'); }
  if ( !in_array($output,array('html','drop','deepdrop')) ) { if ( isset($onerror) ) return $onerror; die('QTbbc: arg #2 must be "html", "drop" or "deepdrop"'); }
  if ( !is_string($nl) ) { if ( isset($onerror) ) return $onerror; die('QTbbc: arg #3 must be a string'); }

  // process

  $arrSearch = array (
  '/</',
  '/>/',
  '/\[b\](.*?)\[\/b\]/',
  '/\[i\](.*?)\[\/i\]/',
  '/\[u\](.*?)\[\/u\]/',
  '/\[\*\]/',
  '/\[img\](.*?)\[\/img\]/',
  '/\[url\](.*?)\[\/url\]/',
  '/\[url\=(.*?)\](.*?)\[\/url\]/',
  '/\[mail\](.*?)\[\/mail\]/',
  '/\[mail\=(.*?)\](.*?)\[\/mail\]/',
  '/\[color\=(.*?)\](.*?)\[\/color\]/',
  '/\[size=(.*?)\](.*?)\[\/size\]/',
  '/\[quote\]/',
  '/\[quote\=(.*?)\]/',
  '/\[\/quote\]/',
  '/\[code\]/',
  '/\[\/code\]/');

  switch ($output)
  {

  case 'html' :
    $arrReplace = array (
    '&lt;',
    '&gt;',
    '<b>$1</b>',
    '<i>$1</i>',
    '<span class="u">$1</span>',
    '&bull;',
    '<div class="div_img_msg"><img class="img_msg" src="$1" alt="[image]" title=""/></div>',
    '<a href="http://$1" target="_blank">$1</a>',
    '<a href="http://$2" target="_blank">$1</a>',
    '<a href="mailto:$1">$1</a>',
    '<a href="mailto:$2">$1</a>',
    '<font color="$1">$2</font>',
    '<span style="font-size:$1pt">$2</span>',
    $beforediv.'<div class="div_quotetitle">Quotation:</div><div class="div_quote">',
    '<div class="div_quotetitle">Quotation by $1:</div><div class="div_quote">',
    '</div>'.$afterdiv,
    $beforediv.'<div class="div_codetitle">Code:</div><div class="div_code">',
    '</div>'.$afterdiv);
    break;

  case 'drop' :
    $arrReplace = array(
    '&lt;','&gt;',
    '$1','$1','$1','$1','$1','$1','$1','$1','$1','$1','$1',
    'Quotation: ','Quotation by $1:','',
    'Code: ','');

  case 'deepdrop' :
    $arrReplace = array(
    '&lt;','&gt;',
    '$1','$1','$1','$1','$1','$1','$1','$1','$1','$1','$1',
    '','','','','');
  }

  $str = preg_replace( $arrSearch, $arrReplace, $str );
  $str = str_replace( array('http://http','http://ftp:','http://mailto:','mailto:mailto:'), array('http','ftp:','mailto:','mailto'), $str ); // special check for the href error
  if ( is_string($nl) ) $str = str_replace( array("\r\n","\r","\n"), $nl, $str );

  if ( is_numeric($length) ) {
  if ( $length>0 ) {
  if ( strlen($str)>$length ) {
    $str = substr($str,0,$length).' ...';
  }}}

  return $str;
}

/* ============
 * QTconv
 * ============ */

function QTconv($str,$to='1',$bConvAmp=false,$bDroptags=true,$onerror=null)
{
  if ( !is_string($str) ) { if ( isset($onerror) ) return $onerror; die('QTconv: arg #1 must be a string'); }
  if ( empty($str) ) return $str;
  if ( !is_string($to) ) { if ( isset($onerror) ) return $onerror; die('QTconv: arg #2 must be a string'); }
  if ( !is_bool($bConvAmp) ) { if ( isset($onerror) ) return $onerror; die('QTconv: arg #3 must be a boolean'); }
  if ( !is_bool($bDroptags) ) { if ( isset($onerror) ) return $onerror; die('QTconv: arg #4 must be a boolean'); }

  // optional drop tags

  if ( $bDroptags ) $str = strip_tags($str);

  // optional force convert & (to disallow symbol)

  if ( $to=='3' && $bConvAmp ) $to='4';

  // U special for username and password
  // I special for input form: convert & to &amp; but not &quote; nor &#039;
  // 1 converts "          // -1 converts &quot;
  // 2 converts " '        // -2 converts &quot; &#039;
  // 3 converts " ' < >    // -3 converts &quot; &#039; &lt; &gt;
  // 4 converts " ' < > &  // -4 converts &quot; &#039; &lt; &gt; &amp;
  // 5 converts to htmlentities but restore the &amp; > &
  // 6 converts to htmlentities
  // K special for keycode
  // F special for filename
  // T convert to time HHMMSS (from HHMM,HH:MM[:SS],...) add 00 if no second

  switch ($to)
  {
  case 'U':
    return substr(htmlspecialchars(trim($str),ENT_QUOTES),0,24);
    break;
  case 'I':
    if ( strstr($str,'&') )
    {
    $str = str_replace('&','&amp;',$str);
    $str = str_replace('&amp;quot;','&quot;',$str);
    $str = str_replace('&amp;#039;','&#039;',$str);
    }
    break;
  case '1':
    $str = str_replace('"','&quot;',$str);
    break;
  case '2':
    $str = str_replace('"','&quot;',$str);
    $str = str_replace("'",'&#039;',$str);
    break;
  case '3':
    $str = str_replace('"','&quot;',$str);
    $str = str_replace("'",'&#039;',$str);
    $str = str_replace('<','&lt;',$str);
    $str = str_replace('>','&gt;',$str);
    break;
  case '4':
    $str = htmlspecialchars($str,ENT_QUOTES);
    break;
  case '5':
    $str = htmlentities($str,ENT_QUOTES);
    if ( strstr($str,'&') ) $str = str_replace('&amp;','&', $str);
    break;
  case '6':
    $str = htmlentities($str,ENT_QUOTES);
    break;
  case '-1':
    $str = str_replace('&quot;','"',$str);
    break;
  case '-2':
    $str = str_replace('&quot;','"',$str);
    $str = str_replace('&#039;',"'",$str);
    break;
  case '-3':
    $str = str_replace('&quot;','"',$str);
    $str = str_replace('&#039;',"'",$str);
    $str = str_replace('&lt;','<',$str);
    $str = str_replace('&gt;','>',$str);
    break;
  case '-4':
    $str = str_replace('&quot;','"', $str);
    $str = str_replace('&#039;',"'", $str);
    if ( strstr($str,'&') )
    {
    $str = str_replace('&amp;','&', $str);
    $str = str_replace('&#39;',"'", $str);
    $str = str_replace('&lt;','<', $str);
    $str = str_replace('&gt;','>', $str);
    }
    break;
  case 'K':
    $str=strtr($str,'éèêëÉÈÊËáàâäÁÀÂÄÅåíìîïÍÌÎÏóòôöÓÒÔÖõÕúùûüÚÙÛÜ','eeeeeeeeaaaaaaaaaaiiiiiiiioooooooooouuuuuuuu');
    $str=strtolower($str);
    $str=preg_replace('/[^a-z0-9_\-\.]/i', '_', $str);
    break;
  case 'T':
    $str = strtr(trim($str),':,.;-HhMmSsUu','             ');
    if ( !strstr(trim($str),' ') && strlen($str)>5 ) $str = substr($str,0,2).' '.substr($str,2,2).' '.substr($str,-2,2);
    if ( !strstr(trim($str),' ') && strlen($str)>3 ) $str = substr($str,0,2).' '.substr($str,2,2);
    $arr = explode(' ',$str);
    $str = $arr[0].$arr[1].(count($arr)>2 ? $arr[2] : '00');
    break;
  }
  if ( strlen($str)>4000 ) $str = substr($str,0,4000);
  return trim($str);
}

/* ============
 * QTinvert
 * ------------
 * This will invert a value (see the list in the code). Return NULL for unknown values.
 * Value must be uppercase
 * ============ */

function QTinvert($str,$onerror=null)
{
  switch($str)
  {
  case 'ASC':  return 'DESC'; break;
  case 'DESC': return 'ASC';  break;
  case 'Y':    return 'N';    break;
  case 'N':    return 'Y';    break;
  case 'YES':  return 'NO';   break;
  case 'NO':   return 'YES';  break;
  case '1':    return '0';    break;
  case '0':    return '1';    break;
  case 1:      return 0;      break;
  case 0:      return 1;      break;
  }
  return NULL;
}

/* ============
 * QTispassword / islogin / ismail /isbetween / isvaliddate
 * ------------
 * These functions shows an error message when the principal argument(s) is not of the correct type.
 * About login/password:
 *   Return FALSE if the text is not trimmed
 *   Return FALSE when text includes unacceptable characters
 *     a login can contain the ' caracter while a password cannot.
 *     both login and password cannot contain " < > \ /
 *     for caracters after z, only a few accents are supported .
 * About validdate:
 *   This function will check date like YYYYMMDD (as string or as number). Options allow also to rejet past/futur year.
 * ============ */

function QTislogin($str,$intMin=4,$intMax=24,$onerror=null)
{
  if ( !is_string($str) ) { if ( isset($onerror) ) return $onerror; die('QTislogin: arg #1 must be a string'); }
  if ( !is_numeric($intMin) ) { if ( isset($onerror) ) return $onerror; die('QTislogin: arg #2 must be a numeric'); }
  if ( !is_numeric($intMax) ) { if ( isset($onerror) ) return $onerror; die('QTislogin: arg #3 must be a numeric'); }

  if ( $str!=trim($str) ) return false;
  if ( strstr($str,'\\') ) return false; //' check this
  if ( strstr($str,'<') ) return false;
  if ( strstr($str,'>') ) return false;
  if ( !ereg('^[#-z éèçôîêñß§\!]+$',$str) ) return false;
  if ( $str!=strip_tags($str) ) return false;
  if ( strlen($str)>$intMax ) return false;
  if ( strlen($str)<$intMin ) return false;
  return true;
}
function QTispassword($str,$intMin=4,$intMax=24,$onerror=null)
{
  if ( !is_string($str) ) { if ( isset($onerror) ) return $onerror; die('QTispassword: arg #1 must be a string'); }
  if ( !is_numeric($intMin) ) { if ( isset($onerror) ) return $onerror; die('QTispassword: arg #2 must be a numeric'); }
  if ( !is_numeric($intMax) ) { if ( isset($onerror) ) return $onerror; die('QTispassword: arg #3 must be a numeric'); }

  // password cannot contain apostrophe while login can
  if ( strstr($str,"'") ) return false;
  // uses QTislogin
  if ( !QTislogin($str,$intMin,$intMax,$onerror) ) return false;
  return true;
}
function QTismail($str,$onerror=null)
{
  if ( !is_string($str) ) { if ( isset($onerror) ) return $onerror; die('QTismail: arg #1 must be a string'); }

  if ( $str!=trim($str) ) return false;
  if ( $str!=strip_tags($str) ) return false;
  if ( !ereg('^.+@.+\..+$',$str) ) return false;
  return true;
}
function QTisbetween($intValue,$intMin=0,$intMax=99999,$onerror=null)
{
  if ( $intValue=='') return false;
  if ( !is_numeric($intValue) ) { if ( isset($onerror) ) return $onerror; die('QTisbetween: arg #1 must be a numeric (or a number as string)'); }
  if ( !is_numeric($intMin) ) { if ( isset($onerror) ) return $onerror; die('QTisbetween: arg #2 must be a numeric (or a number as string)'); }
  if ( !is_numeric($intMax) ) { if ( isset($onerror) ) return $onerror; die('QTisbetween: arg #3 must be a numeric (or a number as string)'); }

  if ( $intValue<$intMin ) return false;
  if ( $intValue>$intMax ) return false;
  return true;
}
function QTisvaliddate($d,$bPast=true,$bFutur=false,$onerror=null) // allow past year, disallow futur year
{
  if ( is_string($d) ) { if ( substr($d,0,6)=='Cannot' ) return false; }
  if ( !is_numeric($d) ) { if ( isset($onerror) ) return $onerror; die('QTisvaliddate: arg #1 must be a number like YYYYMMDD (as number or as string)'); }
  if ( !is_bool($bPast) ) { if ( isset($onerror) ) return $onerror; die('QTisvaliddate: arg #2 must be a bolean'); }
  if ( !is_bool($bFutur) ) { if ( isset($onerror) ) return $onerror; die('QTisvaliddate: arg #3 must be a bolean'); }

  $str = strval($d);
  if ( strlen($str)!=8 ) { if ( isset($onerror) ) return $onerror; die('QTisvaliddate: arg #1 must be a number like YYYYMMDD (as number or as string)'); }
  $intY = intval(substr($str,0,4));
  $intM = intval(substr($str,4,2));
  $intD = intval(substr($str,-2,2));
  if ( $intY<1900 ) return false;
  if ( $intM<1 || $intM>12 ) return false;
  if ( $intD<1 || $intD>31 ) return false;
  if ( !$bPast ) { if ( $intY<date('Y') ) return false; }
  if ( !$bFutur ) { if ( $intY>date('Y') ) return false; }
  if ( !checkdate($intM,$intD,$intY) ) return false;
  return true;
}
function QTisvalidtime($d,$onerror=null)
{
  if ( is_string($d) ) { if ( substr($d,0,6)=='Cannot' ) return false; }
  if ( !is_numeric($d) ) { if ( isset($onerror) ) return $onerror; die('QTisvaliddate: arg #1 must be a time like HHMM or HHMMSS (as number or as string)'); }

  $d = strval($d);
  if ( strlen($d)!=4 && strlen($d)!=6 ) { if ( isset($onerror) ) return $onerror; die('QTisvaliddate: arg #1 must be a time like HHMM or HHMMSS (as number or as string)'); }
  if ( !QTisbetween(substr($d,0,2),0,23) ) return false;
  if ( !QTisbetween(substr($d,2,2),0,59) ) return false;
  if ( strlen($d)==6 ) { if ( !QTisbetween(substr($d,4,2),0,59) ) return false; }
  return true;
}

?>