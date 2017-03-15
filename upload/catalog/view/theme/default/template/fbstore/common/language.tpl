<?php if (count($languages) > 1) { ?>
<div class="language-mobile pull-left">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language">
        <div class="btn-group">
            <button class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                <?php foreach ($languages as $language) { ?>
                <?php if ($language['code'] == $code) { ?>
                <img src="<?php echo $language['flag_url']; ?>" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>">
                <?php } ?>
                <?php } ?>
                <span class="hidden-xs"><?php echo $text_language; ?></span> <i class="fa fa-caret-down caret-down-mobile"></i></button>
            <ul class="dropdown-menu dropdown-menu-pull-right">
                <?php foreach ($languages as $language) { ?>
                <li><button class="btn btn-link btn-block language-select" type="button" name="<?php echo $language['code']; ?>"><img src="<?php echo $language['flag_url'];  ?>" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></button></li>
                <?php } ?>
            </ul>
        </div>
        <input type="hidden" name="code" value="" />
        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
    </form>
</div>
<?php } ?>
