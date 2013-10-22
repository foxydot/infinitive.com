<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage infinite
 * @since infinite 3.1
 */
global $subtitle;
?>

<div id="container" class="content">
	<div id="content" role="main">
<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php /*if ( $wp_query->max_num_pages > 1 ) : ?>
	<div id="nav-above" class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'infinite' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'infinite' ) ); ?></div>
	</div><!-- #nav-above -->
<?php endif;*/ ?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'Not Found', 'infinite' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'infinite' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>

<?php
	/* Start the Loop.
	 *
	 * In Twenty Ten we use the same loop in multiple contexts.
	 * It is broken into three main parts: when we're displaying
	 * posts that are in the gallery category, when we're displaying
	 * posts in the asides category, and finally all other posts.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */ ?>
<?php while ( have_posts() ) : the_post(); ?>

<?php $subtitle->the_meta(); ?>
<?php /* How to display posts of the Gallery format. The gallery category is the old way. */ ?>
	<?php if ( ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) ) || in_category( _x( 'gallery', 'gallery category slug', 'infinite' ) ) ) : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<<?php print is_front_page()?'h2':'h1'; ?> class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'infinite' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></<?php print is_front_page()?'h2':'h1'; ?>>
			<div class="entry-meta">
				<?php infinite_posted_on(); ?>
			</div><!-- .entry-meta -->

			<div class="entry-content">
<?php if ( post_password_required() ) : ?>
				<?php the_content(); ?>
<?php else : ?>
				<?php
					$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
					if ( $images ) :
						$total_images = count( $images );
						$image = array_shift( $images );
						$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
				?>
						<div class="gallery-thumb">
							<a class="size-thumbnail" href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
						</div><!-- .gallery-thumb -->
						<p><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'infinite' ),
								'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'infinite' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
								number_format_i18n( $total_images )
							); ?></em></p>
				<?php endif; ?>
						<?php the_excerpt(); ?>
