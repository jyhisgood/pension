$(function(){


    $('#visible-button').click(function(event) {
        if ($(this).closest('.boxes').find('input[type=checkbox]').is(":checked")) {
            $('.calendar-lib-class').show();
            // $('#visible-button-label').text("예약현황 숨기기");
        }else{
            $('.calendar-lib-class').hide();
            // $('#visible-button-label').text("예약현황 펼치기");
        }
        
    });

       
        // $('.event').hide();
        $('.reserve-status').each(function(index, el) {
            var not_ghost = [];
            var tr_this = $(this);

            $(this).children('.day').each(function(index_td, el_td) {
                $(this).children('.event').each(function(index_event, el_event) {
                    if (!$(this).hasClass('event-ghost')) {
                        // console.log(index_event);
                        not_ghost.push(index_event);
                    }
                });
            });
            var uniq = not_ghost.reduce(function(a,b){
            if (a.indexOf(b) < 0 ) a.push(b);
                return a;
            },[]);

            
            $.each(uniq, function(index_unq, el_unq) {
                tr_this.children('.day').each(function(index, el) {
                    $(this).children('.event').eq(el_unq).show();
                });
            });
            
        });
        
        //**************************** event bar 없는날도 ghost 표시 *********************************

        // var is_reserved = [];

        // $('.long').each(function(index, el) {
        //     is_reserved.push($(this).attr('name'));
        // });
        
        // $.ajax({
        //     url: boardSkinAjaxUrl+"/ajax_manage_reserve.php",
        //     type: 'POST',
        //     dataType: 'json',
        //     data: {
        //         is_reserved: is_reserved,
        //         type : 'del_ghost',
        //         bo_table : tableName
        //     },
        // })
        // .done(function(data) {

        //     $.each(data, function(key, value){

        //         $('[name='+key+']').each(function(index, el) {
        //             $(this).css('display', 'none');
        //         });
        //     });
                    
        // })
        // .fail(function(abc) {
        //     console.log(abc);
        // })
        // .always(function() {
        //     // console.log("complete");
        // });
        

        // $('.reserve-status').each(function(index, el) {
        //     if ($(this).find('.long').length == 0) {
        //         $(this).find('.event').css('display', 'none');
        //     }
        // });
        //**************************** event bar 없는날도 ghost 표시 *********************************
    })

    var before_box_height;

    $(".calendar-lib-class").on('click', 'input[type=checkbox]', function(event) {
        var box_height = $(this).closest('.boxes').outerHeight();
        
        if (box_height < 130 ) {
            box_height = '130px';
        }else{
            box_height = box_height + 'px';
        }


        // $(this).find('input[type=button]').css('display', 'block');

        if ($(this).attr('id')=="display-can-reserve") {
            return;
        }
        if ($(this).closest('.boxes').find('input[type=checkbox]').is(":checked")) {
            $(this).closest('.boxes').css('width', '100%');
            $('.btn-manage-div').show('fast', function() {
                $(this).css('width', '20%'); 
            });     
            
            $(this).closest('.slide-class').animate({
                height: box_height
            });
            $('.btn-manage-div').find('input[type=button]').css('display', 'block');
        }else{
            $('.btn-manage-div').css('width', '0%');

            $(this).closest('.slide-class').animate({
                height: before_box_height+'px'
            },function(){
            $('.btn-manage-div').find('input[type=button]').css('display', 'none');    
            });
            
        }
        var res = $(this).attr('value');
        $('span[data-reserve-id="'+res+'"]').fadeOut(300).fadeIn(300); 
        console.log(res);
        
        
        
        

    });
    
    $('#display-can-reserve').click(function(event) {
        if (tr == 0 && td == 0) {return;}
        $('.calendar-lib-class').find('tr:eq('+tr+')').find('td:eq('+td+')').trigger('click');
    });

    var tr_index = 0;
    var tr = 0;
    var td = 0;

    $('.calendar-lib-class').on('click', '.day', function(event) {
        $('.btn-manage-div').css('width', '0%');
        var this_td = $(this);
        var table = $('.calendar-lib-class').offset();
        var obj = $(this).offset();
        var mi = $(this).innerWidth();
        var value = (obj.left + (mi/2)) - table.left;
        var selected_tr = $('.calendar-lib-class tr').eq($(this).parent('tr').index()+1);
        var selected_td = $(this).index();
        var yymmdd = $('#set-time').data('settime') +"-"+ $(this).find('.number').text();
        
        var append = "";
        var only_reserved = $('#display-can-reserve:checked').val();
        tr = $(this).closest('tr').index();
        td = $(this).index();

        var checkbox_tr = $(this).parent('tr').index()+1;
        $.ajax({
            url: boardSkinAjaxUrl+"/ajax_manage_reserve.php",
            type: 'POST',
            dataType: 'json',
            data: {
                bo_table : tableName,
                bo_1 : board1,
                yymmdd : yymmdd,
                only_reserved :only_reserved
            },
        })
        .done(function(data) {

            append += '<div class="boxes">';
            if (data == "") {
                append += '<label style="color:#ddd;"> 예약된 객실이 없습니다. </label>';
            }else{
                var style = "";
                data.forEach(function(element) {
                    if (checkbox_tr == tr_index) {
                        style='style="display:none;"';
                    }
                    append += '<input type="checkbox" name="checkbox[]" class="'+ element.status+'" value="'+element.wr_id+'" id="'+element.time+';'+element.id+'" data-checkbox="checkbox">';
                    append += '<label for="'+element.time+';'+element.id+'" '+style+'>';
                    if (element.is_reserved == 1) {
                        append += '<span class="name">'+element.name+'</span>';
                        append += '<span class="room">'+element.room+'</span>';
                        append += '<span class="date">('+element.date_range+')</span>';
                        append += '<span class="date">'+element.date_count+'</span>';
                        append += '<span class="status" '+element.color+'>'+element.status+'</span>';

                    }else{
                        append += '<span class="name possible">예약가능</span>';
                        append += '<span class="room">'+element.wr_subject+'</span>';
                    }
                    append += '</label>';
                  
                });
            }
            append += '</div>';
            append += '<div class="btn-manage-div">';
                append += '<div class="btn-manage-inside">';
                    append += '<div class="btn-div">';
                        append += '<input type="button" onclick="status_reg()" value="예약 대기">';
                    append += '</div>';
                    append += '<div class="btn-div">';
                        append += '<input type="button" onclick="status_change()" value="예약 완료" style="margin-top: 10px;">';
                    append += '</div>';
                    append += '<div class="btn-div">';
                        append += '<input type="button" onclick="deleteReserve()" value="예약 취소" style="margin-top: 10px;">';
                    append += '</div>';
                append += '</div>';
            append += '</div>';
            
            if (checkbox_tr == tr_index) {
                
                selected_tr.find('label').fadeOut('slow');
                    
                selected_tr.find('.slide-class').empty();  
                selected_tr.find('.slide-class').append(append);    

                selected_tr.find('label').fadeIn('slow');  
                
                
            }else{
                
                $('.slide-class').slideUp('500',function(){
                    $('.slide-class').not(selected_tr.find('.slide-class')).remove(); 
                });
                
                selected_tr.children('td').append('<div style="display:none;" class="slide-class">'+append+'</div>');
                
                selected_tr.find('.slide-class').slideDown('500');   
                
            }
            
            before_box_height = selected_tr.find('.boxes').outerHeight();
            selected_tr.find('.slide-class').animate({
                height: selected_tr.find('.boxes').outerHeight()+'px'
            });
            
            tr_index = checkbox_tr;
            
            
            
        })
        .fail(function(eror) {
            console.log(eror);
        })
        .always(function() {
            $('.arrow').hide();
            $('.arrow').css('left', value+'px');
            selected_tr.find('.arrow').show();
        });
        
        
    });

    // var chking = [];
    $("input[name='checkbox[]']").click(function (){   
        var chk_value = $(this).val();
        var is_check = $(this).prop('checked'); 
        
        if (is_check) {
            $("input[name ='checkbox[]']:input[value='"+chk_value+"']").prop("checked", true);   


        }else{
            $("input[name ='checkbox[]']:input[value='"+chk_value+"']").prop("checked", false); 
        }
    });








