 <div class="page-content eventDash">
    <?php
    if(isset($status) && $status === false)
    {
        ?>
        <div class="content-block" id="event-login-form">
            <div class="demo-card-square mdl-shadow--2dp text-center">
                <div class="mdl-custom-login-title">
                    <h2 class="mdl-card__title-text">Doolally Login</h2>
                </div>
                <form action="<?php echo base_url().'main/checkUser';?>" method="POST" id="main-event-form">
                    <div class="mdl-card__supporting-text">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="email" name="username">
                            <label class="mdl-textfield__label" for="email">Email</label>
                        </div>
                        <br>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="number" id="mobNum" name="mobNum">
                            <label class="mdl-textfield__label" for="mobNum">Mobile Number</label>
                        </div>
                        <br>
                        <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    else
    {
        ?>
        <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
            <div class="mdl-tabs__tab-bar">
                <a href="#hosting" class="mdl-tabs__tab is-active">Hosting</a>
                <a href="#attending" class="mdl-tabs__tab">Attending</a>
                <i class="ic_logout_icon" id="dashboard-logout"></i>
            </div>
            <div id="hosting" class="mdl-tabs__panel is-active">
                <div class="content-block">
                    <?php
                    if(isset($userEvents) && myIsMultiArray($userEvents))
                    {
                        $postImg = 0;
                        foreach($userEvents as $key => $row)
                        {
                            $img_collection = array();
                            ?>
                            <div class="mdl-card mdl-shadow--2dp demo-card-header-pic">
                                <?php
                                if($postImg <5)
                                {
                                    ?>
                                    <img src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img"/>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <img data-src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img lazy"/>
                                    <?php
                                }
                                $postImg++;
                                ?>

                                <ul class="mdl-list main-avatar-list">
                                    <li class="mdl-list__item mdl-list__item--two-line">
                                        <span class="mdl-list__item-primary-content">
                                            <span class="avatar-title">
                                            <?php
                                            $eventName = (strlen($row['eventName']) > 25) ? substr($row['eventName'], 0, 25) . '..' : $row['eventName'];
                                            echo $eventName;?>
                                            </span>
                                        </span>
                                        <span class="mdl-list__item-secondary-content">
                                            <span class="mdl-list__item-secondary-info">
                                                <input type="hidden" data-name="<?php echo $row['eventName'];?>" value="<?php if(isset($row['shortUrl'])){echo $row['shortUrl'];}else{ echo $row['eventShareLink'];}?>"/>
                                                <?php
                                                if($row['ifApproved'] == EVENT_APPROVED && $row['ifActive'] == ACTIVE)
                                                {
                                                    ?>
                                                    <i class="my-pointer-item ic_me_share_icon pull-right event-share-icn event-card-share-btn"></i>
                                                    <?php
                                                }
                                                ?>
                                            </span>
                                        </span>
                                    </li>
                                </ul>
                                <div class="mdl-card__supporting-text">
                                    <?php
                                    $isApprov = false;
                                    if($row['ifApproved'] == EVENT_DECLINED)
                                    {
                                        ?>
                                        <i class="material-icons">info_outline</i>&nbsp;&nbsp;Event Declined!<?php
                                    }
                                    elseif($row['ifApproved'] == EVENT_WAITING)
                                    {
                                        ?>
                                        <i class="material-icons">info_outline</i>&nbsp;&nbsp;Review In Progress...<?php
                                    }
                                    elseif($row['ifApproved'] == EVENT_APPROVED && $row['ifActive'] == ACTIVE)
                                    {
                                        $isApprov = true;
                                        ?>
                                        <i class="material-icons">info_outline</i>&nbsp;&nbsp;Event Approved!<?php
                                    }
                                    elseif($row['ifApproved'] == EVENT_APPROVED && $row['ifActive'] == NOT_ACTIVE)
                                    {
                                        $isApprov = true;
                                        ?>
                                        <i class="material-icons">info_outline</i>&nbsp;&nbsp;Event Approved But Not Active<?php
                                    }
                                    ?>
                                    <?php
                                    if($isApprov === true)
                                    {
                                        ?>
                                        <a href="<?php echo 'event_details/'.$row['eventSlug'];?>" class="event-bookNow dynamic">View&nbsp;Details <i class="ic_back_icon my-display-inline"></i></a>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <a href="<?php echo 'event_details/'.$row['eventSlug'];?>" class="event-bookNow dynamic" disabled>View&nbsp;Details <i class="ic_back_icon my-display-inline"></i></a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    else
                    {
                        echo 'No Event Created Yet!';
                    }
                    ?>
                </div>
            </div>
            <div id="attending" class="mdl-tabs__panel">
                    <div class="content-block">
                        <?php
                            if(isset($registeredEvents) && myIsMultiArray($registeredEvents))
                            {
                                $postImg = 0;
                                foreach($registeredEvents as $key => $row)
                                {
                                    $img_collection = array();
                                    ?>
                                    <div class="mdl-card mdl-shadow--2dp demo-card-header-pic">
                                        <?php
                                        if($postImg <5)
                                        {
                                            ?>
                                            <img src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img"/>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <img data-src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img lazy"/>
                                            <?php
                                        }
                                        $postImg++;
                                        ?>
                                        <!--<div style="background-image:url()" valign="bottom" class="card-header color-white no-border">Journey To Mountains</div>-->
                                        <div class="card-content">
                                            <div class="card-content-inner">
                                                <ul class="mdl-list main-avatar-list">
                                                    <li class="mdl-list__item mdl-list__item--two-line">
                                                        <span class="mdl-list__item-primary-content">
                                                            <span class="avatar-title">
                                                                <?php
                                                                $eventName = (strlen($row['eventName']) > 25) ? substr($row['eventName'], 0, 25) . '..' : $row['eventName'];
                                                                echo $eventName;
                                                                ?>
                                                            </span>
                                                            <span class="mdl-list__item-sub-title">By <?php echo $row['creatorName'];?></span>
                                                        </span>
                                                        <span class="mdl-list__item-secondary-content">
                                                            <span class="mdl-list__item-secondary-info">
                                                                <input type="hidden" data-name="<?php echo $row['eventName'];?>" value="<?php if(isset($row['shortUrl'])){echo $row['shortUrl'];}else{echo $row['eventShareLink'];} ?>"/>
                                                                <i class="my-pointer-item ic_me_share_icon pull-right event-share-icn event-card-share-btn"></i>
                                                            </span>
                                                        </span>
                                                    </li>
                                                </ul>
                                                <br>
                                                <div class="mdl-card__supporting-text">
                                                    <?php
                                                    $eventDescrip = (strlen($row['eventDescription']) > 100) ? substr($row['eventDescription'], 0, 100) . '..' : $row['eventDescription'];
                                                    ?>
                                                    <a href="<?php echo 'events/'.$row['eventSlug'];?>" class="comment dynamic">
                                                        <?php echo $eventDescrip;?>
                                                    </a>
                                                    <p>
                                                        <i class="ic_me_location_icon main-loc-icon"></i>&nbsp;<?php echo $row['locName']; ?>
                                                        &nbsp;&nbsp;<span class="ic_events_icon event-date-main my-display-inline"></span>&nbsp;
                                                        <?php $d = date_create($row['eventDate']);
                                                        echo date_format($d,EVENT_DATE_FORMAT); ?>
                                                        &nbsp;&nbsp;<i class="ic_me_rupee_icon main-rupee-icon"></i>
                                                        <?php
                                                        switch($row['costType'])
                                                        {
                                                            case "1":
                                                                echo "Free";
                                                                break;
                                                            case "2":
                                                                echo 'Rs '.$row['eventPrice'];
                                                                break;
                                                        }
                                                        ?>
                                                        <a href="<?php echo 'events/'.$row['eventSlug'];?>" class="event-bookNow dynamic">View Details <i class="ic_back_icon my-display-inline"></i></a>
                                                        <?php
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>
        </div>
        <?php
    }
    ?>
</div>
 <script>
     componentHandler.upgradeDom();
     $(".lazy").lazy({
         effect : "fadeIn"
     });
 </script>