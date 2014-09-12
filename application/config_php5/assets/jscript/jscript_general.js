// JavaScript General

/*
*Variables
*/
var BASE_URL = 'http://ultimate-forum.php5.sk/totosomja/';
var ROOT_DIR = 'http://ultimate-forum.php5.sk/totosomja/';
var delay_array=new Array();
var specialSetPage;

/*
* DATA TYPE
*/
function isInt(value){ 
  if (value.length == 0){
    return false;
  }
 for (var i = 0 ; i < value.length ; i++) { 
    if ((value.charAt(i) < '0') || (value.charAt(i) > '9')){
      return false;
    } 
  } 
 return true; 
}
function isFunction(f){
  return (typeof f == 'function');
}
/*
 * String
 */
function replaceRegExp(sourceS, s1, s2){
	var regexp = new RegExp(s1, 'g');
	text = sourceS.replace(regexp, s2);
	return text;
}
/*
*ID
*/
function isId(id){
  return document.getElementById(id);
}
function fillId(id,text)
  {
  document.getElementById(id).innerHTML=text;
  }
function emptyId(id)
  {
  document.getElementById(id).innerHTML="";
  }
/*
*CLASS NAME
*/
function showById(id){
  if (isId(id)){
    showByElem(document.getElementById(id));
  }
}
function showByElem(elem){
  changeClassNameByElem(elem,'invisible','visible');
}
function showArrayById(){
  for (var i=0;i<arguments.length;i++){
    showById(arguments[i]);
  }
}
function showPopUp(id){
  showById(id);
  showById('pop_up_bg');
  pop_up_center(id);
}
function hideById(id){
  if (isId(id)){
    hideByElem(document.getElementById(id));
  }
}
function hideByElem(elem){
  changeClassNameByElem(elem,'visible','invisible');
}
function hideArrayById(){
  for (var i=0;i<arguments.length;i++){
    hideById(arguments[i]);
  }
}
function hidePopUp(id){
  hideById(id);
  hideById('pop_up_bg');
}
function changeVisibilityById(id){
  if (isId(id)){
    changeVisibilityByElem(document.getElementById(id));
  }
}
function changeVisibilityByElem(elem){
  if (isClassNameByElem(elem,'visible')){
    changeClassNameByElem(elem,"visible","invisible");
  }
  else {
    changeClassNameByElem(elem,"invisible","visible");
  }
}
function isClassNameById(id,name){
  return isClassNameByElem(document.getElementById(id),name);
}
function isClassNameByElem(elem,name){
  var ret = false;
  var className = elem.className.split(" ");
  for (var i=0;i<className.length;i++){
    if (className[i]==name){
      ret = true;
      i=className.length;
    }
  }
  return ret;
}
function getClassNameById(id){
  return document.getElementById(id).className;
}
function getClassNameByElem(elem){
  return elem.className;
}
function setClassNameById(id,name){
  setClassNameByElem(document.getElementById(id),name);
}
function setClassNameByElem(elem,name){
  elem.className=name;
}
//zmeni class name1 na class name2
function changeClassNameById(id,name1,name2){
  changeClassNameByElem(document.getElementById(id),name1,name2);
}
//zmeni class name1 na class name2
function changeClassNameByElem(elem,name1,name2){
  removeClassNameByElem(elem,name1);
  addClassNameByElem(elem,name2);
}
function addClassNameById(id,name){
  addClassNameByElem(document.getElementById(id),name);  
}
function addClassNameByElem(elem,name){
  if (elem.className == ""){
    elem.className += name;
  }
  else{
  if (elem.className.indexOf(name) == -1){
      elem.className += " "+name;
    }
  }
}
function removeClassNameById(id,name){
  removeClassNameByElem(document.getElementById(id),name);
}
function removeClassNameByElem(elem,name){
  var className = elem.className.split(" ");
  while (className.indexOf(name)>-1){
    className.splice(className.indexOf(name),1);
  } 
  elem.className = className.join(" ");
}


/*
*Background
*/
function setBackgroundColorById(id,color){
  setBackgroundColorByElem(document.getElementById(id),color)
}
function setBackgroundColorByElem(elem,color){
  elem.style.backgroundColor = color;
}
function setBackgroundImageById(id,image){
  setBackgroundImageByElem(document.getElementById(id),image)
}
function setBackgroundImageByElem(elem,image){
  elem.style.backgroundImage = image;
}

