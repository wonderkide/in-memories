<?php
use app\components\widgets\gallery2;
use app\components\widgets\memory2;
use app\components\widgets\videoJs;
use app\components\widgets\Footer;



?>
<section id="memory" class="page">

                <?php echo memory2::widget(['render'=>'index']); ?>

</section>
<section id="gallery" class="page-alternate">
                <?php echo gallery2::widget(['render'=>'index']); ?>
</section>

<section id="video" class="page">
                <?php echo videoJs::widget(['render'=>'index']); ?>
</section>

<section id="about-us" class="page-alternate">
    <div class="container">
    	<?= Footer::widget(); ?>
    </div>
</section>