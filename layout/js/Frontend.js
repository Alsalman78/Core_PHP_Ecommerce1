$(function () {
	'use strict';

	//Switch Between Login and Logout Form

   $('.login-page h1 span').click(function(){

   		$(this).addClass('selected').siblings().removeClass('selected');

   		$('.login-page form').hide();

   		$('.' + $(this).data('class')).fadeIn(100);


   });

})