/*
*Font
*/
function setColorById(id,color){
  setColorByElem(document.getElementById(id),color);
}
function setColorByElem(elem,color){
  elem.style.color = color;
}
function setIfColorById(id, condition, color1, color2){
  setIfColorByElem(document.getElementById(id), condition, color1, color2);
}
function setIfColorByElem(elem, condition, color1, color2){
  var equal = elem.style.color == color1;
  if (equal == condition){
    elem.style.color = color2;
  }
}
/*
* Float Clear
*/
function clearById(id, clear){
  clearByElem(document.getElementById(id), clear);
}
function clearByElem(elem, clear){
  elem.style.clear = clear;
}
function changeClearById(id, clear1, clear2){
  changeClearByElem(document.getElementById(id), clear1, clear2);
}
function changeClearByElem(elem, clear1, clear2){
  if (elem.style.clear == clear1){
    elem.style.clear = clear2;
  }
  else{
    elem.style.clear = clear1;
  }
}
function floatById(id, f){
  clearByElem(document.getElementById(id), f);
}
function floatByElem(elem, f){
  elem.style.float = f;
}
function changeFloatById(id, f1, f2){
  changeFloatByElem(document.getElementById(id), f1, f2);
}
function changeFloatByElem(elem, f1, f2){
  if (elem.style.float == f1){
    elem.style.float = f2;
  }
  else{
    elem.style.float = f1;
  }
}

/*
*Border
*/
function setBorderColorById(id,side,color){
  if (isId(id)){
    setBorderColorByElem(document.getElementById(id),side,color);
  }
}
function setBorderColorByElem(elem,side,color){
  if (side!=""){
    for (i=1;i<=side.length;i++){
      s=side.substr(i-1,1);
      switch (s){
        case "T":
          elem.style.borderTopColor = color;
        case "R":
          elem.style.borderRightColor = color;
        case "B":
          elem.style.borderBottomColor = color;
        case "L":
          elem.style.borderLeftColor = color;
      }
    }
  }
  else{
    elem.style.borderColor = color;
  }
}
function setBorderColorArrayById(){
  for (var i=0;i<arguments.length-2;i++){
    setBorderColorById(arguments[i],arguments[arguments.length-2],arguments[arguments.length-1]);
  }
}
function changeBorderColorById(id,side,color){
  changeBorderColorByElem(document.getElementById(id),side,color);
}
function changeBorderColorByElem(elem,side,color){
  if (side!=""){
    for (i=1;i<=side.length;i++){
      s=side.substr(i-1,1);
      switch (s){
        case "T":
          if (elem.style.borderTopColor == colorToRGB(color)){
            elem.style.borderTopColor = "transparent";                                      
          }
          else{
            elem.style.borderTopColor = color;
          }
          elem.style.borderTopColor = color;
          break;
        case "R":
          if (elem.style.borderRightColor == colorToRGB(color)){
            elem.style.borderRightColor = "transparent";                                      
          }
          else{
            elem.style.borderRightColor = color;
          }
          break;
        case "B":
          if (elem.style.borderBottomColor == colorToRGB(color)){
            elem.style.borderBottomColor = "transparent";                                      
          }
          else{
            elem.style.borderBottomColor = color;
          }
          break;
        case "L":
          if (elem.style.borderLeftColor == colorToRGB(color)){
            elem.style.borderLeftColor = "transparent";                                      
          }
          else{
            elem.style.borderLeftColor = color;
          }
          break;
      }
    }
  }
  else{
    if (elem.style.borderColor == colorToRGB(color)){
      elem.style.borderColor = "";                                      
    }
    else{
      elem.style.borderColor = color;
    }
  }
}
/*
*Padding
*/
function setPaddingById(id,padding){
  setPaddingByElem(document.getElementById(id),padding);
}
function setPaddingByElem(elem,padding){
  elem.style.padding = padding;
}
function getPaddingById(id){
  return getPaddingByElem(document.getElementById(id));
}
function getPaddingByElem(elem){
  return elem.style.padding.substr(0,elem.style.padding.length()-2);
}
/*
*Size
*/
function setSizeById(id,sizeW,sizeH){
  setSizeByElem(document.getElementById(id),sizeW,sizeH);
}
function setSizeByElem(elem,sizeW,sizeH){
  setWidthByElem(elem,sizeW);
  setHeightByElem(elem,sizeH);
}
function setWidthById(id, width){
  setWidthByElem(document.getElementById(id), width);
}
function setWidthByElem(elem, width){
  elem.style.width = width;
}
function setHeightById(id, height){
  setHeightByElem(document.getElementById(id), height);
}
function setHeightByElem(elem, height){
  elem.style.height = height;
}
function getWidthById(id){
  return getWidthByElem(document.getElementById(id));
}
function getWidthByElem(elem){
  return elem.offsetWidth;
}
function getHeightById(id){
  return getHeightByElem(document.getElementById(id));
}
function getHeightByElem(elem){
  return elem.offsetHeight;
}
function setMinSizeById(id,minWidth,minHeight){
  setMinSizeByElem(document.getElementById(id),minWidth,minHeight);
}
function setMinSizeByElem(elem,minWidth,minHeight){
  if (minWidth!="" && minWidth!=null){
    setWidthByElem(elem,"auto");
    if (getWidthByElem(elem)<minWidth){
      setWidthByElem(elem,minWidth+"px");
    }
    else if (getWidthByElem(elem)<getScreenWidth()){
      setWidthByElem(elem,"");
    }
  }
  if (minHeight!="" && minHeight!=null){
    if (getHeightByElem(elem)<minHeight){ 
      setHeightByElem(elem,minHeight+"px");
    }
    else if (getHeightByElem(elem)<getScreenHeight()){
      setHeightByElem(elem,"");
    }
  }
}
function getScreenHeight(){
  return document.body.clientHeight;
}
function getScreenWidth(){
  return document.body.clientWidth;
}

