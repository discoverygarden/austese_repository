<?php 
/* customise template based on page arguments : 
 * arg(0) == 'repository'
 * arg(1) == apiType (e.g. 'artfacts', 'versions', 'works', 'agents' etc.)
 * arg(2) == apiOperation (optional e.g. 'add' or 'edit')
 */
$modulePrefix = arg(0);
$apiType = substr(arg(1),0,-1); // remove the trailing 's'
$apiOperation = arg(2);
$existingId=arg(3);
?>
<div id="alerts"></div>
<div id="metadata"
 <?php if (user_access('edit metadata')): ?>
  data-editable="true"
 <?php endif; ?>
 <?php if ($existingId):?>
 data-existingid="<?php print $existingId; ?>"
 <?php endif; ?>
 data-moduleprefix="<?php print $modulePrefix; ?>"
 data-modulepath="<?php print drupal_get_path('module', 'repository'); ?>"
 data-apioperation="<?php print $apiOperation;?>"
 data-apitype="<?php print $apiType;?>">
</div>
<form id="create-work" class="form-horizontal">
  <fieldset>
    <div class="control-group">
      <label class="control-label" for="workTitle">Title</label>
      <div class="controls">
        <input name="workTitle" type="text" class="input-xlarge" id="workTitle">
        <p class="help-block">Full title of the work</p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="name">Name</label>
      <div class="controls">
        <input name="name" type="text" class="input-xlarge" id="name">
        <p class="help-block">Short name for the work</p>
      </div>
    </div>
  <div class="control-group">
      <label class="control-label" for="versions">Versions</label>
      <div class="controls">
        <input name="versions" type="text" class="input-xlarge" id="versions">
        <p class="help-block">Versions of this work</p>
      </div>
    </div>
    <div class="control-group">
<div class="controls">
    <input id="save-btn" type="button" class="btn" value="Save">
    <input id="del-btn" style="display:none" type="button" class="btn btn-danger" value="Delete">
</div></div>
  </fieldset>
</form>

<script type="text/javascript" src="js/jquery.tokeninput.js"></script>

  <script type="text/javascript">
    
       
    });
    function loadObject(id){
       jQuery.ajax({
          url: '../works/'+ id,
          success: function(d){
             js2form(document.getElementById('create-work'),d);
             if (d.versions){
               for (var i = 0; i < d.versions.length; i++){
                jQuery.ajax({
                  type: 'GET',
                  url: '../versions/' + d.versions[i],
                  success: function(v){
                    jQuery('#versions').tokenInput("add",v);
                  }
                });
               }
             }
          }
       });
    }

    function onSave(){
     var existing = getURLParameter("id");
     var type = 'POST';
     var url = '../works/';
     if (existing) {
        type = 'PUT';
        url += existing;
     }
     var data = jQuery('#create-work').serializeObject();
     if (data.versions){
       var split = data.versions.split(",");
       data.versions = [];
       for (var i = 0; i < split.length; i++){
          data.versions.push(split[i]);
       }
     }
     jQuery.ajax({
       type: type,
       data: JSON.stringify(data),
       url: url,
       success: function(d){
         jQuery('#alerts').append(jQuery('<div class="alert alert-block"><button type="button" class="close" data-dismiss="alert">x</button><h4>Work saved</h4><p><a href="works.html">View works</a></p></div>').alert());
       }
     });
    };

  </script>
