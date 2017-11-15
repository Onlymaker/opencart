<?php 
    $popup_name = $moduleNameSmall . '[PopupWindow]['.$popup['id'].']';
    $popup_data = isset($moduleData['PopupWindow'][$popup['id']]) ? $moduleData['PopupWindow'][$popup['id']] : array();
?>

<div id="popup_<?php echo $popup['id']; ?>" class="tab-pane popups" style="width:99%">
	 <ul class="nav nav-tabs">
	  <li class="active"><a data-toggle="tab" href="#popup_settings_<?php echo $popup['id'] ?>">Popup settings</a></li>
	  <li><a data-toggle="tab" href="#popup_appearance_<?php echo $popup['id'] ?>">Appearance</a></li>
	 </ul>

	<div class="tab-content">
	  <div id="popup_settings_<?php echo $popup['id'] ?>" class="tab-pane fade in active">
	    <?php require(DIR_APPLICATION.'view/template/' . $modulePath . '/tab_popup_settings.php'); ?>
	  </div>
	  <div id="popup_appearance_<?php echo $popup['id'] ?>" class="tab-pane fade in">
	   	<?php require(DIR_APPLICATION.'view/template/' . $modulePath . '/tab_popup_appearance.php'); ?>
	  </div>
</div>


    <?php if (isset($newAddition) && $newAddition==true) { ?>
		<script type="text/javascript">
            <?php foreach ($languages as $language) { ?>
               summernote_init( $('#message_<?php echo $popup['id']; ?>_<?php echo $language['language_id']; ?>') );
            <?php } ?>
        </script>
	<?php } ?>

	<script>

$(function() {
	selectorsForPopups(this);
});
	</script>
</div>