/*
*Position
*/
function getScrollY(){
  return window.pageYOffset;
}
function getScrollX(){
  return window.pageXOffset;
}
function setTopById(id,top){
  setTopByElem(document.getElementById(id),top);
}
function setTopByElem(elem,top){
  elem.style.top = top;
}
function setLeftById(id,left){
  setLeftByElem(document.getElementById(id),left);
}
function setLeftByElem(elem,left){
  elem.style.left = left;
}
function setPositionById(id,top,left){
  setPositionByElem(document.getElementById(id),top,left);
}
function setPositionByElem(elem,top,left){
  setTopByElem(elem,top);
  setLeftByElem(elem,left);
}
function getLeftById(id){
  return getLeftByElem(document.getElementById(id));
}
function getLeftByElem(elem){
  return elem.offsetLeft;
}
function getTopById(id){
  return getTopByElem(document.getElementById(id));
}
function getTopByElem(elem){
  return elem.offsetTop;
}
function getAbsoluteLeftById(id){
  return getAbsoluteLeftByElem(document.getElementById(id));
}
function getAbsoluteLeftByElem(elem){
  if (elem.offsetParent)
    {
    var left = 0;
    do
      {
      left+=elem.offsetLeft;
      } while (elem=elem.offsetParent)
    return left;
    }
  else{
    return elem.offsetLeft;
  }
}
function getAbsoluteTopById(id){
  return getAbsoluteTopByElem(document.getElementById(id));
}
function getAbsoluteTopByElem(elem){
  if (elem.offsetParent)
    {
    var top = 0;
    do
      {
      top+=elem.offsetTop;
      } while (elem=elem.offsetParent)
    return top;
    }
    else{
      return elem.offsetTop;
    }
  }
/*
*Images
*/
function setImageById(id,image){
  if (isId(id)){
    setImageByElem(document.getElementById(id),image);
  }
}
function setImageByElem(elem,image){
  elem.src=ROOT_DIR+'images/'+image;
}

/*
*Opacity
*/
function setOpacityById(id,opacity){
  setOpacityByElem(document.getElementById(id),opacity);
}
function setOpacityByElem(elem,opacity){
  elem.style.opacity = opacity/100;
}
function setOpacitySmoothById(id,do_o,pridavok){
  var od_op=Math.floor(document.getElementById(id).style.opacity*100);
  if (od_op!=do_o){
    od_op+=pridavok;
    if (pridavok<0){
      if (od_op<do_o){
        od_op=do_o;
      }
    }
    else{
      if (od_op>do_o){
        od_op=do_o;
      }
    }
    setOpacityById(id,od_op);
    if (od_op!=do_o){
      delay('op_time','setOpacitySmoothById("'+id+'",'+do_o+','+pridavok+')',50);
    }
    else{
      stop('op_time');
    }
  }
}
/*
*Forms
*/
function submit(form){
  form.submit();
}
function clickElem(elem){
  elem.click();
}
function clearFormElem(form)
  {
  form.value="";
  }
