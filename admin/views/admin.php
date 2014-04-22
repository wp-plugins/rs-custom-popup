<?php
/**
 * Represents the view for the administration dashboard.
 */
?>
<div class="wrap">
	<div class="icon32" id="admin-icon"><img src="<?php echo plugins_url( '../assets/images/large-icon.png', __FILE__ ); ?>"></div>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<br />
	<div class="updated"></div>
	<div class="error"></div>
	<div class="clear"></div>
	<h2>Create Popup</h2>
	<div class="left-border">
		<p>Please select an image for your popup (Enter a URL or upload an image)</p>
		<form id="create_entry_form_thumb">
			<p>
				<label for="upload_image">
				    <input id="upload_image" type="text" name="upload_image" value="http://" />
				    <input id="upload_button" class="button" type="button" value="Upload Image" />
				</label>
			</p>
			<p>Please add a URL for your popup to click through to</p>
			<p>
				<label for="image_title">
				    <input id="image_title" type="text" name="image_title" value="" placeholder="Popup Link">
				</label>
			</p>
			<p>Please select the pages you would like the popup to appear on (You can select more than one by holding down the 'ctrl' or 'cmd' button on your keyboard)</p>
			<p><?php echo $myPopup->outputPages(); ?></p>
			<p>Please select the background colour of the close button</p>
			<p>
				<input type="text" name="back-color" id="back-color" value="#000000" readonly>
			</p>
			<p>Please select the text colour of the close button</p>
			<p>
				<input type="text" name="front-color" id="front-color" value="#CC0000" readonly>
			</p>
			<p>When the user closes the popup, create a cookie that will stop the popup showing again for 31 days</p>
			<p><input type="radio" name="cookie" id="cookie" value="1">Yes</p>
			<p><input type="radio" name="cookie" id="cookie" value="0" checked>No</p>
		</form>
	</div>
	<br />
	<p>
		<input class="button-primary" type="button" name="add_popup" value="Create Popup" id="add_popup">
	</p>
	<br />
	<h2>Current Popup</h2>
	<table class="widefat">
		<thead>
		    <tr>
		        <th>Popup Image</th>
		        <th>Popup Link</th>
		        <th align="center">Popup Close Background Colour</th>
		        <th align="center">Popup Close Text Colour</th>
		        <th>Create Cookie</th>
		        <th>&nbsp;</th>
		    </tr>
		</thead>
		<!-- <tfoot>
		    <tr>
		    <th>Post Id</th>
		    <th>Post Title</th>
		    <th>Post Link</th>
		    </tr>
		</tfoot> -->
		<tbody class="popupTable">
		</tbody>
	</table>
</div>
