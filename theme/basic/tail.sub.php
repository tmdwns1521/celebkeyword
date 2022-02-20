<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<!-- Bootstrap core JavaScript-->
<script src="<?php echo G5_THEME_URL; ?>/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo G5_THEME_URL; ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo G5_THEME_URL; ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo G5_THEME_JS_URL; ?>/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?php echo G5_THEME_URL; ?>/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?php echo G5_THEME_JS_URL; ?>/table_paging.js"></script>
<script src="<?php echo G5_THEME_JS_URL; ?>/table_rank.js"></script>
<script src="<?php echo G5_THEME_JS_URL; ?>/table_rank1.js"></script>
<script src="<?php echo G5_THEME_JS_URL; ?>/classie.js"></script>
<script src="<?php echo G5_THEME_JS_URL; ?>/clipboard.min.js"></script>
<script src="<?php echo G5_THEME_JS_URL; ?>/menu.custom.js"></script>
<script src="<?php echo G5_THEME_JS_URL; ?>/month_search_chart.js"></script>
<script src="<?php echo G5_THEME_JS_URL; ?>/keyword_year_count.js"></script>
<script src="<?php echo G5_THEME_JS_URL; ?>/chart-pie-demo.js"></script>
<script src="<?php echo G5_THEME_JS_URL; ?>/sex_pie_demo.js"></script>
<script src="<?php echo G5_THEME_JS_URL; ?>/visitor.js"></script>
<?php if ($is_admin == 'super') {  ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>

<!-- ie6,7에서 사이드뷰가 게시판 목록에서 아래 사이드뷰에 가려지는 현상 수정 -->
<!--[if lte IE 7]>
<script>
$(function() {
    var $sv_use = $(".sv_use");
    var count = $sv_use.length;

    $sv_use.each(function() {
        $(this).css("z-index", count);
        $(this).css("position", "relative");
        count = count - 1;
    });
});
</script>
<![endif]-->

<?php run_event('tail_sub'); ?>

</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다. ?>
