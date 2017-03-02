<div class="content-block-title">What's happening this week</div>
<?php
if(isset($weekEvents) && myIsMultiArray($weekEvents))
{
    ?>
    <ul class="hide even-cal-list">
        <?php
        foreach($weekEvents as $key => $row)
        {
            if(isset($row['error']))
            {
                ?>
                <li data-evenDate="<?php echo $row['eventDate'];?>"
                    data-error="<?php echo $row['error'];?>">
                </li>
                <?php
            }
            else
            {
                ?>
                <li data-evenDate="<?php echo $row['eventDate'];?>"
                    data-evenNames="<?php echo $row['eventNames'];?>"
                    data-evenPlaces="<?php echo $row['eventPlaces'];?>"
                    data-evenUrls="<?php
                        $ids = explode(',',$row['eventIds']);
                        $urls = array();
                        foreach($ids as $subKey)
                        {
                            $urls[] = 'events/EV-'.$subKey.'/'.encrypt_data('EV-'.$subKey);
                        }
                        echo implode(',',$urls);
                    ?>">
                </li>
                <?php
            }
        }
        ?>
    </ul>
    <?php
}
?>
<div id='calendar-glance'></div>