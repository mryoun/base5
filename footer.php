
	</div><!-- /#main -->

	<footer id="footer" role="contentinfo">
		<nav>
			<?php wp_nav_menu( array('container' => false, 'menu' => 'nav_footer', 'depth' => '1' )); ?> 
		</nav>
		<p>&copy; <?php echo copyrightYear(); ?> <?php echo bloginfo('name'); ?>, <?php _e('All rights reserved.'); ?></p>
	</footer>

<?php get_footer(); ?> 

<script src="<?php bloginfo('template_directory'); ?>/js/fun.js"></script>

<script>
	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>
