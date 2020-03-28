
<!-------------------- START - Mobile Menu -------------------->
<div class="menu-mobile menu-activated-on-click color-scheme-dark">
    <div class="mm-logo-buttons-w">
        <a class="mm-logo" href="index.html"><img src="<?php echo BASE;?>/assets/admin/img/logo.png"><span>Sofeda Admin</span></a>
        <div class="mm-buttons">
            <div class="content-panel-open">
                <div class="os-icon os-icon-grid-circles"></div>
            </div>
            <div class="mobile-menu-trigger">
                <div class="os-icon os-icon-hamburger-menu-1"></div>
            </div>
        </div>
    </div>
    <div class="menu-and-user">
        <div class="logged-user-w">
            <div class="avatar-w">
                <img alt="" src="<?php echo BASE;?>/assets/admin/img/avatar1.jpg">
            </div>
            <div class="logged-user-info-w">
                <div class="logged-user-name">
                    Maria Gomez
                </div>
                <div class="logged-user-role">
                    Administrator
                </div>
            </div>
        </div>
        <!--------------------
            START - Mobile Menu List
            -------------------->
            <?php display_html( 'admin/common/sideNav'); ?>
        <!--------------------
            END - Mobile Menu List
            -------------------->

    </div>
</div>
<!--------------------
    END - Mobile Menu
    -------------------->

<!--------------------
    START - Main Menu
    -------------------->
<div class="menu-w color-scheme-light color-style-transparent menu-position-side menu-side-left menu-layout-compact sub-menu-style-over sub-menu-color-bright selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
    <div class="logo-w">
        <a class="logo" href="<?php echo BASE; ?>/admin">
            <div class="logo-element"></div>
            <div class="logo-label">
                Sofeda Admin
            </div>
        </a>
    </div>

    <div class="logged-user-w avatar-inline">
        <div class="logged-user-i">
            <div class="avatar-w">
                <img alt="" src="<?php echo BASE;?>/assets/admin/img/avatar1.jpg">
            </div>
            <div class="logged-user-info-w">
                <div class="logged-user-name">
                    Maria Gomez
                </div>
                <div class="logged-user-role">
                    Administrator
                </div>
            </div>
            <div class="logged-user-toggler-arrow">
                <div class="os-icon os-icon-chevron-down"></div>
            </div>
            <div class="logged-user-menu color-style-bright">
                <div class="logged-user-avatar-info">
                    <div class="avatar-w">
                        <img alt="" src="<?php echo BASE;?>/assets/admin/img/avatar1.jpg">
                    </div>
                    <div class="logged-user-info-w">
                        <div class="logged-user-name">
                            Maria Gomez
                        </div>
                        <div class="logged-user-role">
                            Administrator
                        </div>
                    </div>
                </div>
                <div class="bg-icon">
                    <i class="os-icon os-icon-wallet-loaded"></i>
                </div>
                <ul>
                    <li>
                        <a href="apps_email.html"><i class="os-icon os-icon-mail-01"></i><span>Incoming Mail</span></a>
                    </li>
                    <li>
                        <a href="users_profile_big.html"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a>
                    </li>
                    <li>
                        <a href="users_profile_small.html"><i class="os-icon os-icon-coins-4"></i><span>Billing Details</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="os-icon os-icon-others-43"></i><span>Notifications</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="element-search autosuggest-search-activator">
        <input placeholder="Start typing to search..." type="text">
    </div>
    <h1 class="menu-page-header">
        Page Header
    </h1>



    <?php display_html( 'admin/common/sideNav'); ?>




    
</div>
<!-------------------- END - Main Menu -------------------->
