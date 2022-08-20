<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('content'); ?>
    
    <div class="site-section-cover overlay" style="background-image: url('<?= ROOT ?>app/public/site/images/hero_bg.jpg');">
        
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1>
                        <strong>404: Not Found!</strong>
                    </h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 blog-content">
                    <p class="lead"><h2 style="text-align: center">Article you're looking for is not found!</h2></p>
                </div>
            </div>
        </div>
    </div>

<?php $this->end(); ?>