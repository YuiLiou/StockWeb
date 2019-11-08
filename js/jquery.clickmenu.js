/*
 * setting  =>  arrowSrc: 'arrow_r.gif'
 */
/* clickMenu - v0.1.6
 * Copyright (c) 2007 Roman Weich
 * http://p.sohei.org
 *
 * Changelog: 
 * v 0.1.6 - 2007-09-06
 *	-fix: having a link in the top-level menu would not open the menu but call the link instead
 * v 0.1.5 - 2007-07-07
 *	-change/fix: menu opening/closing now through simple show() and hide() calls - before fadeIn and fadeOut were used for which extra functions to stop a already running animation were created -> they were 
 *			buggy (not working with the interface plugin in jquery1.1.2 and not working with jquery1.1.3 at all) and now removed
 *	-change: removed option: fadeTime
 *	-change: now using the bgiframe plugin for adding iframes in ie6 when available
 * v 0.1.4 - 2007-03-20
 *	-fix: the default options were overwritten by the context related options
 *	-fix: hiding a submenu all hover- and click-events were unbound, even the ones not defined in this plugin - unbinding should work now
 * v 0.1.3 - 2007-03-13
 *	-fix: some display problems ie had when no width was set on the submenu, so on ie the width for each submenu will be explicitely set
 *	-fix: the fix to the ie-width-problem is a fix to the "ie does not support css min-width stuff" problem too which displayed some submenus too narrow (it looked just not right)
 *	-fix: some bugs, when user the was too fast with the mouse
 * v 0.1.2 - 2007-03-11
 *	-change: made a lot changes in the traversing routines to speed things up (having better memory usage now as well)
 *	-change: added $.fn.clickMenu.setDefaults() for setting global defaults
 *	-fix: hoverbug when a main menu item had no submenu
 *	-fix: some bugs i found while rewriting most of the stuff
 * v 0.1.1 - 2007-03-04
 *	-change: the width of the submenus is no longer fixed, its set in the plugin now
 *	-change: the submenu-arrow is now an img, not the background-img of the list element - that allows better positioning, and background-changes on hover (you have to set the image through the arrowSrc option)
 *	-fix: clicking on a clickMenu while another was already open, didn't close the open one
 *	-change: clicking on the open main menu item will close it
 *	-fix: on an open menu moving the mouse to a main menu item and moving it fastly elsewere hid the whole menu
 * v 0.1.0 - 2007-03-03
 */

