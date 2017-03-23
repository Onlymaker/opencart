<?php echo $header; ?><?php echo $content_top; ?>
<div id='notification'></div>
<ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
</ul>
<div class="featured-header"><?php echo $heading_title; ?></div>
<div class="featured-content">
    <div class="row">
        <div class="col-sm-7">
            <?php if ($thumb || $images) { ?>
            <ul class="thumbnails">
                <?php if ($thumb) { ?>
                <li><a class="thumbnail" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
                <?php } ?>
                <?php if ($images) { ?>
                <?php foreach ($images as $image) { ?>
                <li class="image-additional"><a class="thumbnail" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"> <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
                <?php } ?>
                <?php } ?>
            </ul>
            <?php } ?>
        </div>
        <div class="col-sm-5">
            <?php if ($price) { ?>
            <?php if (!$special) { ?>
            <h2 class="product-price"><?php echo $price; ?></h2>
            <?php } else { ?>
            <h2 class="product-price"><span style="color: #c0392b;"><?php echo $special; ?></span><span style="text-decoration: line-through; font-size: 13px; margin-left: 8px; color: #999;"><?php echo $price; ?></span></h2>
            <?php } ?>
            <?php if ($tax) { ?>
            <span style="color: #90949c; display: inline-block; margin-bottom: 10px;"><strong><?php echo $text_tax; ?> <?php echo $tax; ?></strong></span>
            <?php } ?>
            <?php } ?>
            <ul class="list-unstyled product-short-information">
                <?php if ($manufacturer) { ?>
                <li><?php echo $text_manufacturer; ?> <?php echo $manufacturer; ?></li>
                <?php } ?>
                <li><?php echo $text_model; ?> <?php echo $model; ?></li>
                <?php if ($reward) { ?>
                <li><?php echo $text_reward; ?> <?php echo $reward; ?></li>
                <?php } ?>
                <li><?php echo $text_stock; ?> <?php echo $stock; ?></li>
            </ul>
            <!-- Start Options -->
            <div id="product">
                <?php if ($options) { ?>
                <hr>
                <?php foreach ($options as $option) { ?>
                <?php if ($option['type'] == 'select') { ?>
                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                    <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
                        <option value=""><?php echo $text_select; ?></option>
                        <?php foreach ($option['product_option_value'] as $option_value) { ?>
                        <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                            <?php if ($option_value['price']) { ?>
                            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                            <?php } ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <?php } ?>
                <?php if ($option['type'] == 'radio') { ?>
                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label"><?php echo $option['name']; ?></label>
                    <div id="input-option<?php echo $option['product_option_id']; ?>">
                        <?php foreach ($option['product_option_value'] as $option_value) { ?>
                        <div class="radio">
                            <label>
                                <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                                <?php echo $option_value['name']; ?>
                                <?php if ($option_value['price']) { ?>
                                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                <?php } ?>
                            </label>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
                <?php if ($option['type'] == 'checkbox') { ?>
                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label"><?php echo $option['name']; ?></label>
                    <div id="input-option<?php echo $option['product_option_id']; ?>">
                        <?php foreach ($option['product_option_value'] as $option_value) { ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                                <?php if ($option_value['image']) { ?>
                                <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> 
                                <?php } ?>
                                <?php echo $option_value['name']; ?>
                                <?php if ($option_value['price']) { ?>
                                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                <?php } ?>
                            </label>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
                <?php if ($option['type'] == 'image') { ?>
                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label"><?php echo $option['name']; ?></label>
                    <div id="input-option<?php echo $option['product_option_id']; ?>">
                        <?php foreach ($option['product_option_value'] as $option_value) { ?>
                        <div class="radio">
                            <label>
                                <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                                <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> <?php echo $option_value['name']; ?>
                                <?php if ($option_value['price']) { ?>
                                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                <?php } ?>
                            </label>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
                <?php if ($option['type'] == 'text') { ?>
                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                </div>
                <?php } ?>
                <?php if ($option['type'] == 'textarea') { ?>
                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                    <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
                </div>
                <?php } ?>
                <?php if ($option['type'] == 'file') { ?>
                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label"><?php echo $option['name']; ?></label>
                    <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                    <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
                </div>
                <?php } ?>
                <?php if ($option['type'] == 'date') { ?>
                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                    <div class="input-group date">
                        <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                        </span></div>
                </div>
                <?php } ?>
                <?php if ($option['type'] == 'datetime') { ?>
                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                    <div class="input-group datetime">
                        <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                        </span></div>
                </div>
                <?php } ?>
                <?php if ($option['type'] == 'time') { ?>
                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                    <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                    <div class="input-group time">
                        <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                        </span></div>
                </div>
                <?php } ?>
                <?php } ?>
                <?php } ?>
            
                <!-- END Options -->
                <hr> 
                <div class="form-group">
                    <label class="control-label" for="input-quantity"><?php echo $entry_qty; ?></label>
                    <input type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="form-control" />
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                    <br />
                    <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block"><?php echo $button_cart; ?></button>
                </div>
            </div>
            <hr>
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style" data-url="<?php echo $share; ?>"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a></div>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
        </div>
    </div>    
</div>
<div class="product-tabs">
    <ul class="nav nav-tabs navs">
        <li class="active"><a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?></a></li>
        <?php if ($attribute_groups) { ?>
        <li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
        <?php } ?>
    </ul>
    <div class="featured-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-description"><?php echo $description; ?></div>
                    <?php if ($attribute_groups) { ?>
                    <div class="tab-pane" id="tab-specification">
                        <table class="table table-bordered">
                            <?php foreach ($attribute_groups as $attribute_group) { ?>
                            <thead>
                                <tr>
                                    <td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                                <tr>
                                    <td><?php echo $attribute['name']; ?></td>
                                    <td><?php echo $attribute['text']; ?></td>
                                </tr>   
                                <?php } ?>
                            </tbody>
                            <?php } ?>
                        </table>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>   
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#button-cart').on('click', function () {
            $.ajax({
                url: 'index.php?route=fbstore/fbcheckout/cart/add',
                type: 'post',
                data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea, input[name=\'product_id\'], input[name=\'quantity\']'),
                dataType: 'json',
                beforeSend: function () {
                    $('#button-cart').button('loading');
                },
                complete: function () {
                    $('#button-cart').button('reset');
                },
                success: function (json) {
                    $('.alert, .text-danger').remove();
                    $('.form-group').removeClass('has-error');
                    if (json['error']) {
                        $('html, body').animate({scrollTop: 200}, 'slow');
                        if (json['error']['option']) {
                            for (i in json['error']['option']) {
                                var element = $('#input-option' + i.replace('_', '-'));

                                if (element.parent().hasClass('input-group')) {
                                    element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                                } else {
                                    element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                                }
                            }
                        }

                        if (json['error']['recurring']) {
                            $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
                        }

                        // Highlight any found errors
                        $('.text-danger').parent().addClass('has-error');
                    }

                    if (json['success']) {
                        $('div#notification').append('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                        $('#cart button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');

                        //$('html, body').animate({scrollTop: 0}, 'slow');

                        //$('#cart > ul').load('index.php?route=common/cart/info ul li');
                    }
                    
                    var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );
                        
                    if(iOS) {
                        $('body, html', parent.document).animate({ scrollTop: 0 },"slow");
                    } else {
                        $('html, body').animate({scrollTop: 0}, 'slow');
                    }
                        
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });

    });

    $('button[id^=\'button-upload\']').on('click', function() {
    var node = this;

    $('#form-upload').remove();

    $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

    $('#form-upload input[name=\'file\']').trigger('click');

    if (typeof timer != 'undefined') {
        clearInterval(timer);
    }

    timer = setInterval(function() {
        if ($('#form-upload input[name=\'file\']').val() != '') {
            clearInterval(timer);

            $.ajax({
                url: 'index.php?route=tool/upload',
                type: 'post',
                dataType: 'json',
                data: new FormData($('#form-upload')[0]),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(node).button('loading');
                },
                complete: function() {
                    $(node).button('reset');
                },
                success: function(json) {
                    $('.text-danger').remove();

                    if (json['error']) {
                        $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
                    }

                    if (json['success']) {
                        alert(json['success']);

                        $(node).parent().find('input').attr('value', json['code']);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }, 500);
});


    $('.date').datetimepicker({
        pickTime: false
    });

    $('.datetime').datetimepicker({
        pickDate: true,
        pickTime: true
    });

    $('.time').datetimepicker({
        pickDate: false
    });


    $(document).ready(function () {
        $('.thumbnail').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    });
</script>
<?php echo $content_bottom; ?>
<?php echo $footer; ?>