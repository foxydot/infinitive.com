<?php
remove_all_actions('genesis_loop');
add_action('genesis_loop','msdlab_team_member_special_loop');
add_action('wp_enqueue_scripts', 'msdlab_add_team_styles');
genesis();
