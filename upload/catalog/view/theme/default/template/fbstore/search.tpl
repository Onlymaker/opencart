<?php echo $header; ?><?php echo $content_top; ?>
<div id='notification'></div>
<ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
</ul>
<?php if(isset($products) && $products) { ?>
<div class="featured-header"><?php echo $text_search_criteria; ?>: <?php echo $search; ?></div>
<div class="featured-content">
    <?php foreach (array_chunk($products, 3) as $products) { ?> 
    <div class="row">
        <?php foreach ($products as $product) { ?>
        <div class="product-layout col-xs-12 col-sm-4">
            <div class="product-thumb transition">
                <div class="image"><a data-product-id="<?php echo $product['product_id']; ?>" href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
                <div class="caption">
                    <h4><a data-product-id="<?php echo $product['product_id']; ?>" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                    <?php if ($product['rating']) { ?>
                    <div class="rating">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <?php if ($product['rating'] < $i) { ?>
                        <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                        <?php } else { ?>
                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                        <?php } ?>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <?php if ($product['price']) { ?>
                    <p class="price">
                        <?php if (!$product['special']) { ?>
                        <?php echo $product['price']; ?>
                        <?php } else { ?>
                        <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                        <?php } ?>
                    </p>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
    <div class="row">
        <?php if($pagination) { ?>
        <div class="col-xs-12">
            <?php echo $pagination; ?>
        </div>
    <?php } ?>
    </div>
</div>
<?php } ?>

<?php if(!$categories && !$products) { ?>
<div class="col-sm-12">
    <div class="featured-header">
        <?php echo $text_error_head; ?>
    </div>
    <div class="featured-content"><?php echo $text_empty; ?></div>
</div>
<?php } ?> 
<?php echo $content_top; ?>
<?php echo $footer; ?>