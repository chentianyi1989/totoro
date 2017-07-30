(function($){
	$().ready(function(){
		/*$('.level').animate({
			'width':$(this).attr('levelNum')
		},800)*/
		$('.level').each(function(){
			var levelNum=$(this).attr('levelNum');
			$(this).animate({
				'width':levelNum
			},800)
		})

		// $('.user_right').load('account_load.html')

		//header load
		$('.user_con').on('click','.userbasic_head a',function(){
			var loadUrl=$(this).attr('_href');
			$('.loading_shadow').show();
			$('.user_right').load(loadUrl,function(responseTxt,statusTxt,xhr){
				if(statusTxt=="success"){
					$('.loading_shadow').hide();
					$('.level').each(function(){
						var levelNum=$(this).attr('levelNum');
						$(this).animate({
							'width':levelNum
						},800)
					});
					//会员存款
					$('.bankchoose_list li:gt(5)').hide();
				}
			    if(statusTxt=="error"){
			    	alert("Error: "+xhr.status+": "+xhr.statusText);
			    	$('.loading_shadow').hide();
			    }
			      
			})
		})

		$('.user_con').on('click','.lock_list li .bot button',function(){
			var _this=$(this)
			$(this).hide();;
			$(this).next('.lock_line').show();
			$(this).next('.lock_line').children('.level').animate({
				'width':'100%'
			},800,function(){
				_this.addClass('success').show();
				_this.next('.lock_line').hide()
				_this.attr('disabled',true)
			})
		});

		$('.user_left').on('click','li',function(){
			$('.user_left li').removeClass('active');
			$(this).addClass('active');
		});

		$('.user_con').on('click','.toggle_more a',function(){
			$('.bankchoose_list li:gt(5)').toggle();
		})

		/*$('.user_con').on('click','.ways .show_bank',function(){
			$('.choosebank').show();
		})
		$('.user_con').on('click','.account_index .show_bank',function(){
			$('.choosebank').show();
			$('.green_pass').hide();
		})
		$('.user_con').on('click','.account_index .ways_box',function(){
			$('.account_index .ways_box').removeClass('active');
			$(this).addClass('active');
		})
		$('.user_con').on('click','.account_index .green_way',function(){
			$('.choosebank').show();
			$('.green_pass').show();
			$('.account_form .green_tips').show();

		})
		$('.user_con').on('click','.account_index .wechar_pay',function(){
			$('.choosebank').hide();
			$('.green_pass').hide();

		})*/
		$('.user_con').on('click','.account_index .wechar_pay',function(){
			$('.pay_toggle_tips').hide();

		})
		$('.user_con').on('click','.account_index .card_pay',function(){
			$('.pay_toggle_tips').show();

		})

		//nav 
		//$(window).scroll(function(){
		//	navToggle();
		//	console.log('a');
		//})
		//navToggle();
		//function navToggle(){
		//	if($('body').scrollTop()>=10){
		//		$('.header_hd').slideUp('fast');
		//		$('.header_bd').slideUp('fast');
		//		$('.nav').addClass('minnav');
		//	}else{
		//		$('.header_hd').slideDown('fast');
		//		$('.header_bd').slideDown('fast');
		//		$('.nav').removeClass('minnav');
		//	}
		//}

		

	})
})(jQuery);
































