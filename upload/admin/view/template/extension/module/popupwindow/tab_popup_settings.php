<div class="tab-pane fade in active">
   <div class="row">
      <!--Popup status-->
      <div class="col-md-4">
         <h5><span class="required">* </span><strong>Popup <?php echo $popup['id']; ?> status</strong></h5>
         <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enable or disable the popup.</span>
      </div>
      <div class="col-md-3">
         <select id="Checker" name="<?php echo $popup_name; ?>[Enabled]" class="form-control">
            <option value="yes" <?php echo (!empty($popup_data['Enabled']) && $popup_data['Enabled'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
            <option value="no"  <?php echo (empty($popup_data['Enabled']) || $popup_data['Enabled']== 'no') ? 'selected=selected' : '' ?>>Disabled</option>
         </select>
      </div>
      <div class="col-md-5" style="text-align:right;">
         Impressions:
         <?php if(isset($impressions)) {
         foreach($impressions as $p_impressions) {
            if($p_impressions['popup_id'] == $popup['id'])
               echo $p_impressions['impressions'];
         }
         } else {
         echo 0;
         }
         ?>
      </div>
   </div>
   <!--End Popup status-->
   <br/>
   <div class="row">
      <!--Showing method-->
      <div class="col-md-4">
         <h5><strong>Popup showing method:</strong></h5>
         <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Choose method </span>
      </div>
      <div class="col-md-3">
         <select name="<?php echo $popup_name; ?>[method]" class="methodTypeSelect form-control">
            <option value="0" <?php echo (!empty($popup_data['method']) && $popup_data['method'] == '0') ? 'selected=selected' : '' ?>>On Homepage</option>
            <option value="1" <?php echo (!empty($popup_data['method']) && $popup_data['method'] == '1') ? 'selected=selected' : '' ?>>All pages</option>
            <option value="2" <?php echo (!empty($popup_data['method']) && $popup_data['method'] == '2') ? 'selected=selected' : '' ?>>Specific URLs</option>
            <option value="3" <?php echo (!empty($popup_data['method']) && $popup_data['method'] == '3') ? 'selected=selected' : '' ?>>CSS Selector</option>
         </select>
      </div>
   </div>
   <!--End Showing method-->
   <div class="row specURL">
      <br />
      <div class="col-md-4">
         <h5><strong>URLs:</strong></h5>
         <span class="help"><i class="fa fa-info-circle"></i>&nbsp;In this box you can type in the URLs you wish the popup to show up, separated by a new line</span>
      </div>
      <div class="col-md-8">
         <textarea rows="5" placeholder="http://" type="text" class="form-control" name="<?php echo $popup_name; ?>[url]"><?php if(!empty($popup_data['url'])) echo $popup_data['url']; else echo""; ?></textarea>
      </div>
   </div>
   <div class="row excludeURL">
      <br />
      <div class="col-md-4">
         <h5><strong>Excluded URLs:</strong></h5>
         <span class="help"><i class="fa fa-info-circle"></i>&nbsp;In this box you can type in the URLs you wish to exclude, separated by a new line</span>
      </div>
      <div class="col-md-8">
         <textarea rows="5" placeholder="http://" type="text" class="form-control" name="<?php echo $popup_name; ?>[excluded_urls]"><?php if(!empty($popup_data['excluded_urls'])) echo $popup_data['excluded_urls']; else echo""; ?></textarea>
      </div>
   </div>
   <div class="row cssSelector">
      <br />
      <div class="col-md-4">
         <h5><strong>Choose CSS selector:</strong></h5>
         <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Set CSS selector for the onClick event</span>
      </div>
      <div class="col-md-3">
         <input placeholder=".css" type="text" class="form-control" name="<?php echo $popup_name; ?>[css_selector]" value="<?php if(!empty($popup_data['css_selector'])) echo $popup_data['css_selector']; else echo""; ?>" />
      </div>
   </div>
   <!--End Showing method-->
   </br>
   <div class="row">
      <!--Trigger event-->
      <div class="col-md-4">
         <h5><strong>Show on:</strong></h5>
         <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Set the event trigger when the popup will show.</span>
      </div>
      <div class="col-md-3">
         <select name="<?php echo $popup_name; ?>[event]" class="eventSelect form-control">
            <option value="0" <?php echo (!empty($popup_data['event']) && $popup_data['event'] == '0') ? 'selected=selected' : '' ?>>Window Load Event</option>
            <option value="1" <?php echo (!empty($popup_data['event']) && $popup_data['event'] == '1') ? 'selected=selected' : '' ?>>Page Load Event</option>
            <option value="2" <?php echo (!empty($popup_data['event']) && $popup_data['event'] == '2') ? 'selected=selected' : '' ?>>Body Click Event</option>
            <option value="3" <?php echo (!empty($popup_data['event']) && $popup_data['event'] == '3') ? 'selected=selected' : '' ?>>Exit intent</option>
            <option value="4" <?php echo (!empty($popup_data['event']) && $popup_data['event'] == '4') ? 'selected=selected' : '' ?>>Scroll Percentage Event</option>
         </select>
      </div>
   </div>
   </br>
   <div class="row">
      <!-- Show on Mobile-->
      <div class="col-md-4">
         <h5><strong>Show on desktop:</strong></h5>
         <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enable or disable the popup for desktop devices.</span>
      </div>
      <div class="col-md-3">
         <select name="<?php echo $popup_name; ?>[show_on_desktop]" class="form-control">
            <option value="1" <?php echo (!isset($popup_data['show_on_desktop']) || $popup_data['show_on_desktop'] == '1') ? 'selected=selected' : '' ?>>Yes</option>
            <option value="0" <?php echo (isset($popup_data['show_on_desktop']) && $popup_data['show_on_desktop'] == '0') ? 'selected=selected' : '' ?>>No</option>
         </select>
      </div>
   </div>
   </br>
   <div class="row">
      <!-- Show on Mobile-->
      <div class="col-md-4">
         <h5><strong>Show on mobile:</strong></h5>
         <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enable or disable the popup for mobile devices.</span>
      </div>
      <div class="col-md-3">
         <select name="<?php echo $popup_name; ?>[show_on_mobile]" class="form-control">
            <option value="1" <?php echo (!isset($popup_data['show_on_mobile']) || $popup_data['show_on_mobile'] == '1') ? 'selected=selected' : '' ?>>Yes</option>
            <option value="0" <?php echo (isset($popup_data['show_on_mobile']) && $popup_data['show_on_mobile'] == '0') ? 'selected=selected' : '' ?>>No</option>
         </select>
      </div>
   </div>
   <br/>
   <div class="row percentageInput">
      <div class="col-md-4">
         <h5><strong><span class="required">* </span>Scroll Percentage</strong></h5>
         <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Trigger the pop-up after the user has scrolled down certain percantege of the page</span>
      </div>
      <div class="col-md-2">
         <div class="percentageInput">
            <br/>
            <div class='input-group'>
               <input type='number' min="1" class="form-control" name="<?php echo $popup_name; ?>[scroll_percentage]" value="<?php if(!empty($popup_data['scroll_percentage'])) echo $popup_data['scroll_percentage'];?>" />
               <span class="input-group-addon">%</span>
            </div>
         </div>
      </div>
   </div>
   <!--End trigger event-->
   <br />
   <div class="row">
      <!--Display frequency-->
      <div class="col-md-4">
         <h5><strong>Repeat:</strong></h5>
         <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Set the display frequency</span>
      </div>
      <div class="col-md-3">
         <select name="<?php echo $popup_name; ?>[repeat]" class="form-control repeatSelect">
            <option value="0" <?php echo (!empty($popup_data['repeat']) && $popup_data['repeat'] == '0') ? 'selected=selected' : '' ?>>Show always</option>
            <option value="1" <?php echo (!empty($popup_data['repeat']) && $popup_data['repeat'] == '1') ? 'selected=selected' : '' ?>>Only once per user session</option>
            <option value="2" <?php echo (!empty($popup_data['repeat']) && $popup_data['repeat'] == '2') ? 'selected=selected' : '' ?>>Show again after X days</option>
         </select>
         <div class="daysPicker">
            <br/>
            <div class="input-group">
               <input type="number" min="1" class="form-control" name="<?php echo $popup_name; ?>[days]" value="<?php if(!empty($popup_data['days'])) echo $popup_data['days']; else echo"1"; ?>" />
               <span class="input-group-addon">days</span>
            </div>
         </div>
      </div>
   </div>
   <!-- End display frequency-->
   <br />
   <div class="row">
      <!-- Hours frequency-->
      <div class="col-md-4">
         <h5><strong>Hours interval:</strong></h5>
         <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Set the hours when you want the popup to show</span>
      </div>
      <div class="col-md-2">
         <select name="<?php echo $popup_name; ?>[time_interval]" class="form-control timeIntervalSelect">
            <option value="0" <?php echo (!empty($popup_data['time_interval']) && $popup_data['time_interval'] == '0') ? 'selected=selected' : '' ?>>Disabled</option>
            <option value="1" <?php echo (!empty($popup_data['time_interval']) && $popup_data['time_interval'] == '1') ? 'selected=selected' : '' ?>>Enabled</option>
         </select>
         <div class="timeInterval">
            <br/>
            Start time:
            <div class='input-group date startTime'>
               <input type='text' class="form-control" name="<?php echo $popup_name; ?>[start_time]" value="<?php if(!empty($popup_data['start_time'])) echo $popup_data['start_time']; else echo"00:00"; ?>" />
               <span class="input-group-addon"><span class="fa fa-clock-o"></span>
            </span>
         </div>
         <br/>End time:
         <div class='input-group date endTime'>
            <input type='text' class="form-control" name="<?php echo $popup_name; ?>[end_time]" value="<?php if(!empty($popup_data['end_time'])) echo $popup_data['end_time']; else echo"00:00"; ?>" />
            <span class="input-group-addon"><span class="fa fa-clock-o"></span>
         </span>
      </div>
   </div>
</div>
</div>
<!-- End hours frequency-->
<br />
<div class="row">
<!-- Date interval-->
<div class="col-md-4">
   <h5><strong>Date schedule:</strong></h5>
   <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Set date interval</span>
</div>
<div class="col-md-2">
   <select name="<?php echo $popup_name; ?>[date_interval]" class="form-control dateIntervalSelect">
      <option value="0" <?php echo (empty($popup_data['date_interval']) || $popup_data['date_interval'] == '0') ? 'selected=selected' : '' ?>>Disabled</option>
      <option value="1" <?php echo (!empty($popup_data['date_interval']) && $popup_data['date_interval'] == '1') ? 'selected=selected' : '' ?>>Enabled</option>
   </select>
   <div class="dateInterval">
      <br/>
      Start date:
      <div class="input-group date startDate">
         <input type="text" name="<?php echo $popup_name; ?>[start_date]" value="<?php if(!empty($popup_data['start_date'])) echo $popup_data['start_date']; else echo""; ?>" placeholder="YYYY-MM-DD" data-date-format="YYYY-MM-DD" class="form-control" />
         <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
         </span>
      </div>
      <br/>End date:
      <div class="input-group date endDate">
         <input type="text" name="<?php echo $popup_name; ?>[end_date]" value="<?php if(!empty($popup_data['end_date'])) echo $popup_data['end_date']; else echo""; ?>" placeholder="YYYY-MM-DD" data-date-format="YYYY-MM-DD" class="form-control" />
         <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
         </span>
      </div>
   </div>
</div>
</div>
<!--End Date interval-->
<br />
<div class="row">
<!-- Seconds interval-->
<div class="col-md-4">
   <h5><strong>Delay:</strong></h5>
   <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Show popup after X seconds</span>
</div>
<div class="col-md-2">
   <div class="input-group">
      <input type="number" min="0" class="form-control" name="<?php echo $popup_name; ?>[seconds]" value="<?php if(!empty($popup_data['seconds'])) echo $popup_data['seconds']; else echo"0"; ?>" />
      <span class="input-group-addon">secs</span>
   </div>
</div>
</div>
<!-- End seconds interval-->
<br />
<div class="row">
<!-- Close after x seconds-->
<div class="col-md-4">
   <h5><strong>Close after:</strong></h5>
   <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Close the popup after X seconds</span>
</div>
<div class="col-md-2">
   <div class="input-group">
      <input type="number" min="0" class="form-control" name="<?php echo $popup_name; ?>[close_after]" value="<?php if(!empty($popup_data['close_after'])) echo $popup_data['close_after']; else echo"0"; ?>" />
      <span class="input-group-addon">secs</span>
   </div>
</div>
</div>
<!-- End close after -->
<br />
<div class="row">
<!-- Prevent closing -->
<div class="col-md-4">
   <h5><strong>Prevent closing:</strong></h5>
   <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Disable the popup from closing when the user clicks on the background or presses the Esc key.</span>
</div>
<div class="col-md-2">
   <select name="<?php echo $popup_name; ?>[prevent_closing]" class="form-control">
      <option value="0" <?php echo (!empty($popup_data['prevent_closing']) && $popup_data['prevent_closing'] == '0') ? 'selected=selected' : '' ?>>Disabled</option>
      <option value="1" <?php echo (!empty($popup_data['prevent_closing']) && $popup_data['prevent_closing'] == '1') ? 'selected=selected' : '' ?>>Enabled</option>
   </select>
</div>
</div>
<!--End Prevent closing -->
<br />
<div class="row">
<!-- Customer Groups -->
<div class="col-md-4">
   <h5><span class="required">*</span><strong>Customer Groups</strong></h5>
   <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Choose the customer group you want to apply the pop-up for. At least one customer group should be selected!</span>
</div>
<div class="col-md-3">
   <div class="checkbox">
      <!-- <label>
         <input type="checkbox" name="<?php echo $popup_name ?>[customerGroups][0]" <?php echo isset($popup_data['customerGroups'][0]) && ($popup_data['customerGroups'][0] == 'on') ? 'checked="checked"' : ''; ?>/> Guest
      </label> -->
      <label>
         <input type="checkbox" name="<?php echo $popup_name ?>[customerGroups][0]" <?php echo !isset($popup_data['customerGroups']) || (isset($popup_data['customerGroups'][0]) && $popup_data['customerGroups'][0] == 'on') ? 'checked="checked"' : ''; ?>/> Guest
      </label>
   </div>
   <?php foreach($customerGroups as $customerGroup) { ?>
   <div class="checkbox">
      <label>
         
         <input type="checkbox" name="<?php echo $popup_name ?>[customerGroups][<?php echo $customerGroup['customer_group_id']?>]" <?php echo !isset($popup_data['customerGroups']) || (isset($popup_data['customerGroups'][$customerGroup['customer_group_id']]) && $popup_data['customerGroups'][$customerGroup['customer_group_id']] == 'on') ? 'checked="checked"' : ''; ?>/> <?php echo $customerGroup['name'] ?>
      </label>
   </div>
   <?php } ?>
</div>
</div>
<br>
<div class="row" >
      <div class="col-md-4">
         <h5><strong>Custom CSS</strong></h5>
         <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Paste your custom css styles here</span>
      </div>
      <div class="col-md-3">     
         <textarea cols="300" rows="5" class="form-control" name="<?php echo $popup_name; ?>[custom_css]"?><?php if(!empty($popup_data['custom_css'])) echo $popup_data['custom_css']; else echo '.popup-id-'.$popup['id'].'{}'?>
         </textarea>
        
      </div>
</div>
<!--End Customer Groups -->
<br>
<div class="row">
       <div class="col-md-4">
         <h5><span class="required">* </span><strong>Content type</strong></h5>
      </div>
      <div class="col-md-3">
         <select id="Checker" name="<?php echo $popup_name; ?>[content_type]" class="form-control">
            <option value="html" <?php echo (empty($popup_data['content_type']) || $popup_data['content_type'] == 'html') ? 'selected=selected' : '' ?>>HTML content</option> 
            <option value="youtube"  <?php echo (!empty($popup_data['content_type']) && $popup_data['content_type']== 'youtube') ? 'selected=selected' : '' ?>>YouTube video</option>                      
         </select>
      </div>
</div>
<br/>
<div class="row" id="showHideYtdLink_<?php echo $popup['id']; ?>">
      <div class="col-md-4">
         <h5><strong>Video Link</strong></h5>
         <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Paste your YouTube video link here</span>
      </div>
      <div class="col-md-3">
         <input placeholder="video link" type="text" class="form-control" name="<?php echo $popup_name; ?>[video_link]" value="<?php if(!empty($popup_data['video_link'])) echo $popup_data['video_link']; else echo""; ?>" />
      </div>
</div>
<br/>
<div id="showHideHtmlContent_<?php echo $popup['id']; ?>">
   <ul class="nav nav-tabs popup_tabs">
         <h5>Multi-lingual settings:</h5>
         <?php $i=0; foreach ($languages as $language) { ?>
         <li <?php if ($i==0) echo 'class="active"'; ?>><a href="#tab-<?php echo $popup['id']; ?>-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="<?php echo $language['flag_url'] ?>"/> <?php echo $language['name']; ?></a></li>
         <?php $i++; }?>
   </ul>
   <div class="tab-content">
   <?php $i=0; foreach ($languages as $language) { ?>
   <div id="tab-<?php echo $popup['id']; ?>-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane language <?php if ($i==0) echo 'active'; ?>">
      <div class="row">
         <div class="col-md-2">
            <h5><strong>Popup Content:</strong></h5>
         </div>
         <div class="col-md-9">
            <textarea class="form-control summernote" id="message_<?php echo $popup['id']; ?>_<?php echo $language['language_id']; ?>" name="<?php echo $popup_name; ?>[content][<?php echo $language['language_id']; ?>]">
            <?php if(!empty($popup_data['content'][$language['language_id']])) echo $popup_data['content'][$language['language_id']]; else echo ''; ?>
            </textarea>
         </div>
      </div>
   </div>
   <?php $i++; } ?>
   </div>
</div>
</div>
<script>
showHideStuff($('select[name="<?php echo $popup_name; ?>[content_type]"]'),$('#showHideHtmlContent_<?php echo $popup['id']; ?>'), 'html');
showHideStuff($('select[name="<?php echo $popup_name; ?>[content_type]"]'),$('#showHideYtdLink_<?php echo $popup['id']; ?>'), 'youtube');

   function showHideStuff($typeSelector, $toggleArea, $selectStatus) {    
       if ($typeSelector.val() === $selectStatus) {
           $toggleArea.show(); 
       } else {
           $toggleArea.hide(); 
       }
       $typeSelector.change(function(){
            if ($typeSelector.val() === $selectStatus) {
               $toggleArea.show(300); 
            }
           else {
               $toggleArea.hide(300); 
            }
       });
   }
</script>