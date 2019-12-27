
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?=$board_skin_url.'/check_reserve'?>/images/icons/favicon.ico"/>

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=$board_skin_url.'/check_reserve'?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=$board_skin_url.'/check_reserve'?>/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?=$board_skin_url.'/check_reserve'?>/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=$board_skin_url.'/check_reserve'?>/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=$board_skin_url.'/check_reserve'?>/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?=$board_skin_url.'/check_reserve'?>/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=$board_skin_url.'/check_reserve'?>/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?=$board_skin_url.'/check_reserve'?>/css/main.css">
<!--===============================================================================================-->
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form p-l-55 p-r-55 p-t-178" method="post" action="./board.php?bo_table=<?=$bo_table?>">
					<input type="hidden" name="listcount" value="0">
					<span class="login100-form-title">
						Reservation
					</span>
					
					<div class="wrap-input100 validate-input m-b-16" data-validate="예약자명을 입력해주세요.">
						<input class="input100" type="text" name="username" placeholder="예약자명">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "휴대폰 번호를 입력해주세요.">
						<input class="input100" type="text" name="phone" placeholder="휴대폰 번호" maxlength="11">
						<span class="focus-input100"></span>
					</div>

					<div class="text-right p-t-13 p-b-23">

						<!-- <span class="txt1">
							Forgot
						</span>
						
						<a href="#" class="txt2">
							Username / Password?
						</a> -->
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" id="searching">
							<i class="fas fa-search"></i>
						</button>
					</div>

					<!-- <div class="flex-col-c p-t-170 p-b-40">
						<span class="txt1 p-b-9">
							Don’t have an account?
						</span>

						<a href="#" class="txt3">
							Sign up now
						</a>
					</div> -->
				</form>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="<?=$board_skin_url.'/check_reserve'?>/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=$board_skin_url.'/check_reserve'?>/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=$board_skin_url.'/check_reserve'?>/vendor/bootstrap/js/popper.js"></script>
	<script src="<?=$board_skin_url.'/check_reserve'?>/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=$board_skin_url.'/check_reserve'?>/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=$board_skin_url.'/check_reserve'?>/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?=$board_skin_url.'/check_reserve'?>/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?=$board_skin_url.'/check_reserve'?>/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="<?=$board_skin_url.'/check_reserve'?>/js/main.js"></script>

<script>

	$("input:text[name=phone]").on("keyup", function() {
	    $(this).val($(this).val().replace(/[^0-9]/g,""));
	});

	$('.validate-form').on('submit',function(){
		if ($('input[name=username]').val() == "" || $('input[name=phone]').val() == "") {
			return false;
		}
		var rtn = false;
		$.ajax({
			url: '<?=$board_skin_url?>/ajax/ajax_checking.php',
			type: 'POST',
			dataType: 'json',
			async:false,
			data: {
				bo_table : "<?=$bo_table?>",
				name : $('input[name=username]').val(),
				number : $('input[name=phone]').val()
			},
		})
		.done(function(data) {
			if (data!="") {
				rtn = true;
				$('input[name=listcount]').val(data.length);
			}else{
				alert("예약된 객실이 없습니다.");
				$('input[name=username]').val("");
				$('input[name=phone]').val("");
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			
		});
		
		return rtn;
	});
	
	

</script>