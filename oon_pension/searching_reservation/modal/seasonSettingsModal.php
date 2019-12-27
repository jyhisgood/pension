<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<!-- 시즌관리 -->
<div class="modal fade" id="setting" role="dialog">
    <div class="modal-dialog" style="z-index: 9999;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5><i class="fa fa-list" aria-hidden="true"></i> 시즌 관리</h5>
            </div>
            <div class="modal-body tbl_head01 tbl_wrap" style="overflow-y: auto;overflow-x: hidden;">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="pills-season-tab" data-toggle="pill" href="#pills-season" role="tab" aria-controls="pills-season" aria-selected="true">시즌설정</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-close-tab" data-toggle="pill" href="#pills-close" role="tab" aria-controls="pills-close" aria-selected="false">날짜막기</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade" id="pills-season" role="tabpanel" aria-labelledby="pills-season-tab">

                        <form id="goods" method="post">
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="4">시즌설정 주의사항</th>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            1. 시즌을 추가했다면 반드시 객실마다 시즌에 맞는 가격을 수정해주셔야 합니다.<br>
                                            2. 시즌을 삭제하면 이미 예약된 객실은 시즌이 적용되어 가격이 정해집니다.<br>
                                            3. 시즌이 설정되지 않은 기간은 모두 비수기 처리 됩니다.<br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>시즌명</th>
                                        <th>시작날짜</th>
                                        <th>끝날짜</th>
                                        <th>관리</th>
                                    </tr>
                                </thead>
                                <tbody class="gd_tbody">
                                    <tr>
                                        <td><input type="text" name="is_name" id="date_name" class="frm_input input03"></td>
                                        <td><input type="text" name="is_date" id="start_date" class="frm_input input01" readonly></td>
                                        <td><input type="text" name="is_date" id="end_date" class="frm_input input01" readonly></td>
                                        <td><button id="regBtn" type="button" class="btn btn-default">등록</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        <table>
                            <thead>
                                <tr>
                                    <th>시즌명</th>
                                    <th>시작날짜</th>
                                    <th>끝날짜</th>
                                    <th>관리</th>
                                </tr>
                            </thead>
                            <tbody class="gd_tbody2">
                                <?php
                                $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'date/config'  order by mta_idx desc";
                                $rs = sql_query( $sql );
                                for ( $i = 0; $row = sql_fetch_array( $rs ); $i++ ) {
                                    $row['mta_db_id'] = preg_replace("/_/", " ", $row['mta_db_id']);
                                    ?>
                                    <tr id="tr_<?=$row['mta_idx']?>">
                                        <td><input type="text" name="is_name" id="date_name_<?=$row['mta_idx']?>" class="frm_input input03"  value="<?=$row['mta_db_id']?>"></td>
                                        <td><input type="text" name="is_date" id="start_date_<?=$row['mta_idx']?>" class="frm_input input01" value="<?=$row['mta_key']?>" readonly></td>
                                        <td><input type="text" name="is_date" id="end_date_<?=$row['mta_idx']?>" class="frm_input input01" value="<?=$row['mta_value']?>" readonly></td>
                                        <td>
                                            <button id="editBtn" type="button" class="btn btn-default" onclick="editBtn( <?=$row['mta_idx']?> )">수정</button>
                                            <button id="delBtn" type="button" class="btn btn-default" onclick="delBtn( <?=$row['mta_idx']?> )">삭제</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-close" role="tabpanel" aria-labelledby="pills-close-tab">
                        <form id="goods" method="post">
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="4">날짜막기 지정</th>
                                    </tr>
                                    <tr>
                                        
                                        <th>시작날짜</th>
                                        <th>끝날짜</th>
                                        <th>관리</th>
                                    </tr>
                                </thead>
                                <tbody class="gd_tbody">
                                    <tr>
                                        
                                        <td style="text-align: center;">
                                            <input type="text" class="frm_input input01" readonly id="close_start" name="is_date">
                                        </td>
                                        <td style="text-align: center;">
                                            <input type="text" class="frm_input input01" readonly id="close_end" name="is_date">
                                        </td>
                                        <td style="text-align: center;">
                                            <button name="reg-close" type="button" class="btn btn-default" value="reg">등록</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        <table>
                            <thead>
                                <tr>
                                    
                                    <th>시작날짜</th>
                                    <th>끝날짜</th>
                                    <th>관리</th>
                                </tr>
                            </thead>
                            <tbody class="gd_tbody2">
                                <?php
                                $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'closed/{$bo_table}' AND mta_db_id = 'closed' order by mta_idx desc";
                                
                                $rs = sql_query( $sql );
                                for ( $i = 0; $row = sql_fetch_array( $rs ); $i++ ) { ?>
                                    <tr id="tr_<?=$row['mta_idx']?>">
                                        
                                        <td style="text-align: center;">
                                            <input type="text" name="is_date" class="frm_input input01 start" value="<?=$row['mta_key']?>" readonly>
                                        </td>
                                        <td style="text-align: center;">
                                            <input type="text" name="is_date" class="frm_input input01 end" value="<?=$row['mta_value']?>" readonly>
                                        </td>
                                        <td style="text-align: center;">
                                            <button name="reg-close" type="button" class="btn btn-default" value="update" data-iden="<?=$row['mta_idx']?>">수정</button><br>
                                            <button name="reg-close" type="button" class="btn btn-default" value="delete" data-iden="<?=$row['mta_idx']?>">삭제</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"> 닫기</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?=$board_skin_url?>/js/calendar/seasonSettingModal.js"></script>