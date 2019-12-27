$('.checkbox-fake-div').click(function(event) {
	if ($(this).children('input:checkbox').is(":checked")) {
		$(this).children('input:checkbox').prop('checked', false);	
		$(this).removeClass('check-active');
	}else{
		$(this).children('input:checkbox').prop('checked', true);	
		$(this).addClass('check-active');
	}
	
});

	/* ===== Logic for creating fake Select Boxes ===== */
$('.sel').each(function() {
  $(this).children('select').css('display', 'none');
  
  var $current = $(this);
  
  $(this).find('option').each(function(i) {
    if (i == 0) {
      $current.prepend($('<div>', {
        class: $current.attr('class').replace(/sel/g, 'sel__box')
      }));
      
      var placeholder = $(this).text();
      $current.prepend($('<span>', {
        class: $current.attr('class').replace(/sel/g, 'sel__placeholder'),
        text: placeholder,
        'data-placeholder': placeholder
      }));
      
      return;
    }
    
    $current.children('div').append($('<span>', {
      class: $current.attr('class').replace(/sel/g, 'sel__box__options'),
      text: $(this).text(),

    }));
  });
});

// Toggling the `.active` state on the `.sel`.
$('.sel').click(function() {
  $(this).toggleClass('active');
   // $('#sort_search').children('option').attr('selected', 'selected');
});

// Toggling the `.selected` state on the options.
$('.sel__box__options').click(function() {
  var txt = $(this).text();
  var index = $(this).index();
  

  $(this).siblings('.sel__box__options').removeClass('selected');
  $(this).addClass('selected');

  var $currentSel = $(this).closest('.sel');
  $currentSel.children('.sel__placeholder').text(txt);
  $currentSel.children('select').prop('selectedIndex', index + 1);

  // {{{{{{ 영훈 }}}}}}
  $(this).closest('.sel').find('select').trigger('change');
});

