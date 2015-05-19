<?php
/* Change Youtube Lyte thumbnails to sddefault.jpg */
add_filter('lyte_match_thumburl','lyte_my_own_thumburl',10,1);
function lyte_my_own_thumburl($thumb) {
return str_replace("hqdefault.jpg", "maxresdefault.jpg", $thumb);
}