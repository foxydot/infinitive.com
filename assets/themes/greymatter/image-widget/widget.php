<?php
/**
 * Widget template. This template can be overriden using the "sp_template_image-widget_widget.php" filter.
 * See the readme.txt file for more info.
 */

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

echo $before_widget;
if($args['id']=='header-right'){ //logo strip
    echo $link?'<a class="'.$this->widget_options['classname'].'-link" href="'.$link.'" target="'.$linktarget.'">':'';
    echo $this->get_image_html( $instance, true );
    echo $link?'</a>':'';
} else { //not in the logo strip
if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
echo $this->get_image_html( $instance, true );
if ( !empty( $description ) ) {
	echo '<div class="'.$this->widget_options['classname'].'-description" >';
	echo wpautop( $description );
	echo "</div>";
}
if ( $link ) {
	$linktext = $linktext != ''?$linktext:'Read More';
		echo '<h4 class="link"><a class="'.$this->widget_options['classname'].'-link alignright" href="'.$link.'" target="'.$linktarget.'">'.$linktext.' ></a><div class="clear"></div></h4>';
	}
	echo '<div class="clear"></div>';
	}
echo $after_widget;