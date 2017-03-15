<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
     <div class="page-header">
        <div class="container-fluid">
          <h1><?php echo $heading_title; ?></h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i>&nbsp;<span style="vertical-align:middle;font-weight:bold;">Login</span></h3>
            </div>
                <iframe id="fblogin" src="https://facebookstore.isenselabs.com/api/page/login" width="100%" height="250px" style="border:none;"></iframe>

        </div>
    </div>
</div>
<?php echo $footer; ?>
<script>
$(document).ready(function() {
    window.addEventListener('message', function(event) {
        // IMPORTANT: Check the origin of the data!
        if (~event.origin.indexOf('https://facebookstore.isenselabs.com')) {
            // The data has been sent from your site

            // The data sent with postMessage is stored in event.data
            if(event.data != ''){
                debugger;
                $.ajax({
                    url: '<?php echo html_entity_decode($saveTokenURL); ?>',
                    type: "post",
                    data: {token: event.data} ,
                    success: function (response) {
                        console.log(response);
                              location.reload();         
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                       console.log(textStatus, errorThrown);
                    }


                });
            }
        } else {
            // The data hasn't been sent from your site!
            // Be careful! Do not use it.
            return;
        }
    });
});
    

</script>