//////////////달력 기간 변경 /////////////////////////////
function prev_month(){
    var year  = $('#prev-val').data('prev1');
    var month = $('#prev-val').data('prev2');
    
    location.href="board.php?bo_table="+tableName+"&toYear="+year+"&toMonth="+month+"&route=reserve_set";
}
function next_month(){
    var year  = $('#next-val').data('next1');
    var month = $('#next-val').data('next2');
    
    
    location.href="board.php?bo_table="+tableName+"&toYear="+year+"&toMonth="+month+"&route=reserve_set";
}


/////////////////////////상태 변경 및 취소 //////////////////////
function status_change(){

    var checked = []
    var date_id = []
    var check_can = []
    $("input[name='checkbox[]']:checked").each(function ()
    {

        checked.push($(this).val());
        date_id.push($(this).attr('id'));
        check_can.push($(this).attr('class'));
    });
    if (checked=="") {
        alert("선택된 객실이 없습니다.");
        return false;
    }
    for (var i = check_can.length - 1; i >= 0; i--) {
        if (check_can[i]=="예약완료") {
            alert("이미 완료된 객실입니다.");
            return false;
        }
    }
    
    $.ajax( {
        url: boardSkinAjaxUrl+"/ajax_change_status.php",
        type: "POST",
        data: {
            "bo_1" : board1,
            "status" : "update",
            "bo_table" : tableName,
            "array_date" : date_id,
            "array_id" : checked
        },
        dataType: "text",
        async: false,
        cache: false,
        success: function( data, textStatus ) {

            alert("예약 수정이 완료되었습니다.");
            location.reload();
        },
        error: function( xhr, textStatus, errorThrown ) {
            console.error( textStatus );
            
        }
    });
}
function status_reg(){

    var checked = []
    var date_id = []
    var check_can = []
    $("input[name='checkbox[]']:checked").each(function ()
    {

        checked.push($(this).val());
        date_id.push($(this).attr('id'));
        check_can.push($(this).attr('class'));
    });

    if (checked=="") {
        alert("선택된 객실이 없습니다.");
        return false;
    }
    for (var i = check_can.length - 1; i >= 0; i--) {
        if (check_can[i]=="예약대기" || check_can[i]=="예약완료" || check_can[i]=="취소요청") {
            alert("예약가능한 객실만 선택해주세요.");
            return false;
        }
    }
    $.ajax( {
        url: boardSkinAjaxUrl+"/ajax_change_status.php",
        type: "POST",
        data: {
            "bo_1" : board1,
            "status" : "reg",
            "bo_table" : tableName,
            "array_date" : date_id,
            "array_id" : checked
        },
        dataType: "text",
        async: false,
        cache: false,
        success: function( data, textStatus ) {
            alert("예약대기가 완료되었습니다.");
            location.reload();
        },
        error: function( xhr, textStatus, errorThrown ) {
            console.error( textStatus );
            
        }
    });
}
function deleteReserve(){

    var checked = [];
    var check_can = [];
    $("input[name='checkbox[]']:checked").each(function ()
    {
        checked.push($(this).val());
        check_can.push($(this).attr("class"));
    });
    if (checked=="") {
        alert("선택된 객실이 없습니다.");
        return false;
    }
    for (var i = check_can.length - 1; i >= 0; i--) {
        if (check_can[i]=="예약가능") {
            alert("예약된 객실만 선택해주세요.");
            return false;
        }
    }
    $.ajax( {
        url: boardSkinAjaxUrl+"/ajax_change_status.php",
        type: "POST",
        data: {
            "bo_1" : board1,
            "status" : "delete",
            "bo_table" : tableName,
            "array_id" : checked
        },
        dataType: "text",
        async: false,
        cache: false,
        success: function( data, textStatus ) {
            alert("예약이 취소되었습니다.");
            location.reload();
        },
        error: function( xhr, textStatus, errorThrown ) {
            console.error( textStatus );
        }
    });
}
/////////////////////////상태 변경 및 취소 //////////////////////