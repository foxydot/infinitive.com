<?php 
if (!class_exists('MSDTeamCPT')) {
    class MSDTeamCPT {
        //Properties
        var $cpt = 'team_member';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDTeamCPT(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            $this->plugin_url = plugin_dir_url('msd-custom-cpt/msd-custom-cpt.php');
            $this->plugin_path = plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php');
            //Actions
            add_action( 'init', array(&$this,'register_tax_practice_areas') );
            add_action( 'init', array(&$this,'register_cpt_team_member') );
            add_action('admin_head', array(&$this,'plugin_header'));
            add_action('admin_print_scripts', array(&$this,'add_admin_scripts') );
            add_action('admin_print_styles', array(&$this,'add_admin_styles') );
            add_action('admin_footer',array(&$this,'info_footer_hook') );
            // important: note the priority of 99, the js needs to be placed after tinymce loads
            add_action('admin_print_footer_scripts',array(&$this,'print_footer_scripts'),99);
            
            //Filters
            add_filter( 'pre_get_posts', array(&$this,'custom_query') );
            add_filter( 'enter_title_here', array(&$this,'change_default_title') );
            add_filter( 'genesis_attr_team_member', array(&$this,'custom_add_team_member_attr') );
            
            //Shortcodes
            add_shortcode('teammembers', array(&$this,'msdlab_team_member_special_loop_shortcode_handler'));
            add_shortcode('team-members', array(&$this,'msdlab_team_member_special_loop_shortcode_handler'));
            
            add_image_size('team-headshot',300,370, array('center','top'));
            
        }
        
        public function register_tax_practice_areas() {
        
            $labels = array( 
                'name' => _x( 'Practice areas', 'practice-areas' ),
                'singular_name' => _x( 'Practice area', 'practice-areas' ),
                'search_items' => _x( 'Search practice areas', 'practice-areas' ),
                'popular_items' => _x( 'Popular practice areas', 'practice-areas' ),
                'all_items' => _x( 'All practice areas', 'practice-areas' ),
                'parent_item' => _x( 'Parent practice area', 'practice-areas' ),
                'parent_item_colon' => _x( 'Parent practice area:', 'practice-areas' ),
                'edit_item' => _x( 'Edit practice area', 'practice-areas' ),
                'update_item' => _x( 'Update practice area', 'practice-areas' ),
                'add_new_item' => _x( 'Add new practice area', 'practice-areas' ),
                'new_item_name' => _x( 'New practice area name', 'practice-areas' ),
                'separate_items_with_commas' => _x( 'Separate practice areas with commas', 'practice-areas' ),
                'add_or_remove_items' => _x( 'Add or remove practice areas', 'practice-areas' ),
                'choose_from_most_used' => _x( 'Choose from the most used practice areas', 'practice-areas' ),
                'menu_name' => _x( 'Practice areas', 'practice-areas' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'public' => true,
                'show_in_nav_menus' => true,
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true, //we want a "category" style taxonomy, but may have to restrict selection via a dropdown or something.
        
                'rewrite' => array('slug'=>'practice-area','with_front'=>false),
                'query_var' => true
            );
        
            register_taxonomy( 'team_practice_area', array($this->cpt), $args );
        }
        
        function register_cpt_team_member() {
        
            $labels = array( 
                'name' => _x( 'Team Members', 'team_member' ),
                'singular_name' => _x( 'Team Member', 'team_member' ),
                'add_new' => _x( 'Add New', 'team_member' ),
                'add_new_item' => _x( 'Add New Team Member', 'team_member' ),
                'edit_item' => _x( 'Edit Team Member', 'team_member' ),
                'new_item' => _x( 'New Team Member', 'team_member' ),
                'view_item' => _x( 'View Team Member', 'team_member' ),
                'search_items' => _x( 'Search Team Member', 'team_member' ),
                'not_found' => _x( 'No team members found', 'team_member' ),
                'not_found_in_trash' => _x( 'No team members found in Trash', 'team_member' ),
                'parent_item_colon' => _x( 'Parent Team Member:', 'team_member' ),
                'menu_name' => _x( 'Team Member', 'team_member' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'hierarchical' => false,
                'description' => 'Team Member',
                'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields', 'excerpt' ),
                'taxonomies' => array( 'team_practice_area' ),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 20,
                
                'show_in_nav_menus' => true,
                'publicly_queryable' => true,
                'exclude_from_search' => false,
                'has_archive' => false,
                'query_var' => true,
                'can_export' => true,
                'rewrite' => array('slug'=>'about/meet-the-team','with_front'=>false),
                'capability_type' => 'post'
            );
        
            register_post_type( $this->cpt, $args );
        }
        
        function plugin_header() {
            global $post_type;
            ?>
            <?php
        }
         
        function add_admin_scripts() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
            }
        }
        
        function add_admin_styles() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_style('thickbox');
                wp_enqueue_style('custom_meta_css',plugin_dir_url(dirname(__FILE__)).'/css/meta.css');
            }
        }   
            
        function print_footer_scripts()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                print '<script type="text/javascript">/* <![CDATA[ */
                    jQuery(function($)
                    {
                        var i=1;
                        $(\'.customEditor textarea\').each(function(e)
                        {
                            var id = $(this).attr(\'id\');
             
                            if (!id)
                            {
                                id = \'customEditor-\' + i++;
                                $(this).attr(\'id\',id);
                            }
             
                            tinyMCE.execCommand(\'mceAddControl\', false, id);
             
                        });
                    });
                /* ]]> */</script>';
            }
        }
        function change_default_title( $title ){
            global $current_screen;
            if  ( $current_screen->post_type == $this->cpt ) {
                return __('Team Member Name','team_member');
            } else {
                return $title;
            }
        }
        
        function info_footer_hook()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                ?><script type="text/javascript">
                        jQuery('#postdivrich').before(jQuery('#_contact_info_metabox'));
                    </script><?php
            }
        }
        

        function custom_query( $query ) {
            if(!is_admin()){
                $is_team_member = ($query->query['post_type'] == $this->cpt)?TRUE:FALSE;
                if($query->is_main_query() && $query->is_search){
                    $post_types = $query->query_vars['post_type'];
                    if(count($post_types)==0){
                        $post_types[] = 'post';
                        $post_types[] = 'page';
                    }
                    $post_types[] = $this->cpt;
                    $query->set( 'post_type', $post_types );
                }
                elseif( $query->is_main_query() && $query->is_archive && $is_team_member) {
                    $query->set( 'post_type', $this->cpt );
                    $query->set( 'meta_query', array() );
                }
            }
        }       
        function msdlab_team_member_special_loop(){
            $args = array(
            );
            print $this->msdlab_team_member_special($args);
        }
        
        function msdlab_team_member_special_loop_shortcode_handler($atts){
            $args = shortcode_atts( array(
            ), $atts );
            remove_filter('the_content','wpautop',12);
            return $this->msdlab_team_member_special($args);
        }
        function msdlab_team_member_special($args){
            global $post,$contact_info;
            $origpost = $post;
            $defaults = array(
                'posts_per_page' => -1,
                'post_type' => 'team_member',
                'order_by' => '_team_last_name',
                'order' => ASC
            );
            $args = array_merge($defaults,$args);
            //set up result array
            $results = array();
            $results = get_posts($args);
            //format result
            $i = 0;
            foreach($results AS $result){
                $post = $result;
                $i++;
                //$ret .= $i .' '.$post->post_title.'<br />';
                $titlearray = explode(" ",$post->post_title);
                $firstname = $titlearray[0];
                $firstname = (substr($firstname, -1) == 's')?$firstname."'":$firstname."'s";
                $contact_info->the_meta($result->ID);
                $ret .= genesis_markup( array(
                        'html5'   => '<article %s>',
                        'xhtml'   => '<div class="team_member type-team_member status-publish has-post-thumbnail entry">',
                        'context' => 'team_member',
                        'echo' => false,
                    ) );
                    $ret .= genesis_markup( array(
                            'html5' => '<div class="wrap">',
                            'xhtml' => '<div class="wrap">',
                            'echo' => false,
                        ) ); 
                    $ret .= genesis_markup( array(
                            'html5' => '<aside>',
                            'xhtml' => '<div class="aside">',
                            'echo' => false,
                        ) ); 
                    $ret .= get_the_post_thumbnail($result->ID,'team-headshot',array('itemprop'=>'image'));
                    $ret .= '
                                <ul>';
                    if($contact_info->get_the_value('_team_linked_in')){
                        $ret .= '<li class="linkedin"><a href="'.$contact_info->get_the_value('_team_linked_in').'" target="_linkedin"><span class="fa-stack fa-lg pull-right">
          <i class="fa fa-square fa-stack-2x"></i>
          <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
        </span></a></li>';
                    }
                    if($contact_info->get_the_value('_team_user_id')!=0){
                    $ret .= '<li class="insights-header"><a href="'.get_permalink($result->ID).'#insights"><span class="fa-stack fa-lg pull-left">
          <i class="fa fa-circle fa-stack-2x"></i>
          <i class="fa fa-rss fa-stack-1x fa-inverse"></i>
        </span>'.$firstname.' Insights</a></li>';
                    }
        
                    $ret .= '</ul>';
                    
                    $ret .= genesis_markup( array(
                            'html5' => '</aside>',
                            'xhtml' => '</div>',
                            'echo' => false,
                        ) ); 
                    $ret .= genesis_markup( array(
                        'html5' => '<main>',
                        'xhtml' => '<div class="main">',
                        'echo' => false,
                    ) ); 
                    $ret .= genesis_markup( array(
                            'html5' => '<header>',
                            'xhtml' => '<div class="header">',
                            'echo' => false,
                        ) ); 
                        
                    $ret .= '<h3 class="entry-title" itemprop="name">'.$post->post_title.'</h3>
                            <h4 class="team-title" itemprop="jobTitle">'.$contact_info->get_the_value('_team_title').'</h4>';
                         
                    $ret .= genesis_markup( array(
                            'html5' => '</header>',
                            'xhtml' => '</div>',
                            'echo' => false,
                        ) ); 
                    $ret .= genesis_markup( array(
                            'html5' => '<content>',
                            'xhtml' => '<div class="content">',
                            'echo' => false,
                        ) ); 
                    $ret .= msdlab_get_excerpt($post->ID,40,'');
                    $ret .= genesis_markup( array(
                            'html5' => '</content>',
                            'xhtml' => '</div>',
                            'echo' => false,
                        ) ); 
                    $ret .= genesis_markup( array(
                            'html5' => '<footer>',
                            'xhtml' => '<div class="footer">',
                            'echo' => false,
                        ) );   
                        if($contact_info->get_the_value('_team_position')=='true'){ $ret .= '
                           <a href="'.get_permalink($post->ID).'" class="readmore button">Read More ></a>';
                        }
                    $ret .= genesis_markup( array(
                            'html5' => '</footer>',
                            'xhtml' => '</div>',
                            'echo' => false,
                        ) );   
                    $ret .= genesis_markup( array(
                        'html5' => '</main>',
                        'xhtml' => '</div>',
                        'echo' => false,
                    ) ); 
                    $ret .= genesis_markup( array(
                        'html5' => '</div>',
                        'xhtml' => '</div>',
                        'echo' => false,
                    ) ); 
                $ret .= genesis_markup( array(
                        'html5' => '</article>',
                        'xhtml' => '</div>',
                        'context' => 'team_member',
                        'echo' => false,
                    ) );
            }
            //return
            $post = $origpost;
            return $ret;
        }
        
        /**
         * Callback for dynamic Genesis 'genesis_attr_$context' filter.
         * 
         * Add custom attributes for the custom filter.
         * 
         * @param array $attributes The element attributes
         * @return array $attributes The element attributes
         */
        function custom_add_team_member_attr( $attributes ){
                $attributes['itemtype']  = 'http://schema.org/Person';
                // return the attributes
                return $attributes;      
        }    
  } //End Class
} //End if class exists statement