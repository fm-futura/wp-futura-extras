<div class="futura-tags font-bebas">
    <?php
    foreach ($tags as $tag => $link) {
    ?>
        <span class="futura-tag">
            #
            <a href="<?php echo $link; ?>">
                <?php echo $tag; ?>
            </a>
        </span>
    <?php
    }
    ?>
</div>
