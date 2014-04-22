<?php
/**
 * Represents the view for the public-facing component of the plugin.
 *
 * This typically includes any information, if any, that is rendered to the
 * frontend of the theme when the plugin is activated.
 *
 */


// This file is used to markup the public facing aspect of the plugin.
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
if($myPopup->showPopup(get_the_ID()) && !isset($_COOKIE["rscustompopup_popup"])){
	// We need to show the popup
	?>
	<div class="rscustompopup-overlay"></div>
	<div class="rscustompopup-modal">
		<div class="rscustompopup-image">
			<a href="<?php echo $myPopup->getURL(); ?>">
				<img src="<?php echo $myPopup->getImage(); ?>" />
			</a>
		</div>
		<div class="rscustompopup-close" style="background:<?php echo $myPopup->getBackColour(); ?>;color:<?php echo $myPopup->gettextColour(); ?>;">X</div>
	</div>
	<?php
}