<?php echo $header; ?>
  <div class="row">
    <?php $class = 'col-sm-12'; ?>
    <div id="content" class="<?php echo $class; ?>">
      <div class="space-thirty"></div>
      <div class="featured-header"><?php echo $heading_title; ?></div>
      <div class="featured-content"><?php echo $text_error; ?></div>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
</div>
<?php echo $footer; ?>