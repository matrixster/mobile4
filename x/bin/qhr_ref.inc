<?php

// QuickTicket 1.9.0.3 build:20081001

if ( !defined('QTI_HTML_DTD') ) define ('QTI_HTML_DTD', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/2002/REC-xhtml1-20020801/DTD/xhtml1-strict.dtd">');
if ( !defined('QTI_HTML_CHAR') ) define ('QTI_HTML_CHAR', 'iso-8859-1');
if ( !defined('QTI_HTML_DIR') ) define ('QTI_HTML_DIR', 'ltr');
if ( !defined('QTI_HTML_LANG') ) define ('QTI_HTML_LANG', 'en');

// Is is recommended to always use capital on first letter in the translation, script changes to lower case if necessary.
// The character doublequote ["] is FORBIDDEN (reserved for html tags)
// To make a single quote use slashe [\']

// -------------
// TOP LEVEL VOCABULARY
// -------------

// Use the top level vocabulary to give the most appropriate name
// for the topics (object items) managed by this application.
// e.g. Ticket, Incident, Subject, Thread, Request, Faq,...

$L['Topic']='Ticket';
$L['Topics']='Tickets';
$L['topic']=strtolower($L['Topic']);
$L['topics']=strtolower($L['Topics']);

// The top level words are re-used in a lot of translations defined here after

$L['Y']='Yes';
$L['N']='No';
$L['Ok']='Ok';

// Specific vocabulary

$L['Domain']='Domain';
  $L['Domains']='Domains';
$L['Section']='Section';
  $L['Sections']='Sections';
$L['Topic_add']='New ticket';
  $L['Topic_del']='Delete ticket';
  $L['Topic_upd']='Update ticket';
  $L['Topic_man']='Manage tickets';
$L['User']='User';
  $L['Users']='Users';
  $L['User_add']='New user';
  $L['User_del']='Delete user';
  $L['User_upd']='Edit profile';
  $L['User_man']='Manage users';
$L['Status']='Status';
  $L['Statuss']='Status';
  $L['Status_add']='New status';
  $L['Status_del']='Delete status';
  $L['Status_upd']='Edit status';
  $L['Status_man']='Manage status';
$L['Message']='Message';
  $L['Messages']='Messages';
  $L['Message_deleted']='Message deleted...';
$L['Forward']='Forward';
  $L['Forwards']='Forwards';
$L['Reply']='Reply';
  $L['Replys']='Replies';
$L['News']='News';
  $L['Newss']='News'; // In other languages: News=One news, Newss=Several news
  $L['News_stamp']='News: '; //put a space after the stamp
$L['First_message']='First&nbsp;message';
$L['Last_message']='Last&nbsp;message';
$L['Attachment']='Attachment';
$L['Notify_also']='Notify also';
$L['Drop_attachment']='Drop&nbsp;attachment';
$L['Wisheddate']='Wished&nbsp;date';
$L['H_Wisheddate']='(yyyy-mm-dd) desired delivery date';
$L['Ref']='Ref.';
$L['Title']='Title';
$L['Smiley']='Prefix icon';
$L['Notification']='Notification';
$L['Username']='Username';
  $L['Userrole']['A']='Administrator'; $L['Userroles']['A']='Administrators';
  $L['Userrole']['M']='Staff member';  $L['Userroles']['M']='Staff members';
  $L['Userrole']['U']='User';          $L['Userroles']['U']='Users';
  $L['Userrole']['V']='Visitor';       $L['Userroles']['V']='Visitors';
  $L['Userrole_MF']='Section coordinator';
  $L['Userrole_MA']='Actor';
  $L['Userrole_UN']='Notified user';
$L['Joined']='Joined';
$L['Avatar']='Photo';
$L['Signature']='Signature';
$L['Role']='Role';
$L['Topic_starter']='Author';
$L['Modified_by']='Modified by';
$L['Deleted_by']='Deleted by';
$L['Top_participants']='Top participants';
$L['Password']='Password';

// Common

$L['Add']='Add';
$L['Advanced_reply']='Preview...';
$L['All']='All';
$L['By']='By';
$L['Change']='Change';
$L['Change_status']='Change status...';
$L['Change_type']='Change type...';
$L['Changed']='Changed';
$L['Close']='Close';
$L['Closed']='Closed';
$L['Containing']='Containing';
$L['Date']='Date';
$L['Dates']='Dates';
$L['Day']='Day';
$L['Days']='Days';
$L['Details']='Details';
$L['Destination']='Destination';
$L['Display_at']='Display at date';
$L['Email']='E-mail'; $L['No_Email']='No e-mail';
$L['Exit']='Exit';
$L['First']='First';
$L['Goodbye']='You are disconnected... Goodbye';
$L['Goto']='Jump to';
$L['H_Website']='Url of your website (with http://)';
$L['Help']='Help';
$L['Hidden']='Hidden';
$L['I_wrote']='I wrote';
$L['Information']='Information';
$L['Items_per_month']='Tickets per month';
$L['Items_per_month_cumul']='Cumulative tickets per month';
$L['Last']='Last';
$L['Legend']='Legend';
$L['Location']='Location';
$L['Maximum']='Maximum';
$L['Minimum']='Minimum';
$L['Month']='Month';
$L['More']='More';
$L['Next']='Next';
$L['None']='None';
$L['Options']='Options';
$L['Page']='page';
$L['Pages']='pages';
$L['Phone']='Phone';
$L['Preview']='Preview';
$L['Previous']='Previous';
$L['Reason']='Reason';
$L['Remove']='Remove';
$L['Result']='Result';
$L['Results']='Results';
$L['Save']='Save';
$L['Seconds']='Seconds';
$L['Selected_from']='selected from';
$L['Send']='Send';
$L['Send_on_behalf']='Send on behalf of';
$L['Statistics']='Statistics';
$L['Total']='Total';
$L['Type']='Type';
$L['Website']='Website'; $L['No_Website']='No website';
$L['Welcome']='Welcome';
$L['Welcome_to']='We welcome a new member, ';
$L['Year']='Year';

// Menu

$L['FAQ']='FAQ';
$L['Search']='Search';
$L['Memberlist']='Memberlist';
$L['Login']='Log&nbsp;in';
$L['Logout']='Log&nbsp;out';
$L['Register']='Register';
$L['Profile']='Profile';
$L['Administration']='Administration';
$L['Privacy']='Privacy';
$L['Coppa_form']='Coppa&nbsp;form';

// Section // use &nbsp; to avoid double ligne buttons

$L['Post_new_topic']='Post&nbsp;new&nbsp;ticket';
$L['Post_reply']='Reply';
$L['Topic_closed']='Ticket&nbsp;closed';
$L['Goto_message']='[<b>&raquo;</b>]';
$L['H_Goto_message']='View last message';

$L['My_last_topic']='My&nbsp;last&nbsp;ticket';
$L['All_my_topics']='All&nbsp;my&nbsp;tickets';
$L['All_my_assigned']='Assigned&nbsp;tickets';
$L['Topic_handled']='Ticket handled';
$L['Topics_handled']='Tickets handled';
$L['Topic_forwarded']='Ticket has been forwarded to %s.';

$L['You_reply']='I replied';
$L['Quote']='Quote';
$L['Edit']='Edit';
$L['Delete']='Delete';
$L['Move']='Move';
$L['Move_to']='Move to';
$L['Change_actor']='Change actor';
$L['Close_my_topic']='I close my ticket';

$L['Quick_reply']='Quick reply';
$L['Previous_replies']='Previous replies';
$L['Close_topic']='Close the ticket';
$L['Edit_message']='Edit message';
$L['Delete_message']='Delete message';

$L['Move_keep']='Keep source reference';
$L['Move_reset']='Reset reference to zero';
$L['Move_follow']='Renumber following the destination section';

$L['Topic_closed_show']='Show closed tickets';
$L['Topic_closed_hide']='Hide closed tickets';
$L['Topic_news_show']='Show news';
$L['Topic_news_hide']='Hide news';
$L['Topic_show_all']='Show all sections at once';
$L['Topic_show_this']='Show this section only';
$L['Last_column']='Extra column';
$L['Last_column_label']['replies']=$L['Replys'];
$L['Last_column_label']['views']='Views';
$L['Last_column_label']['wisheddate']=$L['Wisheddate'];
$L['Last_column_label']['status']=$L['Status'];
$L['Last_column_label']['id']='Id';
$L['Last_column_label']['actorname']=$L['Userrole_MA'];
$L['Last_column_label']['notifiedname']=$L['Userrole_UN'];

// Stats

$L['General_site']='General site';
$L['Board_start_date']='Board start date';
$L['Distinct_users']='Distinct users (having posted a message)';

// Search

$L['Advanced']='Advanced search...';
$L['H_Advanced']='(type a ticket number or a keyword)';
$L['Recent_messages']='Recent&nbsp;tickets';
$L['All_news']='All&nbsp;news';
$L['All_my_topics']='All&nbsp;my&nbsp;tickets';
$L['Keywords']='Keyword(s)';
$L['Search_by_key']='Search by keyword(s)';
$L['Search_by_ref']='Search reference number';
$L['Search_by_status']='Search by status';
$L['Search_result']='Search result';
$L['In_title_only']='In title only';
$L['In_all_sections']='In all sections';
$L['H_Reference']='(type the numeric part only)';
$L['Too_many_keys']='Too many keys';
$L['Search_by_words']='Search each word separately';
$L['Search_exact_words']='Search exact words';
$L['Search_by_date']='Search by date';
$L['At_least_0']='With or without reply';
$L['At_least_1']='At least 1 reply';
$L['At_least_2']='At least 2 replies';
$L['At_least_3']='At least 3 replies';
$L['This_week']='This week';
$L['This_month']='This month';
$L['This_year']='This year';

// Restrictions

$L['R_login_register']='Access is restricted to members only.<br/><br/>Please log in, or proceed to registration to become member.';
$L['R_member']='Access is restricted to members only. <a href="qti_index.php">Exit</a>';
$L['R_moderator']='Access is restricted to staff members only. <a href="qti_index.php">Exit</a>';

// Errors

$L['E_access']='Access denied...';
$L['E_section_closed']='Section is closed';
$L['E_no_public_section']='The board does not contain any public section. Private section access requires login.';
$L['E_invalid']='invalid';
$L['E_wait']='Please wait a few seconds';
$L['E_too_much']='Too much posts today...<br/><br/>For security reasons, the number of posts allowed is limited. Try again tomorrow. Thanks.';
$L['E_too_long']='Message too long';
$L['E_char_max']='(maximum %d characters)';
$L['E_line_max']='(maximum %d lines)';
$L['E_no_title']='Please give a title to this new ticket';
$L['E_topic_private']='(or tickets are private)';
$L['E_mandatory']='Mandartory field is empty';
$L['E_missing_http']='The url must start with http:// or https://';
$L['E_javamail']='Protection: java required to see e-mail addresses';
$L['E_text']='Problem with your text.';
$L['E_file_size']='File is too large';
$L['E_already_used']='Already used';
$L['E_ref_search']='Decimal number (or comma) not valid. Use quotes if you want to search a number as keyword.';

// Success

$L['S_update']='Update successful...';
$L['S_delete']='Delete completed...';
$L['S_insert']='Creation successful...';
$L['S_save']='Successfully saved...';
$L['S_message_saved']='Message saved...<br/>Thank you';

// Dates

$L['dateMMM']=array(1=>'January','February','March','April','May','June','July','August','September','October','November','December');
$L['dateMM'] =array(1=>'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
$L['dateM']  =array(1=>'J','F','M','A','M','J','J','A','S','O','N','D');
$L['dateDDD']=array(1=>'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
$L['dateDD'] =array(1=>'Mon','Tue','Wed','Thu','Fri','Sat','Sun');
$L['dateD']  =array(1=>'M','T','W','T','F','S','S');
$L['dateSQL']=array(
  'January'  => 'January',
  'February' => 'February',
  'March'    => 'March',
  'April'    => 'April',
  'May'      => 'May',
  'June'     => 'June',
  'July'     => 'July',
  'August'   => 'August',
  'September'=> 'September',
  'October'  => 'October',
  'November' => 'November',
  'December' => 'December',
  'Monday'   => 'Monday',
  'Tuesday'  => 'Tuesday',
  'Wednesday'=> 'Wednesday',
  'Thursday' => 'Thursday',
  'Friday'   => 'Friday',
  'Saturday' => 'Saturday',
  'Sunday'   => 'Sunday',
  'Today'=>'Today',
  'Yesterday'=> 'Yesterday',
  'Jan'=>'Jan',
  'Feb'=>'Feb',
  'Mar'=>'Mar',
  'Apr'=>'Apr',
  'May'=>'May',
  'Jun'=>'Jun',
  'Jul'=>'Jul',
  'Aug'=>'Aug',
  'Sep'=>'Sep',
  'Oct'=>'Oct',
  'Nov'=>'Nov',
  'Dec'=>'Dec',
  'Mon'=>'Mon',
  'Tue'=>'Tue',
  'Wed'=>'Wed',
  'Thu'=>'Thu',
  'Fri'=>'Fri',
  'Sat'=>'Sat',
  'Sun'=>'Sun');

?>