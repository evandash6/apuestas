<?Php $session = session(); ?>
<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="APUESTAS">
    <meta name="author" content="Jose Manuel Peralta">
    <title>APUESTAS</title>
    <!-- <link rel="apple-touch-icon" href="<?=base_url()?>/app-assets/images/favicon/apple-touch-icon-152x152.png"> -->
    <!-- <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>/app-assets/images/favicon/favicon-32x32.png"> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>app-assets/vendors/vendors.min.css">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>app-assets/css/themes/vertical-dark-menu-template/materialize.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>app-assets/css/themes/vertical-dark-menu-template/style.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>app-assets/css/pages/dashboard.css">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/app-assets/css/custom/custom.css">
    <!-- END: Custom CSS-->
    <!-- BEGIN VENDOR JS-->
    <script src="<?=base_url()?>app-assets/js/vendors.min.js"></script>
    <!-- END PAGE VENDOR JS-->
    <script src="<?=base_url()?>app-assets/js/custom/custom-script.js"></script>
    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/7898ee300d.js" crossorigin="anonymous"></script>
    <script src="<?=base_url()?>js/sweetalert2.js"></script>
    <script src="<?=base_url()?>app-assets/js/plugins.js"></script>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 2-columns" data-open="click" data-menu="vertical-dark-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <header class="page-topbar" id="header">
        <div class="navbar navbar-fixed">
            <nav class="navbar-main navbar-color nav-collapsible sideNav-lock">
                <div class="nav-wrapper">
                    <ul class="navbar-list right">
                        <li><?=$session->nombre?></li>
                        <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown"><span class="avatar-status avatar-online"><img src="<?=base_url()?>/img/avatar.png" alt="avatar"><i></i></span></a></li>
                    </ul>
                    <!-- profile-dropdown-->
                    <ul class="dropdown-content" id="profile-dropdown">
                        <li><a class="grey-text text-darken-1" href="#"><i class="material-icons">person_outline</i> Perfil</a></li>
                        <li><a class="grey-text text-darken-1" href="#"><i class="material-icons">help_outline</i> Ayuda</a></li>
                        <li class="divider"></li>
                        <li><a class="grey-text text-darken-1" href="#"><i class="material-icons">lock_outline</i> Bloquear</a></li>
                        <li><a class="grey-text text-darken-1" href="<?=base_url()?>administracion/salir"><i class="material-icons">keyboard_tab</i> Salir</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!-- END: Header-->
    <!-- BEGIN: SideNav-->
    <aside class="sidenav-main  nav-lock nav-collapsible sidenav-dark sidenav-active-rounded">
        <div class="brand-sidebar">
            <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="#"><span class="logo-text hide-on-med-and-down">S-APUESTAS</span></a></h1>
        </div>
        <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="accordion">
            <li class="navigation-header"><a class="navigation-header-text">Administración</a>
            <!-- <li class="bold"><a class="waves-effect waves-cyan <?=(isset($m_usuarios))?$m_usuarios:''?>" href="<?=base_url()?>administracion"><i class="material-icons">people</i><span class="menu-title">Usuarios</span></a></li> -->
            <li class="bold"><a class="waves-effect waves-cyan <?=(isset($m_cata))?$m_cata:''?>" href="<?=base_url()?>administracion/canales"><i class="material-icons">assignment</i><span class="menu-title">Canales</span></a></li>
            <li class="navigation-header"><a class="navigation-header-text">Menu</a>
            <li class="bold"><a class="waves-effect waves-cyan <?=(isset($m_apu))?$m_apu:''?>" href="<?=base_url()?>administracion/apuestas"><i class="material-icons">developer_board</i><span class="menu-title">Apuestas</span></a></li>
            <li class="bold"><a class="waves-effect waves-cyan <?=(isset($m_apuh))?$m_apuh:''?>" href="<?=base_url()?>administracion/apuestas_historial"><i class="material-icons">history_toggle_off</i><span class="menu-title">Historico Apuestas</span></a></li>
            <!-- <li class="bold"><a class="waves-effect waves-cyan <?=(isset($m_ava))?$m_ava:''?>" href="<?=base_url()?>home/avances"><i class="material-icons">flag</i><span class="menu-title">Avances y Evidencias</span></a></li> -->
        </ul>
        <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
    </aside>
    <!-- END: SideNav-->
    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container pt-2 pl-2 pr-2">
                <div class="row">
                    <div class="col s12 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-3"><span><i class="material-icons mr-2"><?=$icono?></i><?=$titulo?></span></h5>
                    </div>
                </div>
                <div class="divider mb-2"></div>