$('[name=view_content_btn]').click(function(event) {
	var booking_id = $(this).closest('li').attr('id');
	var booking_name = $('#'+booking_id).children('.li_list_subject').children('span.subject_name').text();
	$.ajax( {
        url: boardSkinAjaxUrl+"/ajax_view_content.php",
        type: "POST",
        data: {
        	"id" : booking_id,
        	"bo_table" : tableName
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function( data, textStatus ) {

        	$('#content_subject').empty();
        	$('#content_subject').append(booking_name+" 객실 소개");
        	$("#content_box").empty();
        	$('#content_box').append(data);
        	$('#view_content').modal();
        	
        },
        error: function( xhr, textStatus, errorThrown ) {
            console.error( textStatus );
            
        }
    });
	
});

$('.select_box_div div').hover(function() {
	$(this).css({
		'background': '#efefef',
		// 'color': 'white'
	});
}, function() {
	$(this).css({
		'background': 'white',
		'color': 'black'
	});
	
});


$(document).on('change', '#sort_search', function(event) {
	
	if ($(this).val()=="price") {
		var temp = {};
	
		$('.total_prc').each(function(index, el) {
			var res = "";
			var price = $(this).text();
			
			res = price.replace(",", "");
			temp[$(this).closest('li').attr('id')] = res.replace("원", ""); 
			// temp[count]['price'] = res.replace("원", "");
			// temp[count]['id'] = $(this).closest('li').attr('id')
			
		});

		// temp.sort(dynamicSort(name));
		// console.log(temp);
		// var sortingField = "age";

		// student.sort(function(a, b) { // 오름차순
		//     return a[sortingField] - b[sortingField];
		//     // 13, 21, 25, 44
		// });
	}
	var id = [];
	$('.list_li').each(function(index, el) {
		id.push($(this).attr('id'));
	});
	

	$.ajax( {
        url: boardSkinAjaxUrl+"/ajax_sort_search.php",
        type: "POST",
        data: {
        	"id" : id,
        	"sort" : $(this).val(),
        	"order" : $(this).data('order'),
        	"bo_table" : tableName,
        	"temp" : temp
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function( data, textStatus ) {
        	
        	// $('.list_li').eq(0).before($('#'+));
        	//정렬 로직
        	for (var i = 0; i < data.length-1; i++) {
        		if (i==0) {
        			$('.list_form').eq(i).before($('#'+data[i]));		
        		}
        		$('.list_form').eq(i).after($('#'+data[i+1]));
        	}
        },
        error: function( xhr, textStatus, errorThrown ) {
            console.error( textStatus );
            
        }
    });
});   

$('.img_container').click(function() {
	var id = $(this).closest('li').attr('id');
	$.ajax( {
        url: boardSkinAjaxUrl+"/ajax_view_image.php",
        type: "POST",
        data: {
        	"wr_id" : id,
        	"bo_table" : tableName
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function( data, textStatus ) {
        	$('#slideshow').remove();
        	// $('.pgwSlideshow').children('li').remove();
        	$('#image_info').append(data);
			
        	
        	
        	$('.pgwSlideshow').pgwSlideshow({
	            transitionEffect : "",
	            autoSlide : "",
	         
	        });
	        $('.ps-current').css('height', '100%');
        	$('.ps-list').css('background', 'black');
        	$('.narrow').css('background', 'black');
        	$('.ps-prev').css('background', 'rgba(0, 0, 0, 0)');
        	$('.ps-next').css('background', 'rgba(0, 0, 0, 0)');
        	// $('.bxslider').bxSlider(); 	
        	$('#view_img').modal();
        },
        error: function( xhr, textStatus, errorThrown ) {
            console.error( textStatus );
            
        }
    });
		
});

$('.submit_reserve').click(function() {

	var id = $(this).closest('li').attr('id');
	var bo_table = $(this).data('data-bo1');
	var start = $('#st_date').text();
	var end = $('#en_date').text();
	var wr_add1 = $('#wr_add1').val();
	
	// return false;
	if (wr_add1=='0' || wr_add1 == null) {
		alert("성인 인원수를 정해주세요");
		$( '.modal' ).animate( { scrollTop : 0 }, 400 );
		setTimeout(function () {
		   $('#wr_add1').closest('.sel').trigger('click');
		}, 400);
		

		return false;
	}

	if (!$("input:checkbox[name='id[]']").is(":checked") ) {
		alert("객실을 선택해주세요.");
		return false;
	}
	
	$('.list_li').each(function(index, el) {
		if($(this).css('display') == 'none') {
			$(this).find('input:checkbox').prop('checked', false);	
			$(this).find('.checkbox-fake-div ').removeClass('check-active');
		}
		
	});
	
	if ($('#wr_add2')) {
		var wr_add2 = "&wr_add2="+$('#wr_add2').val();
		var wr_add3 = "&wr_add3="+$('#wr_add3').val();	
	}

	if ($('.fake-checkbox:checked').length == 0) {
		alert("객실을 선택해주세요.");
		return false;
	}
	
	
});



// $('[data-toggle="tooltip"]').tooltip();

$('[data-toggle="tooltip"]').tooltip({
    show: {duration: 0},
    selector: '[data-toggle="tooltip"]',
    hide: {  duration: 0 },
    content:function(callback) {
    	
    		callback($(this).attr('title'));

    }
});



$(document).on('change', '.chang_price', function() {
	
	var wr_add1 = Number($('#wr_add1').val());
	var wr_add2 = 0;
	var wr_add3 = 0;
	if ($('#wr_add2').length!=0) {
		
		wr_add2 = Number($('#wr_add2').val());
		wr_add3 = Number($('#wr_add3').val());	

	}
	// alert($('#wr_add2').length);
	$('input[name=wr_add1]').val(wr_add1);
	$('input[name=wr_add2]').val(wr_add2);
	$('input[name=wr_add3]').val(wr_add3);
	


	
	var count_arr = [wr_add1, wr_add2, wr_add3];
	var id_arr = [];
	var total = (wr_add1+wr_add2+wr_add3);

	$('.max').each(function (index, item) {
	 	$(this).closest('.list_li').show();
	 	if (total > $(this).text()) {
	 		$(this).closest('.list_li').hide();
	 		
	 	}else{
	 		id_arr.push($(this).closest('.list_li').attr('id'));
	 	}
	 
	});

	
	$.ajax( {
        url: boardSkinAjaxUrl+"/ajax_search.php",
        type: "POST",
        data: {
        	"type" : "count",
        	"id" : id_arr,
        	"count" : count_arr,
            "bo_table" : tableName,
            "start" : choose_start,
            "end" : choose_end

        },
        dataType: "json",
        async: false,
        cache: false,
        success: function( data, textStatus ) {
        	
        	if (data=="") {
        		$('.search-none').show();
        	}else{
        		$('.search-none').hide();
        	}

			for (var i = 0; i < data.length; i++) {
				$('#'+data[i].wr_id+' .add_prc').text('+'+data[i].price+'원');
				$('#'+data[i].wr_id+' .total_prc').text(data[i].total+'원');
			}
			 
			
			
        },
        error: function( xhr, textStatus, errorThrown ) {
            console.error( textStatus );
            
        }
    });
});

$( window ).resize( function () {
	var height = 0;
	var windowWidth = window.innerWidth;
	var windowWidth1 = $( window ).width();
		if(windowWidth < 769) {
		height = $("#abc").height();
	
		$(".img_container").height(height);
		$(".image_info").css({
			'height': height,
			'line-height': height+'px'
		});
	}else{
		$(".img_container").height('inherit');
		$(".image_info").attr('style', '');
	}
	
	
});
$('#view_list').on('shown.bs.modal', function () {
//$( window ).load( function () {
	var height = 0;
	var windowWidth = window.innerWidth;

		if(windowWidth < 769) {
		height = $("#abc").height();
	
		$(".img_container").height(height);
		$(".image_info").css({
			'height': height,
			'line-height': height+'px'
		});
	}else{
		$(".img_container").height('inherit');
		$(".image_info").attr('style', '');
	}
});