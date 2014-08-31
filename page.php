<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		

<?php the_title(); ?>
<?php the_content(); ?>
			
<?php if (is_active_sidebar('page_sidebar')) : dynamic_sidebar('page_sidebar'); endif; ?>

<?php endwhile; ?>				
<?php else : ?>

<p><?php _e('Ooops, you shouldn\'t be here!.', $theme_name); ?></p>

<?php endif; ?>

<?php get_footer(); ?>