<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
		<a class="btn btn-primary" onclick="$('#import').submit();" class="button"><?php echo $button_import; ?></a>
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
      <form action="<?php echo $import; ?>" method="post" enctype="multipart/form-data" id="import">
        <div class="form-group col-sm-12">
			<label class="col-sm-4 control-label"><?php echo $entry_import; ?></label>
            <div class="col-sm-8"><input type="file" name="import" /></div>
        </div>
		
		<div class="form-group col-sm-12">
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
			<div class="form-group col-sm-12">
			<label class="col-sm-4 control-label"><?php echo $entry_language; ?></label>
			<div class="col-sm-8">
				<select name="language_id" class="form-control">
			 <?php foreach($languages as $language){?>
			 <option value="<?php echo $language['language_id']?>"><?php echo $language['name']?></option>
			 <?php } ?>
			 </select>
				</div>
			</div>
			<div class="form-group col-sm-12">
			<label class="col-sm-4 control-label"><?php echo $entry_importby; ?></label>
			<div class="col-sm-8">
				<select name="importby" class="form-control">
				<option value="1"><?php echo $entry_productid?></option>
			 <option value="2"><?php echo $entry_model?></option>
			
			 </select>
				</div>
			</div>
			<div class="form-group col-sm-12">
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
			<div class="form-group  col-sm-12">
			<label class="col-sm-4 control-label"><?php echo $entry_extrafiled; ?></label>
			<div class="col-sm-8" style="padding-left:0px" >
				<?php if(!empty($cfiled)) { foreach($cfiled as $filed) { ?> <label class="col-sm-6 control-label" style="text-align:left"><input type="text" name="<?php echo $filed;?>" class="form-control" placeholder="<?php echo $filed;?> excel filed name"></label> <?php } } else { ?> 
				No custome filed present
				<?php }?>
			</div>
			</div>
      </form>
      
    </div>
  </div>
  </div>
</div>
<?php echo $footer; ?>