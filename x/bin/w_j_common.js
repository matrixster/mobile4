// QHR 1.1.0.1 build:20090101

function html_entity_decode(str)
{
  var ta=document.createElement("textarea");
  ta.innerHTML=str.replace(/</g,"&lt;").replace(/>/g,"&gt;");
  return ta.value;
}

function vmail(id)
{
  var str = document.getElementById('href'+id).href;
  str = str.replace(/-at-/g,'@');
  str = str.replace(/-dot-/g,'.');
  str = str.replace('javamail:','mailto:');
  document.getElementById('href'+id).href = str;
  if ( document.getElementById('img'+id) )
  {
  str = document.getElementById('img'+id).title;
  str = str.replace(/-at-/g,'@');
  str = str.replace(/-dot-/g,'.');
  document.getElementById('img'+id).title = str;
  }
  return null;
}

function hmail(id)
{
  var str = document.getElementById('href'+id).href;
  str = str.replace(/\@/g,'-at-');
  str = str.replace(/\./g,'-dot-');
  str = str.replace('javamail:','mailto:');
  document.getElementById('href'+id).href = str;
  if ( document.getElementById('img'+id) )
  {
  str = document.getElementById('img'+id).title;
  str = str.replace(/\@/g,'-at-');
  str = str.replace(/\./g,'-dot-');
  document.getElementById('img'+id).title = str;
  }
  return null;
}
function writemailto(str1,str2,separator)
{
  document.write('<a class="small" href="mailto:' + str1 + '@' + str2 + '">');
  document.write(str1 + '@' + str2);
  document.write('</a>');
  if ( separator ) document.write(separator);
}

function handle_keypress(e,s)
{
  if ( window.event )
  {
  if (e.keyCode==13) document.getElementById(s).click();
  }
  return null;
}