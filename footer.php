	</article>

	<hr>

	<footer id="footer" role="contentinfo">
		<p>&copy; <?php echo copyrightYear(); ?> <a href="<?php echo home_url( '/' ); ?>"><?php bloginfo('name'); ?></a>, <?php _e('All rights reserved.', 'base5'); ?></p>
	</footer>

<?php get_footer(); ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-min.js"><\/script>')</script>

<script src="<?php bloginfo('template_directory'); ?>/js/script.js"></script>

<script>
	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>
