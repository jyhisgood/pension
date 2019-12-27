


// //current position
// var pos = 0;
// //number of slides
// var totalSlides = $('#slider-wrap ul li').length;
// //get the slide width
// var sliderWidth = $('#slider-wrap').width();

// var commonOptionsArray = [];
// var implode_name = [];
// var implode_price = [];
// $(document).ready(function(){
//     $('#clean-setting3').click(function(event) {
//         $('#setting3').val("");
//     });    
//     $('#setting3').datepicker({
//             changeMonth: true, 
//             changeYear: true, 
//             dateFormat: "yy-mm-dd", 
//             minDate: '+0d', 
//             prevText: '이전 달',
//             nextText: '다음 달',
//             monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
//             monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
//             dayNames: ['일', '월', '화', '수', '목', '금', '토'],
//             dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
//             dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
//             yearSuffix: '년',
//             yearRange: "c-99:c+99"
        
//     });
    
//     $('#console-ud').text($('#pills-tabContent').width());

//     /*****************
//      BUILD THE SLIDER
//     *****************/
//     //set width to be 'x' times the number of slides

//     $('#slider-wrap ul#slider').width(sliderWidth*totalSlides);
    
//     //next slide    
//     $('.next').click(function(){
//         if ($(this).attr('id') == "btn-chapter2") {
//             if ($('#text-chapter2').val() == "") {
//                 alert("이름을 입력해주세요.");
//                 return false;
//             }
//             commonOptionsArray.push($('#text-chapter2').val())
//         }else if($(this).attr('id') == "option_list"){
//             var rtn = false;
//             implode_name = [];
//             implode_price = [];
//             $('input[name=c_option_name]').each(function(index, el) {
//                 if ($(this).val() == "") {
//                     rtn = false;
//                     return false;
//                 }else{
//                     rtn = true;
//                     implode_name.push($(this).val());
//                 }
//             });
//             if (!rtn) {
//                 alert("옵션이름을 모두 채워주세요.");
//                 implode_name = [];
//                 implode_price = [];
//                 return rtn;    
//             }
//             $('input[name=c_option_price]').each(function(index, el) {
//                 if ($(this).val() == "") {
//                     rtn = false;
//                     return false;
//                 }else{
//                     rtn = true;
//                     implode_price.push($(this).val());
//                 }
//             });
            
//             if (!rtn) {
//                 alert("옵션가격을 모두 채워주세요.");
//                 implode_name = [];
//                 implode_price = [];
//                 return rtn;    
//             }
            
              
//         }else{
//             commonOptionsArray.push($(this).data('type'));    
//         }
        
//         slideRight();
//         if (pos == 5) {
//             var appendOptionPreview = '';
//             appendOptionPreview += '<table>';
//             appendOptionPreview += '<tr>'
//             appendOptionPreview += '<th>'+ commonOptionsArray[1] +'</th>';
//             appendOptionPreview += '<td>';
//             if (commonOptionsArray[0] == 'select') {

//                 appendOptionPreview += '<select name="preview-options">';
//                 appendOptionPreview += '<option value="">선택</option>';
//                 for (var i = 0; i < implode_name.length; i++) {
//                     appendOptionPreview += '<option value="'+implode_name[i]+'">'+implode_name[i]+'</option>';
//                 }
//                 appendOptionPreview += '</select>';

//             }else if(commonOptionsArray[0] == 'checkbox'){
                
//             }else if(commonOptionsArray[0] == 'radio'){
                
//             }else if(commonOptionsArray[0] == 'text'){
                
//             }
//             appendOptionPreview += '</td>';


//             if (commonOptionsArray[2] == 'Y') {
//                 appendOptionPreview += '<td>';
//                 appendOptionPreview += '000원';
//                 appendOptionPreview += '</td>';
//             }
//             if (commonOptionsArray[3] == 'Y') {
//                 appendOptionPreview += '<td>';
//                 appendOptionPreview += '개수 : <input type="text" style="width: 40px;">';
//                 appendOptionPreview += '</td>';
//             }
            
