// source --> https://blog.yimian.xyz/wp-content/plugins/crayon-syntax-highlighter/js/min/crayon.min.js?ver=_2.7.2_beta 
var jQueryCrayon=jQuery;(function(a){CrayonUtil=new function(){var c=this;var b=null;c.init=function(){b=CrayonSyntaxSettings;c.initGET()};c.addPrefixToID=function(d){return d.replace(/^([#.])?(.*)$/,"$1"+b.prefix+"$2")};c.removePrefixFromID=function(e){var d=new RegExp("^[#.]?"+b.prefix,"i");return e.replace(d,"")};c.cssElem=function(d){return a(c.addPrefixToID(d))};c.setDefault=function(e,f){return(typeof e=="undefined")?f:e};c.setMax=function(e,d){return e<=d?e:d};c.setMin=function(d,e){return d>=e?d:e};c.setRange=function(e,f,d){return c.setMax(c.setMin(e,f),d)};c.getExt=function(e){if(e.indexOf(".")==-1){return undefined}var d=e.split(".");if(d.length){d=d[d.length-1]}else{d=""}return d};c.initGET=function(){window.currentURL=window.location.protocol+"//"+window.location.host+window.location.pathname;window.currentDir=window.currentURL.substring(0,window.currentURL.lastIndexOf("/"));function d(e){e=e.split("+").join(" ");var h={},g,f=/[?&]?([^=]+)=([^&]*)/g;while(g=f.exec(e)){h[decodeURIComponent(g[1])]=decodeURIComponent(g[2])}return h}window.GET=d(document.location.search)};c.getAJAX=function(d,e){d.version=b.version;a.get(b.ajaxurl,d,e)};c.postAJAX=function(d,e){d.version=b.version;a.post(b.ajaxurl,d,e)};c.reload=function(){var d="?";for(var e in window.GET){d+=e+"="+window.GET[e]+"&"}window.location=window.currentURL+d};c.escape=function(d){if(typeof encodeURIComponent=="function"){return encodeURIComponent(d)}else{if(typeof escape!="function"){return escape(d)}else{return d}}};c.log=function(d){if(typeof console!="undefined"&&b.debug){console.log(d)}};c.decode_html=function(d){return String(d).replace(/&amp;/g,"&").replace(/&lt;/g,"<").replace(/&gt;/g,">")};c.encode_html=function(d){return String(d).replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;")};c.getReadableColor=function(g,f){f=a.extend({amount:0.5,xMulti:1,yMulti:1.5,normalizeHue:[20,180],normalizeHueXMulti:1/2.5,normalizeHueYMulti:1},f);var d=tinycolor(g);var e=d.toHsv();var i={x:e.s,y:1-e.v};i.x*=f.xMulti;i.y*=f.yMulti;if(f.normalizeHue&&e.h>f.normalizeHue[0]&&e.h<f.normalizeHue[1]){i.x*=f.normalizeHueXMulti;i.y*=f.normalizeHueYMulti}var h=Math.sqrt(Math.pow(i.x,2)+Math.pow(i.y,2));if(h<f.amount){e.v=0}else{e.v=1}e.s=0;return tinycolor(e).toHexString()};c.removeChars=function(e,f){var d=new RegExp("["+e+"]","gmi");return f.replace(d,"")}};a(document).ready(function(){CrayonUtil.init()});a.fn.bindFirst=function(c,e){this.bind(c,e);var b=this.data("events")[c.split(".")[0]];var d=b.pop();b.splice(0,0,d)};a.keys=function(d){var c=[];for(var b in d){c.push(b)}return c};RegExp.prototype.execAll=function(c){var f=[];var b=null;while((b=this.exec(c))!=null){var e=[];for(var d in b){if(parseInt(d)==d){e.push(b[d])}}f.push(e)}return f};RegExp.prototype.escape=function(b){return b.replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&")};String.prototype.sliceReplace=function(d,b,c){return this.substring(0,d)+c+this.substring(b)};String.prototype.escape=function(){var b={"&":"&amp;","<":"&lt;",">":"&gt;"};return this.replace(/[&<>]/g,function(c){return b[c]||c})};String.prototype.linkify=function(b){b=typeof b!="undefined"?b:"";return this.replace(/(http(s)?:\/\/(\S)+)/gmi,'<a href="$1" target="'+b+'">$1</a>')};String.prototype.toTitleCase=function(){var b=this.split(/\s+/);var c="";a.each(b,function(e,d){if(d!=""){c+=d.slice(0,1).toUpperCase()+d.slice(1,d.length);if(e!=b.length-1&&b[e+1]!=""){c+=" "}}});return c}})(jQueryCrayon);jqueryPopup=Object();jqueryPopup.defaultSettings={centerBrowser:0,centerScreen:0,height:500,left:0,location:0,menubar:0,resizable:0,scrollbars:0,status:0,width:500,windowName:null,windowURL:null,top:0,toolbar:0,data:null,event:"click"};(function(a){popupWindow=function(d,c,f,b){f=typeof f!=="undefined"?f:null;b=typeof b!=="undefined"?b:null;if(typeof d=="string"){d=jQuery(d)}if(!(d instanceof jQuery)){return false}var e=jQuery.extend({},jqueryPopup.defaultSettings,c||{});d.handler=jQuery(d).bind(e.event,function(){if(f){f()}var g="height="+e.height+",width="+e.width+",toolbar="+e.toolbar+",scrollbars="+e.scrollbars+",status="+e.status+",resizable="+e.resizable+",location="+e.location+",menuBar="+e.menubar;e.windowName=e.windowName||jQuery(this).attr("name");var h=jQuery(this).attr("href");if(!e.windowURL&&!(h=="#")&&!(h=="")){e.windowURL=jQuery(this).attr("href")}var i,j;var k=null;if(e.centerBrowser){if(typeof window.screenY=="undefined"){i=(window.screenTop-120)+((((document.documentElement.clientHeight+120)/2)-(e.height/2)));j=window.screenLeft+((((document.body.offsetWidth+20)/2)-(e.width/2)))}else{i=window.screenY+(((window.outerHeight/2)-(e.height/2)));j=window.screenX+(((window.outerWidth/2)-(e.width/2)))}k=window.open(e.windowURL,e.windowName,g+",left="+j+",top="+i)}else{if(e.centerScreen){i=(screen.height-e.height)/2;j=(screen.width-e.width)/2;k=window.open(e.windowURL,e.windowName,g+",left="+j+",top="+i)}else{k=window.open(e.windowURL,e.windowName,g+",left="+e.left+",top="+e.top)}}if(k!=null){k.focus();if(e.data){k.document.write(e.data)}}if(b){b()}});return e};popdownWindow=function(b,c){if(typeof c=="undefined"){c="click"}b=jQuery(b);if(!(b instanceof jQuery)){return false}b.unbind(c,b.handler)}})(jQueryCrayon);(function(f){f.fn.exists=function(){return this.length!==0};f.fn.style=function(B,E,A){var D=this.get(0);if(typeof D=="undefined"){return}var C=D.style;if(typeof B!="undefined"){if(typeof E!="undefined"){A=typeof A!="undefined"?A:"";if(typeof C.setProperty!="undefined"){C.setProperty(B,E,A)}else{C[B]=E}}else{return C[B]}}else{return C}};var d="crayon-pressed";var a="";var n="div.crayon-syntax";var e=".crayon-toolbar";var c=".crayon-info";var w=".crayon-plain";var o=".crayon-main";var m=".crayon-table";var v=".crayon-loading";var h=".crayon-code";var p=".crayon-title";var l=".crayon-tools";var b=".crayon-nums";var j=".crayon-num";var q=".crayon-line";var g="crayon-wrapped";var s=".crayon-nums-content";var u=".crayon-nums-button";var k=".crayon-wrap-button";var i=".crayon-expand-button";var t="crayon-expanded crayon-toolbar-visible";var y="crayon-placeholder";var x=".crayon-popup-button";var r=".crayon-copy-button";var z=".crayon-plain-button";CrayonSyntax=new function(){var I=this;var N=new Object();var ag;var H;var G=0;var Z;I.init=function(){if(typeof N=="undefined"){N=new Object()}ag=CrayonSyntaxSettings;H=CrayonSyntaxStrings;f(n).each(function(){I.process(this)})};I.process=function(aD,aE){aD=f(aD);var ar=aD.attr("id");if(ar=="crayon-"){ar+=X()}aD.attr("id",ar);CrayonUtil.log(ar);if(typeof aE=="undefined"){aE=false}if(!aE&&!aa(ar)){return}var au=aD.find(e);var aC=aD.find(c);var ap=aD.find(w);var aq=aD.find(o);var aB=aD.find(m);var aj=aD.find(h);var aG=aD.find(p);var aA=aD.find(l);var ay=aD.find(b);var av=aD.find(s);var az=aD.find(u);var am=aD.find(k);var ao=aD.find(i);var aF=aD.find(x);var at=aD.find(r);var al=aD.find(z);N[ar]=aD;N[ar].toolbar=au;N[ar].plain=ap;N[ar].info=aC;N[ar].main=aq;N[ar].table=aB;N[ar].code=aj;N[ar].title=aG;N[ar].tools=aA;N[ar].nums=ay;N[ar].nums_content=av;N[ar].numsButton=az;N[ar].wrapButton=am;N[ar].expandButton=ao;N[ar].popup_button=aF;N[ar].copy_button=at;N[ar].plainButton=al;N[ar].numsVisible=true;N[ar].wrapped=false;N[ar].plainVisible=false;N[ar].toolbar_delay=0;N[ar].time=1;f(w).css("z-index",0);var aw=aq.style();N[ar].mainStyle={height:aw&&aw.height||"","max-height":aw&&aw.maxHeight||"","min-height":aw&&aw.minHeight||"",width:aw&&aw.width||"","max-width":aw&&aw.maxWidth||"","min-width":aw&&aw.minWidth||""};N[ar].mainHeightAuto=N[ar].mainStyle.height==""&&N[ar].mainStyle["max-height"]=="";var ak;var ax=0;N[ar].loading=true;N[ar].scrollBlockFix=false;az.click(function(){CrayonSyntax.toggleNums(ar)});am.click(function(){CrayonSyntax.toggleWrap(ar)});ao.click(function(){CrayonSyntax.toggleExpand(ar)});al.click(function(){CrayonSyntax.togglePlain(ar)});at.click(function(){CrayonSyntax.copyPlain(ar)});B(ar);var an=function(){if(ay.filter('[data-settings~="hide"]').length!=0){av.ready(function(){CrayonUtil.log("function"+ar);CrayonSyntax.toggleNums(ar,true,true)})}else{ac(ar)}if(typeof N[ar].expanded=="undefined"){if(Math.abs(N[ar].main.outerWidth()-N[ar].table.outerWidth())<10){N[ar].expandButton.hide()}else{N[ar].expandButton.show()}}if(ax==5){clearInterval(ak);N[ar].loading=false}ax++};ak=setInterval(an,300);C(ar);f(j,N[ar]).each(function(){var aJ=f(this).attr("data-line");var aI=f("#"+aJ);var aH=aI.style("height");if(aH){aI.attr("data-height",aH)}});aq.css("position","relative");aq.css("z-index",1);Z=(aD.filter('[data-settings~="touchscreen"]').length!=0);if(!Z){aq.click(function(){A(ar,"",false)});ap.click(function(){A(ar,"",false)});aC.click(function(){A(ar,"",false)})}if(aD.filter('[data-settings~="no-popup"]').length==0){N[ar].popup_settings=popupWindow(aF,{height:screen.height-200,width:screen.width-100,top:75,left:50,scrollbars:1,windowURL:"",data:""},function(){F(ar)},function(){})}ap.css("opacity",0);N[ar].toolbarVisible=true;N[ar].hasOneLine=aB.outerHeight()<au.outerHeight()*2;N[ar].toolbarMouseover=false;if(au.filter('[data-settings~="mouseover"]').length!=0&&!Z){N[ar].toolbarMouseover=true;N[ar].toolbarVisible=false;au.css("margin-top","-"+au.outerHeight()+"px");au.hide();if(au.filter('[data-settings~="overlay"]').length!=0&&!N[ar].hasOneLine){au.css("position","absolute");au.css("z-index",2);if(au.filter('[data-settings~="hide"]').length!=0){aq.click(function(){T(ar,undefined,undefined,0)});ap.click(function(){T(ar,false,undefined,0)})}}else{au.css("z-index",4)}if(au.filter('[data-settings~="delay"]').length!=0){N[ar].toolbar_delay=500}aD.mouseenter(function(){T(ar,true)}).mouseleave(function(){T(ar,false)})}else{if(Z){au.show()}}if(aD.filter('[data-settings~="minimize"]').length==0){I.minimize(ar)}if(ap.length!=0&&!Z){if(ap.filter('[data-settings~="dblclick"]').length!=0){aq.dblclick(function(){CrayonSyntax.togglePlain(ar)})}else{if(ap.filter('[data-settings~="click"]').length!=0){aq.click(function(){CrayonSyntax.togglePlain(ar)})}else{if(ap.filter('[data-settings~="mouseover"]').length!=0){aD.mouseenter(function(){CrayonSyntax.togglePlain(ar,true)}).mouseleave(function(){CrayonSyntax.togglePlain(ar,false)});az.hide()}}}if(ap.filter('[data-settings~="show-plain-default"]').length!=0){CrayonSyntax.togglePlain(ar,true)}}var ai=aD.filter('[data-settings~="expand"]').length!=0;if(!Z&&aD.filter('[data-settings~="scroll-mouseover"]').length!=0){aq.css("overflow","hidden");ap.css("overflow","hidden");aD.mouseenter(function(){M(ar,true,ai)}).mouseleave(function(){M(ar,false,ai)})}if(ai){aD.mouseenter(function(){D(ar,true)}).mouseleave(function(){D(ar,false)})}if(aD.filter('[data-settings~="disable-anim"]').length!=0){N[ar].time=0}if(aD.filter('[data-settings~="wrap"]').length!=0){N[ar].wrapped=true}N[ar].mac=aD.hasClass("crayon-os-mac");ac(ar);ab(ar);Y(ar)};var aa=function(ai){CrayonUtil.log(N);if(typeof N[ai]=="undefined"){N[ai]=f("#"+ai);CrayonUtil.log("make "+ai);return true}CrayonUtil.log("no make "+ai);return false};var X=function(){return G++};var F=function(ai){if(typeof N[ai]=="undefined"){return aa(ai)}var aj=N[ai].popup_settings;if(aj&&aj.data){return}var al=N[ai].clone(true);al.removeClass("crayon-wrapped");if(N[ai].wrapped){f(j,al).each(function(){var ao=f(this).attr("data-line");var an=f("#"+ao);var am=an.attr("data-height");am=am?am:"";if(typeof am!="undefined"){an.css("height",am);f(this).css("height",am)}})}al.find(o).css("height","");var ak="";if(N[ai].plainVisible){ak=al.find(w)}else{ak=al.find(o)}aj.data=I.getAllCSS()+'<body class="crayon-popup-window" style="padding:0; margin:0;"><div class="'+al.attr("class")+' crayon-popup">'+I.removeCssInline(I.getHtmlString(ak))+"</div></body>"};I.minimize=function(al){var ak=f('<div class="crayon-minimize crayon-button"><div>');N[al].tools.append(ak);N[al].origTitle=N[al].title.html();if(!N[al].origTitle){N[al].title.html(H.minimize)}var aj="crayon-minimized";var ai=function(){N[al].toolbarPreventHide=false;ak.remove();N[al].removeClass(aj);N[al].title.html(N[al].origTitle);var am=N[al].toolbar;if(am.filter('[data-settings~="never-show"]').length!=0){am.remove()}};N[al].toolbar.click(ai);ak.click(ai);N[al].addClass(aj);N[al].toolbarPreventHide=true;T(al,undefined,undefined,0)};I.getHtmlString=function(ai){return f("<div>").append(ai.clone()).remove().html()};I.removeCssInline=function(ak){var aj=/style\s*=\s*"([^"]+)"/gmi;var ai=null;while((ai=aj.exec(ak))!=null){var al=ai[1];al=al.replace(/\b(?:width|height)\s*:[^;]+;/gmi,"");ak=ak.sliceReplace(ai.index,ai.index+ai[0].length,'style="'+al+'"')}return ak};I.getAllCSS=function(){var ak="";var aj=f('link[rel="stylesheet"]');var ai=[];if(aj.length==1){ai=aj}else{ai=aj.filter('[href*="crayon-syntax-highlighter"], [href*="min/"]')}ai.each(function(){var al=I.getHtmlString(f(this));ak+=al});return ak};I.copyPlain=function(ak,al){if(typeof N[ak]=="undefined"){return aa(ak)}var aj=N[ak].plain;I.togglePlain(ak,true,true);T(ak,true);var ai=N[ak].mac?"\u2318":"CTRL";var am=H.copy;am=am.replace(/%s/,ai+"+C");am=am.replace(/%s/,ai+"+V");A(ak,am);return false};var A=function(aj,al,ai){if(typeof N[aj]=="undefined"){return aa(aj)}var ak=N[aj].info;if(typeof al=="undefined"){al=""}if(typeof ai=="undefined"){ai=true}if(L(ak)&&ai){ak.html("<div>"+al+"</div>");ak.css("margin-top",-ak.outerHeight());ak.show();Q(aj,ak,true);setTimeout(function(){Q(aj,ak,false)},5000)}if(!ai){Q(aj,ak,false)}};var B=function(ai){if(window.devicePixelRatio>1){var aj=f(".crayon-button-icon",N[ai].toolbar);aj.each(function(){var al=f(this).css("background-image");var ak=al.replace(/\.(?=[^\.]+$)/g,"@2x.");f(this).css("background-size","48px 128px");f(this).css("background-image",ak)})}};var L=function(ai){var aj="-"+ai.outerHeight()+"px";if(ai.css("margin-top")==aj||ai.css("display")=="none"){return true}else{return false}};var Q=function(al,ak,aj,an,am,ap){var ai=function(){if(ap){ap(al,ak)}};var ao="-"+ak.outerHeight()+"px";if(typeof aj=="undefined"){if(L(ak)){aj=true}else{aj=false}}if(typeof an=="undefined"){an=100}if(an==false){an=false}if(typeof am=="undefined"){am=0}ak.stop(true);if(aj==true){ak.show();ak.animate({marginTop:0},ah(an,al),ai)}else{if(aj==false){if(ak.css("margin-top")=="0px"&&am){ak.delay(am)}ak.animate({marginTop:ao},ah(an,al),function(){ak.hide();ai()})}}};I.togglePlain=function(al,am,aj){if(typeof N[al]=="undefined"){return aa(al)}var ai=N[al].main;var ak=N[al].plain;if((ai.is(":animated")||ak.is(":animated"))&&typeof am=="undefined"){return}ae(al);var ao,an;if(typeof am!="undefined"){if(am){ao=ai;an=ak}else{ao=ak;an=ai}}else{if(ai.css("z-index")==1){ao=ai;an=ak}else{ao=ak;an=ai}}N[al].plainVisible=(an==ak);N[al].top=ao.scrollTop();N[al].left=ao.scrollLeft();N[al].scrollChanged=false;C(al);ao.stop(true);ao.fadeTo(ah(500,al),0,function(){ao.css("z-index",0)});an.stop(true);an.fadeTo(ah(500,al),1,function(){an.css("z-index",1);if(an==ak){if(aj){ak.select()}else{}}an.scrollTop(N[al].top+1);an.scrollTop(N[al].top);an.scrollLeft(N[al].left+1);an.scrollLeft(N[al].left)});an.scrollTop(N[al].top);an.scrollLeft(N[al].left);ab(al);T(al,false);return false};I.toggleNums=function(am,al,ai){if(typeof N[am]=="undefined"){aa(am);return false}if(N[am].table.is(":animated")){return false}var ao=Math.round(N[am].nums_content.outerWidth()+1);var an="-"+ao+"px";var ak;if(typeof al!="undefined"){ak=false}else{ak=(N[am].table.css("margin-left")==an)}var aj;if(ak){aj="0px";N[am].numsVisible=true}else{N[am].table.css("margin-left","0px");N[am].numsVisible=false;aj=an}if(typeof ai!="undefined"){N[am].table.css("margin-left",aj);ac(am);return false}var ap=(N[am].table.outerWidth()+J(N[am].table.css("margin-left"))>N[am].main.outerWidth());var aq=(N[am].table.outerHeight()>N[am].main.outerHeight());if(!ap&&!aq){N[am].main.css("overflow","hidden")}N[am].table.animate({marginLeft:aj},ah(200,am),function(){if(typeof N[am]!="undefined"){ac(am);if(!ap&&!aq){N[am].main.css("overflow","auto")}}});return false};I.toggleWrap=function(ai){N[ai].wrapped=!N[ai].wrapped;Y(ai)};I.toggleExpand=function(ai){var aj=!CrayonUtil.setDefault(N[ai].expanded,false);D(ai,aj)};var Y=function(ai,aj){aj=CrayonUtil.setDefault(aj,true);if(N[ai].wrapped){N[ai].addClass(g)}else{N[ai].removeClass(g)}E(ai);if(!N[ai].expanded&&aj){V(ai)}N[ai].wrapTimes=0;clearInterval(N[ai].wrapTimer);N[ai].wrapTimer=setInterval(function(){if(N[ai].is(":visible")){O(ai);N[ai].wrapTimes++;if(N[ai].wrapTimes==5){clearInterval(N[ai].wrapTimer)}}},200)};var ad=function(ai){if(typeof N[ai]=="undefined"){aa(ai);return false}};var J=function(aj){if(typeof aj!="string"){return 0}var ai=aj.replace(/[^-0-9]/g,"");if(ai.length==0){return 0}else{return parseInt(ai)}};var ac=function(ai){if(typeof N[ai]=="undefined"||typeof N[ai].numsVisible=="undefined"){return}if(N[ai].numsVisible){N[ai].numsButton.removeClass(a);N[ai].numsButton.addClass(d)}else{N[ai].numsButton.removeClass(d);N[ai].numsButton.addClass(a)}};var E=function(ai){if(typeof N[ai]=="undefined"||typeof N[ai].wrapped=="undefined"){return}if(N[ai].wrapped){N[ai].wrapButton.removeClass(a);N[ai].wrapButton.addClass(d)}else{N[ai].wrapButton.removeClass(d);N[ai].wrapButton.addClass(a)}};var W=function(ai){if(typeof N[ai]=="undefined"||typeof N[ai].expanded=="undefined"){return}if(N[ai].expanded){N[ai].expandButton.removeClass(a);N[ai].expandButton.addClass(d)}else{N[ai].expandButton.removeClass(d);N[ai].expandButton.addClass(a)}};var ab=function(ai){if(typeof N[ai]=="undefined"||typeof N[ai].plainVisible=="undefined"){return}if(N[ai].plainVisible){N[ai].plainButton.removeClass(a);N[ai].plainButton.addClass(d)}else{N[ai].plainButton.removeClass(d);N[ai].plainButton.addClass(a)}};var T=function(aj,ai,al,ak){if(typeof N[aj]=="undefined"){return aa(aj)}else{if(!N[aj].toolbarMouseover){return}else{if(ai==false&&N[aj].toolbarPreventHide){return}else{if(Z){return}}}}var am=N[aj].toolbar;if(typeof ak=="undefined"){ak=N[aj].toolbar_delay}Q(aj,am,ai,al,ak,function(){N[aj].toolbarVisible=ai})};var R=function(ak,ai){var aj=f.extend({},ak);aj.width+=ai.width;aj.height+=ai.height;return aj};var P=function(ak,ai){var aj=f.extend({},ak);aj.width-=ai.width;aj.height-=ai.height;return aj};var U=function(ai){if(typeof N[ai].initialSize=="undefined"){N[ai].toolbarHeight=N[ai].toolbar.outerHeight();N[ai].innerSize={width:N[ai].width(),height:N[ai].height()};N[ai].outerSize={width:N[ai].outerWidth(),height:N[ai].outerHeight()};N[ai].borderSize=P(N[ai].outerSize,N[ai].innerSize);N[ai].initialSize={width:N[ai].main.outerWidth(),height:N[ai].main.outerHeight()};N[ai].initialSize.height+=N[ai].toolbarHeight;N[ai].initialOuterSize=R(N[ai].initialSize,N[ai].borderSize);N[ai].finalSize={width:N[ai].table.outerWidth(),height:N[ai].table.outerHeight()};N[ai].finalSize.height+=N[ai].toolbarHeight;N[ai].finalSize.width=CrayonUtil.setMin(N[ai].finalSize.width,N[ai].initialSize.width);N[ai].finalSize.height=CrayonUtil.setMin(N[ai].finalSize.height,N[ai].initialSize.height);N[ai].diffSize=P(N[ai].finalSize,N[ai].initialSize);N[ai].finalOuterSize=R(N[ai].finalSize,N[ai].borderSize);N[ai].initialSize.height+=N[ai].toolbar.outerHeight()}};var D=function(al,ao){if(typeof N[al]=="undefined"){return aa(al)}if(typeof ao=="undefined"){return}var aj=N[al].main;var aq=N[al].plain;if(ao){if(typeof N[al].expanded=="undefined"){U(al);N[al].expandTime=CrayonUtil.setRange(N[al].diffSize.width/3,300,800);N[al].expanded=false;var ap=N[al].finalOuterSize;N[al].placeholder=f("<div></div>");N[al].placeholder.addClass(y);N[al].placeholder.css(ap);N[al].before(N[al].placeholder);N[al].placeholder.css("margin",N[al].css("margin"));f(window).bind("resize",K)}var am={height:"auto","min-height":"none","max-height":"none"};var ai={width:"auto","min-width":"none","max-width":"none"};N[al].outerWidth(N[al].outerWidth());N[al].css({"min-width":"none","max-width":"none"});var an={width:N[al].finalOuterSize.width};if(!N[al].mainHeightAuto&&!N[al].hasOneLine){an.height=N[al].finalOuterSize.height;N[al].outerHeight(N[al].outerHeight())}aj.css(am);aj.css(ai);N[al].stop(true);N[al].animate(an,ah(N[al].expandTime,al),function(){N[al].expanded=true;W(al)});N[al].placeholder.show();f("body").prepend(N[al]);N[al].addClass(t);K()}else{var ar=N[al].initialOuterSize;var ak=N[al].toolbar_delay;if(ar){N[al].stop(true);if(!N[al].expanded){N[al].delay(ak)}var an={width:ar.width};if(!N[al].mainHeightAuto&&!N[al].hasOneLine){an.height=ar.height}N[al].animate(an,ah(N[al].expandTime,al),function(){af(al)})}else{setTimeout(function(){af(al)},ak)}N[al].placeholder.hide();N[al].placeholder.before(N[al]);N[al].css({left:"auto",top:"auto"});N[al].removeClass(t)}ae(al);if(ao){Y(al,false)}};var K=function(){for(uid in N){if(N[uid].hasClass(t)){N[uid].css(N[uid].placeholder.offset())}}};var af=function(ai){N[ai].expanded=false;V(ai);W(ai);if(N[ai].wrapped){Y(ai)}};var M=function(al,aj,am){if(typeof N[al]=="undefined"){return aa(al)}if(typeof aj=="undefined"||am||N[al].expanded){return}var ai=N[al].main;var ak=N[al].plain;if(aj){ai.css("overflow","auto");ak.css("overflow","auto");if(typeof N[al].top!="undefined"){visible=(ai.css("z-index")==1?ai:ak);visible.scrollTop(N[al].top-1);visible.scrollTop(N[al].top);visible.scrollLeft(N[al].left-1);visible.scrollLeft(N[al].left)}}else{visible=(ai.css("z-index")==1?ai:ak);N[al].top=visible.scrollTop();N[al].left=visible.scrollLeft();ai.css("overflow","hidden");ak.css("overflow","hidden")}N[al].scrollChanged=true;C(al)};var C=function(ai){N[ai].table.style("width","100%","important");var aj=setTimeout(function(){N[ai].table.style("width","");clearInterval(aj)},10)};var V=function(ak){var aj=N[ak].main;var ai=N[ak].mainStyle;aj.css(ai);N[ak].css("height","auto");N[ak].css("width",ai.width);N[ak].css("max-width",ai["max-width"]);N[ak].css("min-width",ai["min-width"])};var ae=function(ai){N[ai].plain.outerHeight(N[ai].main.outerHeight())};var O=function(ai){f(j,N[ai]).each(function(){var al=f(this).attr("data-line");var ak=f("#"+al);var aj=null;if(N[ai].wrapped){ak.css("height","");aj=ak.outerHeight();aj=aj?aj:""}else{aj=ak.attr("data-height");aj=aj?aj:"";ak.css("height",aj)}f(this).css("height",aj)})};var ah=function(ai,aj){if(ai=="fast"){ai=200}else{if(ai=="slow"){ai=600}else{if(!S(ai)){ai=parseInt(ai);if(isNaN(ai)){return 0}}}}return ai*N[aj].time};var S=function(ai){return typeof ai=="number"}};f(document).ready(function(){CrayonSyntax.init()})})(jQueryCrayon);
// source --> https://blog.yimian.xyz/wp-content/plugins/jetpack/_inc/build/postmessage.min.js?ver=6.8.1 
/* Do not modify this file directly. It is compiled from other files. */
/**
 The MIT License

 Copyright (c) 2010 Daniel Park (http://metaweb.com, http://postmessage.freebaseapps.com)

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 THE SOFTWARE.
 **/
var NO_JQUERY={};!function(e,t,n){if(!("console"in e)){var a=e.console={};a.log=a.warn=a.error=a.debug=function(){}}t===NO_JQUERY&&(t={fn:{},extend:function(){for(var e=arguments[0],t=1,n=arguments.length;t<n;t++){var a=arguments[t];for(var r in a)e[r]=a[r]}return e}}),t.fn.pm=function(){return console.log("usage: \nto send:    $.pm(options)\nto receive: $.pm.bind(type, fn, [origin])"),this},t.pm=e.pm=function(e){r.send(e)},t.pm.bind=e.pm.bind=function(e,t,n,a,s){r.bind(e,t,n,a,!0===s)},t.pm.unbind=e.pm.unbind=function(e,t){r.unbind(e,t)},t.pm.origin=e.pm.origin=null,t.pm.poll=e.pm.poll=200;var r={send:function(e){var n=t.extend({},r.defaults,e),a=n.target;if(!n.target)return void console.warn("postmessage target window required");if(!n.type)return void console.warn("postmessage type required");var s={data:n.data,type:n.type};n.success&&(s.callback=r._callback(n.success)),n.error&&(s.errback=r._callback(n.error)),"postMessage"in a&&!n.hash?(r._bind(),a.postMessage(JSON.stringify(s),n.origin||"*")):(r.hash._bind(),r.hash.send(n,s))},bind:function(e,t,n,a,s){r._replyBind(e,t,n,a,s)},_replyBind:function(n,a,s,o,i){"postMessage"in e&&!o?r._bind():r.hash._bind();var u=r.data("listeners.postmessage");u||(u={},r.data("listeners.postmessage",u));var c=u[n];c||(c=[],u[n]=c),c.push({fn:a,callback:i,origin:s||t.pm.origin})},unbind:function(e,t){var n=r.data("listeners.postmessage");if(n)if(e)if(t){var a=n[e];if(a){for(var s=[],o=0,i=a.length;o<i;o++){var u=a[o];u.fn!==t&&s.push(u)}n[e]=s}}else delete n[e];else for(var o in n)delete n[o]},data:function(e,t){return void 0===t?r._data[e]:(r._data[e]=t,t)},_data:{},_CHARS:"0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz".split(""),_random:function(){for(var e=[],t=0;t<32;t++)e[t]=r._CHARS[0|32*Math.random()];return e.join("")},_callback:function(e){var t=r.data("callbacks.postmessage");t||(t={},r.data("callbacks.postmessage",t));var n=r._random();return t[n]=e,n},_bind:function(){r.data("listening.postmessage")||(e.addEventListener?e.addEventListener("message",r._dispatch,!1):e.attachEvent&&e.attachEvent("onmessage",r._dispatch),r.data("listening.postmessage",1))},_dispatch:function(e){function t(t){n.callback&&r.send({target:e.source,data:t,type:n.callback})}try{var n=JSON.parse(e.data)}catch(e){return}if(n.type){var a=r.data("callbacks.postmessage")||{},s=a[n.type];if(s)s(n.data);else for(var o=r.data("listeners.postmessage")||{},i=o[n.type]||[],u=0,c=i.length;u<c;u++){var l=i[u];if(l.origin&&"*"!==l.origin&&e.origin!==l.origin){if(console.warn("postmessage message origin mismatch",e.origin,l.origin),n.errback){var f={message:"postmessage origin mismatch",origin:[e.origin,l.origin]};r.send({target:e.source,data:f,type:n.errback})}}else try{l.callback?l.fn(n.data,t,e):t(l.fn(n.data,e))}catch(t){if(!n.errback)throw t;r.send({target:e.source,data:t,type:n.errback})}}}}};r.hash={send:function(t,n){var a=t.target,s=t.url;if(!s)return void console.warn("postmessage target window url is required");s=r.hash._url(s);var o,i=r.hash._url(e.location.href);if(e==a.parent)o="parent";else try{for(var u=0,c=parent.frames.length;u<c;u++){if(parent.frames[u]==e){o=u;break}}}catch(t){o=e.name}if(null==o)return void console.warn("postmessage windows must be direct parent/child windows and the child must be available through the parent window.frames list");var l={"x-requested-with":"postmessage",source:{name:o,url:i},postmessage:n},f="#x-postmessage-id="+r._random();a.location=s+f+encodeURIComponent(JSON.stringify(l))},_regex:/^\#x\-postmessage\-id\=(\w{32})/,_regex_len:"#x-postmessage-id=".length+32,_bind:function(){r.data("polling.postmessage")||(setInterval(function(){var t=""+e.location.hash,n=r.hash._regex.exec(t);if(n){var a=n[1];r.hash._last!==a&&(r.hash._last=a,r.hash._dispatch(t.substring(r.hash._regex_len)))}},t.pm.poll||200),r.data("polling.postmessage",1))},_dispatch:function(t){function n(e){a.callback&&r.send({target:i,data:e,type:a.callback,hash:!0,url:t.source.url})}if(t){try{if(t=JSON.parse(decodeURIComponent(t)),!("postmessage"===t["x-requested-with"]&&t.source&&null!=t.source.name&&t.source.url&&t.postmessage))return}catch(e){return}var a=t.postmessage,s=r.data("callbacks.postmessage")||{},o=s[a.type];if(o)o(a.data);else{var i;i="parent"===t.source.name?e.parent:e.frames[t.source.name];for(var u=r.data("listeners.postmessage")||{},c=u[a.type]||[],l=0,f=c.length;l<f;l++){var p=c[l];if(p.origin){var g=/https?\:\/\/[^\/]*/.exec(t.source.url)[0];if("*"!==p.origin&&g!==p.origin){if(console.warn("postmessage message origin mismatch",g,p.origin),a.errback){var d={message:"postmessage origin mismatch",origin:[g,p.origin]};r.send({target:i,data:d,type:a.errback,hash:!0,url:t.source.url})}continue}}try{p.callback?p.fn(a.data,n):n(p.fn(a.data))}catch(e){if(!a.errback)throw e;r.send({target:i,data:e,type:a.errback,hash:!0,url:t.source.url})}}}}},_url:function(e){return(""+e).replace(/#.*$/,"")}},t.extend(r,{defaults:{target:null,url:null,type:null,data:null,success:null,error:null,origin:"*",hash:!1}})}(this,"undefined"==typeof jQuery?NO_JQUERY:jQuery),"JSON"in window&&window.JSON||(JSON={}),function(){function f(e){return e<10?"0"+e:e}function quote(e){return escapable.lastIndex=0,escapable.test(e)?'"'+e.replace(escapable,function(e){var t=meta[e];return"string"==typeof t?t:"\\u"+("0000"+e.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+e+'"'}function str(e,t){var n,a,r,s,o,i=gap,u=t[e];switch(u&&"object"==typeof u&&"function"==typeof u.toJSON&&(u=u.toJSON(e)),"function"==typeof rep&&(u=rep.call(t,e,u)),typeof u){case"string":return quote(u);case"number":return isFinite(u)?String(u):"null";case"boolean":case"null":return String(u);case"object":if(!u)return"null";if(gap+=indent,o=[],"[object Array]"===Object.prototype.toString.apply(u)){for(s=u.length,n=0;n<s;n+=1)o[n]=str(n,u)||"null";return r=0===o.length?"[]":gap?"[\n"+gap+o.join(",\n"+gap)+"\n"+i+"]":"["+o.join(",")+"]",gap=i,r}if(rep&&"object"==typeof rep)for(s=rep.length,n=0;n<s;n+=1)"string"==typeof(a=rep[n])&&(r=str(a,u))&&o.push(quote(a)+(gap?": ":":")+r);else for(a in u)Object.hasOwnProperty.call(u,a)&&(r=str(a,u))&&o.push(quote(a)+(gap?": ":":")+r);return r=0===o.length?"{}":gap?"{\n"+gap+o.join(",\n"+gap)+"\n"+i+"}":"{"+o.join(",")+"}",gap=i,r}}"function"!=typeof Date.prototype.toJSON&&(Date.prototype.toJSON=function(e){return this.getUTCFullYear()+"-"+f(this.getUTCMonth()+1)+"-"+f(this.getUTCDate())+"T"+f(this.getUTCHours())+":"+f(this.getUTCMinutes())+":"+f(this.getUTCSeconds())+"Z"},String.prototype.toJSON=Number.prototype.toJSON=Boolean.prototype.toJSON=function(e){return this.valueOf()});var cx=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,escapable=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,gap,indent,meta={"\b":"\\b","\t":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},rep;"function"!=typeof JSON.stringify&&(JSON.stringify=function(e,t,n){var a;if(gap="",indent="","number"==typeof n)for(a=0;a<n;a+=1)indent+=" ";else"string"==typeof n&&(indent=n);if(rep=t,t&&"function"!=typeof t&&("object"!=typeof t||"number"!=typeof t.length))throw new Error("JSON.stringify");return str("",{"":e})}),"function"!=typeof JSON.parse&&(JSON.parse=function(text,reviver){function walk(e,t){var n,a,r=e[t];if(r&&"object"==typeof r)for(n in r)Object.hasOwnProperty.call(r,n)&&(a=walk(r,n),void 0!==a?r[n]=a:delete r[n]);return reviver.call(e,t,r)}var j;if(cx.lastIndex=0,cx.test(text)&&(text=text.replace(cx,function(e){return"\\u"+("0000"+e.charCodeAt(0).toString(16)).slice(-4)})),/^[\],:{}\s]*$/.test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,"")))return j=eval("("+text+")"),"function"==typeof reviver?walk({"":j},""):j;throw new SyntaxError("JSON.parse")})}();
// source --> https://blog.yimian.xyz/wp-content/plugins/jetpack/_inc/build/jquery.jetpack-resize.min.js?ver=6.8.1 
/* Do not modify this file directly. It is compiled from other files. */
/* global Jetpack, JSON */
/**
 * Resizeable Iframes.
 *
 * Start listening to resize postMessage events for selected iframes:
 * $( selector ).Jetpack( 'resizeable' );
 * - OR -
 * Jetpack.resizeable( 'on', context );
 *
 * Resize selected iframes:
 * $( selector ).Jetpack( 'resizeable', 'resize', { width: 100, height: 200 } );
 * - OR -
 * Jetpack.resizeable( 'resize', { width: 100, height: 200 }, context );
 *
 * Stop listening to resize postMessage events for selected iframes:
 * $( selector ).Jetpack( 'resizeable', 'off' );
 * - OR -
 * Jetpack.resizeable( 'off', context );
 *
 * Stop listening to all resize postMessage events:
 * Jetpack.resizeable( 'off' );
 */
!function(e){var t,a,i,r,n=!1,o=[],s=!1;if(void 0===window.Jetpack&&(window.Jetpack={getTarget:function(t){return this instanceof jQuery?t?this.filter(t):this:t?e(t):t}}),void 0===e.fn.Jetpack&&(e.fn.Jetpack=function(t){if("function"==typeof Jetpack[t])return Jetpack[t].apply(this,Array.prototype.slice.call(arguments,1));e.error('Namespace "'+t+'" does not exist on jQuery.Jetpack')}),"function"!=typeof window.postMessage)return void e.extend(window.Jetpack,{resizeable:function(){e.error("Browser does not support window.postMessage")}});t=function(e){return e.match(/^https?:\/\//)||(e=document.location.href),e.split("/").slice(0,3).join("/")},a=function(){n=!0,e(window).on("message.JetpackResizeableIframe",function(t){var a,i=t.originalEvent;if(-1!==e.inArray(i.origin,o)){if("object"==typeof i.data)a=i.data.data;else try{a=JSON.parse(i.data)}catch(e){a=!1}a.data&&(a=a.data,void 0!==a.action&&"resize"===a.action&&s.filter(function(){return void 0!==a.name?this.name===a.name:i.source===this.contentWindow}).first().Jetpack("resizeable","resize",a))}})},i=function(){n=!1,e(window).off("message.JetpackResizeableIframe"),o=[],e(".jetpack-resizeable").removeClass("jetpack-resizeable"),s=!1},r={on:function(i){var r=Jetpack.getTarget.call(this,i);return n||a(),r.each(function(){o.push(t(e(this).attr("src")))}).addClass("jetpack-resizeable"),s=e(".jetpack-resizeable"),r},off:function(a){var r=Jetpack.getTarget.call(this,a);return void 0===r?(i(),r):(r.each(function(){var a=t(e(this).attr("src")),i=e.inArray(a,o);-1!==i&&o.splice(i,1)}).removeClass("jetpack-resizeable"),s=e(".jetpack-resizeable"),r)},resize:function(t,a){var i=Jetpack.getTarget.call(this,a);return e.each(["width","height"],function(e,a){var r,n=0;void 0!==t[a]&&(n=parseInt(t[a],10)),0!==n&&(i[a](n),r=i.parent(),r.hasClass("slim-likes-widget")&&r[a](n))}),i}},e.extend(window.Jetpack,{resizeable:function(t){return r[t]?r[t].apply(this,Array.prototype.slice.call(arguments,1)):t?void e.error("Method "+t+" does not exist on Jetpack.resizeable"):r.on.apply(this)}})}(jQuery);