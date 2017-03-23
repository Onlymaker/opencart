<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-banner" <?php if(!$isOwner && $ModuleEdit) echo 'disabled' ?> data-toggle="tooltip" title="<?php echo $button_save; ?>" class="save-changes btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php echo (empty($moduleData['LicensedOn'])) ? base64_decode('ICAgIDxkaXYgY2xhc3M9ImFsZXJ0IGFsZXJ0LWRhbmdlciBmYWRlIGluIj4NCiAgICAgICAgPGJ1dHRvbiB0eXBlPSJidXR0b24iIGNsYXNzPSJjbG9zZSIgZGF0YS1kaXNtaXNzPSJhbGVydCIgYXJpYS1oaWRkZW49InRydWUiPsOXPC9idXR0b24+DQogICAgICAgIDxoND5XYXJuaW5nISBVbmxpY2Vuc2VkIHZlcnNpb24gb2YgdGhlIG1vZHVsZSE8L2g0Pg0KICAgICAgICA8cD5Zb3UgYXJlIHJ1bm5pbmcgYW4gdW5saWNlbnNlZCB2ZXJzaW9uIG9mIHRoaXMgbW9kdWxlISBZb3UgbmVlZCB0byBlbnRlciB5b3VyIGxpY2Vuc2UgY29kZSB0byBlbnN1cmUgcHJvcGVyIGZ1bmN0aW9uaW5nLCBhY2Nlc3MgdG8gc3VwcG9ydCBhbmQgdXBkYXRlcy48L3A+PGRpdiBzdHlsZT0iaGVpZ2h0OjVweDsiPjwvZGl2Pg0KICAgICAgICA8YSBjbGFzcz0iYnRuIGJ0bi1kYW5nZXIiIGhyZWY9ImphdmFzY3JpcHQ6dm9pZCgwKSIgb25jbGljaz0iJCgnYVtocmVmPSNpc2Vuc2Vfc3VwcG9ydF0nKS50cmlnZ2VyKCdjbGljaycpIj5FbnRlciB5b3VyIGxpY2Vuc2UgY29kZTwvYT4NCiAgICA8L2Rpdj4=') : '' ?>
            <?php
              if (!function_exists('modification_vqmod')) {
                function modification_vqmod($file) {
                  if (class_exists('VQMod')) {
                    return VQMod::modCheck(modification($file), $file);
                  } else {
                    return modification($file);
                  }
                }
              }
            ?>


    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check_circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
        <?php if(!$ModuleEdit) { ?>
          <div class="storeSwitcherWidget">
            <div class="form-group">
                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-pushpin"></span>&nbsp;<?php echo $store['name']; if($store['store_id'] == 0) echo " <strong>".$text_default."</strong>"; ?>&nbsp;<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                <ul class="dropdown-menu" role="menu">
                    <?php foreach ($stores as $st) { ?>
                          <li><a href="index.php?route=module/<?php echo $moduleNameSmall; ?><?php echo $module_id; ?>&store_id=<?php echo $st['store_id'];?>&token=<?php echo $token; ?>"><?php echo $st['name']; ?></a></li>
                    <?php } ?> 
                </ul>
            </div>
          </div>
          <?php } ?>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>&store_id=<?php echo $store['store_id']; ?>" method="post" enctype="multipart/form-data" id="form-fbstore" class="form-horizontal">
                <input type="hidden" name="access_token" value="<?php echo $access_token; ?>">
                 <input type="hidden" name="store_id" value="<?php echo $store['store_id']; ?>">
          <div class="tabbable">
              <div class="tab-navigation form-inline">
                  <ul class="nav nav-tabs mainMenuTabs" id="mainTabs">
                      <li class="active"><a href="#controlpanel" role="tab" data-toggle="tab">&nbsp;Control Panel</a></li>
                      <li><a href="#isense_support" role="tab" data-toggle="tab">&nbsp;Support</a></li>
                  </ul>
                </div>
          </div>

          <div class="tab-content">
            <div id="controlpanel" class="tab-pane active">

              <?php if($isOwner || !$ModuleEdit) { ?>


          <div class="form-group">
            <div class="col-sm-2">
              <h5 class="" for="email"><strong><?php echo $entry_name; ?></strong></h5>
              <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Set the name of the FacebookStore module.</span>
            </div>
            <div class="col-sm-5">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div> 
       
        <div class="form-group">
            <div class="col-sm-2">
              <h5><strong><?php echo $entry_chooseapage; ?></strong></h5>
              <span class="help"><i class="fa fa-info-circle"></i>&nbsp; This is a list of all your Facebook pages. Select which one to apply a FacebookStore to.</span>
            </div>
            <div class="col-sm-5">
            <?php if($ModuleEdit) { ?>
              <?php foreach ($pages as $facebookpage) { ?>
                  <?php if(strpos($selectedPage, $facebookpage['id']) !== false) { ?>
                    <div class="well well-sm"><?php echo $facebookpage['name']; ?> </div>
                    <input name='selectedPage' type="hidden" value="<?php echo $facebookpage['id']; ?>||<?php echo $facebookpage['access_token']; ?>" >
                  <?php } 
                    } 
                  } else { ?>
                    <select name='selectedPage' id="toPage" class="form-control">
                    <?php foreach ($pages as $facebookpage) { ?>
                      <option id='choosepage' value="<?php echo $facebookpage['id']; ?>||<?php echo $facebookpage['access_token']; ?>">
                       <?php echo $facebookpage['name']; ?>                               
                      </option>
                    <?php } ?>
                    </select>
              <?php } ?>
            </div>

          </div>
          

          <div class="form-group">
            <div class="col-sm-2">
              <h5><strong><?php echo $entry_tabname; ?></strong></h5>
              <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Set the name for the tab of your Facebook page.</span>
            </div>
            <div class="col-sm-5">
              <input type="text" value="<?php echo isset($tab['name']) ? $tab['name'] : ''; ?>" placeholder="Store" name="page-name" id="page-name" class="form-control" />
              <?php if ($error_page_name) { ?>
              <div class="text-danger"><?php echo $error_page_name; ?></div>
              <?php } ?>
            </div>
            <?php if(isset($tab['link'])) { ?>
              <div class="col-sm-4">
                <a href='<?php echo $tab['link']; ?>' target="_blank" class="btn btn-primary">View your Facebook store</a>
              </div>
            <?php } ?>
          </div>

          
          <?php if($ModuleEdit) { ?>
          <div class="form-group">

            <div class="col-sm-2">
              <h5><strong><?php echo $entry_position; ?></strong></h5>
              <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Set the position of your FacebookStore tab in your Facebook page.</span>
            </div>
            <div class="col-sm-5">
                <select name='position' class="form-control">
                <?php $max_position =  isset($tab['max_position']) ? $tab['max_position'] : '1';
                      $current_tab =  isset($tab['position']) ? $tab['position'] : false;
                 ?>
                  <?php for ($i=3; $i <= $max_position; $i++) { ?>
                    <option <?php echo ($current_tab == $i) ? 'selected' : ''  ?> value="<?php echo $i; ?>">
                     <?php echo $i; ?>                               
                    </option>
                 <?php } ?>                
                </select>
            </div>
          </div> 
            <div class="form-group">

                <div class="col-sm-2">
                    <h5><strong><span data-toggle="tooltip" title="Select Categories">Categories to show:</span></strong></h5>
                    <span class="help"><i class="fa fa-info-circle"></i>&nbsp; Select the categories you want to display on your FacebookStore.If left empty, all categories will be available on your store.</span>
                </div>
                <div class="col-sm-5">
                  <input type="text" name="category" value="" placeholder="Enter category" id="input-category" class="form-control" />
                  <div id="product-category" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($categories as $id => $name) { ?>
                    <div id="product-category<?php echo $id; ?>"><i class="fa fa-minus-circle"></i> <?php echo $name; ?>
                      <input type="hidden" name="categories[<?php echo $id; ?>]" value="<?php echo $name; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
            </div>

      <div class="form-group">
       <div class="col-sm-2">
          <h5><strong>Product limit on page:</strong></h5>
          <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Choose the number of products to be shown on each category page.</span>
       </div>
       <div class="col-sm-5">
              <input type="number" min="3" step="3" class="form-control" name="limit" value="<?php if (isset($limit)) echo $limit; else echo '9' ; ?>" />
       </div>
    </div>
    <div class="form-group">
      <div class="col-sm-2">
        <h5><strong>Product image width:</strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Set the product image width.</span>
      </div>
      <div class="col-sm-5">
        <div class="input-group"> 
          <input type="number" name="imageWidth" value="<?php if (isset($imageWidth)) echo $imageWidth; else echo '150'; ?>" min="0.00" step="1.00" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control number" />
          <span class="input-group-addon">px</span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-2">
        <h5><strong>Product image height:</strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Set the product image height.</span>
      </div>
      <div class="col-sm-5">
        <div class="input-group"> 
          <input type="number" name="imageHeight" value="<?php if (isset($imageHeight)) echo $imageHeight; else echo '150'; ?>" min="0.00" step="1.00" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control number" />
          <span class="input-group-addon">px</span>
        </div>
      </div>
    </div>

            <?php } ?>


                <?php } else { ?>
                  <h3>You are not Adminitrator of this page! Create a new module or contact the addministrator!</h3>
                <?php  } ?>
          </div>


          <div id="isense_support" class="tab-pane"><?php require_once modification_vqmod(DIR_APPLICATION.'view/template/'.$modulePath.'/support.tpl'); ?></div>

          </form>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

$('input[name=\'category\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'category\']').val('');

    $('#product-category' + item['value']).remove();

    $('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="categories['+ item['value'] +']" value="' + item['label'] + '" /></div>');
  }
});

$('#product-category').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});


$('#addTabToPage').click(function (e) {
  e.preventDefault();
  if($('#page-name').val() !== ''){
      
      if($('#page-name').parent().find('div.text-danger').length){
          $('#page-name').parent().find('div.text-danger').text('');
      }

      $.ajax({
        url: "index.php?route=module/fbstore/addtab&token=<?php echo $token; ?>",
        type: "post",
        data: {page_data: $('#toPage').val() ,
                page_name: $('#page-name').val() } ,
        success: function (response) {
           console.log(response);
           location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }

    

    });

} else {
  if($('#page-name').parent().find('div.text-danger').length){
    $('#page-name').parent().find('div.text-danger').text('You must choose a page name!');
  } else {
    $('#page-name').parent().append('<div class="text-danger">You must choose a page name!</div>');
  }
  
}

});

</script>


<?php echo $footer; ?>