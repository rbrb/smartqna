$(function() {
	var pop = $('.popbtn');
	var row = $('.row:not(:first):not(:last)');
	
	var recentlyClickedItem;
	var recentlyClickedPopbtn;
	var recentlyClickedPrice;
	
	var isPaymentSucsessive;

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
		recentlyClickedItem = $(this).parent().find(".isChecked");
		pop.popover('toggle');
		pop.not(this).popover('hide');
	});
	
	$(document).on('click', 'a>.glyphicon-ok', function(e){
		if(!recentlyClickedItem.hasClass("glyphicon"))
		{
			recentlyClickedPrice = recentlyClickedPopbtn.siblings(".price").text();
			recentlyClickedItem.addClass("glyphicon");
			recentlyClickedItem.addClass("glyphicon-ok");
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
		
		IMP.request_pay({
			pay_method : $(".pay_method").value,
			escrow : 1,
			merchant_uid : 'merchant_' + new Date().getTime(),
			name: "결제테스트: 결제명", 
			amount: accounting.unformat($(".totalPrice").text()),
			buyer_email: "test@test.test", 
			buyer_name: "결제테스트: 구매자", 
			buyer_tel: "결제테스트: 전화번호", 
			buyer_addr: "결제테스트: 주소",
			buyer_postcode: "결제테스트: 우편번호",
			vbank_due: moment().add(2, 'day').format('YYYYMMDD'),
			app_scheme:'test'
		}, function(rsp) {
			if ( rsp.success ) {
				var msg = '<p>고유ID : ' + rsp.imp_uid + '</p>';
				msg += '<p>상점 거래ID : ' + rsp.merchant_uid + '</p>';
				msg += '<p>결제 금액 : ' + rsp.paid_amount + '</p>';

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
				$('#paymentDoneModalLabel').text("결제를 실패했습니다.");
				isPaymentSucsessive = false;
			}

			$('.payment-done-body').html(msg).show();
			$('#paymentModal').modal('hide');
			$('#paymentDoneModal').modal('toggle');
		});
	});
	
	$('.order-done').on('click', function(e) {
		if(isPaymentSucsessive)
			window.location.replace("intro.php");
		else
			location.reload();
	});
});