$(function() {
	var pop = $('.popbtn');
	var row = $('.row:not(:first):not(:last)');
	
	var recentlyClickedItem;
	var recentlyClickedPopbtn;
	var recentlyClickedPrice;
	
	var isPaymentSucsessive;
	
	var numberSelectedItems = 0;

	pop.popover({
		trigger: 'manual',
		html: true,
		container: 'body',
		placement: 'bottom',
		animation: false,
		content: function() {
			return $('#popover').html();
		}
	});
	
	pop.on('click', function(e) {
		recentlyClickedPopbtn = $(this);
		recentlyClickedItem = $(this).siblings(".isChecked");
		pop.popover('toggle');
		pop.not(this).popover('hide');
	});
	
	$(document).on('click', 'a>.glyphicon-ok', function(e){
		if(!recentlyClickedItem.hasClass("glyphicon"))
		{
			recentlyClickedPrice = recentlyClickedPopbtn.siblings(".price").text();
			recentlyClickedItem.addClass("glyphicon");
			recentlyClickedItem.addClass("glyphicon-ok");
			numberSelectedItems += 1;
			addTotalPrice();
		}
		recentlyClickedPopbtn.popover('toggle');
	});
	
	$(document).on('click', 'a>.glyphicon-remove', function(e){
		if(recentlyClickedItem.hasClass("glyphicon"))
		{
			recentlyClickedPrice = recentlyClickedPopbtn.siblings(".price").text();
			recentlyClickedItem.removeClass("glyphicon");
			recentlyClickedItem.removeClass("glyphicon-ok");
			numberSelectedItems -= 1;
			subTotalPrice();
		}
		recentlyClickedPopbtn.popover('toggle');
	});
	
	$(window).on('resize', function() {
		pop.popover('hide');
	});

	row.on('touchend', function(e) {
		$(this).find('.popbtn').popover('toggle');
		row.not(this).find('.popbtn').popover('hide');
		return false;
	});

	function addTotalPrice()
	{
		var priceToAdd = accounting.unformat(recentlyClickedPrice);
		var lastTotalPrice = accounting.unformat($(".totalPrice").text());
		var totalPrice = lastTotalPrice + priceToAdd;
		$(".totalPrice").text(accounting.formatMoney(totalPrice, "￦", 0));
	};
	
	function subTotalPrice()
	{
		var priceToSub = accounting.unformat(recentlyClickedPrice);
		var lastTotalPrice = accounting.unformat($(".totalPrice").text());
		var totalPrice = lastTotalPrice - priceToSub;
		$(".totalPrice").text(accounting.formatMoney(totalPrice, "￦", 0));
	};

	$('.order-confirm').on('click', function(e) {
		var IMP = window.IMP;
		IMP.init('iamport');
		
		var paymentName = "no payment name";	// will be overwritten
		$("li").each(function(index) {
			
			if($(this).children(".isChecked").hasClass("glyphicon"))
			{
				paymentName = $(this).children(".itemName").text();
				return false;
			}
		});
		if(numberSelectedItems != 1)
			paymentName = paymentName + " 외 " + (numberSelectedItems - 1);
		
		function getEle(callback){
			$.ajax({
		    	type: "POST",
		    	dataType: "json",
		    	url: "retrieveUserData.php", //Relative or absolute path to response.php file
		        success: function(data) {
		        	var element = [];
		            element[0] = data["userName"];
		            element[1] = data["userHp"];
		            callback(element);
		        }
		    });
			}
		
		getEle(function (element){
			var userName = element[0];
			var userHp = element[1];
			
			IMP.request_pay({
				pay_method : $(".pay_method").val(),
				escrow : 1,
				merchant_uid : 'merchant_' + new Date().getTime(),
				name: paymentName, 
				amount: accounting.unformat($(".totalPrice").text()),
				buyer_email: "test@test.test",		// no email on db 
				buyer_name: userName, 
				buyer_tel: userHp, 
				buyer_addr: "",
				buyer_postcode: "",
				vbank_due: moment().add(7, 'day').format('YYYYMMDD'),
				app_scheme:'test'
			}, function(rsp) {
				if ( rsp.success ) {
					var msg = '<p>고유ID : ' + rsp.imp_uid + '</p>';
					msg += '<p>상점 거래ID : ' + rsp.merchant_uid + '</p>';
					msg += '<p>결제 금액 : ' + accounting.formatMoney(rsp.paid_amount, "￦", 0) + '</p>';

					if ( rsp.pay_method === 'card' ) {
						msg += '<p>카드 승인번호 : ' + rsp.apply_num + '</p>';
					} else if ( rsp.pay_method === 'vbank' ) {
						msg += '<p>가상계좌 번호 : ' + rsp.vbank_num + '</p>';
						msg += '<p>가상계좌 은행 : ' + rsp.vbank_name + '</p>';
						msg += '<p>가상계좌 예금주 : ' + rsp.vbank_holder + '</p>';
						msg += '<p>가상계좌 입금기한 : ' + rsp.vbank_date + '</p>';
					}
					$('#paymentDoneModalLabel').text("결제가 완료되었습니다.");
					isPaymentSucsessive = true;
				} else {
					var msg = rsp.error_msg;
					$('#paymentDoneModalLabel').text("결제에 실패했습니다.");
					isPaymentSucsessive = false;
				}

				$('.payment-done-body').html(msg).show();
				$('#paymentModal').modal('hide');
				$('#paymentDoneModal').modal('toggle');
			});
		});

		
	});
	
	$('.order-done').on('click', function(e) {
		if(isPaymentSucsessive)
			window.location.replace("intro.php");
		else
			location.reload();
	});
});