

$("input[name^='is_date']").each(function(){
    
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

///////////////////modal//////////////////////
$('#goodsbtn').click( function () {
    $('#setting').modal();
    $('#pills-season-tab').trigger('click');
});

$('[name=reg-close]').click(function(event) {
    var start_date = "";
    var end_date = "";
    var route = $(this).val();
    if ($(this).val() == "delete" || $(this).val() == "update") {
        start_date = $(this).closest('tr').find('.start').val();
        end_date = $(this).closest('tr').find('.end').val();

    }else{
        start_date = $( '#close_start' ).val();
        end_date = $( '#close_end' ).val();    
    }

    if ( start_date == '' ) {
        alert( '시작날짜를 입력하세요.' );
        $( '#close_start' ).focus();
        return false;
    } else if ( end_date == '' ) {
        alert( '끝날짜를 입력하세요' );
        $( '#close_end' ).focus();
        return false;
    }else {

        $.ajax( {
            url: boardSkinAjaxUrl+"/modal/ajax_season_setting.php",
            type: "POST",
            data: {
                "status" : "closeRoom",
                "route" : route,
                "id" : $(this).data('iden'),
                "bo_table" : tableName,
                "start_date" : start_date,
                "end_date" : end_date
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function( data, textStatus ) {
                if (route=="reg") {
                    alert("등록되었습니다.");    
                }else if(route=="delete"){
                    alert("삭제되었습니다.");
                }else{
                    alert("변경되었습니다.");
                }
                console.log(data);
                //location.reload();

            },
            error: function( xhr, textStatus, errorThrown ) {
                console.error( textStatus );
            }
        });
    }
});
// 기간등록
$( '#regBtn' ).click( function () {

    var $date_name = $( '#date_name' ).val();
    var $start_date = $( '#start_date' ).val();
    var $end_date = $( '#end_date' ).val();
    
    if ( $date_name == '' ) {
        alert( '시즌명을 입력하세요.' );
        $( '#date_name' ).focus();
        return false;
    } else if ( $start_date == '' ) {
        alert( '시작날짜를 입력하세요.' );
        $( '#start_date' ).focus();
        return false;
    } else if ( $end_date == '' ) {
        alert( '끝날짜을 입력하세요.' );
        $( '#end_date' ).focus();
        return false;
    } else {
        $.ajax( {
            url: boardSkinAjaxUrl+"/modal/ajax_season_setting.php",
            type: "POST",
            data: {
                "status" : "seasonInsert",
                "bo_table" : tableName,
                "date_name" : $date_name,
                "start_date" : $start_date,
                "end_date" : $end_date
            },
            dataType: "text",
            async: false,
            cache: false,
            success: function( data, textStatus ) {
                console.log(data);
                alert("등록되었습니다.");
                //location.reload();
            },
            error: function( xhr, textStatus, errorThrown ) {
                console.error( textStatus );
            }
        } );
    }
} );

// 기간수정
function editBtn( id ) {
    var $date_name = $( '#date_name_'+id ).val();
    var $start_date = $( '#start_date_'+id ).val();
    var $end_date = $( '#end_date_'+id ).val();
    

    if ( $date_name == '' ) {
        alert( '시즌명을 입력하세요.' );
        $( '#date_name' ).focus();
        return false;
    } else if ( $start_date == '' ) {
        alert( '시작날짜를 입력하세요.' );
        $( '#start_date' ).focus();
        return false;
    } else if ( $end_date == '' ) {
        alert( '끝날짜을 입력하세요.' );
        $( '#end_date' ).focus();
        return false;
    } else {
        $.ajax( {
            url: boardSkinAjaxUrl+"/modal/ajax_season_setting.php",
            type: "POST",
            data: {
                "status" : "seasonUpdate",
                "bo_table" : tableName,
                "id" : id,
                "date_name" : $date_name,
                "start_date" : $start_date,
                "end_date" : $end_date
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function( data, textStatus ) {

                alert("수정되었습니다.");
                location.reload();
            },
            error: function( xhr, textStatus, errorThrown ) {
                console.error( textStatus );
            }
        } );
    }
}
//기간삭제
function delBtn( id ) {
    if (confirm("해당 기간을 삭제하시겠습니까?") == true ) {
        $.ajax({
            url: boardSkinAjaxUrl+"/modal/ajax_season_setting.php",
            type: "POST",
            data:{
                "status" : "seasonDelete",
                "bo_table" : tableName,
                "id" : id
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                alert("삭제 되었습니다.");
                
                location.reload();
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error( textStatus );
            }
        });
    } else {
        return false;
    }
}