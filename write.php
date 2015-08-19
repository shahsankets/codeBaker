<?php require_once("codelibrary/inc/db.php");
    require_once("codelibrary/inc/functions.php");
                   
/**
*@author RN Kushwaha
*@email at Rn.kushwaha022@gmail.com
*@created 5th April 2014
*/

    @extract($_REQUEST);
    validate_admin();
    if( $_POST["submitForm"]=="yes"){
        $contents = $_POST['contents'];
        touch($_POST['file']);
        file_put_contents($_POST['file'], $contents);
        header("Location: ".$_SERVER[http_referer]) ;
        exit;
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit | Files :: <?php echo SITE_ADMIN_TITLE;?></title>
<link href="codelibrary/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include("header.inc.php");?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="180" valign="top" class="rightBorder">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><?php include("left_menu.inc.php");?></td>
        </tr>
        <tr>
          <td width="23">&nbsp;</td>
        </tr>
      </table>
    <br />
    <br /></td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td height="400" align="center" valign="top">
	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="21" align="left" class="txt">
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="title">
                    <tr>
                      <td width="76%" height="25"><img src="images/heading_icon.gif" width="16" height="16" hspace="5">Manage Files </td>
                      <td width="24%" align="right"><input name="b1" type="button" class="button1" id="b1" value="Manage Files" onClick="location.href='generator_list.php'">
                      &nbsp;</td>
                    </tr>
              </table>
	</td>
          </tr>
          <tr>
            <td height="400" align="center" valign="top"><br>
			  <form action="" method="post" enctype="multipart/form-data" name="frm" onSubmit="return validate(this)">
                          
                           <table width="94%" border="0" align="center" cellpadding="4" cellspacing="0" >
			  <input type="hidden" name="submitForm" value="yes">
			  <input type="hidden" name="file" class="txtfld" value="<?php echo urlencode($_GET['file']);?>">
                          
			<tr class="evenRow">
                            <td align="left" colspan="2" class="txt" style="border:1px solid #ccc;"> 
                                <textarea name="contents" class="txtfld" id="jform_source" rows="27" cols="137" style="padding: 5px;"><?php echo trim(htmlentities(file_get_contents($_REQUEST['file'])));?></textarea></td>
                        </tr>
                <tr class="evenRow">
                    <td align=center colspan=100%>
                        <input type="submit" name="submit" class="button1" value="Submit" id="submitbtn1"/> 
                        <input type="reset" name="reset" class="button1" value="Reset" id="submitbtn3"/>
                    </td>
            </tr>
            </table>
            </form>
            </td>
       </tr>
     </table>
    </td>
  </tr>
</table>
<?php include("footer.inc.php");?>
    <script>
    var CodeMirrorConfig=window.CodeMirrorConfig||{},CodeMirror=function(){function D(a,b){for(var c in b)a.hasOwnProperty(c)||(a[c]=b[c])}function E(a,b){for(var c=0;c<a.length;c++)b(a[c])}function s(a){return document.createElementNS&&document.documentElement.namespaceURI!==null?document.createElementNS("http://www.w3.org/1999/xhtml",a):document.createElement(a)}function F(a,b){var c=s("div"),e=s("div");c.style.position="absolute";c.style.height="100%";if(c.style.setExpression)try{c.style.setExpression("height",
"this.previousSibling.offsetHeight + 'px'")}catch(f){}c.style.top="0px";c.style.left="0px";c.style.overflow="hidden";a.appendChild(c);e.className="CodeMirror-line-numbers";c.appendChild(e);e.innerHTML="<div>"+b+"</div>";return c}function G(a){if(typeof a.parserfile=="string")a.parserfile=[a.parserfile];if(typeof a.basefiles=="string")a.basefiles=[a.basefiles];if(typeof a.stylesheet=="string")a.stylesheet=[a.stylesheet];var b=' spellcheck="'+(a.disableSpellcheck?"false":"true")+'"',c=['<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html'+
b+"><head>"];c.push('<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>');var e=a.noScriptCaching?"?nocache="+(new Date).getTime().toString(16):"";E(a.stylesheet,function(f){c.push('<link rel="stylesheet" type="text/css" href="'+f+e+'"/>')});E(a.basefiles.concat(a.parserfile),function(f){/^https?:/.test(f)||(f=a.path+f);c.push('<script type="text/javascript" src="'+f+e+'"><\/script>')});c.push('</head><body style="border-width: 0;" class="editbox"'+b+"></body></html>");return c.join("")}
function t(a,b){this.options=b=b||{};D(b,CodeMirrorConfig);if(b.dumbTabs)b.tabMode="spaces";else if(b.normalTab)b.tabMode="default";if(b.cursorActivity)b.onCursorActivity=b.cursorActivity;var c=this.frame=s("iframe");if(b.iframeClass)c.className=b.iframeClass;c.frameBorder=0;c.style.border="0";c.style.width="100%";c.style.height="100%";c.style.display="block";var e=this.wrapping=s("div");e.style.position="relative";e.className="CodeMirror-wrapping";e.style.width=b.width;e.style.height=b.height=="dynamic"?
b.minHeight+"px":b.height;var f=this.textareaHack=s("textarea");e.appendChild(f);f.style.position="absolute";f.style.left="-10000px";f.style.width="10px";f.tabIndex=1E5;c.CodeMirror=this;if(b.domain&&H){this.html=G(b);c.src="javascript:(function(){document.open();"+(b.domain?'document.domain="'+b.domain+'";':"")+"document.write(window.frameElement.CodeMirror.html);document.close();})()"}else c.src="javascript:;";a.appendChild?a.appendChild(e):a(e);e.appendChild(c);if(b.lineNumbers)this.lineNumbers=
F(e,b.firstLineNumber);this.win=c.contentWindow;if(!b.domain||!H){this.win.document.open();this.win.document.write(G(b));this.win.document.close()}}D(CodeMirrorConfig,{stylesheet:[],path:"",parserfile:[],basefiles:["util.js","stringstream.js","select.js","undo.js","editor.js","tokenize.js"],iframeClass:null,passDelay:200,passTime:50,lineNumberDelay:200,lineNumberTime:50,continuousScanning:false,saveFunction:null,onLoad:null,onChange:null,undoDepth:50,undoDelay:800,disableSpellcheck:true,textWrapping:true,
readOnly:false,width:"",height:"300px",minHeight:100,onDynamicHeightChange:null,autoMatchParens:false,markParen:null,unmarkParen:null,parserConfig:null,tabMode:"indent",enterMode:"indent",electricChars:true,reindentOnLoad:false,activeTokens:null,onCursorActivity:null,lineNumbers:false,firstLineNumber:1,onLineNumberClick:null,indentUnit:2,domain:null,noScriptCaching:false,incrementalLoading:false});var H=document.selection&&window.ActiveXObject&&/MSIE/.test(navigator.userAgent);t.prototype={init:function(){this.options.initCallback&&
this.options.initCallback(this);if(this.options.onLoad)this.options.onLoad(this);this.options.lineNumbers&&this.activateLineNumbers();this.options.reindentOnLoad&&this.reindent();this.options.height=="dynamic"&&this.setDynamicHeight()},getCode:function(){return this.editor.getCode()},setCode:function(a){this.editor.importCode(a)},selection:function(){this.focusIfIE();return this.editor.selectedText()},reindent:function(){this.editor.reindent()},reindentSelection:function(){this.focusIfIE();this.editor.reindentSelection(null)},
focusIfIE:function(){this.win.select.ie_selection&&document.activeElement!=this.frame&&this.focus()},focus:function(){this.win.focus();this.editor.selectionSnapshot&&this.win.select.setBookmark(this.win.document.body,this.editor.selectionSnapshot)},replaceSelection:function(a){this.focus();this.editor.replaceSelection(a);return true},replaceChars:function(a,b,c){this.editor.replaceChars(a,b,c)},getSearchCursor:function(a,b,c){return this.editor.getSearchCursor(a,b,c)},undo:function(){this.editor.history.undo()},
redo:function(){this.editor.history.redo()},historySize:function(){return this.editor.history.historySize()},clearHistory:function(){this.editor.history.clear()},grabKeys:function(a,b){this.editor.grabKeys(a,b)},ungrabKeys:function(){this.editor.ungrabKeys()},setParser:function(a,b){this.editor.setParser(a,b)},setSpellcheck:function(a){this.win.document.body.spellcheck=a},setStylesheet:function(a){if(typeof a==="string")a=[a];for(var b={},c={},e=this.win.document.getElementsByTagName("link"),f=0,
d;d=e[f];f++)if(d.rel.indexOf("stylesheet")!==-1)for(var g=0;g<a.length;g++){var n=a[g];if(d.href.substring(d.href.length-n.length)===n){b[d.href]=true;c[n]=true}}for(f=0;d=e[f];f++)if(d.rel.indexOf("stylesheet")!==-1)d.disabled=!(d.href in b);for(g=0;g<a.length;g++){n=a[g];if(!(n in c)){d=this.win.document.createElement("link");d.rel="stylesheet";d.type="text/css";d.href=n;this.win.document.getElementsByTagName("head")[0].appendChild(d)}}},setTextWrapping:function(a){if(a!=this.options.textWrapping){this.win.document.body.style.whiteSpace=
a?"":"nowrap";this.options.textWrapping=a;if(this.lineNumbers){this.setLineNumbers(false);this.setLineNumbers(true)}}},setIndentUnit:function(a){this.win.indentUnit=a},setUndoDepth:function(a){this.editor.history.maxDepth=a},setTabMode:function(a){this.options.tabMode=a},setEnterMode:function(a){this.options.enterMode=a},setLineNumbers:function(a){if(a&&!this.lineNumbers){this.lineNumbers=F(this.wrapping,this.options.firstLineNumber);this.activateLineNumbers()}else if(!a&&this.lineNumbers){this.wrapping.removeChild(this.lineNumbers);
this.wrapping.style.paddingLeft="";this.lineNumbers=null}},cursorPosition:function(a){this.focusIfIE();return this.editor.cursorPosition(a)},firstLine:function(){return this.editor.firstLine()},lastLine:function(){return this.editor.lastLine()},nextLine:function(a){return this.editor.nextLine(a)},prevLine:function(a){return this.editor.prevLine(a)},lineContent:function(a){return this.editor.lineContent(a)},setLineContent:function(a,b){this.editor.setLineContent(a,b)},removeLine:function(a){this.editor.removeLine(a)},
insertIntoLine:function(a,b,c){this.editor.insertIntoLine(a,b,c)},selectLines:function(a,b,c,e){this.win.focus();this.editor.selectLines(a,b,c,e)},nthLine:function(a){for(var b=this.firstLine();a>1&&b!==false;a--)b=this.nextLine(b);return b},lineNumber:function(a){for(var b=0;a!==false;){b++;a=this.prevLine(a)}return b},jumpToLine:function(a){if(typeof a=="number")a=this.nthLine(a);this.selectLines(a,0);this.win.focus()},currentLine:function(){return this.lineNumber(this.cursorLine())},cursorLine:function(){return this.cursorPosition().line},
cursorCoords:function(a){return this.editor.cursorCoords(a)},activateLineNumbers:function(){function a(){if(d.offsetWidth!=0){for(var h=d;h.parentNode;h=h.parentNode);if(!i.parentNode||h!=document||!g.Editor){try{z()}catch(l){}clearInterval(J)}else if(i.offsetWidth!=A){A=i.offsetWidth;d.parentNode.style.paddingLeft=A+"px"}}}function b(){i.scrollTop=q.scrollTop||n.documentElement.scrollTop||0}function c(h){var l=j.firstChild.offsetHeight;if(l!=0){l=Math.ceil((50+Math.max(q.offsetHeight,Math.max(d.offsetHeight,
q.scrollHeight||0)))/l);for(var o=j.childNodes.length;o<=l;o++){var w=s("div");w.appendChild(document.createTextNode(h?String(o+k.options.firstLineNumber):"\u00a0"));j.appendChild(w)}}}function e(){function h(){c(true);b()}k.updateNumbers=h;var l=g.addEventHandler(g,"scroll",b,true),o=g.addEventHandler(g,"resize",h,true);z=function(){l();o();if(k.updateNumbers==h)k.updateNumbers=null};h()}function f(){function h(p,B){r||(r=j.appendChild(s("div")));I&&I(r,B,p);u.push(r);u.push(p);x=r.offsetHeight+
r.offsetTop;r=r.nextSibling}function l(){for(var p=0;p<u.length;p+=2)u[p].innerHTML=u[p+1];u=[]}function o(){if(!(!j.parentNode||j.parentNode!=k.lineNumbers)){for(var p=(new Date).getTime()+k.options.lineNumberTime;m;){for(h(C++,m.previousSibling);m&&!g.isBR(m);m=m.nextSibling)for(var B=m.offsetTop+m.offsetHeight;j.offsetHeight&&B-3>x;){var K=x;h("&nbsp;");if(x<=K)break}if(m)m=m.nextSibling;if((new Date).getTime()>p){l();v=setTimeout(o,k.options.lineNumberDelay);return}}for(;r;)h(C++);l();b()}}function w(p){b();
c(p);m=q.firstChild;r=j.firstChild;x=0;C=k.options.firstLineNumber;o()}function y(){v&&clearTimeout(v);if(k.editor.allClean())w();else v=setTimeout(y,200)}var m,r,C,x,u=[],I=k.options.styleNumbers;w(true);var v=null;k.updateNumbers=y;var L=g.addEventHandler(g,"scroll",b,true),M=g.addEventHandler(g,"resize",y,true);z=function(){v&&clearTimeout(v);if(k.updateNumbers==y)k.updateNumbers=null;L();M()}}var d=this.frame,g=d.contentWindow,n=g.document,q=n.body,i=this.lineNumbers,j=i.firstChild,k=this,A=null;
i.onclick=function(h){var l=k.options.onLineNumberClick;if(l){h=(h||window.event).target||(h||window.event).srcElement;var o=h==i?NaN:Number(h.innerHTML);isNaN(o)||l(o,h)}};var z=function(){};a();var J=setInterval(a,500);(this.options.textWrapping||this.options.styleNumbers?f:e)()},setDynamicHeight:function(){function a(){for(var q=0,i=f.lastChild,j;i&&e.isBR(i);){i.hackBR||q++;i=i.previousSibling}if(i){d=i.offsetHeight;j=i.offsetTop+(1+q)*d}else if(d)j=q*d;if(j){if(b.options.onDynamicHeightChange)j=
b.options.onDynamicHeightChange(j);if(j)b.wrapping.style.height=Math.max(n+j,b.options.minHeight)+"px"}}var b=this,c=b.options.onCursorActivity,e=b.win,f=e.document.body,d=null,g=null,n=2*b.frame.offsetTop;f.style.overflowY="hidden";e.document.documentElement.style.overflowY="hidden";this.frame.scrolling="no";setTimeout(a,300);b.options.onCursorActivity=function(q){c&&c(q);clearTimeout(g);g=setTimeout(a,100)}}};t.InvalidLineHandle={toString:function(){return"CodeMirror.InvalidLineHandle"}};t.replace=
function(a){if(typeof a=="string")a=document.getElementById(a);return function(b){a.parentNode.replaceChild(b,a)}};t.fromTextArea=function(a,b){function c(){a.value=d.getCode()}if(typeof a=="string")a=document.getElementById(a);b=b||{};if(a.style.width&&b.width==null)b.width=a.style.width;if(a.style.height&&b.height==null)b.height=a.style.height;if(b.content==null)b.content=a.value;if(a.form){typeof a.form.addEventListener=="function"?a.form.addEventListener("submit",c,false):a.form.attachEvent("onsubmit",
c);if(typeof a.form.submit=="function"){var e=a.form.submit,f=function(){c();a.form.submit=e;a.form.submit();a.form.submit=f};a.form.submit=f}}a.style.display="none";var d=new t(function(g){a.nextSibling?a.parentNode.insertBefore(g,a.nextSibling):a.parentNode.appendChild(g)},b);d.save=c;d.toTextArea=function(){c();a.parentNode.removeChild(d.wrapping);a.style.display="";if(a.form){if(typeof a.form.submit=="function")a.form.submit=e;typeof a.form.removeEventListener=="function"?a.form.removeEventListener("submit",
c,false):a.form.detachEvent("onsubmit",c)}};return d};t.isProbablySupported=function(){var a;return window.opera?Number(window.opera.version())>=9.52:/Apple Computer, Inc/.test(navigator.vendor)&&(a=navigator.userAgent.match(/Version\/(\d+(?:\.\d+)?)\./))?Number(a[1])>=3:document.selection&&window.ActiveXObject&&(a=navigator.userAgent.match(/MSIE (\d+(?:\.\d*)?)\b/))?Number(a[1])>=6:(a=navigator.userAgent.match(/gecko\/(\d{8})/i))?Number(a[1])>=20050901:(a=navigator.userAgent.match(/AppleWebKit\/(\d+)/))?
Number(a[1])>=525:null};return t}();

    </script>
    <script type="text/javascript">
(function() {
var editor = CodeMirror.fromTextArea("jform_source",
    {"basefiles":["basefiles.js"],"path":"\/mvc\/rnmysqli/\codelibrary\/codemirror\/js\/",
    "parserfile":["parsexml.js","parsecss.js","tokenizejavascript.js","parsejavascript.js","tokenizephp.js","parsephp.js","parsephphtmlmixed.js"],
    "stylesheet":["\/mvc\/rnmysqli/\codelibrary\/codemirror\/css\/xmlcolors.css","\/mvc\/rnmysqli/\codelibrary\/codemirror\/css\/jscolors.css","\/mvc\/rnmysqli/\codelibrary\/codemirror\/css\/csscolors.css","\/mvc\/rnmysqli/\codelibrary\/codemirror\/css\/phpcolors.css"],
    "height":"400px","width":"100%",
    "continuousScanning":500});
//Joomla.editors.instances['jform_source'] = editor;
})()
</script>
</body>
</html>