(function($)
{
	var defaults = {
		onClick: function(){
			$(this).find('>a').each(function(){
				if ( this.href )
				{
					window.location = this.href;
				}
			});
		},
		arrowSrc: 'arrow_r.gif',
		subDelay: 300,
		mainDelay: 10
	};

	$.fn.clickMenu = function(options) 
	{
		var shown = false;
		var liOffset = ( ($.browser.msie) ? 4 : 2 );

		var settings = $.extend({}, defaults, options);

		var hideDIV = function(div, delay)
		{
			//a timer running to show the div?
			if ( div.timer && !div.isVisible )
			{
				clearTimeout(div.timer);
			}
			else if (div.timer)
			{
				return; //hide-timer already running
			}
			if ( div.isVisible )
			{
				div.timer = setTimeout(function()
				{
					//remove events
					$(getAllChilds(getOneChild(div, 'UL'), 'LI')).unbind('mouseover', liHoverIn).unbind('mouseout', liHoverOut).unbind('click', settings.onClick);
					//hide it
					$(div).hide();
					div.isVisible = false;
					div.timer = null;
				}, delay);
			}
		};

		var showDIV = function(div, delay)
		{
			if ( div.timer )
			{
				clearTimeout(div.timer);
			}
			if ( !div.isVisible )
			{
				div.timer = setTimeout(function()
				{
					//check if the mouse is still over the parent item - if not dont show the submenu
					if ( !checkClass(div.parentNode, 'hover') )
					{
						return;
					}
					//assign events to all div>ul>li-elements
					$(getAllChilds(getOneChild(div, 'UL'), 'LI')).mouseover(liHoverIn).mouseout(liHoverOut).click(settings.onClick);
					//positioning
					if ( !checkClass(div.parentNode, 'main') )
					{
						var left1=div.parentNode.offsetWidth - liOffset;


						$(div).css('left', left1);
					}
					//show it
					div.isVisible = true; //we use this over :visible to speed up traversing
					$(div).show();
					if ( $.browser.msie ) //fixing a display-bug in ie6 and adding min-width
					{
						var cW = $(getOneChild(div, 'UL')).width();
						if ( cW < 100 )
						{
							cW = 100;
						}
						$(div).css('width', cW);
					}

						var left1=div.parentNode.offsetWidth - liOffset;

						var curleft = 0;
						var obj=div.parentNode;
						var lv=0;

						  if(obj.offsetParent) {
							while(1) {
							  curleft += obj.offsetLeft;
							  lv++;
							  if(!obj.offsetParent)
								break;
							  obj = obj.offsetParent;
							}
						  } else if(obj.x) {
							curleft += obj.x;
						  }

							if(lv>2) $(div).css('top', -3);
							if ( $.browser.msie && (!$.browser.version || parseInt($.browser.version) <= 7) )
							{
//								alert('lv='+lv);
								if(lv<=2){
									$(div).css('top', 22);
									$(div).css('left', left1-div.parentNode.offsetWidth+12);
								}
							}
							

						  if(curleft+left1+div.offsetWidth>document.body.offsetWidth){
							  var offset1=curleft+left1+div.offsetWidth-document.body.offsetWidth;
							  left1-=offset1;
							if(lv>2) $(div).css('top', -3);
							$(div).css('left', left1);
							$(div).css('z-index', lv);
//						  alert('lv='+lv+' '+div.innerHTML);
//							$(div.parentNode).unbind('mouseover', liHoverIn).unbind('mouseout', liHoverOut).unbind('click', settings.onClick);
						  }
							if ( !checkClass(div, 'menu_lv'+lv/2) )
							{
								var old_width=document.body.clientWidth;
								$(div).addClass('menu_lv'+lv/2);
								if(old_width!=document.body.clientWidth) document.body.style.width=old_width;
							}

					div.timer = null;
				}, delay);
			}
		};

		//same as hover.handlehover in jquery - just can't use hover() directly - need the ability to unbind only the one hover event
		var testHandleHover = function(e)
		{
			// Check if mouse(over|out) are still within the same parent element
			var p = (e.type == "mouseover" ? e.fromElement : e.toElement) || e.relatedTarget;
			// Traverse up the tree
			while ( p && p != this )
			{
				try
				{ 
					p = p.parentNode;
				}
				catch(e)
				{ 
					p = this;
				}
			}
			// If we actually just moused on to a sub-element, ignore it
			if ( p == this )
			{
				return false;
			}
			return true;
		};
		
		var mainHoverIn = function(e)
		{
			//no need to test e.target==this, as no child has the same event binded
			//its possible, that a main menu item still has hover (if it has no submenu) - thus remove it
			var lis = getAllChilds(this.parentNode, 'LI');
			var pattern = new RegExp("(^|\\s)hover(\\s|$)");
			for (var i = 0; i < lis.length; i++)
			{
				if ( pattern.test(lis[i].className) )
				{
					$(lis[i]).removeClass('hover');
				}
			}
			var old_width=document.body.clientWidth;
			$(this).addClass('hover');
			if(old_width!=document.body.clientWidth) document.body.style.width=old_width;

//			alert('shown='+shown+ ' '+this.childNodes.length);

			if ( shown ){
				if(this.childNodes.length==1){
//					alert(this.innerHTML +' '+settings.arrowSrc);
//					alert(this.id +' '+settings.arrowSrc);
	//				var n1= document.createElement(menu1);
					var n1= document.createElement('UL');
					if(this.id=='mm0'){
						n1.innerHTML=menu0;
					} else if(this.id=='mm1'){
						n1.innerHTML=menu1;
					} else if(this.id=='mm2'){
						n1.innerHTML=menu2;
					} else if(this.id=='mm3'){
						n1.innerHTML=menu3;
					} else if(this.id=='mm4'){
						n1.innerHTML=menu4;
					} else if(this.id=='mm5'){
						n1.innerHTML=menu5;
					} else if(this.id=='mm6'){
						n1.innerHTML=menu6;
					} else if(this.id=='mm7'){
						n1.innerHTML=menu7;
					} else if(this.id=='mm8'){
						n1.innerHTML=menu8;
					} else if(this.id=='mm9'){
						n1.innerHTML=menu9;
					} else if(this.id=='mm10'){
						n1.innerHTML=menu10;
					} else if(this.id=='mm11'){
						n1.innerHTML=menu11;
					}
					this.appendChild(n1);
					$('ul', this).shadowBox();

					if ( $.browser.msie && (!$.browser.version || parseInt($.browser.version) <= 6) )
					{
						if ( $.fn.bgiframe )
						{
							$('div.outerbox', this).bgiframe();
						}
						else
						{
							/* thanks to Mark Gibson - http://www.nabble.com/forum/ViewPost.jtp?post=6504414&framed=y */
							$('div.outerbox', this).append('<iframe style="display:block;position:absolute;top:0;left:0;z-index:-1;filter:mask();' + 
											'width:expression(this.parentNode.offsetWidth);height:expression(this.parentNode.offsetHeight)"/>');
						}
					}
					//assign events
					$(this).bind('closemenu', function(){clean();}); //assign closemenu-event, through wich the menu can be closed from outside the plugin

//					if ( settings.arrowSrc ){
//						$('ul.inner ul.outerbox', this).before('<img src="' + settings.arrowSrc + '" class="liArrow" />');
//					}
	//				$(li).after(menu1);
	//				li.innerHTML=li.innerText+(menu1);
	//				$('#list').clickMenu();
	//				$(li).mouseover(mainHover);
//					innerDiv = getOneChild(li, 'DIV');
	//				alert('innerDiv1='+li.childNodes.length);
				}

				hoverIn(this, settings.mainDelay);
			}
		};

		var liHoverIn = function(e)
		{
			if ( !testHandleHover(e) )
			{
				return false;
			}
			if ( e.target != this )
			{
				//look whether the target is a direct child of this (maybe an image)
				if ( !isChild(this, e.target) )
				{
					return;
				}
			}
			hoverIn(this, settings.subDelay);
		};

		var hoverIn = function(li, delay)
		{
//			alert('lis='+li.innerText+' '+li.childNodes.length);

			var innerDiv = getOneChild(li, 'DIV');

//			alert('innerDiv='+innerDiv+' '+li.childNodes.length);
			//stop running timers from the other menus on the same level - a little faster than $('>*>div', li.parentNode)
			var n = li.parentNode.firstChild;
			for ( ; n; n = n.nextSibling ) 
			{
				if ( n.nodeType == 1 && n.nodeName.toUpperCase() == 'LI' )
				{
					var div = getOneChild(n, 'DIV');
					if ( div && div.timer && !div.isVisible ) //clear show-div timer
					{
						clearTimeout(div.timer);
						div.timer = null;
					}
				}
			}
			//is there a timer running to hide one of the parent divs? stop it
			var pNode = li.parentNode;
			for ( ; pNode; pNode = pNode.parentNode ) 
			{
				if ( pNode.nodeType == 1 && pNode.nodeName.toUpperCase() == 'DIV' )
				{
					if (pNode.timer)
					{
						clearTimeout(pNode.timer);
						pNode.timer = null;
						var old_width=document.body.clientWidth;
						$(pNode.parentNode).addClass('hover');
						if(old_width!=document.body.clientWidth) document.body.style.width=old_width;
					}
				}
			}
			//highlight the current element
			var old_width=document.body.clientWidth;
			$(li).addClass('hover');
			if(old_width!=document.body.clientWidth) document.body.style.width=old_width;
			//is the submenu already visible?
			if ( innerDiv && innerDiv.isVisible )
			{
				//hide-timer running?
				if ( innerDiv.timer )
				{
					clearTimeout(innerDiv.timer);
					innerDiv.timer = null;
				}
				else
				{
					return;
				}
			}
			//hide all open menus on the same level and below and unhighlight the li item (but not the current submenu!)
			$(li.parentNode.getElementsByTagName('DIV')).each(function(){
				if ( this != innerDiv && this.isVisible )
				{
					hideDIV(this, delay);
					$(this.parentNode).removeClass('hover');
				}
			});
			//show the submenu, if there is one
			if ( innerDiv )
			{
				showDIV(innerDiv, delay);
			}
		};

		var liHoverOut = function(e)
		{
			if ( !testHandleHover(e) )
			{
				return false;
			}
			if ( e.target != this )
			{
				if ( !isChild(this, e.target) ) //return only if the target is no direct child of this
				{
					return;
				}
			}
			//remove the hover from the submenu item, if the mouse is hovering out of the menu (this is only for the last open (levelwise) (sub-)menu)
			var div = getOneChild(this, 'DIV');
			if ( !div )
			{
				$(this).removeClass('hover');
			}
			else 
			{
				if ( !div.isVisible )
				{
					$(this).removeClass('hover');
				}
			}
		};

		var mainHoverOut = function(e)
		{
			//no need to test e.target==this, as no child has the same event binded
			//remove hover
			var div = getOneChild(this, 'DIV');
			var relTarget = e.relatedTarget || e.toElement; //this is undefined sometimes (e.g. when the mouse moves out of the window), so dont remove hover then
			var p;
			if ( !shown )
			{
				$(this).removeClass('hover');
			}
			else if ( !div && relTarget ) //menuitem has no submenu, so dont remove the hover if the mouse goes outside the menu
			{
				p = findParentWithClass(e.target, 'UL', 'clickMenu');
				if ( p.contains(relTarget))
				{
					$(this).removeClass('hover');
				}
			}
			else if ( relTarget )
			{
				//remove hover only when moving to anywhere inside the clickmenu
				p = findParentWithClass(e.target, 'UL', 'clickMenu');
				if ( !div.isVisible && (p.contains(relTarget)) )
				{
					$(this).removeClass('hover');
				}
			}
		};
		var mainHover = function()
		{   
			hoverIn(this, settings.mainDelay);   
			shown = true;   
			$(document).bind('mousedown', checkMouse);   
			return false;   
		}
		var mainClick = function()
		{
			var div = getOneChild(this, 'DIV');
			if ( div && div.isVisible ) //clicked on an open main-menu-item
			{
/* remark at 20100902  */
//				clean();
//				var old_width=document.body.clientWidth;
//				$(this).addClass('hover');
//				if(old_width!=document.body.clientWidth) document.body.style.width=old_width;

			}else{


				if ( true ){
					if(this.childNodes.length==1){
	//					alert(this.innerHTML +' '+settings.arrowSrc);
	//					alert(this.id +' '+settings.arrowSrc);
		//				var n1= document.createElement(menu1);
						var n1= document.createElement('UL');
						if(this.id=='mm0'){
							n1.innerHTML=menu0;
						} else if(this.id=='mm1'){
							n1.innerHTML=menu1;
						} else if(this.id=='mm2'){
							n1.innerHTML=menu2;
						} else if(this.id=='mm3'){
							n1.innerHTML=menu3;
						} else if(this.id=='mm4'){
							n1.innerHTML=menu4;
						} else if(this.id=='mm5'){
							n1.innerHTML=menu5;
						} else if(this.id=='mm6'){
							n1.innerHTML=menu6;
						} else if(this.id=='mm7'){
							n1.innerHTML=menu7;
						} else if(this.id=='mm8'){
							n1.innerHTML=menu8;
						} else if(this.id=='mm9'){
							n1.innerHTML=menu9;
						} else if(this.id=='mm10'){
							n1.innerHTML=menu10;
						} else if(this.id=='mm11'){
							n1.innerHTML=menu11;
						}
						this.appendChild(n1);
						$('ul', this).shadowBox();

						if ( $.browser.msie && (!$.browser.version || parseInt($.browser.version) <= 6) )
						{
							if ( $.fn.bgiframe )
							{
								$('div.outerbox', this).bgiframe();
							}
							else
							{
								/* thanks to Mark Gibson - http://www.nabble.com/forum/ViewPost.jtp?post=6504414&framed=y */
								$('div.outerbox', this).append('<iframe style="display:block;position:absolute;top:0;left:0;z-index:-1;filter:mask();' + 
												'width:expression(this.parentNode.offsetWidth);height:expression(this.parentNode.offsetHeight)"/>');
							}
						}
						//assign events
						$(this).bind('closemenu', function(){clean();}); //assign closemenu-event, through wich the menu can be closed from outside the plugin

					}

				}


				hoverIn(this, settings.mainDelay);
				shown = true;
				$(document).bind('mousedown', checkMouse);
//				alert('tt='+settings.mainDelay);
			}
			return false;
		};

		var checkMouse = function(e)
		{
			//is the mouse inside a clickmenu? if yes, is it an open (the current) one?
			var vis = false;
			var cm = findParentWithClass(e.target, 'UL', 'clickMenu');
			if ( cm )
			{
				$(cm.getElementsByTagName('DIV')).each(function(){
					if ( this.isVisible )
					{
						vis = true;
					}
				});
			}
			if ( !vis )
			{
				clean();
			}
		};

		var clean = function()
		{
			//remove timeout and hide the divs
			$('ul.clickMenu div.outerbox').each(function(){
				if ( this.timer )
				{
					clearTimeout(this.timer);
					this.timer = null;
				}
				if ( this.isVisible )
				{
					$(this).hide();
					this.isVisible = false;
				}
			});
			$('ul.clickMenu li').removeClass('hover');
			//remove events
			$('ul.clickMenu>li li').unbind('mouseover', liHoverIn).unbind('mouseout', liHoverOut).unbind('click', settings.onClick);
			$(document).unbind('mousedown', checkMouse);
			shown = false;
//			alert('clean ?');
		};

		var getOneChild = function(elem, name)
		{
			if ( !elem )
			{
				return null;
			}
			var n = elem.firstChild;
			for ( ; n; n = n.nextSibling ) 
			{
				if ( n.nodeType == 1 && n.nodeName.toUpperCase() == name )
				{
					return n;
				}
			}
			return null;
		};

		var getAllChilds = function(elem, name)
		{
			if ( !elem )
			{
				return [];
			}
			var r = [];
			var n = elem.firstChild;
			for ( ; n; n = n.nextSibling ) 
			{
				if ( n.nodeType == 1 && n.nodeName.toUpperCase() == name )
				{
					r[r.length] = n;
				}
			}
			return r;
		};

		var findParentWithClass = function(elem, searchTag, searchClass)
		{
			var pNode = elem.parentNode;
			var pattern = new RegExp("(^|\\s)" + searchClass + "(\\s|$)");
			for ( ; pNode; pNode = pNode.parentNode )
			{
				if ( pNode.nodeType == 1 && pNode.nodeName.toUpperCase() == searchTag && pattern.test(pNode.className) )
				{
					return pNode;
				}
			}
			return null;
		};
		
		var checkClass = function(elem, searchClass)
		{
			var pattern = new RegExp("(^|\\s)" + searchClass + "(\\s|$)");
			if ( pattern.test(elem.className) )
			{
				return true;
			}
			return false;
		};
		
		var isChild = function(elem, childElem)
		{
			var n = elem.firstChild;
			for ( ; n; n = n.nextSibling ) 
			{
				if ( n == childElem )
				{
					return true;
				}
			}
			return false;
		};

	    return this.each(function()
		{
			//add .contains() to mozilla - http://www.quirksmode.org/blog/archives/2006/01/contains_for_mo.html
			if (window.Node && Node.prototype && !Node.prototype.contains)
			{
				Node.prototype.contains = function(arg) 
				{
					return !!(this.compareDocumentPosition(arg) & 16);
				};
			}
			//add class
			if ( !checkClass(this, 'clickMenu') )
			{
				var old_width=document.body.clientWidth;
				$(this).addClass('clickMenu');
				if(old_width!=document.body.clientWidth) document.body.style.width=old_width;
			}
			//add shadows
			$('ul', this).shadowBox();
			//ie6? - add iframes
			if ( $.browser.msie && (!$.browser.version || parseInt($.browser.version) <= 6) )
			{
				if ( $.fn.bgiframe )
				{
					$('div.outerbox', this).bgiframe();
				}
				else
				{
					/* thanks to Mark Gibson - http://www.nabble.com/forum/ViewPost.jtp?post=6504414&framed=y */
					$('div.outerbox', this).append('<iframe style="display:block;position:absolute;top:0;left:0;z-index:-1;filter:mask();' + 
									'width:expression(this.parentNode.offsetWidth);height:expression(this.parentNode.offsetHeight)"/>');
				}
			}
			//assign events
			$(this).bind('closemenu', function(){clean();}); //assign closemenu-event, through wich the menu can be closed from outside the plugin
			//add click event handling, if there are any elements inside the main menu
			var liElems = getAllChilds(this, 'LI');
			for ( var j = 0; j < liElems.length; j++ )
			{
//				if ( getOneChild(getOneChild(getOneChild(liElems[j], 'DIV'), 'UL'), 'LI') ) // >div>ul>li
				{
					$(liElems[j]).click(mainClick);
					//$(liElems[j]).mouseover(mainHover);
				}
			}
			//add hover event handling and assign classes
			$(liElems).hover(mainHoverIn, mainHoverOut).addClass('main').find('>div').addClass('inner');
			//add the little arrow before each submenu
			if ( settings.arrowSrc )
			{
				$('div.inner div.outerbox', this).before('<img src="' + settings.arrowSrc + '" class="liArrow" />');
			}

			//the floating list elements are destroying the layout..so make it nice again..
			$(this).wrap('<div class="cmDiv"></div>').after('<div style="clear: both; visibility: hidden;"></div>');
	    });
	};
	$.fn.clickMenu.setDefaults = function(o)
	{
		$.extend(defaults, o);
	};
})(jQuery);

(function($)
{
	$.fn.shadowBox = function() {
	    return this.each(function()
		{
			var outer = $('<div class="outerbox"></div>').get(0);


			if ( $(this).css('position') == 'absolute' )
			{
				//if the child(this) is positioned abolute, we have to use relative positioning and shrink the outerbox accordingly to the innerbox
				$(outer).css({position:'relative', width:this.offsetWidth, height:this.offsetHeight});
			}
			else
			{
				//shrink the outerbox
				$(outer).css('position', 'absolute');
			}
			//add the boxes
			$(this).addClass('innerBox').wrap(outer).
					before('<div class="shadowbox1"></div><div class="shadowbox2"></div><div class="shadowbox3"></div>');
	    });
	};
})(jQuery);