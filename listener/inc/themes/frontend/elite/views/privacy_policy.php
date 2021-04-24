<?php include 'h-elite.php'?>
<div class="main-content">
    <div class="bg-info w-100 h-76"></div>

    <section class="section-terms" style="padding-top: 130px; margin-bottom: 80px;">
        <div class="container">
            <?php _e( htmlspecialchars_decode(get_option('privacy_policy', ''), ENT_QUOTES) , false)?>
        </div>
    </section>
</div>

<?php include 'f-elite.php'?>