<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex align-items-center"> <!-- Added align-items-center for vertical centering -->
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="companies.php" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.svg" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">BMS</span>
                    </span>
                </a>

                <a href="companies.php" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.svg" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">BMS</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex align-items-center"> <!-- Added align-items-center here as well -->
            <!-- Add Bon Button -->
            <!-- Conditionally display the "Add Bon" button if not on the "add_bon.php" page -->
            <?php if (basename($_SERVER['PHP_SELF']) !== 'add_bon.php'): ?>
                <form method="GET" action="add_bon.php" class="mb-0 d-inline">
                    <button type="submit" class="btn btn-primary" style="margin-right: 20px;"
                        <?php 
                        // Example permission logic
                        $permissions = ['canadd' => 1]; // Change this value to 0 to test the disabled button
                        if ($permissions['canadd'] == 0) {
                            echo 'style="pointer-events: none; opacity: 0.6;"'; 
                        } 
                        ?>>
                        <i class="fas fa-plus me-2"></i> Add Bon
                    </button>
                </form>
            <?php endif; ?>

            <!-- Search Dropdown -->
            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="<?php echo $language["Search"]; ?>"
                                    aria-label="Search Result">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Language Dropdown -->
            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <?php if ($lang == 'en') { ?>
                        <img class="me-2" src="assets/images/flags/us.jpg" alt="Header Language" height="16">
                    <?php } ?>
                    <?php if ($lang == 'fr') { ?>
                        <img class="me-2" src="assets/images/flags/france.jpg" alt="Header Language" height="16">
                    <?php } ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="?lang=en" class="dropdown-item notify-item language"
                        onclick="document.location.href='set_lang.php?lang=en';">
                        <img src="assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12">
                        <span class="align-middle"> English </span>
                    </a>
                    <a href="?lang=fr" class="dropdown-item notify-item language"
                        onclick="document.location.href='set_lang.php?lang=fr';">
                        <img src="assets/images/flags/france.jpg" alt="user-image" class="me-1" height="12">
                        <span class="align-middle"> French </span>
                    </a>
                </div>
            </div>

            <!-- Dark/Light Mode Button -->
            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>

            <!-- User Profile Dropdown -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-light-subtle border-start border-end"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">
                        <?php
                        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                            echo htmlspecialchars($_SESSION["username"]);
                        } else {
                            echo "Guest";
                        }
                        ?>
                    </span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="apps-contacts-profile.php"><i
                            class="mdi mdi mdi-face-man font-size-16 align-middle me-1"></i>
                        <?php echo $language["Profile"]; ?></a>
                    <a class="dropdown-item" href="auth-lock-screen.php"><i
                            class="mdi mdi-lock font-size-16 align-middle me-1"></i>
                        <?php echo $language["Lock_screen"]; ?> </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><i
                            class="mdi mdi-logout font-size-16 align-middle me-1"></i>
                        <?php echo $language["Logout"]; ?></a>
                </div>
            </div>
        </div>
    </div>
</header>



<!-- ========== Left Sidebar Start ========== -->
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu"><?php echo $language["Menu"]; ?></li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-authentication">Apps</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="sites.php" data-key="t-data-tables">
                                <i class="fas fa-map-marker-alt me-2" style="font-size: 16px;"></i>
                                <?= $lang == 'fr' ? 'Sites' : 'Sites' ?>
                            </a>
                        </li>
                        <li>
                            <a href="companies.php" data-key="t-data-tables">
                                <i class="fas fa-building me-2" style="font-size: 16px;"></i>
                                <?= $lang == 'fr' ? 'Entreprises' : 'Companies' ?>
                            </a>
                        </li>
                        <li>
                            <a href="bons.php" data-key="t-lock-screen">
                                <i class="fas fa-file-invoice me-2" style="font-size: 16px;"></i>
                                <?= $lang == 'fr' ? 'Bons' : 'Bons' ?>
                            </a>
                        </li>
                    </ul>

                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->