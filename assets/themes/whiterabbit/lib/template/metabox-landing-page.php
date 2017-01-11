<?php global $wpalchemy_media_access; ?>

<?php 

$postid = is_admin()?$_GET['post']:$post->ID;
$template_file = get_post_meta($postid,'_wp_page_template',TRUE);
  // check for a template type
if (is_admin()){
    if($template_file == 'page-landing.php' ) {
        ?>
        <style>
            #msdlab_meta_control .table {
  display: block;
  width: 100%;
}
#msdlab_meta_control .row {
  display: block;
  cursor: move;
  *zoom: 1;
}
#msdlab_meta_control .row:before,
#msdlab_meta_control .row:after,
#msdlab_meta_control .row .cell:before,
#msdlab_meta_control .row .cell:after {
  content: " ";
  /* 1 */
  display: table;
  /* 2 */
}
#msdlab_meta_control .row:after,
#msdlab_meta_control .row .cell:after {
  clear: both;
}
#msdlab_meta_control .box {
  margin: 20px 0;
  padding: 20px 0;
  border-top: 1px solid #ccc;
  border-bottom: 1px solid #ccc;
}
#msdlab_meta_control .cell {
  display: block;
  clear: both;
  margin-left: 1rem;
}
#msdlab_meta_control .cell label {
  display: block;
  font-weight: bold;
  margin-right: 1%;
  float: left;
  width: 20%;
  text-align: right;
}
#msdlab_meta_control .cell .input_container {
  width: 79%;
  float: left;
}
#msdlab_meta_control .cell .input_container .file input[type="text"] {
  width: 70%;
}
#msdlab_meta_control .cell .input_container input[type="color"] {
  height: 30px;
  width: 40px;
}
#msdlab_meta_control .cell .input_container textarea,
#msdlab_meta_control .cell .input_container input[type='text'],
#msdlab_meta_control .cell .input_container select,
#msdlab_meta_control .cell .input_container .wp-editor-wrap {
  display: inline;
  margin-bottom: 3px;
  width: 90%;
}
#msdlab_meta_control .cell .input_container textarea.small,
#msdlab_meta_control .cell .input_container input[type='text'].small,
#msdlab_meta_control .cell .input_container select.small,
#msdlab_meta_control .cell .input_container .wp-editor-wrap.small {
  max-width: 80px;
}
#msdlab_meta_control .even {
  background: #eee;
}
#msdlab_meta_control .odd {
  background: #fff;
}
#msdlab_meta_control .cell label.cols-2 {
  display: none;
}
#msdlab_meta_control .cols-2,
#msdlab_meta_control .cols-3,
#msdlab_meta_control .cols-4 {
  display: none;
}
#msdlab_meta_control h2.feature_handle {
  padding-left: 2.2em;
  margin: 2px 0 0;
}
#msdlab_meta_control .feature_params {
  max-height: 90vh;
  overflow: auto;
}
#msdlab_meta_control .ui-toggle-btn {
  display: block;
  position: relative;
  width: 40px;
  height: 20px;
  margin: 0 0 1rem 0;
  background: #555;
  overflow: hidden;
  white-space: nowrap;
  border-radius: 5px;
  box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.4) inset, 1px 1px 0 rgba(255, 255, 255, 0.15);
}
#msdlab_meta_control .ui-toggle-btn input {
  position: absolute;
  left: 0;
  bottom: 0;
  z-index: 9999;
  background-color: red;
  border: solid 1px;
  width: 100%;
  height: 100%;
  opacity: 0;
}
#msdlab_meta_control .ui-toggle-btn .handle {
  position: relative;
  z-index: 99;
  width: 20%;
  height: 100%;
  background: #BBB;
  border-radius: 5px;
  color: #DDD;
  -webkit-transition: all 240ms;
  -moz-transition: all 240ms;
  box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.3) inset;
  -webkit-transform: translate3d(0, 0, 1px);
  -moz-transform: translate3d(0, 0, 1px);
}
#msdlab_meta_control .ui-toggle-btn input:checked + .handle {
  -webkit-transform: translateX(400%);
  -moz-transform: translateX(400%);
}
#msdlab_meta_control .ui-toggle-btn .handle:before,
#msdlab_meta_control .ui-toggle-btn .handle:after {
  position: absolute;
  top: 0;
  width: 400%;
  height: 100%;
  line-height: 20px;
  font-size: 0.8em;
  text-align: center;
}
#msdlab_meta_control .ui-toggle-btn .handle:before {
  content: attr(data-on);
  right: 100%;
}
#msdlab_meta_control .ui-toggle-btn .handle:after {
  content: attr(data-off);
  left: 100%;
}
#msdlab_meta_control .switchable {
  -webkit-transition: height 0.5s ease-in-out;
  -moz-transition: height 0.5s ease-in-out;
  -ms-transition: height 0.5s ease-in-out;
  -o-transition: height 0.5s ease-in-out;
  transition: height 0.5s ease-in-out;
}

        </style>
        <div class="msdlab_meta_control" id="msdlab_meta_control">
            <p id="warning" style="display: none;background:lightYellow;border:1px solid #E6DB55;padding:5px;">Order has changed. Please click Save or Update to preserve order.</p>
            <div class="table">
            <?php $s = 1; ?>
            <?php while($mb->have_fields('features',3)): ?>
            <?php $mb->the_group_open(); ?>
            <?php $feature_name = strlen($mb->get_the_value('feature-name'))==0?'Feature '.$s:$mb->get_the_value('feature-name')?>
            <div id="<?php print $feature_name; ?>" class="msdlab_feature row <?php print $s%2==1?'even':'odd'; ?>">
                <h2 class="feature_handle <?php print $s%2==1?'even':'odd'; ?>"><span><?php print $feature_name; ?></span></h2>
                <div class="feature_data">
                <div class="feature_params">
                <div class="cell">
                    <?php $mb->the_field('resource-type'); ?>
                    <label>Resource Type</label>            
                    <div class="input_container">
                        <select name="<?php $mb->the_name(); ?>" class="resource-type">
                            <option value="eBOOK"<?php $mb->the_select_state('eBOOK'); ?>>eBook</option>
                            <option value="CHECK LIST"<?php $mb->the_select_state('eBOOK'); ?>>Check List</option>
                            <option value="FACT SHEET"<?php $mb->the_select_state('eBOOK'); ?>>Fact Sheet</option>
                            <option value="NEWS"<?php $mb->the_select_state('NEWS'); ?>>News</option>
                            <option value="INFOGRAPHIC"<?php $mb->the_select_state('INFOGRAPHIC'); ?>>Infographic</option>
                            <option value="CASE STUDY"<?php $mb->the_select_state('CASE STUDY'); ?>>Case Study</option>
                            <option value="VIDEO"<?php $mb->the_select_state('VIDEO'); ?>>Video</option>
                        </select>
                    </div>
                </div>
                <div class="cell">
                    <?php $mb->the_field('resource-title'); ?>
                    <label>Title</label>            
                    <div class="input_container">
                        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" maxlength="90" />
                    </div>
                </div>
                <div class="cell file">
                    <label>Feature Image</label>
                    <div class="input_container">
                        <?php $mb->the_field('resource-image'); ?>
                        <?php if($mb->get_the_value() != ''){
                            $thumb_array = wp_get_attachment_image_src( get_attachment_id_from_src($mb->get_the_value()), 'thumbnail' );
                            $thumb = $thumb_array[0];
                        } else {
                            $thumb = WP_PLUGIN_URL.'/msd-specialty-pages/lib/img/spacer.gif';
                        } ?>
                        <img class="resource-preview-img" src="<?php print $thumb; ?>">
                        <?php $group_name = 'resource-img-'. $mb->get_the_index(); ?>
                        <?php $wpalchemy_media_access->setGroupName($group_name)->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
                        <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
                        <?php echo $wpalchemy_media_access->getButton(array('label' => '+')); ?>
                    </div>
                </div>   
                <div class="cell">
                    <?php $mb->the_field('link'); ?>
                    <label>Link</label>            
                    <div class="input_container">
                        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
                    </div>
                </div>  
                <div class="cell">
                    <?php $mb->the_field('css-classes'); ?>
                    <label>CSS Classes</label>            
                    <div class="input_container">
                        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/><br />
                    </div>
                </div>     
                <div class="cell">
                    <?php $mb->the_field('inline-css'); ?>
                    <label>Inline CSS</label>            
                    <div class="input_container">
                        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/><br />
                    </div>
                </div>
                </div>
            </div>
            </div>
            <?php $s++; ?>
            <?php $mb->the_group_close(); ?>
            <?php endwhile; ?>
            </div>
        </div> <?php
    } else {
    print "<style>#_landing_page_metabox{display: none;}</style>";
}
} ?>
