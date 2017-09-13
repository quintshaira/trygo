/*"use strict";function PFR(){var myWindow=window.open("","MsgWindow","width=500, height=500");myWindow.document.write('<img src="assets/img/sample.jpg" alt="">')}$.fn.bootstrapSwitch.defaults.onText="Active",$.fn.bootstrapSwitch.defaults.offText="Deactivated",$.fn.bootstrapSwitch.defaults.labelWidth="10px",$("[name='my-checkbox']").bootstrapSwitch(),$("#menu-toggle").click(function(e){e.preventDefault(),$(".body-container").toggleClass("toggled"),$(".sub-menu").toggleClass("expand-sub")}),$(".display-add a").click(function(e){e.preventDefault(),$(".extra-add").toggleClass("appear"),$("> .group").toggleClass("extra-fade")}),$(document).ready(function(){$("#multiselect").multiselect()}),$(function(){$(".sidebar-nav > li").on("mouseover",function(){var $menuItem=$(this),$submenuWrapper=$("> .sub-menu",$menuItem),menuItemPos=$menuItem.position();$submenuWrapper.css({top:menuItemPos.top})})}),$(document).ready(function(){$(document).ready(function(){function openSubMenu(){$(this).find("ul").show()}function closeSubMenu(){$(this).find("ul").hide()}$(".sidebar-nav > li").bind("mouseover",openSubMenu),$(".sidebar-nav > li").bind("mouseout",closeSubMenu)})});*/

$("#menu-toggle").click(function(e){
		e.preventDefault(),
		$(".body-container").toggleClass("toggled"),
		$(".dropdown-menu").toggleClass("expand-sub")
		});
		
$(function(){
$(".li-sub").on("mouseover",function(){var $menuItem=$(this),$submenuWrapper=$("> .sub-menu",$menuItem),menuItemPos=$menuItem.position();$submenuWrapper.css({top:menuItemPos.top})})
	}),
	
	$(document).ready(function(){
		$(document).ready(function(e){
			function openSubMenu(){$(this).find("ul").show()}
			function closeSubMenu(){$(this).find("ul").hide()}
			$(".li-sub").bind("mouseover",openSubMenu),
			$(".li-sub").bind("mouseout",closeSubMenu),
			e.preventDefault()
		})
	});

/*	$(".li-sub").live('mouseover', function(){
     var $menuItem=$(this),$submenuWrapper=$("> .sub-menu",$menuItem),menuItemPos=$menuItem.position();$submenuWrapper.css({top:menuItemPos.top})
	});*/
	
//# sourceMappingURL=script.js.map
/*function is_touch_device() {
 return (('ontouchstart' in window)
      || (navigator.MaxTouchPoints > 0)
      || (navigator.msMaxTouchPoints > 0));     // works on IE10/11 and Surface
};*/
/*function is_touch_device() {
 return (('ontouchstart' in window)
      || (navigator.MaxTouchPoints > 0)
      || (navigator.msMaxTouchPoints > 0));
}
$('ul > li > a').click(function(e){
    var target = $(e.target);
    var parent = target.parent(); // the li
    if(is_touch_device()){
        if(target.hasClass("active")){
            //run default action of the link
        }
        else{
            e.preventDefault();
            target.addClass("active");
            parent.addClass("active");
	        }
    }
});*/

$("#menu-toggle1").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
		
    });
     $("#menu-toggle-2").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled-2");
        $('#menu ul').hide();
    });
 
     function initMenu() {
      $('#menu ul').hide();
      $('#menu ul').children('.current').parent().show();
      //$('#menu ul:first').show();
      $('#menu li a').click(
        function() {
          var checkElement = $(this).next();
          if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
            return false;
            }
          if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
            $('#menu ul:visible').slideUp('normal');
            checkElement.slideDown('normal');
            return false;
            }
          }
        );
      }
    $(document).ready(function() {initMenu();});