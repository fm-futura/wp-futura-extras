<?php
ob_start();
?>
<div preload="none" class="audioPlayer <?php echo $a['color']; ?> <?php if($a['type']==''){echo 'medium';}else{echo $a['type'];}?>" data-audio-mp3="<?php echo $a['mp3']; ?>" data-audio-ogg="<?php echo $a['ogg']; ?>">

    <div class="mdi-container play">
        <a href="" class="mdi control-play  tdc-font-fa tdc-font-fa-play-circle"> </a>
        <a href="" class="mdi control-pause tdc-font-fa tdc-font-fa-pause-circle"></a>
    </div>

    <div class="controls_container track">
        <input type="range" class="trackRange" value="0" max="100"/>
    </div>

    <div class="controls_container volumen">
        <div class="mdi-container">
            <a href="" class="mdi mdi-volume-high"></a>
            <a href="" class="mdi mdi-volume-off"></a>
        </div>
        <div class="input_container">
            <input type="range" class="volumeRange" value="50" max="100">
        </div>
    </div>

    <div class="mdi-container download">
        <a href="<?php echo $a['mp3']; ?>" download class="mdi tdc-font-fa tdc-font-fa-download"></a>
    </div>
</div>
<div class="clearfix"></div>

