$(function(){var $messages,$form,setFooterElHeight=function(){var mapEl=document.getElementById("loginfooter");mapEl.style.minHeight=window.innerHeight-mapEl.offsetTop+"px"};$messages=$(".message-bottom"),$form=$("#loginform, #registerform, #lostpasswordform"),$($messages.get().reverse()).each(function(){$form.after(this)}),$(window).resize(setFooterElHeight),setFooterElHeight()});