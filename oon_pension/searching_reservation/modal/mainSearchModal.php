<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

?>





<script src="<?php echo $board_skin_url; ?>/lib/pgwslideshow.min.js"></script>
<link rel="stylesheet" href="<?php echo $board_skin_url?>/lib/pgwslideshow_light.min.css">
<link rel="stylesheet" href="<?php echo $board_skin_url?>/lib/pgwslideshow.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">	
<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div class="modal fade" id="view_list" role="dialog">
	<form action="./write.php?bo_table=<?=$board['bo_1']?>" method="post" id="form1-data">
	<div class="wrap-reserve-btn-fixed">
		<div class="reserve-btn-fixed">
		   	<div class="fixd-btn"><input type="submit" value="예약하기" class="submit_reserve" data-bo1="<?=$board['bo_1']?>"></div>
		</div>
	</div>
    <div class="modal-dialog modal-lg" style="z-index:1050;margin-bottom: 100px;">
        <!-- Modal content-->

        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body tbl_wrap" style="/*overflow: auto;*/">
   				


            	<div class="check_date_wrap" style="overflow: hidden;margin: 6px;">
	            	<div style="float: left;">
						<div>
		            		<span>체크인</span>
		            		<span id="st_date"></span>
		        		</div>
	        		</div>
	        		<div style="float: right;">
		        		<div>
		        			<span>체크아웃</span>
		        			<span id="en_date" style="color: red;"></span>	
		        		</div>	
	        		</div>
				</div>
            	<div class="select_container" style="">
            		<?php
            		//select box 갯수 찾는 로직
            		$max_count_temp = array();

            		for ($i=0; $i < count($total_list); $i++) { 
            			//메타테이블에 있는 자료들을 $total_list에 합침
                		$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_id = '{$total_list[$i]['wr_id']}' AND mta_db_table = 'board/{$bo_table}'";
			            $result = sql_query($sql);
			            while ($row = sql_fetch_array($result)) {
			                $total_list[$i]["{$row['mta_key']}"] = $row['mta_value'];
			                
			            }
			            $max_count_temp[] = $total_list[$i]['wr_max'];

            		}
            		arsort($max_count_temp);
            		
            		foreach ($max_count_temp as $key => $value) {
            			$max_count = $value;
            			break;
            		}
            		?>
            		<div style="text-align: center;margin-top: 11px;">
	            		<div class="wrap-sel-div">
			            	<div class="sel sel--black-panther" style="float: left;">
							  <select id="sort_search">
							    <option value="" disabled>정렬</option>
							    <option value="wr_subject" data-order="asc">객실명순</option>
		                		<<!-- option value="price" data-order="asc">가격순 ▲</option> -->
		                		<option value="price" data-order="desc">가격순</option>
		                		<!-- <option value="wr_max" data-order="asc">인원순 ▲</option> -->
		                		<option value="wr_max" data-order="desc">인원순</option>
		                		<!-- <option value="wr_area" data-order="asc">넓이순 ▲</option> -->
		                		<option value="wr_area" data-order="desc">넓이순</option>
							  </select>
							</div>
							<div class="sel sel--black-panther" style="float: right;">
							  <select id="wr_add1" class="chang_price">
							    <option value="" disabled>성인</option>
							    <?for ($i=1; $i <= $max_count; $i++) { ?>
		                			<option value="<?=$i?>"><?=$i?>명</option>	
		                		<? }?>
							  </select>
							</div>
						</div>
						<?if ($board['bo_2_subj'] == "1") {?>
							<div class="wrap-sel-div" id="sec-wrap-sel-div">
								<div class="sel sel--superman" style="float: left;">
								  <select id="wr_add2" class="chang_price">
								    <option value="" disabled>소아</option>
								    <?for ($i=0; $i <= $max_count; $i++) { ?>
			                			<option value="<?=$i?>"><?=$i?>명</option>	
			                		<? }?>
								  </select>
								</div>
								<div class="sel sel--superman" style="float: right;">
								  <select id="wr_add3" class="chang_price">
								    <option value="" disabled>유아</option>
								    <?for ($i=0; $i <= $max_count; $i++) { ?>
			                			<option value="<?=$i?>"><?=$i?>명</option>	
			                		<? }?>
								  </select>
								</div>
							</div>
						<? }?>
					</div>
                </div>
				<?
				$thumb = get_list_thumbnail($board['bo_table'], $list[0]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height']);
				?>
				<img src="<?=$thumb['src']?>" id="abc" style="width:100%;height:auto;display:none;">
				<!-- <img src="<?=$thumb['src']?>"> -->
                <ul class="list_container" style="position: relative;">
                	
                	<?for ($i=0; $i<count($total_list); $i++) {
                		
			            //썸네일 추출

                		$thumb = get_list_thumbnail($board['bo_table'], $total_list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height']);
			            if($thumb['src']) {
			                $img_content = '<img src="'.$thumb['ori'].'" alt="'.$thumb['alt'].'" class="img_content" id="img_content">';
			            }
			            // print_r2($thumb);
			            //옵션명 및 가격 추출
			            $sql = "SELECT COUNT(*) FROM {$g5['meta_table']} WHERE mta_db_id = '{$total_list[$i]['wr_id']}' AND mta_key LIKE '%wr_option_name%' AND mta_db_table = 'board/{$bo_table}'";
			            $result = sql_fetch($sql);
			            $option_tooltip = "";

			            // 테이블 모드
			            if ($result['COUNT(*)'] != 0) {

				            $option_tooltip .="<table class='tooltip-table'>";
				            for ($j=0; $j < $result['COUNT(*)']; $j++) { 
				            	$option_tooltip .="<tr>";

				            	$option_tooltip .= "<td>".$total_list[$i]['wr_option_name'.$j]."</td><td>".number_format($total_list[$i]['wr_option_price'.$j])."원</td>";
				            	
				            	$option_tooltip .="</tr>";
				            }
				            $option_tooltip .= "</table>";
			            }
			           




	    				$text = "";
	    				$text .= "<table class='tooltip-table'>";
		    				$text .= "<tr>";
			    				$text .= "<td>성인추가요금</td>
			    				          <td>".number_format($total_list[$i]['wr_11'])."원</td>";
		    				$text .= "</tr>";
	    				if ($board['bo_2_subj']) {
							$text .= "<tr>";
		    					$text .= "<td>소인추가요금</td>
		    					          <td>".number_format($total_list[$i]['wr_12'])."원</td>";
	    					$text .= "</tr>";
	    					$text .= "<tr>";
								$text .= "<td>유아추가요금</td>
										  <td>".number_format($total_list[$i]['wr_13'])."원</td>";
							$text .= "</tr>";
	    				}
	    				?>
					<form action="./write.php?bo_table=<?=$board['bo_1']?>" method="post" class="list_form">
                		<!-- <input type="hidden" name="id" value="<?=$total_list[$i]['wr_id']?>"> -->
                		<input type="hidden" name="reservation_date" value="">
                		<input type="hidden" name="end_date" value="">
                		<input type="hidden" name="wr_add1" value="0">
                		<input type="hidden" name="wr_add2" value="0">
                		<input type="hidden" name="wr_add3" value="0">
	            		<li style="padding: 7px;" id="<?=$total_list[$i]['wr_id']?>" class="list_li">
							<div class="li_list_subject">
								<i class="far fa-calendar-alt"></i> 
								<span class="subject_name" style="font-size: 20px;letter-spacing: -0.05em;margin-right: 6px;    word-break: break-all;"><?=$total_list[$i]['wr_subject']?></span> 
								<span style="padding: 0 5px;border: 1px solid black; font-weight: bold;"><span class="min"><?=$total_list[$i]['wr_min']?></span>명/<span class="max"><?=$total_list[$i]['wr_max']?></span>명</span>
								<span style="padding: 0 5px;border: 1px solid black;padding: 0 4px; font-weight: bold;"><?=$total_list[$i]['wr_area']?>평</span>
		        				<?php if ($option_tooltip): ?>
		        					<label data-toggle="tooltip" title="<?=$option_tooltip?>" data-placement="bottom" data-html="true" style="background-color: #1f3d73;padding: 0 7px;color: white;font-weight: 100;border-radius: 3px;">옵션보기</label>	
		        				<?php else: ?>
		        					<label style="background-color: #a9a9a9;padding: 0 5px;color: white;">옵션없음</label>
		        				<?php endif ?>
							</div>
		                	<div class="li_list_obj">
		                		<div style="background-image: url('<?=$thumb['ori']?>');" class="img_container">
			                		<span class="image_info"><i class="fas fa-search-plus"></i></span>
		                		</div>
		                		
		                		<div>		
		                			<div class="booking_content" style="height: 128px;float: none;">
		                				
		                				<?$remove_img = str_replace("<img", "[사진첨부]<img style='display:none;' ", $total_list[$i]['wr_content']);
		                				$remove_img = strip_tags($remove_img,'<br>');
		                				?>
		                				
		                				<div><?=$remove_img?></div>

		            				</div>
		            				<div style="font-size: 23px;height: 31px;text-align: right;padding-right: 5px;"><i class="fas fa-plus-square" name="view_content_btn" style="cursor: pointer;"></i></div>
		                		</div>
		                		<div class="price_cul">
		                			<div style="overflow: hidden;">
			                			<div class="price_subj_clas count_day"></div><div class="book_prc"></div>
		                			</div>
		                			<div style="overflow: hidden;">
		                				
		                				<div class="price_subj_clas">추가인원 <i class="fas fa-question-circle" data-toggle="tooltip" title="<?=$text?>" data-html="true"></i></div><div class="add_prc">+0원</div>
		                			</div>
		                			<div style="overflow: hidden;margin-bottom: 9px;">
		                				<div class="price_subj_clas">연박할인</div><div style="color: red;"  class="sale_prc"></div>	
		                			</div>
		                			<div style="overflow: hidden;overflow: hidden;border-top: 1px solid #ddd;padding-top: 9px;font-weight: bold;font-size: 19px;font-size: 17px;">
		                				<div class="price_subj_clas">총요금</div><div class="total_prc"></div>	
		                			</div>
		                			
		                		</div>
		                		
		                		<div>
									<div style="text-align: center;height: 100%;">
										<div class="checkbox-fake-div">
											<i class="far fa-check-square" style="font-size: 40px;"></i>
											<input type="checkbox" name="id[]" value="<?=$total_list[$i]['wr_id']?>" style="display: none;" class="fake-checkbox">
										</div>
										
									</div>
		                		</div>
		                	</div>
	                	</li>
                	</form>
                	<?}?>
                	<li>
                		<div class="search-none" <?if(count($total_list) != 0){echo "style='display:none;'";}?>>검색결과가 없습니다.</div>
                	</li>
                </ul>
				<img src="<?=$thumb['src']?>" id="abc" style="width:100%;height:auto;display:none;">
            </div>
		</div>
    </div>
    </form>
</div>
<div class="modal fade" id="view_img" role="dialog">
    <div class="modal-dialog modal-lg"  style="z-index:1060;">
    	<div style="width: 100%;height: 45px;position: absolute;z-index: 1;"><button type="button" class="close" data-dismiss="modal" style="width: 40px;height: 40px;"><i class="fas fa-times" style="color: black;font-size: 30px"></i></button></div>
    	
    	<div class="modal-body tbl_head01 tbl_wrap" style="overflow: auto;padding: 0;" id="image_info"></div>
        
    </div>
</div>

<div class="modal fade" id="view_content" role="dialog">
    <div class="modal-dialog"  style="z-index:1060;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            	<span id="content_subject"></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body tbl_wrap" id="content_box">

			<!-- wr_content 들ㅇ어가는 곳 -->

			</div>
        </div>
    </div>
</div>
        

<script type="text/javascript" src="<?=$board_skin_url?>/js/calendar/searchModal.js"></script>