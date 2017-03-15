<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $heading_title; ?></title>
        <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
        <link href="catalog/view/theme/default/template/fbstore/styles/bootstrap.css" rel="stylesheet" media="screen" />
        <script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
        <link href="catalog/view/theme/default/template/fbstore/styles/stylesheet.css" rel="stylesheet">
        <script src="catalog/view/javascript/fbstore.js" type="text/javascript"></script>
        <link href="catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="catalog/view/javascript/jquery/magnific/magnific-popup.css" type="text/css" rel="stylesheet" media="screen" />
        <link href="catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
        <script src="catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js" type="text/javascript"></script>
        <script src="catalog/view/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>
        <script src="catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    </head>
    <body>
           <nav id="top">
                <div class="container">
                    <div class="row visible-xs hidden-sm hidden-md hidden-lg">
                        <div class="col-xs-12">
                            <a class="btn btn-default btn-xs go-to-store" target="_blank" href="<?php echo $StoreUrl; ?>">
                                <i class="fa fa-shopping-bag" aria-hidden="true"></i> <?php echo $text_go_store_button; ?>
                            </a>   
                        </div>
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-3">
                                    <a href="<?php echo $base; ?>" title="home" class="btn btn-default go-home"><i class="fa fa-home" style="font-size: 16px;"></i></a>
                                </div>
                                <div class="col-xs-3 col-xs-offset-3">
                                    <?php echo $currency; ?>
                                </div>
                                 <div class="col-xs-3">
                                    <?php echo $language; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row hidden-xs visible-sm visible-md visible-lg">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-xs-1">
                                    <a href="<?php echo $base; ?>" title="home" class="btn btn-default go-home"><i class="fa fa-home" style="font-size: 16px;"></i></a>
                                </div>
                                <div class="col-xs-5">
                                    <?php echo $currency; ?>
                                    <?php echo $language; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-xs-12">      
                                    <a class="btn btn-default btn-xs pull-right go-to-store" target="_blank" href="<?php echo $StoreUrl; ?>"><i class="fa fa-shopping-bag" aria-hidden="true"></i> <?php echo $text_go_store_button; ?></a>     
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </nav>

        <div class="container">      
            <div id="top-fbstore">
                <div class="row">
                    <div class="col-xs-12 col-sm-8">
                        <?php echo $search; ?>
                    </div>
                    <div class="col-xs-12 col-sm-4 cart pull-right">
                        <?php echo $cart; ?>
                    </div>
                </div>
            </div>