$(function(){

	var count        = 0;
	var start        = "";
	var end          = "";
	var temp         = "";
	var start_date   = "";
	var end_date     = "";
	var change       = "current";
	var select_color = ' #e3e3e3';
	var border_set   = "2px solid black"; 
	
	var current_date = "";
	var yy1          = "";
	var mm1          = "";
	var yy_mm        = "";
	var arrr1        = "";
	var arrr2        = "";
	var init_sort_list = [];
	
	change_calendar(yy_mm, change);
	$( "#tabs" ).tabs();

	$('.list_li').each(function(index, el) {
		init_sort_list.push($(this).attr('id'));
	});

	$(document).on('click', '.check_day', function() {

		var date = new Date();
		var yy =date.getFullYear();
		var mm =date.getMonth()+1;

		if (count > 1) {
			
			$('.check_day').children('font').css({
				'background-color': 'white',
				'border': '0',
				'border-radius': '0'
			});
			count = 0;
			start = "";
			end = "";
			start_date = "";
			end_date = "";
			$('#start').text("선택하세요");
			$('#end').text("선택하세요");
			return;
		}
		count++;


		if (count % 2 == 1) {
			$(this).children('font').css({
				'background-color': select_color,
				'border-radius': '120px 0 0 120px'
			});
			start = $(this).attr('id');
			start_date = new Date(start);
			tr = $(this).parent().index();
			td = $(this).index();
			arrr1 = [tr,td];
			
			$('#start').text(start);
		}else{

			$(this).children('font').css({
				'background-color': select_color,
				'border-radius': '0 120px 120px 0'
			});
			
			end = $(this).attr('id');	
			end_date = new Date(end);
			tr = $(this).parent().index();
			td = $(this).index();
			arrr2 = [tr,td];
			
			if (start_date>end_date) {

				
				//YY-MM-DD 값
				temp = start;
				start = end;
				end = temp;

				$('#'+start).children('font').css({
					'background-color': select_color,
					'border-radius': '120px 0 0 120px'
				});
				$('#'+end).children('font').css({
					'background-color': select_color,
					'border-radius': '0 120px 120px 0'
				});

				//td 좌표
				temp = arrr1;
				arrr1 = arrr2;
				arrr2 = temp;

				//타임스템프 값
				temp = start_date;
				start_date = end_date;
				end_date = temp;

				$('#start').text(start);
			}
			
			$('#end').text(end);
			select_td(arrr1,arrr2,start_date,end_date,yy_mm);
			
		}

	});
	function change_calendar(date, value){
		
		yy_mm = date;
		change = value;
		start_ajax = $('#start').text();
		end_ajax = $('#end').text();
		

		$.ajax( {
	        url: boardSkinAjaxUrl+"/ajax_calendar_control.php",
	        type: "POST",
	        data: {
	        	"change" : change,
	        	"path" : boardSkinUrl,
	        	"bo_table" : tableName,
	            "yy_mm" : yy_mm
	        },
	        dataType: "json",
	        async: false,
	        cache: true,
	        success: function( data, textStatus ) {
				// console.log(data);
	        	$("#cal_tb").append(data.table);
	        	var parent_height = $('.content').height();
				$('.content').children('div').css('line-height', parent_height+'px');
	        	
				yy_mm = data.next_month;
				var present = new Date(yy_mm);
				if (start_date) {
					var restore_start = start_date.setDate(1);	
				}

				sb_string1 = yy_mm.substring(0,7);
				sb_string2 = start.substring(0,7);
				sb_string3 = $('#end').text().substring(0,7);
				
				if (present >= restore_start && present <= end_date && count == 2 ) {
					select_td(arrr1,arrr2,start_date,end_date,yy_mm);
				}
				
	        },
	        error: function( xhr, textStatus, errorThrown ) {
	            console.error( xhr );
	        }
	    });
	}
	
	function select_td(start, end,start_date,end_date,yy_mm){
		var i_start   = 0;
		var i_end     = 0;
		var for_start = 0;
		var for_end   = 0;
		var counting  = 0;
		var route     = "";
		
		if (start_date.getMonth()+1 < end_date.getMonth()+1 || start_date.getFullYear() < end_date.getFullYear()) {

			if ($('#start').text().substring(0,7) == yy_mm) {
				//입실날짜와 같을때
				for_start = 6;
				for_end = start[1];
				i_start = start[0];
				i_end = $('#cal_tb tr').length-1;
				route = "start";

			}else if($('#end').text().substring(0,7) == yy_mm){
				//퇴실날짜와 같을때
				for_start = end[1];
				for_end = 0;
				i_start = 2;
				i_end = end[0];
				route = "end";

			}else{
				for_start = 10;
				for_end = 0;
				i_start = 2;
				i_end = 7;
			}
			
			for (var i = i_start; i <= i_end; i++) {
				
				if (route == "start") {
					//입실날짜와 같을때
					if (counting > 0) {
						for_end = 0;
					}
				}else if(route == "end"){
					//퇴실날짜와 같을때
					if (i != end[0]) {
						for_start = 6;
					}else{
						for_start = end[1];
					}
				}
		
				for (var j = for_start; j >= for_end; j--) {
					//중간날짜
					$("tr:eq("+i+")").find("td:eq("+j+")").children('font').css({
						'background-color': select_color
						
					});
					//시작날짜 처음 radious 처리
					if (i == i_start && j == for_end && route == 'start') {
						$("tr:eq("+i+")").find("td:eq("+j+")").children('font').css({
							
							'border-radius': '120px 0 0 120px'
						});
					//끝날짜 처음 radious 처리	
					}else if (route == 'end' && i == i_end && j == for_start) {

						$("tr:eq("+i+")").find("td:eq("+j+")").children('font').css({
							
							'border-radius': '0 120px 120px 0'
						});
					}	
				}
				counting++;
			}


		}else{

			for (var i = start[0]; i <= end[0]; i++) {
				//첫번째
				if (start[0] == end[0]) {
					for_start = end[1];
					for_end = start[1];
				//마지막이거나 중간
				}else{
				
					if (i == start[0]) {
						for_start = 6;
						for_end = start[1];
						
					}else{
						//마지막 row

						if (i == end[0]) {
							for_start = end[1];
							for_end = 0;
							
						}else{
							for_start = 6;
							for_end = 0;
							
								
						}
					}
				}


				

				for (var j = for_start; j >= for_end; j--) {
					if ($("tr:eq("+i+")").find("td:eq("+j+")").attr('class') != "check_day") {

						$('.check_day').children('font').css({
							'background-color': 'white',
							'border': '0',
							'border-radius': '0'
						});
						count = 0;
						start = "";
						end = "";
						start_date = "";
						end_date = "";
						$('#start').text("선택하세요");
						$('#end').text("선택하세요");
						alert("선택 불가능한 날짜가 있습니다.");
						return false;
					}
					$("tr:eq("+i+")").find("td:eq("+j+")").children('font').css({
						'background-color': select_color
					});

					//시작날짜 처음 radious 처리
					if (i == start[0] && j==for_end) {
						$("tr:eq("+i+")").find("td:eq("+j+")").children('font').css({
							
							'border-radius': '120px 0 0 120px'
						});
					//끝날짜 마지막 radious 처리	
					}else if (i == end[0] && j == for_start) {

						$("tr:eq("+i+")").find("td:eq("+j+")").children('font').css({
							
							'border-radius': '0 120px 120px 0'
						});
					}
				}
			}
		}	
	}
	
	//객실검색

	$('.search_booking').click(function() {
		
		choose_start = $('#start').text();
		choose_end = $('#end').text();
		
		if (choose_start=="선택하세요") {
			alert("입실날짜를 선택해주세요");
			return false;
		}else if (choose_end=="선택하세요") {
			alert("퇴실날짜를 선택해주세요");
			return false;
		}else if (choose_start == choose_end) {
			alert("입실날짜와 퇴실날짜가 같으면 안됩니다.");
			$('.check_day').children('font').css({'background-color': 'white','border-radius': '0'});
			
			count = 0;
			start = "";
			end = "";
			start_date = "";
			end_date = "";
			$('#start').text("선택하세요");
			$('#end').text("선택하세요");
			return false;
		}
		
		
		$.ajax( {
	        url: boardSkinAjaxUrl+"/ajax_search.php",
	        type: "POST",
	        data: {
	        	"start" : choose_start,
	        	"end" : choose_end,
	            "bo_table" : tableName,
	            "bo_1" : board1,
	            "bo_5_subj" : boardSub5,
	            "bo_7_subj" : boardSub7,
	            "bo_8_subj" : boardSub8


	        },
	        dataType: "json",
	        //async: false,
	        cache: true,
			beforeSend: function( xhr ) {
				
				$('.search_booking').css({
	            	'background-image': 'url('+boardSkinUrl+'/img/ajax-loader.gif)',
				    'background-size': '36px',
				    'background-repeat': 'no-repeat',
				    'background-position': 'center',
					'transition':'none'
	            });
				$('.search_booking').val("");
			},
	        success: function( data, textStatus ) {
	        	// console.log(data);

	        	/*************검색창 닫을시 인원 초기화****************/
	        	$('.sel__box__options').removeClass('selected');
	        	$('.sel__placeholder').each(function(index, el) {
	        		$(this).text($(this).data('placeholder'));
	        	});
	        	$('#wr_add1').val('0');
	        	$('#wr_add2').val('0');
	        	$('#wr_add3').val('0');

	        	/*************검색창 닫을시 객실정렬 초기화****************/
	        	for (var i = 0; i < init_sort_list.length-1; i++) {
	        		if (i==0) {
	        			$('.list_form').eq(i).before($('#'+init_sort_list[i]));		
	        		}
	        		$('.list_form').eq(i).after($('#'+init_sort_list[i+1]));
	        	}

	        	/**************************가격 계산************************/	        	
	        	for (var i = 0; i < data.list.length; i++) {
	        		$('#'+data.list[i].wr_id).show();
	        		$('#'+data.list[i].wr_id+' .book_prc').text(data.list[i].price);
	        		$('#'+data.list[i].wr_id+' .sale_prc').text('-'+data.list[i].sale);
	        		$('#'+data.list[i].wr_id+' .total_prc').text(data.list[i].total);
	        		$('#'+data.list[i].wr_id+' .add_prc').text('+0원');
	        		
	        	}

	        	//************************************************버튼 초기화

	        	///////////////////////////////////////////////////////////다중예약시

	        	$('.fake-checkbox').prop("checked", false); 
	        	$('.cant-reseve').attr('class', 'checkbox-fake-div');
				$('.checkbox-fake-div').removeClass('check-active');
				$('.checkbox-fake-div').find('i').attr('class', 'far fa-check-square');

	        	///////////////////////////////////////////////////////////다중예약 end

	        	
	        	for (var i = 0; i < data.reserved.length; i++) {
	        		
					$('#'+data.reserved[i]).find('.checkbox-fake-div').children('i').attr('class', 'far fa-calendar-check');
					$('#'+data.reserved[i]).find('.checkbox-fake-div').attr('class', 'cant-reseve');
					
	        		
	        		
	        	}
	        	//************************************************버튼 초기화 끝
	        	//폼데이터 입력
	        	$('input[name=reservation_date]').val($('#start').text());
				$('input[name=end_date]').val($('#end').text());


				
				$('#st_date').text($('#start').text());
				$('#en_date').text($('#end').text());
				var count_2 = data.count + 1;
				$('.count_day').text(data.count+'박 '+count_2+'일');
				
				//로딩감추기
				$('.search_booking').attr('style','');
				$('.search_booking').val("객실검색");

				
				$('.search-none').css('display', 'none');
				$('#view_list').modal({backdrop:'static'});
				
	        },
	        error: function( xhr, textStatus, errorThrown ) {
	            console.error( textStatus );
	            
	        }
	    });
	});




	//달력 날짜 바꾸기
	$(document).on('click', '.change_month', function() {
		if ($(this).val() == "<") {
			var change = 'prev';
		}else if ($(this).val() == ">") {
			var change = 'next';
		}

		
		if (current_date == "") {
			current_date = new Date();
			yy1 = current_date.getFullYear();
			mm1 = current_date.getMonth()+1;
			yy_mm = yy1+"-"+mm1;
		}


		$('.calendar_day').remove();
		$('#daily').remove();
		$('#table_header').remove();
	    change_calendar(yy_mm,change);
	});


	$('#wrap_content').tooltip({
        track: true,
        show: {duration: 0},
        selector: '.tooltip-class',
        hide: {  duration: 0 },
        content:function(callback) {
        	var tooltipData;
        	var thisDate = yy_mm + "-" +$(this).text();
        	$.ajax({
        		url: boardSkinAjaxUrl+"/ajax_calendar_check_tooltip.php",
        		type: 'POST',
        		dataType: 'json',
        		data: {
        			'date' : thisDate,
        			'bo_1' : board1,
        			'bo_table' : tableName,
        		},
        	})
        	.done(function(data) {
        		callback(data);
        	})
        	.fail(function() {
        		
        	});
        	
        	

        }
    });

});

$( window ).resize( function () {
	var parent_height = $('.content').height();
	if (window.innerWidth > 767) {
		$('#wrap_search_form').height($('#cal_tb').height());	
	}else{
		$('#wrap_search_form').attr('style', '');
	}
	$('.content').children('div').css('line-height', parent_height+'px');
} );

$( window ).load( function () {
	var parent_height = $('.content').height();

	if (window.innerWidth > 767) {
		$('#wrap_search_form').height($('#cal_tb').height());	
	}
	
	$('.content').children('div').css('line-height', parent_height+'px');
	
	
} );	
$('#reserve-list').click(function(event) {
	location.href="board.php?bo_table="+board1;
});
$('#manage-room').click(function(event) {
	location.href="board.php?bo_table="+tableName+"&route=reserve_set";
});
