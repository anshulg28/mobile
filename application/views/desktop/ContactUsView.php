
<div class="page-content">
    <div class="content-block event-wrapper">
        <?php
        if(isset($locData) && myIsMultiArray($locData))
        {
            foreach($locData as $key => $row)
            {
                if(isset($row['viewFrame']))
                {
                    ?>
                    <div class="card">
                        <div class="row no-gutter">
                            <div class="col-100">
                                <?php echo $row['viewFrame'];?>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-content-inner">
                                <div class="comment clear">
                                    <p>
                                        <?php echo $row['locName'];?> Taproom
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="tel:<?php echo $row['phoneNumber']; ?>" class="external link">
                                <span class="ic_event_contact_icon point-item"></span> Call
                            </a>
                            <a href="<?php echo $row['mapLink'];?>" class="external link" target="_blank">
                                <i class="ic_me_location_icon point-item"></i>
                                Get Directions
                            </a>
                        </div>
                    </div>
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