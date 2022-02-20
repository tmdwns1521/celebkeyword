<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo G5_URL; ?>">
        <div class="sidebar-brand-text mx-3"><img src='<?php echo G5_THEME_URL; ?>/img/logo.png' id ="logo_img" style="height: 110px;"></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item<?php if (defined('_INDEX_')) { echo ' active'; } ?>">
        <a class="nav-link" href="<?php echo G5_URL; ?>">
          <i class="fas fa-home"></i>
          <span>Home</span></a>
      </li>
      <!-- Nav Item - KeyWORD CHECK -->
      <li class="nav-item<?php if (defined('_INDEX_')) { echo ' active'; } ?>">
        <a class="nav-link" href="<?php echo G5_URL; ?>/keyword_check.php">
          <i class="fas fa-chart-bar"></i>
          <span>키워드 분석</span></a>
      </li>
      <li class="nav-item<?php if (defined('_INDEX_')) { echo ' active'; } ?>">
        <a class="nav-link" href="<?php echo G5_URL; ?>/posting_check.php">
          <i class="fas fa-chart-bar"></i>
          <span>포스팅 분석</span></a>
      </li>
      <li class="nav-item<?php if (defined('_INDEX_')) { echo ' active'; } ?>">
        <a class="nav-link" href="<?php echo G5_URL; ?>/mykeword_check.php">
          <i class="fas fa-chart-bar"></i>
          <span>MY 키워드 분석</span></a>
      </li>
      <!-- <li class="nav-item<?php if (defined('_INDEX_')) { echo ' active'; } ?>">
        <a class="nav-link" href="<?php echo G5_URL; ?>/shoping_check.php">
          <i class="fas fa-chart-bar"></i>
          <span>쇼핑 키워드 분석</span></a>
      </li> -->

      <!-- Divider -->
      <hr class="sidebar-divider">

		<?php
		$menu_datas = get_menu_db(0, true);
		$i = 0;
		foreach($menu_datas as $row ) {
			if( empty($row) ) continue;

			$menu_board = explode("bo_table=", $row['me_link']);
			if (count($menu_board) == 2 && $menu_board[1]) { $menu_boardname = $menu_board[1]; }
			if (count($menu_board) == 1) { $menu_boardname = ''; }
		?>

			<li class="nav-item<?php if ($bo_table && $menu_boardname == $bo_table) { echo ' active'; } ?>">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#<?php echo $row['me_name']; ?>" aria-expanded="true" aria-controls="<?php echo $row['me_name']; ?>"> <i class="fas fa-fw fa-cog"></i> <span><?php echo $row['me_name']; ?></span></a>
				<div id="<?php echo $row['me_name']; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header"><?php echo $row['me_name']; ?></h6>
						<?php if ($row['me_link'] != "#") { ?>

						<a class="collapse-item" href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>"><?php echo $row['me_name']; ?></a>
						<?php } ?>

			<?php
			$k = 0;
			foreach( (array) $row['sub'] as $row2 ) {

				if( empty($row2) ) continue;

				if($k == 0) {
					//echo '		<hr class="sidebar-divider">'.PHP_EOL;
					//echo '<span class="bg">하위분류</span><div class="gnb_2dul"><ul class="gnb_2dul_box">'.PHP_EOL;
				}
			?>
				<a class="collapse-item" href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"> <?php echo $row2['me_name'] ?></a>
			<?php
			$k++;
			}   //end foreach $row2

			if($k > 0)
				echo ''.PHP_EOL;
			?>

					</div>
				</div>
			</li>
			<!-- Divider -->
			<hr class="sidebar-divider">
			<?php
			$i++;
		}   //end foreach $row
		?>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></i></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
