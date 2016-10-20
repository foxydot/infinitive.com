<?php global $wpalchemy_media_access; ?>
<div class="msdlab_meta_control" id="banner_metabox">
    <div class="row">
    <div class="cell">
        <label>Replace Title with Header Text</label>
        <div class="input_container">
            <?php $mb->the_field('banner_text_bool'); ?>
            <div class="ui-toggle-btn">
              <input type="checkbox" name="<?php $mb->the_name(); ?>" value="1"<?php $mb->the_checkbox_state('1');?> />
              <div class="handle" data-on="ON" data-off="OFF"></div>
            </div>
            <div class="switchable">
                <?php $mb->the_field('banner_text'); ?>
                <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
           </div>
       </div>
    </div>
    <div class="cell">
        <label>Doodle</label>
        <div class="input_container" style="overflow:auto;height:14em;border:1px solid #ddd;">
            <?php $mb->the_field('doodle'); ?>
            <div class="doodle-choice"><span class="radiolabel"><i class="doodle"></i><span class="caption">No Doodle</span></span><input type="radio" name="<?php $mb->the_name(); ?>" value=""<?php $mb->the_select_state(''); ?>></input></div>
            <?php
                $doodlearray = array("arrowdown",
"videoplay",
"atbubble",
"balance",
"bargraph",
"bentarrowup",
"bullseye",
"calendar",
"ideamap",
"lockkey",
"piechart",
"radio",
"shield",
"usercycle",
"travel",
"sales",
"press",
"retail",
"media",
"marketing",
"financial",
"heathcare",
"ebf",
"dbf",
"cpg",
"core-values",
"careers",
"casestudies",
"community",
"testimonials",
"blog",
"about",
"team",
"sitemap",
"privacy",
"cloud");
                foreach($doodlearray AS $doodlename){
                    $checked = $mb->is_value($doodlename)?' checked="checked"':'';
                    print '
                    <div class="doodle-choice">
                        <span class="radiolabel"><i class="doodle-'.$doodlename.'"></i><span class="caption">'.$doodlename.'</span></span>
                        <input type="radio" name="'.$mb->get_the_name().'" value="'.$doodlename.'"'.$checked.'></input>
                    </div>';
                }
            ?>
       </div>
    </div>
    </div>
</div>
<style>
    .msdlab_meta_control .table {
      display: block;
      width: 100%;
    }
    .msdlab_meta_control .row {
      display: block;
      cursor: move;
      *zoom: 1;
    }
    .msdlab_meta_control .row:before,
    .msdlab_meta_control .row:after,
    .msdlab_meta_control .row .cell:before,
    .msdlab_meta_control .row .cell:after {
      content: " ";
      /* 1 */
      display: table;
      /* 2 */
    }
    .msdlab_meta_control .row:after,
    .msdlab_meta_control .row .cell:after {
      clear: both;
    }
    .msdlab_meta_control .box {
      margin: 20px 0;
      padding: 20px 0;
      border-top: 1px solid #ccc;
      border-bottom: 1px solid #ccc;
    }
    .msdlab_meta_control .cell {
      display: block;
      clear: both;
      margin-left: 1rem;
    }
    .msdlab_meta_control .cell label {
      display: block;
      font-weight: bold;
      margin-right: 1%;
      float: left;
      width: 20%;
      text-align: right;
    }
    .msdlab_meta_control .cell .input_container {
      width: 79%;
      float: left;
    }
    .msdlab_meta_control .cell .input_container .file input[type="text"] {
      width: 70%;
    }
    .msdlab_meta_control .cell .input_container input[type="color"] {
      height: 30px;
      width: 40px;
    }
    .msdlab_meta_control .cell .input_container textarea,
    .msdlab_meta_control .cell .input_container input[type='text'],
    .msdlab_meta_control .cell .input_container select,
    .msdlab_meta_control .cell .input_container .wp-editor-wrap {
      display: inline;
      margin-bottom: 3px;
      width: 90%;
    }
    .msdlab_meta_control .cell .input_container textarea.small,
    .msdlab_meta_control .cell .input_container input[type='text'].small,
    .msdlab_meta_control .cell .input_container select.small,
    .msdlab_meta_control .cell .input_container .wp-editor-wrap.small {
      max-width: 80px;
    }
    .msdlab_meta_control .even {
      background: #eee;
    }
    .msdlab_meta_control .odd {
      background: #fff;
    }
    .msdlab_meta_control .cell label.cols-2 {
      display: none;
    }
    .msdlab_meta_control .cols-2,
    .msdlab_meta_control .cols-3,
    .msdlab_meta_control .cols-4 {
      display: none;
    }
    .msdlab_meta_control h2.section_handle {
      padding-left: 2.2em;
      margin: 2px 0 0;
    }
    .msdlab_meta_control .section_params {
      max-height: 90vh;
      overflow: auto;
    }
    .msdlab_meta_control .ui-toggle-btn {
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
    .msdlab_meta_control .ui-toggle-btn input {
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
    .msdlab_meta_control .ui-toggle-btn .handle {
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
    .msdlab_meta_control .ui-toggle-btn input:checked + .handle {
      -webkit-transform: translateX(400%);
      -moz-transform: translateX(400%);
    }
    .msdlab_meta_control .ui-toggle-btn .handle:before,
    .msdlab_meta_control .ui-toggle-btn .handle:after {
      position: absolute;
      top: 0;
      width: 400%;
      height: 100%;
      line-height: 20px;
      font-size: 0.8em;
      text-align: center;
    }
    .msdlab_meta_control .ui-toggle-btn .handle:before {
      content: attr(data-on);
      right: 100%;
    }
    .msdlab_meta_control .ui-toggle-btn .handle:after {
      content: attr(data-off);
      left: 100%;
    }
    .msdlab_meta_control .switchable {
      -webkit-transition: height 0.5s ease-in-out;
      -moz-transition: height 0.5s ease-in-out;
      -ms-transition: height 0.5s ease-in-out;
      -o-transition: height 0.5s ease-in-out;
      transition: height 0.5s ease-in-out;
    }
    .msdlab_meta_control .doodle-choice {
        border: 1px solid #ddd;
        margin: 0.5em;
        padding: 0.5em;
        display: inline-block;
        width: 12em;
        text-align: center;
    }
    .msdlab_meta_control .doodle-choice .radiolabel {display: block;}
    .msdlab_meta_control .doodle-choice .radiolabel i {display: block;}
</style>
<script>
    jQuery(function($){
        $('.ui-toggle-btn').each(function(){
            var toggled = $(this).next('.switchable');
            if($(this).find('input[type=checkbox]').is(':checked')){
                toggled.slideDown(500);
            } else {
                toggled.slideUp(500);
            }
        });
        $('.ui-toggle-btn').click(function(){
            var toggled = $(this).next('.switchable');
            if($(this).find('input[type=checkbox]').is(':checked')){
                toggled.slideDown(500);
            } else {
                toggled.slideUp(500);
            }
        });
    });
</script>
