<?php
/*
Template Name: Single Post
*/
?>
<?php get_header(); ?>

<div id="content" class="content-singular content-single">
	<div class="pad append-clear wrap-inner-3">
		<div id="post-<?php the_ID(); ?>" <?php post_class('hentry-large'); ?>>

<?php while (have_posts()) : ?>
	<?php the_post(); ?>

<?php 
	if (function_exists('bcn_display')) { 
		echo '<p class="breadcrumb">';
		bcn_display(); 
		echo '</p>';
	} 
?>	

<div class="title">
	<h1><?php the_title(); ?></h1>
</div>
<div class="meta append-clear">
	<p>				
		<span class="date"><?php the_time(get_option('date_format')); ?></span> |
		<span class="category"><?php the_category(', '); ?></span> |
		<span class="comments"><a href="<?php comments_link(); ?> "><?php echo comments_number('no comments', '1 comment', '% comments'); ?></a></span>
	</p>
	<?php padd_theme_share_button(); ?>
</div>
<div class="content">
	<?php the_content(); ?>
	<?php wp_link_pages(array('before' => '<p class="pages"><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
</div>
<div class="post-box post-box-share append-clear">
	<div class="title">
		<h2>Share Our Post</h2>
	</div>
	<?php
		remove_filter('excerpt_more','padd_theme_hook_excerpt_index_more');
		add_filter('get_the_excerpt','padd_theme_hook_excerpt_bookmark');
		add_filter('excerpt_more','padd_theme_hook_excerpt_bookmark_more');
		$padd_sb_url = urlencode(get_permalink());
		$padd_sb_title = urlencode(get_the_title());
		$padd_sb_notes = urlencode(get_the_excerpt());
		$padd_img_path = get_template_directory_uri() . '/images/icon-bm-32-%s.png';
	?>
	<div class="interior append-clear">
		<ul>
		<?php
			global $padd_socialbook;
			foreach ($padd_socialbook as $k => $psb) {
				$psb->set_ref_url($padd_sb_url);
				$psb->set_title($padd_sb_title);
				$psb->set_excerpt($padd_sb_notes);
				$psb->set_content('<img alt="' . $psb->get_network() . '" src="' . sprintf($padd_img_path, $k) . '" />');
				echo '<li>' . $psb . '</li>';
			}
		?>
		</ul>
	</div>
</div>
<?php 
	$enabled = get_option(PADD_NAME_SPACE . '_rp_enable');
	if ($enabled) { 
?>
<div class="post-box post-box-related">
	<div class="title">
		<h2>Related Posts</h2>
	</div>
	<div class="interior append-clear">
		<?php padd_theme_single_related_posts(get_the_ID()); ?>
	</div>
</div>
<?php } ?>
<?php comments_template('',true); ?>
<?php endwhile; ?>

		</div>
	</div>
</div>

<?php get_sidebar(); ?>

<div class="clear"></div>

<?php get_footer(); ?>