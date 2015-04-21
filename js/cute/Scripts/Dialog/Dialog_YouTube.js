var OxO7669=["divpreview","idSource","Width","Height","TargetUrl","chk_Transparency","chk_AllowFullScreen","value","innerHTML","","$5","\x26","checked","wmode=\x22transparent\x22","allowfullscreen=\x22true\x22","\x3Cembed src=\x22","\x22 width=\x22","\x22 height=\x22","\x22 "," "," type=\x22application/x-shockwave-flash\x22 pluginspage=\x22http://www.macromedia.com/go/getflashplayer\x22 \x3E\x3C/embed\x3E\x0A","\x3Cobject xcodebase=","\x22http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab\x22"," height=\x22","\x22 classid=","\x22clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\x22 \x3E"," \x3Cparam name=\x22Movie\x22 value=\x22","\x22 /\x3E","\x3Cparam name=\x22wmode\x22 value=\x22transparent\x22/\x3E","\x3Cparam name=\x22allowFullScreen\x22 value=\x22true\x22/\x3E","\x3C/object\x3E"];
var divpreview=Window_GetElement(window,OxO7669[0x0],true);
var idSource=Window_GetElement(window,OxO7669[0x1],true);
var Width=Window_GetElement(window,OxO7669[0x2],true);
var Height=Window_GetElement(window,OxO7669[0x3],true);
var TargetUrl=Window_GetElement(window,OxO7669[0x4],true);
var chk_Transparency=Window_GetElement(window,OxO7669[0x5],true);
var chk_AllowFullScreen=Window_GetElement(window,OxO7669[0x6],true);
var editor=Window_GetDialogArguments(window); 
function do_preview()
{	var Ox48=GetEmbed();
	if(Ox48){if(idSource[OxO7669[0x7]]!=Ox48&&idSource[OxO7669[0x7]]!=null){ idSource[OxO7669[0x7]]=Ox48 ;} ; divpreview[OxO7669[0x8]]=Ox48 ;} ;}  ; 
function do_insert()
{	//var Ox48=GetEmbed();
	//if(Ox48){ editor.PasteHTML(idSource) ;};
	alert(idSource);
	editor.PasteHTML(idSource); Window_CloseDialog(window) ;
}  ; 

function do_Close(){ Window_CloseDialog(window) ;}  ; 
function GetEmbed(){
	var Ox54a=OxO7669[0x9];
	if(idSource[OxO7669[0x7]]!=OxO7669[0x9]&&idSource[OxO7669[0x7]]!=null)
	{ Ox54a=idSource[OxO7669[0x7]] ;
		var Ox54b=/(<object[^\>]*>[\s|\S]*?)(<embed[^\>]*?)(\ssrc=\s*)\s*("|')(.+?)\4([^>]*)(.*<\/embed>)[\s|\S]*?<\/object>/gi;
		if(Ox54a.match(Ox54b)){ Ox54a=Ox54a.replace(Ox54b,OxO7669[0xa]) ;} ;if(Ox54a.indexOf(OxO7669[0xb])!=-0x1){ TargetUrl[OxO7669[0x7]]=Ox54a.substring(0x0,Ox54a.indexOf(OxO7669[0xb])) ;} ;} 
	else {return ;} ;
		var Ox54c=OxO7669[0x9];var Ox284,Ox258,Ox2d8,Ox2d9; Ox284=Width[OxO7669[0x7]]+OxO7669[0x9] ; Ox258=Height[OxO7669[0x7]]+OxO7669[0x9] ; Ox2d8=chk_Transparency[OxO7669[0x7]] ;if(Ox54a==OxO7669[0x9]){ divpreview[OxO7669[0x8]]=OxO7669[0x9] ;return ;} ;var Ox2dc,Ox54d; Ox54d=OxO7669[0x9] ; Ox2dc=chk_Transparency[OxO7669[0xc]]?OxO7669[0xd]:OxO7669[0x9] ; Ox54d=chk_AllowFullScreen[OxO7669[0xc]]?OxO7669[0xe]:OxO7669[0x9] ;var Ox2e2=OxO7669[0xf]+Ox54a+OxO7669[0x10]+Ox284+OxO7669[0x11]+Ox258+OxO7669[0x12]+Ox54d+OxO7669[0x13]+Ox2dc+OxO7669[0x14];var Ox2e3=OxO7669[0x15]+OxO7669[0x16]+OxO7669[0x17]+Ox258+OxO7669[0x10]+Ox284+OxO7669[0x18]+OxO7669[0x19]+OxO7669[0x1a]+Ox54a+OxO7669[0x1b];if(chk_Transparency[OxO7669[0xc]]){ Ox2e3=Ox2e3+OxO7669[0x1c] ;} ;if(chk_AllowFullScreen[OxO7669[0xc]]){ Ox2e3=Ox2e3+OxO7669[0x1d] ;} ; Ox2e3=Ox2e3+Ox2e2+OxO7669[0x1e] ;return Ox2e3;}  ;