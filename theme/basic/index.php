<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if (defined("_INDEX_")) {
    header("Location: ".G5_BBS_URL."/board.php?bo_table=notice");
    return;
}
if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');

if(defined('_INDEX_')) { // index에서만 실행
	include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
}
?>

<div id="kakao-talk-channel-chat-button"></div>

<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<script type='text/javascript'>
  //<![CDATA[
    // 사용할 앱의 JavaScript 키를 설정해 주세요.
    Kakao.init('0302c8348bee186e92d2d89b7ecd34e2');
    // 카카오톡 채널 1:1채팅 버튼을 생성합니다.
    Kakao.Channel.createChatButton({
      container: '#kakao-talk-channel-chat-button',
      channelPublicId: '_nRRUK' // 카카오톡 채널 홈 URL에 명시된 ID
    });
  //]]>
</script>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          </div>

          <!-- Content Row -->

		  <?php // 최신글
      echo latest('theme/basic', 'notice', 6, 24);
		  echo latest('theme/basic', 'free', 6, 24);
		  echo latest('theme/basic', 'qa', 6, 24);
		  ?>





        </div>
        <!-- /.container-fluid -->

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>
