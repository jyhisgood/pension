
var weekName = ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"];

///////////////////멀티예약 탭 //////////////////////
var save_click_multi_tab = "100";
var parent_wrap = "";
var disabledDays = "";

var totalPriceArray = [[]];
var priceThisRoom = [];


// 전체객실 누적금액 정보
var reserveAdded  = 0;
var discountAdded = 0;
var guestsAdded   = 0;
var petAdded      = 0;
var optionsAdded  = 0;
var totalAdded    = 0;


function disableAllTheseDays(date) {
    var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
    for (i = 0; i < disabledDays.length; i++) {
        if($.inArray(y + '-' +(m+1) + '-' + d,disabledDays) != -1) {
            return [false];
        }
    }
    return [true];
}



$('.multi-reserve-tab').click(function(event) {
    parent_wrap = $(this).parent('.multi-reserve-wrap');
    $('.multi-reserve-wrap').find('.multi-reserve-contents').slideUp('slow');

    // 다른거 클릭했을 시 슬라이드다운
    if (save_click_multi_tab != parent_wrap.index()) {

        parent_wrap.find('.multi-reserve-contents').slideDown('slow');
        //index 저장 (다시 클릭시 닫기 위함)
        save_click_multi_tab = parent_wrap.index();
    }else{
        save_click_multi_tab = "100";
    }

    disabledDays = disabledDaysArray[parent_wrap.index()];
    
    

    /* 출발 시간 날짜 선택 - 시작 */
    $('.wr_4').datepicker('destroy');
    $('.wr_5').datepicker('destroy');

    parent_wrap.find('.wr_4').datepicker({
        showOn: 'both',
        buttonImage:boardSkinUrl+"/img/calendar.png", 
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        yearRange: 'c-99:c+99',
        constrainInput: true,
        prevText: '이전 달',
        nextText: '다음 달',
        monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        dayNames: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        yearSuffix: '년',
        maxDate: new Date(closed_setting),
        minDate: "+d;",
        beforeShowDay: disableAllTheseDays
    }); 
    chang_start(parent_wrap.find('.wr_4').val(), false);
    
    /* 출발 시간 날짜 선택 - 종료 */


    getPriceJs();

});
///////////////////멀티예약 탭 end //////////////////////
 
if (is_search) {
    getPriceJs();    
}
   
$('.check_agree').change(function(event) {
    if ($(this).is(':checked')) {
        $(this).closest('div').css('background', '#545454');
        $(this).closest('h4').css('color', 'white');
    }else{
        $(this).closest('div').css('background', '#ddd');
        $(this).closest('h4').css('color', 'black');
    }
});
$("#check_all").click(function(){
    var chk = $(this).is(":checked");//.attr('checked');

    if(chk){
        
        $('.agree-div').css('background', '#545454');
        $('.agree-div').find('h4').css('color', 'white');
        $(".check_agree").prop('checked', true);  
    }else{
        $('.agree-div').css('background', '#ddd');
        $('.agree-div').find('h4').css('color', 'black');
        $(".check_agree").prop('checked', false);    
    }  
});

$("#agree1").click(function(){
    if ($("#agree1").text()=="내용보기") {
        
        $("#agree1").text("내용숨기기");
        $("#scr1").show(500);
    }else{
        $("#agree1").text("내용보기");
        $("#scr1").hide(500);
    }
    
});
$("#agree2").click(function(){
    if ($("#agree2").text()=="내용보기") {
        
        $("#agree2").text("내용숨기기");
        $("#scr2").show(500);
    }else{
        $("#agree2").text("내용보기");
        $("#scr2").hide(500);
    }
    
});
$("#agree3").click(function(){
    if ($("#agree3").text()=="내용보기") {
        
        $("#agree3").text("내용숨기기");
        $("#scr3").show(500);
    }else{
        $("#agree3").text("내용보기");
        $("#scr3").hide(500);
    }
    
});
$('#wr_pickup').change(function(){
    if ($("#wr_pickup").is(":checked")) {
        
        document.getElementById("pickup_content").innerHTML = boardSub6;
    }else{
        document.getElementById("pickup_content").innerHTML = "픽업요청시 체크박스를 클릭해주세요.";
    }
});
$('[data-toggle="tooltip"]').tooltip();



