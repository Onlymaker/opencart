<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
	
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
	<?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
	<div class="panel panel-default">
    <div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
    <div class="panel-body">
      <form class="form-horizontal" action="<?php echo $restore; ?>" method="post" enctype="multipart/form-data" id="restore">
		  <div class="row">
            <div class="col-sm-6">
		<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_category; ?></label>
			<div class="col-sm-8">
				 <select class="form-control" name="category">
				 <option value=""><?php echo $text_all_category?></option>
				 <?php foreach($categories as $cat){?>
				 <option value="<?php echo $cat['category_id']?>"><?php echo $cat['name']?></option>
				 <?php } ?>
				 </select>
			</div>
			</div>
			<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_manufature; ?></label>
			<div class="col-sm-8">
				  <select  class="form-control" name="manufacturer_id">
				 <option value=""><?php echo $text_all_manufacturer?></option>
				 <?php foreach($manufacturers as $manufacturer){?>
				 <option value="<?php echo $manufacturer['manufacturer_id']?>"><?php echo $manufacturer['name']?></option>
				 <?php } ?>
				 </select>
				</div>
			</div>
			<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_stores; ?></label>
			<div class="col-sm-8">
				  <select name="store_id" class="form-control" >
				 <option value=""><?php echo $text_all_stores?></option>
				 <?php foreach($stores as $store){?>
				 <option value="<?php echo $store['store_id']?>"><?php echo $store['name']?></option>
				 <?php } ?>
				 </select>
				</div>
			</div>
			
			<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_stock_status; ?></label>
			<div class="col-sm-8">
				 <select name="stock_status_id"  class="form-control" >
		 <option value=""><?php echo $text_all_stockstatus?></option>
		 <?php foreach($stock_statuss as $stock_status){?>
		 <option value="<?php echo $stock_status['stock_status_id']?>"><?php echo $stock_status['name']?></option>
		 <?php } ?>
		 </select>
				</div>
			</div>
			
			<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_status; ?></label>
			<div class="col-sm-8">
				  <select name="status" class="form-control">
			<option value=""><?php echo $text_all_status?></option>
			<option value="1"><?php echo $text_enabled?></option>
			<option value="2"><?php echo $text_disabled?></option>
			
			</select>
				</div>
			</div>
			
			<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_language; ?></label>
			<div class="col-sm-8">
				<select name="language_id" class="form-control">
			 <?php foreach($languages as $language){?>
			 <option value="<?php echo $language['language_id']?>"><?php echo $language['name']?></option>
			 <?php } ?>
			 </select>
				</div>
			</div>
			
				
				<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_review; ?></label>
			<div class="col-sm-8">
				<select name="productreview" class="form-control">
				<option value="0"><?php echo $text_no?></option>
				<option value="1"><?php echo $text_yes?></option>
				
			 </select>
			</div>
			</div>
			<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_extrafiled; ?></label>
			<div class="col-sm-8" style="padding-left:0px" >
				<?php if(isset($cfiled)) { foreach($cfiled as $filed) { ?> <label class="col-sm-6 control-label" style="text-align:left"><input type="checkbox" value="<?php echo $filed;?>" name="cfiled[]">  <?php echo $filed?></label> <?php } } else { ?> 
				No custome filed present
				<?php }?>
			</div>
			</div>
			
			
		</div>
		 <div class="col-sm-6">
			
			
			
			
			
				<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_producturl; ?></label>
			<div class="col-sm-8">
				<select name="productimage" class="form-control">
				<option value="0"><?php echo $text_no?></option>
				<option value="1"><?php echo $text_yes?></option>
				
			 </select>
			</div>
			</div>
			<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_quantity; ?></label>
			<div class="col-sm-8">
				 <input name="quantity" value=""  class="form-control" >
				</div>
			</div>
			<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_productname; ?></label>
			<div class="col-sm-8">
				 <input name="productname" value=""  class="form-control" >
				</div>
			</div>
			
			
			<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_model; ?></label>
			<div class="col-sm-8">
				 <input name="model" value=""  class="form-control" >
				</div>
			</div>
			<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_number; ?></label>
			<div class="col-sm-8" style="padding-left:0px">
				<div class="col-xs-6">
				<input name="number" value="<?php echo $number?>" class="form-control input-sm">  
				</div>
				<div class="col-xs-6" >
				<input name="end" value="<?php echo $end?>" class="form-control input-sm " >
				</div>
				</div>
			</div>
			<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_price; ?></label>
			<div class="col-sm-8" style="padding-left:0px">
				<div class="col-xs-6">
				<input name="price" value="" class="form-control input-sm"> 
				</div>
				<div class="col-xs-6">
				<input name="price1" value="" class="form-control input-sm " >
				</div>
				</div>
			</div>
			<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_type; ?></label>
			<div class="col-sm-8">
				<select name="format" class="form-control">
				<option value="xls" selected>xls</option>
				<option value="xlsx">xlsx</option>
				<option value="csv">csv</option>
				<option value="xml">XML</option>
				
			 </select>
				</div>
			</div>
			
			<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $entry_exportxls; ?></label>
			<div class="col-sm-8">
				<input type="submit" class="btn btn-primary" value="<?php echo $button_export; ?>">
			</div>
		</div>
		 </div>
		 
		
		
		
      </form>
    </div>
  </div>
</div>
 <script type="text/javascript"><!--
$('input[name=\'productname\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'productname\']').val(item['label']);
	}
});

$('input[name=\'model\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['model'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'model\']').val(item['label']);
	}
});
//--></script>
<?php echo $footer; ?>