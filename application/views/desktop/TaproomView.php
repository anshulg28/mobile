
<div class="page-content">
    <div class="content-block">
        <input type="hidden" value="<?php echo $taproomId;?>" id="taproom-Id"/>
        <?php
        if(isset($taproomInfo) && myIsMultiArray($taproomInfo))
        {
            ?>
            <div class="content-block-title">Now Playing</div>
            <div class="list-block media-list">
                <ul>
                    <?php
                    foreach($taproomInfo as $key => $row)
                    {
                        if($key == 'now_playing')
                        {
                            ?>
                            <li>
                                <a href="#" class="item-content color-black">
                                    <div class="item-media">
                                        <img class="album-thumb" src="<?php $url = preg_replace("/^http:/i", "https:", $row['albumartThumbnail']); echo $url;?>" width="80">
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            <div class="item-title"><?php echo $row['name'];?></div>
                                        </div>
                                        <div class="item-subtitle"><?php echo $row['artist'];?></div>
                                        <div class="item-text"><?php echo $row['album'];?></div>
                                    </div>
                                </a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="content-block-title">Queue</div>
        <?php
            if(isset($taproomInfo['request_queue']) && myIsMultiArray($taproomInfo['request_queue']))
            {
                ?>
                <div class="list-block media-list">
                    <ul>
                        <?php
                        foreach($taproomInfo as $key => $row)
                        {
                            if($key == 'request_queue')
                            {
                                foreach($row as $subKey => $subRow)
                                ?>
                                <li>
                                    <div class="item-content">
                                        <div class="item-media"><img class="queue-img-icon" src="<?php $url = preg_replace("/^http:/i", "https:", $subRow['albumartThumbnail']); echo $url;?>" width="44"></div>
                                        <div class="item-inner">
                                            <div class="item-title-row">
                                                <div class="item-title"><?php echo $subRow['name'];?></div>
                                                <div class="item-title color-gray"><?php echo $subRow['votes'];?></div>
                                            </div>
                                            <div class="item-subtitle">
                                                <?php echo $subRow['artist'];?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            <?php
            }
        }
        else
        {
            ?>
            <div class="content-block">
                Not Available!
            </div>
            <?php
        }
        ?>
    </div>
</div>
<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored music-request-btn">
    <i class="ic_request_music"></i>
    <!--<i class="fa fa-plus"></i>-->
</button>