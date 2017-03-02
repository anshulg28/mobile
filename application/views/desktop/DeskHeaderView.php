<header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
        <!-- Title -->
        <div class="mdl-cell mdl-cell--2-col">
            <span class="mdl-layout-title">
                <button id="demo-menu-lower-left"
                        class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="material-icons">menu</i>
                </button>
                <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect"
                    data-mdl-for="demo-menu-lower-left">
                    <a href="<?php echo base_url();?>" class="my-noUnderline">
                        <li class="mdl-menu__item">
                            <i class="fa fa-home fa-14x mdl-list__item-icon"></i> Home
                        </li>
                    </a>
                    <a href="jukebox" class="my-noUnderline dynamic">
                        <li class="mdl-menu__item">
                            <i class="fa fa-music fa-14x mdl-list__item-icon"></i> Jukebox
                        </li>
                    </a>
                    <a href="event_dash" class="my-noUnderline dynamic">
                        <li class="mdl-menu__item">
                            <i class="fa fa-calendar fa-14x mdl-list__item-icon"></i> My Events
                        </li>
                    </a>
                    <a href="contact_us" class="my-noUnderline dynamic">
                        <li class="mdl-menu__item">
                            <i class="fa fa-life-ring fa-14x mdl-list__item-icon"></i> Contact
                        </li>
                    </a>
                </ul>
            </span>
        </div>
        <div class="mdl-cell mdl-cell--3-col"></div>
        <div class="mdl-cell mdl-cell--half-col"></div>
        <div class="mdl-cell mdl-cell--3-col my-filter-row">
            <div class="pull-left main-site-logo">
                <a href="<?php echo base_url();?>">
                    <img class="main-logo-img" src="<?php echo base_url().'asset/images/splashLogo.png';?>" alt="Logo"/>
                </a>
            </div>
            <!-- Add spacer, to align navigation to the right -->
            <div class="mdl-layout-spacer"></div>
            <!-- Navigation. We hide it in small screens. -->
            <nav class="mdl-navigation">
                <i class="ic_filter_icon"></i>
            </nav>
        </div>
        <div class="mdl-cell mdl-cell--3-col"></div>
    </div>
    <div class="mdl-layout__tab-bar mdl-js-ripple-effect hide" id="mainNavBar">
        <a href="#timelineTab" class="mdl-layout__tab is-active">
            <i class="ic_doolally_icon common-main-tabs on header-tabs-reposition mdl-badge--overlap" data-badge=""></i><span class="head-txt-up">Doolally</span>
        </a>
        <a href="#eventsTab" class="mdl-layout__tab">
            <span class="ic_events_icon common-main-tabs header-tabs-reposition"></span><span class="head-txt-up">Events</span>
        </a>
        <a href="#fnbTab" class="mdl-layout__tab">
            <span class="ic_fnb_icon common-main-tabs header-tabs-reposition"></span><span class="head-txt-up">FnB</span>
        </a>
    </div>
</header>