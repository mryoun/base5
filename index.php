<?php get_header(); ?> 

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<div class="entry-meta">
					<span>Posted on</span> <time datetime="<?php echo date(DATE_W3C); ?>" pubdate><?php the_time('F jS, Y') ?></time>
				</div>
			</header>
			<div class="entry">
				<?php the_content(); ?>
			</div>
			<footer>
				<?php the_tags(); ?> 
				<p>Posted in <?php the_category(', '); ?></p>
				<p class="comments"><?php comments_popup_link('No Comments &#187;', '1 Comment #187;', '% Comments &#187;'); ?></p>
			</footer>
		</article>
<?php endwhile; else : ?> 

		<h2>Not Found</h2>

<?php endif; ?> 
		
<?php get_footer(); ?>
