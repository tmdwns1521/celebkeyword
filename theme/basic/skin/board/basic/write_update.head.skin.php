<?php
$post_limit = 1; // 하루 글제한수
if($w != 'u') { //글수정이 아니면 작동
 // 오늘 체크
 $sql_today = apms_sql_term('today', 'wr_datetime'); // 기간(일수,today,yesterday,month,prev)
 if($is_member) { // 회원이면 mb_id로 체크
  $row = sql_fetch("select count(*) as cnt from $write_table where mb_id = '{$member['mb_id']}' and wr_is_comment = '0' $sql_today ");
 } else { // 비회원이면 ip로 체크
  $row = sql_fetch("select count(*) as cnt from $write_table where wr_ip = '{$_SERVER['REMOTE_ADDR']}' and wr_is_comment = '0' $sql_today ");
 }
 if($row['cnt'] >= $post_limit) {
  alert('본 게시판은 하루에 글을 '.$post_limit.'개까지만 등록할 수 있습니다.');
 }
}
 ?>
