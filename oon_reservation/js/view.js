

//current position
var pos = 0;
//number of slides
var totalSlides = $('#slider-wrap ul li').length;
//get the slide width
var sliderWidth = $('#slider-wrap').width();

var wrapHeight = 0;



$(document).ready(function(){
    
    sliderWidth = $('#bo_v_atc').width();
    $('#wrapper').css('width', sliderWidth);
    $('#slider-wrap').css('width', sliderWidth);
    $('#slider-wrap ul#slider li').css('width', sliderWidth);
    $('#slider-wrap ul#slider').width(sliderWidth*totalSlides);
    // $('#slider-wrap ul#slider').stop();
    $('#slider-wrap ul#slider').css('left', -(sliderWidth*pos));
    /*****************
     BUILD THE SLIDER
    *****************/
    //set width to be 'x' times the number of slides
    $('#slider-wrap ul#slider').width(sliderWidth*totalSlides);
    
    //next slide    
    $('#next').click(function(){
        slideRight();
    });
    
    //previous slide
    $('#previous').click(function(){
        slideLeft();
    });
    

    $('#slider-wrap ul li').each(function(index, el) {

        if (wrapHeight < $(this).height()) {
            wrapHeight = $(this).height(); 
        }
    });

    $('#wrapper').css('height', wrapHeight);
    $('#slider-wrap').css('height', wrapHeight);
    // #slider-wrap
    
    /*************************
     //*> OPTIONAL SETTINGS
    ************************/
    //automatic slider
    // var autoSlider = setInterval(slideRight, 3000);
    
    //for each slide 
    $.each($('#slider-wrap ul li'), function() { 

       //create a pagination
       var li = document.createElement('li');
       $('#pagination-wrap ul').append(li);    
    });
    
    //counter
    countSlides();
    
    //pagination
    pagination();
    
    //hide/show controls/btns when hover
    //pause automatic slide when hover
    // $('#slider-wrap').hover(
    //     function(){ 
    //         $(this).addClass('active');// clearInterval(autoSlider); 
    //     }, 
    //     function(){ 
    //         $(this).removeClass('active');// autoSlider = setInterval(slideRight, 3000);
    //     }
    // );
    
    

});//DOCUMENT READY
    


/***********
 SLIDE LEFT
************/
function slideLeft(){
    pos--;
    if(pos==-1){ pos = totalSlides-1; }
    $('#slider-wrap ul#slider').css('left', -(sliderWidth*pos));    
    
    //*> optional
    countSlides();
    pagination();
}


/************
 SLIDE RIGHT
*************/
function slideRight(){
    pos++;
    if(pos==totalSlides){ pos = 0; }
    $('#slider-wrap ul#slider').css('left', -(sliderWidth*pos)); 
    
    //*> optional 
    countSlides();
    pagination();
}



    
/************************
 //*> OPTIONAL SETTINGS
************************/
function countSlides(){
    $('#counter').html(pos+1 + ' / ' + totalSlides);
}

function pagination(){
    $('#pagination-wrap ul li').removeClass('active');
    $('#pagination-wrap ul li:eq('+pos+')').addClass('active');
}




 $(window).resize(function(event) {
    var wrapHeight = 0;
    sliderWidth = $('#bo_v_atc').width();
    $('#wrapper').css('width', sliderWidth);
    $('#slider-wrap').css('width', sliderWidth);
    $('#slider-wrap ul#slider li').css('width', sliderWidth);
    $('#slider-wrap ul#slider').width(sliderWidth*totalSlides);
    // $('#slider-wrap ul#slider').stop();
    $('#slider-wrap ul#slider').css('left', -(sliderWidth*pos));

    $('#slider-wrap ul li').each(function(index, el) {

        if (wrapHeight < $(this).height()) {
            wrapHeight = $(this).height(); 
        }
    });


    $('#wrapper').css('height', wrapHeight);
    $('#slider-wrap').css('height', wrapHeight);
    

    // wrapHeight
});



$('[data-toggle="tooltip"]').tooltip();
$("input[name='status_cancel']").click(function(){
    $id = $(this).attr("id");

    $.ajax( {
            url: boardSkinAjaxUrl+"/ajax_change_status.php",
            type: "POST",
            data: {
                "status" : "cancel",
                "bo_table" : tableName,
                "id" : $id
                // "value" : $value
                
            },
            // dataType: "json",
            async: false,
            cache: false,
            success: function( data, textStatus ) {
                alert("예약 취소되었습니다.");
                location.reload();
                
                
                // document.getElementById("total_price").innerHTML = data.price.total+"원";
            },
            error: function( xhr, textStatus, errorThrown ) {
                console.error( textStatus );
            }
    } );

})
$("input[name='status_update']").click(function(){

    $id = $(this).attr("id");
    $value = $(this).val();
    status = $("#status").text();
    if ($value == status) {
        alert("이미 취소요청 되었습니다.")
        return false;
    }
    
    $.ajax( {
        url: boardSkinAjaxUrl+"/ajax_change_status.php",
        type: "POST",
        data: {
            "status" : "update",
            "bo_table" : tableName,
            "id" : $id,
            "value" : $value
            
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function( data, textStatus ) {

            // console.log(data);
            alert("상태가 수정되었습니다.");
            location.reload();
            
            // document.getElementById("total_price").innerHTML = data.price.total+"원";
        },
        error: function( xhr, textStatus, errorThrown ) {
            
            console.error( textStatus );
        }
    });
});