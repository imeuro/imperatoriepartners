<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package IP24
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<span class="footer-logo">IMPERATORI&PARTNERS</span>
			<p>&copy; <?php echo date("Y"); ?> - Tutti i diritti riservati</p>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<script type="text/javascript">
function ip24Loader(objAttr, chainId = null, elementType = "script", target = document.body) {
	return new Promise(function (resolve, reject) {
		let element = document.createElement(elementType);

		for (const property in objAttr) {
			element.setAttribute(property, objAttr[property]);
		}
		let path = objAttr.src || objAttr.href;
		element.onload = () => {
			resolve(element);
			console.log(`[ip24Loader] ${path} caricato!`, "chainId_" + chainId + " Time: " + performance.now());
		};
		element.onerror = e => {
			reject(
				new Error(`[ip24Loader] Errore sul caricamento di ${path}`)
			);
			console.log(e);
		};

	    target.appendChild(element);
	});
}




ip24Loader({
	src: "<?php echo get_template_directory_uri().'/js/ip24.js' ?>",
	async: true
},"ip24Chain")
.then(
	element => ip24Loader({
		src: "<?php echo get_template_directory_uri().'/js/ip24Carousel.js' ?>",
		async: true
	}, "ip24Chain")
)
.then(element => {
	//initCommonScripts();
});
</script>
</body>
</html>
