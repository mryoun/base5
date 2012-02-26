
	</div><!-- /#main -->

	<footer id="footer" role="contentinfo">
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

<?php
// Display the year
function copyrightYear() {
	$year = 2012;

	if (date("Y") == $year) {
		echo $year;
	} else {
		echo $year . "-" . date("Y");
	}
}
?>
