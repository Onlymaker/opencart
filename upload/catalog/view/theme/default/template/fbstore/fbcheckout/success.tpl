<?php echo $header; ?>
<div class="row">
    <?php $class = 'col-sm-12'; ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
        <div class="featured-header"><?php echo $heading_title; ?></div>
        <div class="featured-content">
            <?php echo $text_message; ?>
        </div>
        <div class="buttons">
            <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
        </div>
        <?php echo $content_bottom; ?>
    </div>
</div>
<?php echo $footer; ?>