function fillTextFormElem(elem,text)
  {
  elem.value=text;
  }
function getFileName(elem)
  {
  var name=elem.value;
  name=name.substring(name.lastIndexOf('\\')+1,name.lastIndexOf('.'));
  return name;
  }
function isFormEmpty(form)
  {
  return (form.value=="");
  }
function focusFormElem(form){
  form.focus();
}
/*
*Site
*/
function reload(){
  window.location.reload();
}
function redirect(to){
	window.location.replace(to);
}
/*
*Window
*/
function newWindow(page,name,width,height)
  {
  window.open(ROOT_DIR+page,'link','width='+width+',height='+height+',toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,copyhistory=no,resizable=yes,left=300,top=300');
  }


function isEnter(e){
  return isPressed(e,13);
}
function isPressed(e,key){
  return getOrd(e) == key;
}
function getOrd(e){
  var keynum;
  if(window.event){                                     
    keynum=e.keyCode;
  }
  else if(e.which){                                   
    keynum=e.which;
  }
  return keynum;
}


function stop_bubble(event){
  event.stopPropagation();
  event.cancelBubble=true;
} 
function isFunction(f){
  return (typeof f == 'function');
}
function pop_up_center(id){
if (isId(id))
  {
  showById(id);
  if (getScreenHeight()>getHeightById(id))
    {
    setTopById(id,(getScreenHeight()-getHeightById(id))/2+"px");
    }
  else
    {
    setTopById(id,"0px");
    }
  if (getScreenWidth()>getWidthById(id))
    {
    setLeftById(id,(getScreenWidth()-getWidthById(id))/2+"px");
    }
  else
    {
    setLeftById(id,"0px");
    }
  }
}
function hexToDec(hex){
  var ret = 0;
  var dec = 0;
  var ch;
  for(var i=0;i<hex.length;i++){
    ch = hex.substr(i,1); 
    dec = 0;
    if (ch>='0' && ch<='9'){
      dec = ch.charCodeAt(0) - '0'.charCodeAt(0);
    }
    else if (ch>='a' && ch<='f'){
      dec = 10 + ch.charCodeAt(0) - 'a'.charCodeAt(0);
    }
    else if (ch>='A' && ch<='F'){
      dec = 10 + ch.charCodeAt(0) - 'A'.charCodeAt(0);
    }
    ret += powerOf(16,(hex.length-1-i))*dec;  
  }
  return ret;
}
function colorToRGB(color){
return "rgb("+hexToDec(color.substr(1,2))+", "+hexToDec(color.substr(3,2))+", "+hexToDec(color.substr(5,2))+")";
}
function powerOf(x,n){
  var ret = 1;
  for (var i=0;i<n;i++){
    ret *= x;
  }
  return ret;
}
function adress(a){
  location.replace(ROOT_DIR+a);
}
function delay(id,fun,time){
  delay_array[id]=setTimeout(fun,time);
}
function stop(id){
  clearTimeout(delay_array[id]);
}
function isEmpty(text){
  return (text=="" || text==null);
}


function loading(id,top){
  document.getElementById(id).innerHTML="<div style='text-align:center;position:relative;padding-top:"+top+"px;'><img src='"+ROOT_DIR+"images/ufo_nacitanie3.gif' /></div>";
}
function set_cursor(cursor){
  document.body.style.cursor=cursor;
}
/*
*announcer
*/
function showAnnouncer()
  {
  setOpacityById('announcer',100);
  setAnnouncer();
  showById('announcer');
  }
function fillAnnouncer(text)
  {
  document.getElementById('announcer').innerHTML=text;
  showAnnouncer();
  }
function setAnnouncer()
  {
  setLeftById('announcer',(getScreenWidth()-getWidthById('announcer'))/2+"px");
  }
function hideAnnouncer()
  {
  delay("announcer_opacity",'setOpacitySmoothById(\'announcer\',0,-5);',3000);
  delay("announcer_hide",'setOpacityById(\'announcer\');',5000);
  }