<?php endif; ?>
			</div><!-- .entry-content -->

			<div class="entry-utility">
			<?php if ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) ) : ?>
				<a href="<?php echo get_post_format_link( 'gallery' ); ?>" title="<?php esc_attr_e( 'View Galleries', 'infinite' ); ?>"><?php _e( 'More Galleries', 'infinite' ); ?></a>
				<span class="meta-sep">|</span>
			<?php elseif ( in_category( _x( 'gallery', 'gallery category slug', 'infinite' ) ) ) : ?>
				<a href="<?php echo get_term_link( _x( 'gallery', 'gallery category slug', 'infinite' ), 'category' ); ?>" title="<?php esc_attr_e( 'View posts in the Gallery category', 'infinite' ); ?>"><?php _e( 'More Galleries', 'infinite' ); ?></a>
				<span class="meta-sep">|</span>
			<?php endif; ?>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'infinite' ), __( '1 Comment', 'infinite' ), __( '% Comments', 'infinite' ) ); ?></span>
				<?php edit_post_link( __( 'Edit', 'infinite' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->

<?php /* How to display posts of the Aside format. The asides category is the old way. */ ?>

	<?php elseif ( ( function_exists( 'get_post_format' ) && 'aside' == get_post_format( $post->ID ) ) || in_category( _x( 'asides', 'asides category slug', 'infinite' ) )  ) : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if ( is_archive() || is_search() ) : // Display excerpts for archives and search. ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'infinite' ) ); ?>
			</div><!-- .entry-content -->
		<?php endif; ?>

			<div class="entry-utility">
				<?php infinite_posted_on(); ?>
				<span class="meta-sep">|</span>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'infinite' ), __( '1 Comment', 'infinite' ), __( '% Comments', 'infinite' ) ); ?></span>
				<?php edit_post_link( __( 'Edit', 'infinite' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->
<?php /* How to display speaker posts. */ ?>
		<?php elseif('msd_speaker' == $post->post_type ) : ?>
		<?php global $speaker_title,$speakers; 
	    	$speaker_title->the_meta($post->ID);
	    	$speakers->the_meta($post->ID);?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php the_post_thumbnail('medium', array('class' => 'alignright')); ?>
			<<?php print is_front_page()?'h2':'h1'; ?> class="entry-title"><?php the_title(); ?></<?php print is_front_page()?'h2':'h1'; ?>>
			<?php if($speaker_title->get_the_value('speaker_title')!=''): ?>
			<h2><?php $speaker_title->the_value('speaker_title'); ?></h2>
			<?php endif; ?>
			<?php if($speakers->get_the_value('focus-areas')!=''): ?>
			<p><strong>Focus Area:</strong> <?php $speakers->the_value('focus-areas'); ?></p>
			<?php endif; ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'infinite' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'infinite' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->

			<div class="entry-utility">
				<?php edit_post_link( __( 'Edit', 'infinite' ), '<span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->
<?php /* How to display session posts. */ ?>
		<?php elseif('msd_session' == $post->post_type ) : ?>
		<?php global $session_info,$timeslots,$tracks; 
	    	$session_info->the_meta($post->ID);
	    	?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<<?php print is_front_page()?'h2':'h1'; ?> class="entry-title"><?php the_title(); ?></<?php print is_front_page()?'h2':'h1'; ?>>
			<h2>
			<?php if($the_track = (int) $session_info->get_the_value('track')){print $tracks[$the_track].' | ';} ?>
			<?php if($the_time = (int) $session_info->get_the_value('timeslot') + 1){print $timeslots[$the_time-1];} ?>
			</h2>
			<?php while($session_info->have_fields('moderator')): ?>
			<?php if($session_info->is_first()){ ?>
			<h2>Moderator(s): 
			<?php } ?>
			<?php $speaker = get_post($session_info->get_the_value());?>
			<a href="<?php print get_permalink($speaker->ID);?>">
			<?php print $speaker->post_title; ?>
			</a>
			<?php if($session_info->is_last()){ ?>
			</h2>
			<?php } else { ?>
			, 
			<?php } ?>
			<?php endwhile; ?>
			<?php while($session_info->have_fields('speaker')): ?>
			<?php if($session_info->is_first()){ ?>
			<h2>Presenter(s): 
			<?php } ?>
			<?php $speaker = get_post($session_info->get_the_value());?>
			<a href="<?php print get_permalink($speaker->ID);?>">
			<?php print $speaker->post_title; ?>
			</a>
			<?php if($session_info->is_last()){ ?>
			</h2>
			<?php } else { ?>
			, 
			<?php } ?>
			<?php endwhile; ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'infinite' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'infinite' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->

			<div class="entry-utility">
				<?php edit_post_link( __( 'Edit', 'infinite' ), '<span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->
<?php /* How to display all other posts. */ ?>
<?php elseif(is_page()) : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<<?php print is_front_page()?'h2':'h1'; ?> class="entry-title"><?php the_title(); ?></<?php print is_front_page()?'h2':'h1'; ?>>
			<?php if($subtitle->get_the_value('subtitle')!=''): ?>
			<h2><?php $subtitle->the_value('subtitle'); ?></h2>
			<?php endif; ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'infinite' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'infinite' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->

			<div class="entry-utility">
				<?php edit_post_link( __( 'Edit', 'infinite' ), '<span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->
		
	<?php else : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<<?php print is_front_page()?'h2':'h1'; ?> class="entry-title"><?php if(!is_single()){ ?><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'infinite' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php } ?><?php the_title(); ?><?php if(!is_single()){ ?></a><?php } ?></<?php print is_front_page()?'h2':'h1'; ?>>

			<div class="entry-meta">
				<?php infinite_posted_on(); ?>
			</div><!-- .entry-meta -->

	<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
	<?php else : ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'infinite' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'infinite' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
	<?php endif; ?>

			<div class="entry-utility">
				<?php if ( count( get_the_category() ) ) : ?>
					<span class="cat-links">
						<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'infinite' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
					</span>
					<span class="meta-sep">|</span>
				<?php endif; ?>
				<?php
					$tags_list = get_the_tag_list( '', ', ' );
					if ( $tags_list ):
				?>
					<span class="tag-links">
						<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'infinite' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
					</span>
					<span class="meta-sep">|</span>
				<?php endif; ?>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'infinite' ), __( '1 Comment', 'infinite' ), __( '% Comments', 'infinite' ) ); ?></span>
				<?php edit_post_link( __( 'Edit', 'infinite' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->

		<?php comments_template( '', true ); ?>

	<?php endif; // This was the if statement that broke the loop into three parts based on categories. ?>

<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'infinite' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'infinite' ) ); ?></div>
				</div><!-- #nav-below -->
<?php endif; ?>

	</div><!-- #content -->
</div><!-- #container -->