$('.submit-btn-reserve').click(function(event) {
    if (parent_wrap.find('.wr_4').val() == "" || parent_wrap.find('.wr_5').val() == "") {
        alert("숙박기간을 정해주세요.");
        return;
    }
    reserveAdded  = 0;
    discountAdded = 0;
    guestsAdded   = 0;
    petAdded      = 0;
    optionsAdded  = 0;
    totalAdded    = 0;
    console.log(totalPriceArray);
    totalPriceArray.forEach(function(item){
        reserveAdded  = Number(reserveAdded) + Number(item['reserve']);
        discountAdded = Number(discountAdded) + Number(item['sale']);
        guestsAdded   = Number(guestsAdded) + Number(item['count']);
        petAdded      = Number(petAdded) + Number(item['animals']);
        optionsAdded  = Number(optionsAdded) + Number(item['option']);
        totalAdded    = Number(totalAdded) + Number(item['total']);
    });

    $('#room_price').text("+"+AddComma(reserveAdded)+"원");
    $('#room_sale_price').text("-"+AddComma(discountAdded)+"원");
    $('#county_price').text("+"+AddComma(guestsAdded)+"원");
    $('#animals_price').text("+"+AddComma(petAdded)+"원");
    $('#op_price').text("+"+AddComma(optionsAdded)+"원");
    $('#sum_price').text("+"+AddComma(totalAdded)+"원");
    



    parent_wrap.find('.multi-reserve-tab').addClass('submited-this-room');
    parent_wrap.find('.room-name').css('color', 'white');
    parent_wrap.find('.check-submit').show();
    

    



    var chekCheck = true;
    $('.multi-reserve-tab').each(function(index, el) {
        if ($(this).hasClass('submited-this-room') === false) {

            var param = $(this);
            setTimeout(function(param) {
                param.trigger('click');
            }, 200, $(this));

            return chekCheck = false;

        }
    });
    if (chekCheck) {
        parent_wrap.find('.multi-reserve-contents').slideUp('slow');
        parent_wrap = ""
    }
});    
function AddComma(num)
{
    var regexp = /\B(?=(\d{3})+(?!\d))/g;
    return num.toString().replace(regexp, ',');
}

    
function chang_start($start_date, checking){
    // console.log(checking);
    
    var day = ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'];
    
    $.ajax( {
            url: boardSkinAjaxUrl+"/ajax_chaging_date.php",
            type: "POST",
            data: {
                "status" : "chang_start",
                "bo_table" : tableName,
                "bo_1" : board1,
                
                "start_date" : $start_date,
                "id" : parent_wrap.data('wrid')
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function( data, textStatus ) {
              // console.log(data);
                var d = new Date($start_date);
                var date = d.getFullYear()+"년 "+new String(d.getMonth()+1)+"월 " + d.getDate()+"일 "+day[d.getDay()];
                
                $min = "+"+data.start_cul+"d;";
                $max = "+"+data.count_day+"d;";
               

               $('#this-room-in-out-time').html(
                  parent_wrap.find('.wr_4').val() + " " + parent_wrap.find('.wr_4').data('roomst') +"<br>퇴실날짜를 정해주세요"
                
                );
                
                //datepicker 초기화

                parent_wrap.find('.wr_5').datepicker("destroy");
                if (checking) {
                    parent_wrap.find('.wr_5').val("");
                    parent_wrap.find('.submited-this-room').removeClass('submited-this-room');
                    parent_wrap.find('.room-name').css('color', 'black');
                    parent_wrap.find('.check-submit').css('display', 'none');
                    $('#this-room-price').text('숙박기간을 정해주세요.');
                }
                
                parent_wrap.find('.wr_5').datepicker({ 
                    changeMonth: true, 
                    changeYear: true, 
                    dateFormat: "yy-mm-dd", 
                    yearRange: "c-99:c+99", 
                    prevText: '이전 달',
                    nextText: '다음 달',
                    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                    monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                    dayNames: ['일', '월', '화', '수', '목', '금', '토'],
                    dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
                    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
                    yearSuffix: '년',
                    minDate: $min,
                    maxDate: $max, 

                    buttonImage:boardSkinUrl+"/img/calendar.png", 
                    buttonImageOnly: true, showOn: 'both'
                });
            },
            error: function( xhr, textStatus, errorThrown ) {
                console.error( textStatus );
            }
    });
}

    // 기간수정
function getPriceJs(id) {
    
    if (id == "change") {
        parent_wrap.find('.submited-this-room').removeClass('submited-this-room');
        parent_wrap.find('.room-name').css('color', 'black');
        parent_wrap.find('.check-submit').css('display', 'none');
    }
    if (!parent_wrap) {return;}
    var start_date = parent_wrap.find('.wr_4').val();                 // 입실날짜 
    var end_date   = parent_wrap.find('.wr_5').val();                 // 퇴실날짜 
    var old1       = parent_wrap.find('.wr_old1').val();              // 성인
    var old2       = parent_wrap.find('.wr_old2').val();              // 소인
    var old3       = parent_wrap.find('.wr_old3').val();              // 유아
    var animals    = parent_wrap.find('.wr_animals2').val();          // 애완동물
    var room_sale  = parent_wrap.find('.room-sale').data('roomSale'); // 연박할인
    var to         = old1*1 + old2*1 + old3*1;                        // 인원수
    var opName     = new Array();                                     // 옵션이름 배열 선언
    var opValue    = new Array();                                     // 옵션개수 배열 선언
    
    // 옵션
    parent_wrap.find('.amount').each(function(index, el) {
        opName.push($(this).data('opname'));
        opValue.push($(this).val());
    });
    
    
    if (to > parent_wrap.find('.counting-max').data('maxChecking')) {
        alert("예약가능한 최대인원을 초과했습니다.");
        
        parent_wrap.find('.wr_old1').val("0");
        parent_wrap.find('.wr_old2').val("0");
        parent_wrap.find('.wr_old3').val("0");

        return false;
    }

    
    
    if ( end_date == '' ) {
        $('#this-room-price').text('숙박기간을 정해주세요.');
        
    } else {
        
        var thisSelected = new Date(start_date);
        $('.reserve_date').text(getFormatDate(thisSelected));
        $.ajax( {
                url: boardSkinAjaxUrl+"/ajax_reservation.php",
                type: "POST",
                data: {
                    "status"     : "get_price",
                    "bo_table"   : tableName,
                    "bo_1_subj"  : boardSub1,
                    "sale"       : room_sale,
                    "start_date" : start_date,
                    "end_date"   : end_date,
                    "old1"       : old1,
                    "old2"       : old2,
                    "old3"       : old3,
                    "animals"    : animals,
                    "op_name"    : opName,
                    "op_value"   : opValue,
                    "id" : parent_wrap.data('wrid')

                },
                dataType: "json",
                async: false,
                cache: false,
                success: function( data, textStatus ) {
                    var priceThisRoom = [];
                    priceThisRoom['reserve'] = data.reserve.replace(/,/gi,'');
                    priceThisRoom['sale']    = data.sale.replace(/,/gi,'');
                    priceThisRoom['count']   = data.count.replace(/,/gi,'');
                    priceThisRoom['animals'] = data.animals.replace(/,/gi,'');
                    priceThisRoom['option']  = data.option.replace(/,/gi,'');
                    priceThisRoom['total']   = data.total.replace(/,/gi,'');

                    
                    totalPriceArray[parent_wrap.index()] = priceThisRoom;

                    // console.log(totalPriceArray);
                    

                    parent_wrap.find('.total_price').val(data.total+"원");
                    parent_wrap.find('.animals_price').val(data.animals+"원");
                    parent_wrap.find('.calendarCounting').val(data.diff);
                    $('#this-room-name').text(parent_wrap.find('.room-name').text());
                    $('#this-room-price').text(data.total+"원");
                    $('#this-room-in-out-time').html(
                          parent_wrap.find('.wr_4').val() + " " + parent_wrap.find('.wr_4').data('roomst') +"<br>"
                        + parent_wrap.find('.wr_5').val() + " " + parent_wrap.find('.wr_5').data('roomen')
                        );

                    $('#animal_price').val(data.animals+"원");


                    $('#count_price').val(data.count+"원");
                    $('#reserve_price').val(data.reserve+"원");
                    $('#option_price').val(data.option+"원");
                    $('#sale_price').val("-"+data.sale+"원");
                    
                    
                    

                    // console.log(priceThisRoom);

                    
                    
                },
                error: function( xhr, textStatus, errorThrown ) {
                    console.error( textStatus );
                }
        });
    }
}
function getFormatDate(date){ 
    var year = date.getFullYear();              //yyyy 
    var month = (1 + date.getMonth());          //M 
    month = month >= 10 ? month : '0' + month;  //month 두자리로 저장 
    var day = date.getDate();                   //d 
    day = day >= 10 ? day : '0' + day;          //day 두자리로 저장 
    return year + '년 ' + month + '월 ' + day + '일 ' + weekName[date.getDay()]; 
}


$(document).ready(function(){
    /* 제이쿼리 충돌 수정 - 시작 */
    jQuery.browser = {};
    (function () {
        jQuery.browser.msie = false;
        jQuery.browser.version = 0;
        if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
            jQuery.browser.msie = true;
            jQuery.browser.version = RegExp.$1;
        }
    });
    /* 제이쿼리 충돌 수정 - 종료 */

});