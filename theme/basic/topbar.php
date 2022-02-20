<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

        <!-- Topbar -->
        <div class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" id="mn__list">
          <div class="topbar_li">
            <div class="brand_logo">
              <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo G5_URL; ?>">
                <div class="sidebar-brand-text mx-3"><img src='<?php echo G5_THEME_URL; ?>/img/logo.png' id ="logo_img" style="height: 110px;"></div>
              </a>
            </div>
            <div class="m_n_list">
              <ul>
                <li style="border-left: solid 2px;"><a href="<?php echo G5_URL; ?>"><span >Home</span></a></li>
                <li><a href="<?php echo G5_URL; ?>/keyword_check.php"><span>키워드 분석</span></a></li>
                <li><a href="<?php echo G5_URL; ?>/posting_check.php"><span>포스팅 분석</span></a></li>
                <li><a href="<?php echo G5_URL; ?>/mykeword_check.php"><span>MY 키워드 분석</span></a></li>
                <li><a href="<?php echo G5_URL; ?>/shoping_check.php"><span>쇼핑 키워드 분석</span></a></li>
                <?php if ($member['mb_id']) { ?>
                      <!-- Nav Item - Messages -->

                      <!-- Nav Item - User Information -->
                      <li>
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="mr-2 d-none d-lg-inline text-gray-600 small">LV<?php echo $member['mb_level']; ?> <?php echo $member['mb_nick']; ?>/ 보유포인트 : <?php echo $member['mb_point']; ?> </span>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                          <?php if ($is_admin) { ?>
                  <a class="dropdown-item" href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            설정
                          </a>
                  <?php } else {
                    echo outlogin('theme/basic');
                  } ?>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            로그아웃
                          </a>
                        </div>
                      </li>
                <?php } else {
                  echo outlogin('theme/basic');
                } ?>
              </ul>
            </div>
          </div>
          <!-- Sidebar Toggle (Topbar) -->



          <!-- Topbar Navbar -->


        </div>

        <script src="<?php echo G5_THEME_URL; ?><?php echo '/js/classie.js"></script>'; ?>
        <script src="<?php echo G5_THEME_URL; ?><?php echo '/js/clipboard.min.js"></script>'; ?>
        <script src="<?php echo G5_THEME_URL; ?><?php echo '/js/classies.js"></script>'; ?>
        <!-- End of Topbar -->
