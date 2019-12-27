<style>
	.season-room-name{
		font-weight: bold;
	}
    
	.season-table td{
		text-align: center;
		white-space:nowrap !important;
	}
    .season-day {float: left;}
    .season-price {float: right;font-weight: bold;}
</style>
<?php
$season = array();
$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'date/config'";

$result = sql_query($sql);
$i = 0;
while ($row = sql_fetch_array($result)) {
    $season[$i]['name'] = $row['mta_db_id'];
    $season[$i]['start'] = strtotime($row['mta_key']);
    $season[$i]['end'] = strtotime($row['mta_value']);

    $i++;
}


?>
<div class="modal fade" id="season-price" role="dialog">
    <div class="modal-dialog modal-lg" style="z-index: 9999;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5><i class="fa fa-list" aria-hidden="true"></i> 시즌별 가격 보기</h5>
            </div>
            <div class="modal-body tbl_head01 tbl_wrap" style="overflow-y: auto;overflow-x: hidden;">
                <div style="overflow-x: scroll;">
                <table class="season-table">
                    <thead>
                    <tr>
                        <th></th>
                        <!-- 비수기 이름 출력 -->
                        <th style="width: 123px;">비수기</th>
                        <!-- 시즌 이름 출력 -->
                        <?for ($j=0; $j < count($season); $j++) { ?>
                            <th style="width: 123px;">
                                <div><?=$season[$j]['name']?></div>
                                <div><?=date('Y-m-d',$season[$j]['start'])?></div>
                                <div><?=date('Y-m-d',$season[$j]['end'])?></div>
                            </th>
                       <? }?>
                   </tr>
                   </thead>
                   <tbody>
                    <?for ($i=0; $i < count($total_list); $i++) { ?>
                        <tr>
                            <!-- 객실이름 -->
                            <td style="font-weight: bold;"><?=$total_list[$i]['wr_subject']?></td>
                            <!-- 비수기 가격 -->
                            <td>
                                <div style="clear: both;">
                                    <span class="season-day">평일</span>
                                    <span class="season-price"><?=number_format($total_list[$i]['wr_weekday비수기'])?>원</span>
                                </div>
                                <div style="clear: both;">
                                    <span class="season-day"><?if($board['bo_7_subj']==""){echo "금토";}else{echo "금";}?></span>
                                    <span class="season-price"><?=number_format($total_list[$i]['wr_weekend비수기'])?>원</span>
                                </div>
                                <?php if ($board['bo_7_subj'] != ""): ?>
                                <div style="clear: both;">
                                    <span class="season-day">토</span>
                                    <span class="season-price">
                                        <?if (!$total_list[$i]['wr_weekend2비수기']) {
                                            echo "<span style='color:red;'>설정되지않음</span>";
                                        }else{
                                            echo number_format($total_list[$i]['wr_weekend2비수기'])."원"; 
                                        }?>
                                        
                                    </span>
                                </div>
                                <? endif?>
                                <?php if ($board['bo_7_subj'] == "2"): ?>
                                <div style="clear: both;">
                                    <span class="season-day">일</span>
                                    <span class="season-price">
                                        <?if (!$total_list[$i]['wr_weekend3비수기']) {
                                            echo "<span style='color:red;'>설정되지않음</span>";
                                        }else{
                                            echo number_format($total_list[$i]['wr_weekend3비수기'])."원"; 
                                        }?>
                                        
                                    </span>
                                </div>    
                                <?php endif ?>
                                
                            </td>

                            <!-- 시즌별 가격 -->
                           <?for ($j=0; $j < count($season); $j++) { ?>
                                <td>
                                    <div style="clear: both;">
                                        <span class="season-day">평일</span>
                                        <span class="season-price">
                                        <?if ($total_list[$i]['wr_weekday'.$season[$j]['name']] == "") {
                                            
                                            echo number_format($total_list[$i]['wr_weekday비수기'])."원";
                                        }else{
                                            echo number_format($total_list[$i]['wr_weekday'.$season[$j]['name']])."원";
                                        }?></span>

                                    </div>
                                   
                                        
                                    
                                    <div style="clear: both;">
                                    <span class="season-day"><?if ($board['bo_7_subj'] == "") {echo "금토";}else{echo "금";}?></span>
                                    <span class="season-price">  
                                        <?if ($total_list[$i]['wr_weekend'.$season[$j]['name']] =="") {
                                            echo number_format($total_list[$i]['wr_weekend비수기'])."원";
                                        }else{
                                            echo number_format($total_list[$i]['wr_weekend'.$season[$j]['name']])."원";
                                        }?></span>
                                    </div>
                                     <?if ($board['bo_7_subj'] != "") {?>
                                    <div style="clear: both;"><span class="season-day">토</span>
                                    <span class="season-price">  
                                        <?if ($total_list[$i]['wr_weekend2'.$season[$j]['name']] =="") {
                                            if (!$total_list[$i]['wr_weekend2비수기'] && $board['bo_7_subj'] != "") {
                                                echo "<span style='color:red;'>설정되지않음</span>";
                                            }else{
                                                echo number_format($total_list[$i]['wr_weekend2비수기'])."원";
                                            }
                                        }else{
                                            echo number_format($total_list[$i]['wr_weekend2'.$season[$j]['name']])."원";
                                        }?>
                                    </span>
                                    </div>
                                    <? }?>
                                    <?php if ($board['bo_7_subj'] == "2"): ?>
                                    <div style="clear: both;">
                                        <span class="season-day">일</span>
                                    <span class="season-price">
                                        <?if ($total_list[$i]['wr_weekend3'.$season[$j]['name']] =="") {
                                            if (!$total_list[$i]['wr_weekend3비수기']) {
                                                echo "<span style='color:red;'>설정되지않음</span>";
                                            }else{
                                            echo number_format($total_list[$i]['wr_weekend3비수기'])."원";
                                            }
                                        }else{
                                            echo number_format($total_list[$i]['wr_weekend3'.$season[$j]['name']])."원";
                                        }?>
                                 </span>
                                    </div>    
                                    <?php endif ?>
                                </td>
                           <? }?>
                        </tr>
                    <? }?>
                    </tbody>
                	<!-- <thead>
                		<tr>
                			<th></th>
                			<th>비수기</th>
                			<th>준성수기</th>
                			<th>성수기</th>
                			<th>극성수기</th>
                			
                		</tr>
                	</thead>
                	<?
                	for ($n=0; $n < count($total_list); $n++) { ?>
                		<tr>
	                		<td class="season-room-name"><?=$total_list[$n]['wr_subject']?></td>
	                		<td>123123123123</td>
	                		<td>123123123123</td>
	                		<td>123123123123</td>
	                		<td>123123123123</td>
	                		
	                		
	                	</tr>
                	<? } ?>  -->
                	
                	
                </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"> 닫기</button>
            </div>
        </div>
    </div>
</div>