//             appendOptionPreview += '</table>';
//             $('#preview-test').append(appendOptionPreview);
//         }
//         console.log(commonOptionsArray);
//         console.log(implode_name);
//         console.log(implode_price);
        
        
//     });
    
//     //previous slide
//     $('#previous').click(function(){
//         slideLeft();
//     });
    
    
    
//     /*************************
//      //*> OPTIONAL SETTINGS
//     ************************/
//     //automatic slider
//     // var autoSlider = setInterval(slideRight, 3000);
    
//     //for each slide 
//     $.each($('#slider-wrap ul li'), function() { 

//        //create a pagination
//        var li = document.createElement('li');
//        $('#pagination-wrap ul').append(li);    
//     });
    
//     //counter
//     countSlides();
    
//     //pagination
//     pagination();
    
//     //hide/show controls/btns when hover
//     //pause automatic slide when hover
//     // $('#slider-wrap').hover(
//     //   function(){ $(this).addClass('active'); clearInterval(autoSlider); }, 
//     //   function(){ $(this).removeClass('active'); autoSlider = setInterval(slideRight, 3000); }
//     // );
    
    

// });//DOCUMENT READY
    


// /***********
//  SLIDE LEFT
// ************/
// function slideLeft(){

//     pos--;
//     if(pos==-1){ pos = totalSlides-1; }
//     $('#slider-wrap ul#slider').css('left', -(sliderWidth*pos));    
    
//     //*> optional
//     countSlides();
//     pagination();
// }


// /************
//  SLIDE RIGHT
// *************/
// function slideRight(){
//     pos++;
//     if(pos==totalSlides){ pos = 0; }
//     $('#slider-wrap ul#slider').css('left', -(sliderWidth*pos)); 
    
//     //*> optional 
//     countSlides();
//     pagination();
// }



    
// /************************
//  //*> OPTIONAL SETTINGS
// ************************/
// function countSlides(){
//     $('#counter').html(pos+1 + ' / ' + totalSlides);
// }

// function pagination(){
//     $('#pagination-wrap ul li').removeClass('active');
//     $('#pagination-wrap ul li:eq('+pos+')').addClass('active');
// }
        
    

// function widthImport(){
//     sliderWidth = $('#pills-tabContent').width();
//     $('#wrapper').css('width', sliderWidth);
//     $('#slider-wrap').css('width', sliderWidth);
//     $('#slider-wrap ul#slider li').css('width', sliderWidth);
//     $('#slider-wrap ul#slider').width(sliderWidth*totalSlides);
    
// }

// $('#add-option-btn').click(function(event) {
//     $('#option-form-wrapper').append('<div style="margin-bottom: 5px;"> 옵션 이름 : <input type="text" style="width: 100px; border-radius: 7px; border: 0;" name="c_option_name"> 옵션 가격 : <input type="text" style="width: 100px; border-radius: 7px; border: 0;" placeholder="숫자만 입력" name="c_option_price"> </div>')
// });

