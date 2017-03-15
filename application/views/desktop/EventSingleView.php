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
        <input type="hidden" value="Doolally Login" id="docTitle"/>
        <?php
    }
    elseif(isset($eventDetails) && myIsMultiArray($eventDetails))
    {
        foreach($eventDetails as $key => $row)
        {
            ?>
            <input type="hidden" value="<?php echo $row['eventName'];?>" id="docTitle"/>
            <div class="page-content event-details-page">
                <div class="mdl-card mdl-shadow--2dp demo-card-header-pic">
                    <img src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img"/>
                    <div class="card-content">
                        <div class="card-content-inner">
                            <input type="hidden" id="eventId" value="<?php echo $row['eventId'];?>"/>
                            <ul class="mdl-list main-avatar-list">
                                <li class="mdl-list__item">
                                    <span class="mdl-list__item-primary-content">
                                        <span class="avatar-title">
                                            <?php
                                            $eventName = (strlen($row['eventName']) > 35) ? substr($row['eventName'], 0, 35) . '..' : $row['eventName'];
                                            echo $eventName;
                                            ?>
                                        </span>
                                    </span>
                                    <span class="mdl-list__item-secondary-content">
                                        <span class="mdl-list__item-secondary-info">
                                            <input type="hidden" data-name="<?php echo $row['eventName'];?>" value="<?php if(isset($row['shortUrl'])){echo $row['shortUrl'];}else{echo $row['eventShareLink'];} ?>"/>
                                            <i class="my-pointer-item ic_me_share_icon pull-right event-share-icn event-card-share-btn"></i>
                                        </span>
                                    </span>
                                </li>
                            </ul>
                            <div class="comment my-event-status">
                                <span>
                                <?php
                                if($row['ifApproved'] == EVENT_DECLINED)
                                {
                                    ?>
                                    <i class="ic_me_info_icon info-icon"></i>&nbsp;&nbsp;Event Declined!<?php
                                }
                                elseif($row['ifApproved'] == EVENT_WAITING)
                                {
                                    ?>
                                    <i class="ic_me_info_icon info-icon"></i>&nbsp;&nbsp;Review In Progress...<?php
                                }
                                elseif($row['ifApproved'] == EVENT_APPROVED && $row['ifActive'] == ACTIVE)
                                {
                                    ?>
                                    <i class="ic_me_info_icon info-icon"></i>&nbsp;&nbsp;Event Approved!<?php
                                }
                                elseif($row['ifApproved'] == EVENT_APPROVED && $row['ifActive'] == NOT_ACTIVE)
                                {
                                    ?>
                                    <i class="ic_me_info_icon info-icon"></i>&nbsp;&nbsp;Event Approved But Not Active<?php
                                }
                                ?>
                                </span>
                            </div>
                            <div class="mdl-grid text-center">
                                <div class="mdl-cell--12-col eventDash-stats">
                                    <ul class="list-inline">
                                        <li>
                                            <h4 class="dashboard-stats">
                                                <?php
                                                if($row['costType'] == "1")
                                                {
                                                    ?>
                                                    Free
                                                    <?php
                                                }
                                                else
                                                {
                                                    $total = (int)$row['eventPrice'] * (int)$row['totalQuant'];
                                                    echo 'Rs. '.number_format($total);
                                                }
                                                ?>
                                            </h4>
                                            <span>Amount Collected</span>
                                        </li>
                                        <li>
                                            <div class="dash-spacer"></div>
                                        </li>
                                        <li>
                                            <h4 class="dashboard-stats">
                                                <?php
                                                if(isset($row['totalQuant']))
                                                {
                                                    echo $row['totalQuant'];
                                                }
                                                else
                                                {
                                                    echo '0';
                                                }
                                                ?>
                                            </h4>
                                            <span>People Attending</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <hr>
                            <div class="mdl-card__supporting-text">
                                <span>Signups</span>
                            </div>
                            <?php
                                if(isset($signupList) && myIsMultiArray($signupList))
                                {
                                    foreach($signupList as $signKey => $signRow)
                                    {
                                        $remain = (int)$signRow['quantity'] - 1;
                                        ?>
                                        <div class="demo-list-action mdl-list">
                                            <div class="mdl-list__item">
                                                <span class="mdl-list__item-primary-content">
                                                  <span><?php echo $signRow['firstName'].' '.$signRow['lastName'];?></span>
                                                    <?php
                                                    if($remain != 0)
                                                    {
                                                        ?>
                                                        <span class="mdl-chip mdl-list__item-avatar">
                                                                <span class="mdl-chip__text">+<?php echo $remain;?></span>
                                                            </span>
                                                        <?php
                                                    }
                                                    ?>
                                                </span>
                                                <a href="mailto:<?php echo $signRow['emailId'];?>" class="mdl-list__item-secondary-action">
                                                    <i class="ic_event_email_icon"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            ?>
                            <div class="mdl-card__actions mdl-card--border">
                                <?php
                                if(isset($row['isEventCancel']) && $row['isEventCancel'] == '1')
                                {
                                    ?>
                                    <i data-ignore-cache="true" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect event-bookNow" disabled>Edit Event</i>
                                    <i class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect pull-right" disabled>Cancellation in Review</i>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <a href="<?php echo 'eventEdit/'.$row['eventSlug'];?>" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect event-bookNow dynamic">Edit Event</a>
                                    <i class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect event-cancel-btn pull-right">Cancel Event</i>
                                    <?php
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    else
    {
        ?>
        <div class="page-content">
            Nothing Found
        </div>
        <?php
    }
?>