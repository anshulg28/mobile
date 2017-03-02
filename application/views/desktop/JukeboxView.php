 <div class="page-content">
    <div class="content-block">
        <?php
        if(isset($taprooms) && myIsMultiArray($taprooms))
        {
            foreach($taprooms as $key => $row)
            {
                if(isset($row['id']) && $row['is_online'] === true)
                {
                    ?>
                    <a href="taprom/<?php echo $row['id'];?>" class="taproom-btn dynamic">
                        <div class="card">
                            <div class="row no-gutter">
                                <div class="col-100">
                                    <img src="<?php $url = preg_replace("/^http:/i", "https:", $row['app_image_thumb']); echo $url;?>" alt="<?php echo $row['name'];?>"
                                         class="taproom-img"/>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-content-inner">
                                    <div class="comment clear">
                                        <p>
                                            <?php echo $row['name'];?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php
                }
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