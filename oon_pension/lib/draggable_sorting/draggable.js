$(function() {
	$('#sorting_mode').click(function() {
		
		//순서바꾸기
		var bo_table = $(this).data('table');

		if ($(this).val() == "드래그") {

			$(this).val("완료");
			
		    $( "ul" ).sortable({
		    	
			    start: function(event, ui) {
			        // Create a temporary attribute on the element with the old index
			        var list_height = parseFloat(window.getComputedStyle($(this).children('li').get(0)).height);
			        ui.placeholder.outerHeight(list_height);

			        $(this).attr('data-currentindex', ui.item.index());
			    },
			    update: function(event, ui) {
			    	
			        let current_position = $(this).attr('data-currentindex');
			        let desired_position = ui.item.index();
			        
			        $.ajax({
		                url: boardSkinLibUrl+"/draggable_sorting/ajax_draggable.php",
		                type: "POST",
		                data: {
		                	"current" : current_position,
		                	"desired" : desired_position,
		                    "bo_table" : bo_table
		                 
		                },
		                dataType: "json",
		                async: false,
		                cache: false,
		                success: function( data, textStatus ) {

		                    console.log(data);
		                    
		                  
		                },
		                error: function( xhr, textStatus, errorThrown ) {
		                    console.error( textStatus );
		                }
			        });
			    }
		    });
		    $( "#sortable" ).disableSelection();
		//완료
		}else if ($(this).val()=="완료") {
			alert("적용되었습니다.");
			location.reload();
		}
		
    });


	$('input[name=selected_move]').click(function(event) {
        var checked_id_array = [];
        var route = $(this).data('value');
        var bo_table = $(this).data('table');
        $("input[name*='chk_wr_id']:checked").each(function() { 
            checked_id_array.push($(this).val()); 
        });
        
        if (route=="chan") {

            if (checked_id_array.length!=2) {
                alert("2개의 게시물만 선택해주세요.")
                return false;
            }
        }else if(route=="prev" || route=="next"){

            if (checked_id_array.length!=1) {
                alert("1개의 게시물만 선택해주세요.")
                return false;
            }
        }else{

            alert("잘못된 접근입니다.");
            return false;
        }
        $.ajax({
                url: boardSkinLibUrl+"/draggable_sorting/ajax_move_update.php",
                type: "POST",
                data: {
                    
                    "bo_table" : bo_table,
                    "checked_id" : checked_id_array,
                    "route" : route
                },
                dataType: "text",
                async: false,
                cache: false,
                success: function( data, textStatus ) {
                    console.log(data);
                    alert("수정되었습니다.");
                    location.reload();
                },
                error: function( xhr, textStatus, errorThrown ) {
                    console.error( textStatus );
                }
        });
    });
    
});
