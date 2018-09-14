<?php
$title = 'Contact Us';
$body = 'index-4';
$description = 'Use our convenient contact form to reach us. Use our Google map to find us. We welcome your telephone calls as well.';
include 'includes/header.php';
?>

<!--=======content================================-->

<section id="content">
	<div class="container">
		<div class="block-3">
			<div class="row">
				<div class="col-md-12" id="find_us">
					<header>
						<h2 class="wow bounceInDown" data-wow-duration="1s" data-wow-delay="1s" data-wow-offset="10"><span>how to find us</span></h2>
					</header>
					<div id="content_map">
						<div class="google-map-api"> 
							<div id="map-canvas" class="gmap"></div> 
						</div> 
					</div>
					<p class="content"></p>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="block-4">
			<div class="row">
				<div class="col-md-12">
					<header>
						<h2 id="contact_form"  class="wow bounceInRight" data-wow-duration="1s" data-wow-delay="1.25s" data-wow-offset="1"><span>Contact form</span></h2>
					</header>
				</div>
			</div>
			<div class="row">
				<form id="contact-form">
					<div class="contact-form-loader"></div>
						<fieldset>
							<div class="col-md-6">
								<label class="name">
									<input type="text" name="name" placeholder="Name" value="" data-constraints="@Required @JustLetters" />
                                                                        <span class="empty-message">*This field is required.</span>
                                                                        <span class="error-message">*This is not a valid name.</span>
								</label>
								<label class="email">
									<input type="text" name="email" placeholder="E-mail" value="" data-constraints="@Required @Email" />
									<span class="empty-message">*This field is required.</span>
									<span class="error-message">*This is not a valid email.</span>
								</label>
								<label class="phone">
									<input type="text" name="phone" placeholder="Phone" value="" data-constraints="@Required @JustNumbers" />
									<span class="empty-message">*This field is required.</span>
									<span class="error-message">*This is not a valid phone.</span>
								</label>
							</div>
							<div class="col-md-6">
								<label class="message">
									<textarea name="message" placeholder="Comments" data-constraints='@Required @Length(min=20,max=999999)'></textarea>
									<span class="empty-message">*This field is required.</span>
									<span class="error-message">*The message is too short.</span>
								</label>
							</div>
							<!-- <label class="recaptcha"><span class="empty-message">*This field is required.</span></label> -->
						<div class="col-md-12">
							<div class="cont_btn">
								<a href="#" data-type="submit" class="btn-jb">Send message</a>
							</div>
						</div>
					</fieldset> 
					<div class="modal fade response-message">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">Modal title</h4>
								</div>
								<div class="modal-body">
									You message has been sent! We will be in touch soon.
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?php  
include 'includes/footer.php';
?>