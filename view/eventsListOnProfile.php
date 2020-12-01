<?php 
if (isset($events)): 
    foreach ($events as $event): ?>
        <div class="eventItem">
            <div class="title"><?= $event->name; ?></div>
            <div class="content">
                <div class="imgContainer">
                    <img src="./private/event/<?=$event->imageName;?>" alt="event image">
                </div>
                <div class="rightContainer">
                    <div class="date"><?= $event->eventDate; ?></div>
                    <div class="host">Hosted by <?= $event->hostName; ?></div>
                </div>
            </div>
            <input type="hidden" class="eventId" value="<?=$event->id;?>">
        </div>
<?php 
    endforeach; 
else :     
    echo "<div class='noEvents'>There are no events.</div>";
endif; 
?>