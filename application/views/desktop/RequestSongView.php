<script src="https://apis.google.com/js/platform.js?onload=renderButton"></script>

<div class="page-content">
<?php
if(isset($status) && $status === true)
{
    if(isset($tapSongs) && myIsMultiArray($tapSongs))
    {
        $songs = json_decode($tapSongs[0]['tapSongs'],true);
        ?>
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored pull-right" id="juke-logout">
            Logout
        </button>
        <div class="list-block media-list clear">
            <ul class="demo-list-two mdl-list">
                <?php
                foreach($songs[0] as $key => $row)
                {

                    ?>
                    <li class="mdl-list__item mdl-list__item--two-line demo-card-square mdl-shadow--2dp request_song_btn" data-songId="<?php echo $row['id'];?>"
                        data-tapId="<?php echo $tapId;?>">
                        <span class="mdl-list__item-primary-content">
                            <?php
                                if($row['albumartThumbnail'] == '')
                                {
                                    ?>
                                    <i class="fa fa-music music-placeholder mdl-list__item-avatar"></i>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <img class="queue-img-icon mdl-list__item-avatar" src="<?php $url = preg_replace("/^http:/i", "https:", $row['albumartThumbnail']); echo $url;?>" width="44"/>
                                    <?php
                                }
                            ?>
                            <span>
                                <?php
                                $truncated_RestaurantName = (strlen($row['name']) > 30) ? substr($row['name'], 0, 30) . '..' : $row['name'];
                                echo $truncated_RestaurantName;
                                ?>
                            </span>
                            <span class="mdl-list__item-sub-title"><?php echo $row['artist'];?></span>
                        </span>
                        <span class="mdl-list__item-secondary-content">
                            <i class="fa fa-plus"></i>
                        </span>
                    </li>
                    <?php
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
    <div class="content-block" id="jukebox-login-form">
        <div class="demo-card-square mdl-shadow--2dp text-center">
            <div class="mdl-custom-login-title">
                <h2 class="mdl-card__title-text">Login/Signup</h2>
            </div>
            <div class="mdl-card__supporting-text">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="email" name="email">
                    <label class="mdl-textfield__label" for="email">Email</label>
                </div>
                <br>
                <button type="button" id="jukebox-login-btn" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    Submit
                </button>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <div class="text-center my-marginTopBottom">OR</div>
                <div class="fb-login-button" data-max-rows="1" data-size="large" onlogin="checkLoginState();"
                     data-show-faces="false" data-auto-logout-link="false" data-scope="email"></div>
                <div id="my-signin2"></div>
            </div>

        </div>
    </div>
    <?php
}
?>
</div>
