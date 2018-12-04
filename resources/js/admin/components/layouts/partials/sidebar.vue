<template>
    <div class="sidebar">
        <div class="sidebar-inner">
            <!-- ### $Sidebar Header ### -->
            <div class="sidebar-logo">
                <div class="peers ai-c fxw-nw">
                    <div class="peer peer-greed">
                        <a class='sidebar-link td-n' href="/">
                            <div class="peers ai-c fxw-nw">
                                <div class="peer">
                                    <div class="logo">
                                        <img src="/images/logo.png" alt="">
                                    </div>
                                </div>
                                <div class="peer peer-greed">
                                    <h5 class="lh-1 mB-0 logo-text">Nhóm 3</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="peer">
                        <div class="mobile-toggle sidebar-toggle">
                            <a href="" class="td-n">
                                <i class="ti-arrow-circle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ### $Sidebar Menu ### -->
            <ul class="sidebar-menu scrollable pos-r">
                <li class="nav-item mT-30 active">
                    <router-link class='sidebar-link' to="/admin/dashboard" default>
                        <span class="icon-holder">
                          <i class="c-blue-500 ti-home"></i>
                        </span>
                        <span class="title">Dashboard</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/book" class='sidebar-link'>
                        <span class="icon-holder">
                          <i class="c-pink-500 ti-calendar"></i>
                        </span>
                        <span class="title">Quản Lý Sách</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/user" class='sidebar-link'>
                        <span class="icon-holder">
                          <i class="c-red-500 ti-user"></i>
                        </span>
                        <span class="title">Quản Lý Người Dùng</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/invoice" class='sidebar-link'>
                        <span class="icon-holder">
                          <i class="c-orange-500 ti-comment-alt"></i>
                        </span>
                        <span class="title">Quản Lý Hóa Đơn</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/import" class='sidebar-link'>
                        <span class="icon-holder">
                          <i class="c-indigo-500 ti-tag"></i>
                        </span>
                        <span class="title">Quản Lý Nhập Hàng</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/category" class='sidebar-link'>
                        <span class="icon-holder">
                          <i class="c-green-500 ti-view-list-alt"></i>
                        </span>
                        <span class="title">Quản Lý Danh Mục</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/supplier" class='sidebar-link'>
                        <span class="icon-holder">
                            <i class="c-light-blue-500 ti-pencil"></i>
                        </span>
                        <span class="title">Quản Lý Nhà Cung Cấp</span>
                    </router-link>
                </li>
                <li class="nav-item dropdown">
                    <router-link to="/admin/role" class='sidebar-link'>
                        <span class="icon-holder">
                            <i class="c-pink-500 ti-palette"></i>
                        </span>
                        <span class="title">Quản Lý Quyền</span>
                    </router-link>
                </li>
                <!--<li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                        <i class="c-orange-500 ti-layout-list-thumb"></i>
                        </span>
                            <span class="title">Tables</span>
                            <span class="arrow">
                        <i class="ti-angle-right"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <router-link class='sidebar-link' to="/admin/product/create">New Product</router-link>
                        </li>
                        <li>
                            <a class='sidebar-link' href="datatable.html">Data Table</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="c-purple-500 ti-map"></i>
                    </span>
                        <span class="title">Maps</span>
                        <span class="arrow">
                    <i class="ti-angle-right"></i>
                    </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="google-maps.html">Google Map</a>
                        </li>
                        <li>
                            <a href="vector-maps.html">Vector Map</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="c-red-500 ti-files"></i>
                    </span>
                        <span class="title">Pages</span>
                        <span class="arrow">
                    <i class="ti-angle-right"></i>
                    </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class='sidebar-link' href="404.html">404</a>
                        </li>
                        <li>
                            <a class='sidebar-link' href="500.html">500</a>
                        </li>
                        <li>
                            <a class='sidebar-link' href="signin.html">Sign In</a>
                        </li>
                        <li>
                            <a class='sidebar-link' href="signup.html">Sign Up</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                    <i class="c-teal-500 ti-view-list-alt"></i>
                    </span>
                        <span class="title">Multiple Levels</span>
                        <span class="arrow">
                  <i class="ti-angle-right"></i>
                    </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-item dropdown">
                            <a href="javascript:void(0);">
                                <span>Menu Item</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="javascript:void(0);">
                                <span>Menu Item</span>
                                <span class="arrow">
                      <i class="ti-angle-right"></i>
                    </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="javascript:void(0);">Menu Item</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">Menu Item</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </div>
    </div>
</template>
<script type="text/javascript">
    import * as $ from 'jquery';
    export default {
        mounted () {
            $('.sidebar .sidebar-menu li a').on('click', function () {
                const $this = $(this);

                if ($this.parent().hasClass('open')) {
                  $this
                    .parent()
                    .children('.dropdown-menu')
                    .slideUp(200, () => {
                      $this.parent().removeClass('open');
                    });
                } else {
                  $this
                    .parent()
                    .parent()
                    .children('li.open')
                    .children('.dropdown-menu')
                    .slideUp(200);

                  $this
                    .parent()
                    .parent()
                    .children('li.open')
                    .children('a')
                    .removeClass('open');

                  $this
                    .parent()
                    .parent()
                    .children('li.open')
                    .removeClass('open');

                  $this
                    .parent()
                    .children('.dropdown-menu')
                    .slideDown(200, () => {
                      $this.parent().addClass('open');
                    });
                }
            });

            // Sidebar Activity Class
            const sidebarLinks = $('.sidebar').find('.sidebar-link');

            sidebarLinks
            .each((index, el) => {
              $(el).removeClass('active');
            })
            .filter(function () {
              const href = $(this).attr('href');
              const pattern = href[0] === '/' ? href.substr(1) : href;
              return pattern === (window.location.pathname).substr(1);
            })
            .addClass('active');

            // ٍSidebar Toggle
            $('.sidebar-toggle').on('click', e => {
            $('.app').toggleClass('is-collapsed');
            e.preventDefault();
            });

            /**
            * Wait untill sidebar fully toggled (animated in/out)
            * then trigger window resize event in order to recalculate
            * masonry layout widths and gutters.
            */
            // $('#sidebar-toggle').click(e => {
            //   e.preventDefault();
            //   setTimeout(() => {
            //     window.dispatchEvent(window.EVENT);
            //   }, 300);
            // });

            // Search bar
            $('.search-toggle').on('click', e => {
            $('.search-box, .search-input').toggleClass('active');
            $('.search-input input').focus();
            e.preventDefault();
            });
        }
    }
</script>