//     $(window).resize(function(event) {
//         sliderWidth = $('#pills-tabContent').width();
//         $('#wrapper').css('width', sliderWidth);
//         $('#slider-wrap').css('width', sliderWidth);
//         $('#slider-wrap ul#slider li').css('width', sliderWidth);
//         $('#slider-wrap ul#slider').width(sliderWidth*totalSlides);
//     });

    $('#clean-setting3').click(function(event) {
        $('#setting3').val("");
    });    
    $('#setting3').datepicker({
            changeMonth: true, 
            changeYear: true, 
            dateFormat: "yy-mm-dd", 
            minDate: '+0d', 
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            yearSuffix: '년',
            yearRange: "c-99:c+99"
    
    });
    $('#reg_holiday_btn').click(function(event) {
        var holi_name = $('#reg_holiday_name').val();
        var holi_date = $('#reg_holiday_date').val();

        if (holi_name == "" || holi_date == "") {
            alert("빈칸을 채워주세요.");
            return false;
        }

        $.ajax({
            url: boardSkinAjaxUrl+'/modal/ajax_all_setting.php',
            type: 'POST',
            dataType: 'json',
            data: {
                bo_table: tableName,
                status : 'reg_holi',
                name : holi_name,
                date : holi_date
            },
        })
        .done(function(data) {
            alert("추가되었습니다.");
            $('#reg_holiday_name').val("");
            $('#reg_holiday_date').val("");
            $('#holi-list').append('<tr><td style="text-align: center;"><span class="holiday-name-span">'+holi_name+'</span></td><td style="text-align: center;"><span class="holiday-date-span">'+holi_date+'</span></td><td style="text-align: center;"><input type="button" value="삭제" class="btn btn-default holi-remove"></td></tr>');
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
        
    });
    $('#holi-list').on('click', '.holi-remove', function(event) {
        var this_tr = $(this).closest('tr');
        var remove_holi_name = this_tr.find('.holiday-name-span').text();
        var remove_holi_date = this_tr.find('.holiday-date-span').text();
        $.ajax({
            url: boardSkinAjaxUrl+'/modal/ajax_all_setting.php',
            type: 'POST',
            dataType: 'json',
            data: {
                bo_table: tableName,
                status : 'remove_holi',
                name : remove_holi_name,
                date : remove_holi_date
            },
        })
        .done(function(data) {

            alert("삭제되었습니다.");
            
            this_tr.remove();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    });
    
    $(document).ready(function() {

        $('#is_pay_for_pet').click(function(event) {
            if (!$(this).prop("checked")) {
                $('#pay_for_pet').val("");
                $('#pay_for_pet').attr('disabled', true);
            }else{
                $('#pay_for_pet').attr('disabled', false);
                $('#pay_for_pet').val("0");
            }
        });

        $('#pay_for_pet').keyup(function(event) {
            $(this).val($(this).val().replace(/[^0-9]/g,""));
            if ($(this).val()=="") {
                $(this).val("0");
            }
        });
        $('#pay_for_pet').blur(function(event) {
            $(this).val($(this).val().replace(/[^0-9]/g,""));
        });

        $('#pills-home-tab').trigger('click');
        $('#pills-season-tab').trigger('click');

        $('[data-toggle="tooltip"]').tooltip();
        is_use_sms = $("#sms_check").val();
        if (is_use_sms == "") {

            $(".sms_tr").hide();
            $('#tb_sms').css("opacity","0.5");
        }else{
            $(".sms_tr").show();
            $('#tb_sms').css("opacity","1");
        }

        var use_count = $("input[name=bo_2_subj]:checked").val();

        if (use_count == "") {
            $("#kids").hide();

        }else{
            $("#kids").show();

        }

    });

    $("input[name^='is_date']").each(function(){
        // var _this = this.id;

        $(this).datepicker({
            changeMonth: true, 
            changeYear: true, 
            dateFormat: "yy-mm-dd", 

            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            yearSuffix: '년',
            yearRange: "c-99:c+99"
        });
    });

    $( '#settingbtn' ).click( function () {
        
        $( '#settings' ).modal();

    } );

//sms 사용 여부
$("#sms_check").change(function(){
    is_use_sms = $("#sms_check").val();
    if (is_use_sms == "") {
        $(".sms_tr").hide();
        $('#tb_sms').css("opacity","0.5");
    }else{
        $(".sms_tr").show();
        $('#tb_sms').css("opacity","1");
    }
});
//소인 유아 환경설정 여부
$("input[name=bo_2_subj]").change(function(){
    var use_count = $("input[name=bo_2_subj]:checked").val();
    
    if (use_count == "") {
        $("#kids").hide('fast');
        
    }else{
        $("#kids").show('fast');
        
    }
});

$("input[name=bo_6_subj]").change(function(){
    var pick = $("input[name=bo_6_subj]:checked").val();
    
    if (pick == "") {

        $("#pick_up").hide('fast');
        
    }else{
        $("#pick_up").show('fast');
        
    }
});

// 환경설정
function bo_set() {
    var pick_up_ch = $("input[name=bo_6_subj]:checked").val();
    var setting_array = [];
    var setting_temp = [];
    
    if($("#setting1").prop("checked")){
        
        setting_temp[0] = $("#setting1:checked").data('name');
        setting_temp[1] = $("#setting1:checked").val();
        setting_array.push(setting_temp);
        setting_temp = [];
    }
    if($("#setting2").prop("checked")){
        
        setting_temp[0] = $("#setting2:checked").data('name');
        setting_temp[1] = $("#setting2:checked").val();
        setting_array.push(setting_temp);
        setting_temp = [];
    }
    if ($("#setting3").val() != "") {
        setting_temp[0] = $("#setting3").data('name');
        setting_temp[1] = $("#setting3").val();
        setting_array.push(setting_temp);
        setting_temp = [];   
    }
    
    if (pick_up_ch == "") {
        var $bo_6_subj_content = "";

    }else{
        var $bo_6_subj_content = $("#bo_6_subj_content").val();

    }

    var $bo_1_subj         = $("input[name=bo_1_subj]:checked").val();
    var $bo_2_subj         = $("input[name=bo_2_subj]:checked").val();
    var $bo_3_subj         = $("input[name=bo_3_subj]").val();
    var $bo_4_subj         = $("input[name=bo_4_subj]").val();
    var $bo_5_subj         = $("input[name=bo_5_subj]:checked").val();
    var $bo_7_subj         = $("input[name=bo_7_subj]:checked").val();
    var $bo_8_subj         = $("input[name=bo_8_subj]:checked").val();

    var $bo_2              = $("input[name=bo_2]").val();
    var $bo_3              = $("input[name=bo_3]:checked").val();
    var $bo_4              = $("input[name=bo_4]").val();
    var $chk_SMS           = $("input:checkbox[name='chk_SMS']").is(":checked") == true;
    var $bo_5              = $("input[name=bo_5]").val();
    var $bo_6              = $("textarea[name=bo_6]").val();
    var $bo_7              = $("textarea[name=bo_7]").val();
    var $bo_8              = $("textarea[name=bo_8]").val();
    var $bo_9              = $("input[name=bo_9]").val();
    var $bo_10             = $("input[name=bo_10]").val();
    
    //SMS 발송
    var $sms_check = $("#sms_check").val();
    
    var $chk_resev_ready_adm       = $("input:checkbox[name='chk_resev_ready_adm']").is(":checked") == true;
    var $msg_resev_ready_adm       = $("textarea[name=msg_resev_ready_adm]").val();
    var $chk_resev_ready_user      = $("input:checkbox[name='chk_resev_ready_user']").is(":checked") == true;
    var $msg_resev_ready_user      = $("textarea[name=msg_resev_ready_user]").val();

    var $chk_resev_compl_adm       = $("input:checkbox[name='chk_resev_compl_adm']").is(":checked") == true;
    var $msg_resev_compl_adm       = $("textarea[name=msg_resev_compl_adm]").val();
    var $chk_resev_compl_user      = $("input:checkbox[name='chk_resev_compl_user']").is(":checked") == true;
    var $msg_resev_compl_user      = $("textarea[name=msg_resev_compl_user]").val();

    var $chk_resev_cancel_req_adm  = $("input:checkbox[name='chk_resev_cancel_req_adm']").is(":checked") == true;
    var $msg_resev_cancel_req_adm  = $("textarea[name=msg_resev_cancel_req_adm]").val();
    var $chk_resev_cancel_req_user = $("input:checkbox[name='chk_resev_cancel_req_user']").is(":checked") == true;
    var $msg_resev_cancel_req_user = $("textarea[name=msg_resev_cancel_req_user]").val();

    var $chk_resev_cancel_res_adm  = $("input:checkbox[name='chk_resev_cancel_res_adm']").is(":checked") == true;
    var $msg_resev_cancel_res_adm  = $("textarea[name=msg_resev_cancel_res_adm]").val();
    var $chk_resev_cancel_res_user = $("input:checkbox[name='chk_resev_cancel_res_user']").is(":checked") == true;
    var $msg_resev_cancel_res_user = $("textarea[name=msg_resev_cancel_res_user]").val();

    //Email 발송 내용
    var $is_mail = $("#email_check").val();
    var $mail_id = $("input[name=mail_id]").val();
    var $mail_pass = $("input[name=mail_pass]").val();
    var $mail_ad = $("input[name=mail_ad]").val();
    var $mail_text = $("textarea[name=mail_text]").val();
    var $mail_text2 = $("textarea[name=mail_text2]").val();
    var $mail_user_chk = $("#user_email:checked").val();
    var $mail_adm_chk = $("#admin_email:checked").val();
    var $pay_for_pet = "";
    if ($('#is_pay_for_pet').prop("checked")) {
        $pay_for_pet = $('#pay_for_pet').val();
    }
    
    $.ajax( {
        url: boardSkinAjaxUrl+"/modal/ajax_all_setting.php",
        type: "POST",
        data: {
            "status"    : "settings",
            "bo_table"  : tableName,
            "bor_table" : board1,
            "bo_1_subj" : $bo_1_subj,
            "bo_2_subj" : $bo_2_subj,
            "bo_3_subj" : $bo_3_subj,
            "bo_4_subj" : $bo_4_subj,
            "bo_5_subj" : $bo_5_subj,
            "bo_6_subj" : $bo_6_subj_content,
            "bo_7_subj" : $bo_7_subj,
            "bo_8_subj" : $bo_8_subj,
            "bo_1"      : board1,
            "bo_2"      : $bo_2,
            "bo_3"      : $bo_3,
            "bo_4"      : $bo_4,
            "chk_SMS"   : $chk_SMS,
            "bo_5"      : $bo_5,
            "bo_6"      : $bo_6,
            "bo_7"      : $bo_7,
            "bo_8"      : $bo_8,
            "bo_9"      : $bo_9,
            "bo_10"     : $bo_10,
            "sms_check" : $sms_check,
            "chk_resev_ready_adm"       : $chk_resev_ready_adm,
            "msg_resev_ready_adm"       : $msg_resev_ready_adm,
            "chk_resev_ready_user"      : $chk_resev_ready_user,
            "msg_resev_ready_user"      : $msg_resev_ready_user,
            "chk_resev_compl_adm"       : $chk_resev_compl_adm,
            "msg_resev_compl_adm"       : $msg_resev_compl_adm,
            "chk_resev_compl_user"      : $chk_resev_compl_user,
            "msg_resev_compl_user"      : $msg_resev_compl_user,
            "chk_resev_cancel_req_adm"  : $chk_resev_cancel_req_adm,
            "msg_resev_cancel_req_adm"  : $msg_resev_cancel_req_adm,
            "chk_resev_cancel_req_user" : $chk_resev_cancel_req_user,
            "msg_resev_cancel_req_user" : $msg_resev_cancel_req_user,
            "chk_resev_cancel_res_adm"  : $chk_resev_cancel_res_adm,
            "msg_resev_cancel_res_adm"  : $msg_resev_cancel_res_adm,
            "chk_resev_cancel_res_user" : $chk_resev_cancel_res_user,
            "msg_resev_cancel_res_user" : $msg_resev_cancel_res_user,
            "is_mail"                   : $is_mail,
            "mail_id"                   : $mail_id,
            "mail_pass"                 : $mail_pass,
            "mail_ad"                   : $mail_ad,
            "mail_text"                 : $mail_text,
            "mail_text2"                : $mail_text2,
            "mail_user_chk"             : $mail_user_chk,
            "mail_adm_chk"              : $mail_adm_chk,
            "pay_for_pet"               : $pay_for_pet,
            "settings_meta"             : setting_array
        },
        dataType: "json",
        // async: false,
        // cache: false,
        success: function( data, textStatus ) {
            // console.log(data);
            alert("수정되었습니다.");
            location.reload();

        },
        error: function( xhr, textStatus, errorThrown ) {
            console.error( textStatus );
        }
    } );
    
}
/////////////////modal ////////////////////////////////////


//펜션 초기설정
$('#set-pension').click(function(event) {
    $.ajax({
        url: boardSkinAjaxUrl+"/ajax_pension_setting.php",
        type: 'POST',
        dataType: 'json',
        data: {
            bo_table: tableName,
        },
    })
    .done(function(data) {
        console.log(data);
        alert("적용되었습니다.");
        location.reload();
    });
    
});