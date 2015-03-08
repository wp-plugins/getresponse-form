<div id="grfc_form_container" class="grfc_form_container" style="background-color:<?php echo $background_color; ?>">
	<div id="grfc_headline" class="grfc_headline"><?php echo $headline; ?></div>
	<?php
		if($image){
	?>
	<div id="grfc_image" class="grfc_image"><img src="<?php echo $image ?>"/></div>
	<?php
		} //end if($image)
	?>
	<div id="grfc_message" class="grfc_message"><?php echo wpautop($message); ?></div>
	<div id="grfc_form_box">
		<form action="https://app.getresponse.com/add_subscriber.html" id="grfc_form" accept-charset="utf-8" method="post">
			<div id="grfc_name_field">
				<input type="text" name="name" placeholder="Enter Your Name" class="grfc_name">
			</div>
			<div id="grfc_email_field">
				<input type="text" name="email" placeholder="Enter Your Email" class="grfc_email">
			</div>
			<input type="hidden" name="campaign_token" value="<?php echo $getresponse_campaign_token ?>">
		</form>
	</div>
	<div id="grfc_button" class="grfc_button">
		<a class="btn" href="#" style="background:<?php echo $button_color; ?>"><?php echo $button_text; ?></a>
	</div>
</div>
