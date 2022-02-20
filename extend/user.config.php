<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//1일 등록 가능한 게시물 게시판별 제한
function ask_write_check($bo_table, array $board_list){
    global $g5, $member;
    //하루에 작성 가능한 게시물 수
    $write_count = 1;

    if(in_array($bo_table, $board_list) && $member && strstr($_SERVER['PHP_SELF'], 'write.php')){
        $sql = "select count(*) as cnt from {$g5['write_prefix']}{$bo_table} where mb_id = '{$member['mb_id']}' and date_format(wr_datetime, '%Y-%m-%d') = '" . G5_TIME_YMD . "' ";
        $cnt = sql_fetch($sql);

        if($cnt['cnt'] >= $write_count){
            alert("하루에 {$write_count}개의 게시물만 작성 가능합니다.");
            return;
        }else{
            return;
        }
    }
}
ask_write_check($bo_table, array('attendance'));//
?>
