<?php echo $header; ?><?php echo $content_top; ?>
<div id='notification'></div>
<?php if($breadcrumbs) { ?>
<ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
</ul>
<?php } ?>
<?php if($categories) { ?>
<div class="featured-header"><?php echo $text_categories_header; ?></div>
<div class="featured-content">
    <?php foreach (array_chunk($categories, 3) as $categories) { ?> 
    <div class="row">
        <?php foreach ($categories as $cat) { ?>
        <div class="product-layout category-layout col-xs-12 col-sm-4">
            <div class="product-thumb transition">
                <div class="image"><a data-product-id="<?php echo $cat['category_id']; ?>" href="<?php echo $cat['href']; ?>"><img src="<?php echo $cat['thumb']; ?>" alt="<?php echo $cat['name']; ?>" title="<?php echo $cat['name']; ?>" class="img-responsive" /></a>
                </div>
                <div class="caption">
                    <h4><a data-product-id="<?php echo $cat['category_id']; ?>" href="<?php echo $cat['href']; ?>"><?php echo $cat['name']; ?></a></h4> 
                    <span><?php echo $cat['total']; ?> <?php echo $text_cat_total_products; ?></span>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>  
    <?php } ?>
</div> 
<?php } ?>
<?php if(isset($products) && $products) { ?>
<div class="featured-header"><?php echo $text_all_products_category; ?> <?php echo $category_name; ?></div>
<div class="featured-content">
<div class="products">
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
</div>


<div class="row">

<?php if(false) { ?>

    <div class="col-xs-12 text-center">
        <div class="loadMore">
            <button style="width:33%;" type="button" class="btn btn-default">Load more</button>
        </div>
    </div>

<?php } else { ?>
    <?php if($pagination) { ?>
        <div class="col-xs-12">
            <?php echo $pagination; ?>
        </div>
    <?php } ?>
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


<!-- Modal
<div id="Product" style="z-index:1041;" class="modal fade" role="dialog">
  <div style='width:700px' class="modal-dialog">
    
  </div>
</div>

-->
<?php if(false) { ?>
 <script type="text/javascript">

    var pageNum = <?php echo ++$page; ?>;

    $('.loadMore').on('click', 'button', function(e){
           $.ajax({
                url: 'index.php?route=fbstore/category/getJSONPaginationProducts',
                type: 'POST',
                data: {'cat_id' : <?php echo $cat_id; ?>, page: pageNum},
                success: function(data) {
                    var dataPr = JSON.parse(data);
                    addHTMLtoRows(dataPr.products);

                    if( dataPr.ifNext == false){
                        $('.loadMore').hide();
                    }
                    pageNum++;
                }
            });
    });
    

    function addHTMLtoRows(products){
                    html = '<div class="row">';
                    var i=1;
                    products.forEach(function (value, index) { 

                      html += '<div class="product-layout col-xs-12 col-sm-4">';
                      html += '<div class="product-thumb transition">';
                    html += '<div class="image"><a data-product-id="'+  value['product_id'] +'" href="'+  value['href'] +'"><img src="'+  value['thumb'] +'" alt="'+  value['thumb'] +'" title="'+  value['name'] +'" class="img-responsive" /></a></div>';
                    html += '<div class="caption">';
                    html += '<h4><a data-product-id="'+  value['product_id'] +'" href="'+  value['href'] +'">'+  value['name'] +'</a></h4>';




                    if (value['rating']) {
                        //html +='';
                    }
                    if (value['price']) {
                        html += '<p class="price">';
                        if (!value['special']) { 
                            html += value['price']; 
                        } else { 
                            html += '<span class="price-new">'+ value['special'] + '</span> <span class="price-old">'+ value['price'] + '</span>';
                        } 
                        html += '</p>';
                    }
                    html += '</div></div></div>'; 
                        if(i % 3 ==0) {
                            html += '</div><div class="row">';
                            i = 0;
                        }
                        i++;
                    });

                    html += '</div>';


                $('.products').append(html);
    }

  </script>
<?php } ?>


<!--script type="text/javascript">

    $('body').on('click', 'a', function(e){

        if($(this).attr("href").indexOf("route=module/fbstore") == -1 && $(this).attr("href").indexOf("https://") > -1 && $(this).attr("href").indexOf("image") == -1){
          e.preventDefault(); 
          var url = $(this).attr('href');
          window.open(url, '_blank');
        }

    });

 </script--> 
<?php echo $content_bottom; ?> 
<?php echo $footer; ?>
