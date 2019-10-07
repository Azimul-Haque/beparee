<footer id="footer" class="dark">

	<div class="container">

		<!-- Footer Widgets
		============================================= -->
		<div class="footer-widgets-wrap clearfix">

			<div class="col_one_third">

				<div class="widget clearfix">
					<h4>দোকান খাতা</h4>
					<div style="background: url('/vendor/canvas/images/world-map.png') no-repeat center center; background-size: 100%;">
						<address>
							<strong>দোকান খাতা</strong><br>
							ঢাকা, বাংলাদেশ<br>
						</address>
						<abbr title="ফোন নম্বর"><strong>ফোন নম্বরঃ</strong></abbr> (+88) 01515 297 658<br>
						<abbr title="ফোন নম্বর"><strong>ফোন নম্বরঃ</strong></abbr> (+88) 01751 398 392<br>
						<abbr title="ইমেল"><strong>ইমেল:</strong></abbr> support@dokankhata.com
					</div>

				</div>

			</div>

			<div class="col_one_third">

				<div class="widget clearfix">
					<h4>ক্লায়েন্ট প্রশংসাপত্র</h4>

					<div class="fslider testimonial no-image nobg noborder noshadow nopadding" data-animation="slide" data-arrows="false">
						<div class="flexslider">
							<div class="slider-wrap">
								<div class="slide">
									{{-- <div class="testi-image">
										<a href="#"><img src="/vendor/canvas/images/testimonials/3.jpg" alt="Customer Testimonails"></a>
									</div> --}}
									<div class="testi-content">
										<p>Similique fugit repellendus expedita excepturi iure perferendis provident quia eaque. Repellendus, vero numquam?</p>
										<div class="testi-meta">
											Steve Jobs
											<span>Apple Inc.</span>
										</div>
									</div>
								</div>
								<div class="slide">
									{{-- <div class="testi-image">
										<a href="#"><img src="/vendor/canvas/images/testimonials/2.jpg" alt="Customer Testimonails"></a>
									</div> --}}
									<div class="testi-content">
										<p>Natus voluptatum enim quod necessitatibus quis expedita harum provident eos obcaecati id culpa corporis molestias.</p>
										<div class="testi-meta">
											Collis Ta'eed
											<span>Envato Inc.</span>
										</div>
									</div>
								</div>
								<div class="slide">
									{{-- <div class="testi-image">
										<a href="#"><img src="/vendor/canvas/images/testimonials/1.jpg" alt="Customer Testimonails"></a>
									</div> --}}
									<div class="testi-content">
										<p>Incidunt deleniti blanditiis quas aperiam recusandae consequatur ullam quibusdam cum libero illo rerum!</p>
										<div class="testi-meta">
											John Doe
											<span>XYZ Inc.</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>

			<div class="col_one_third col_last">

				<div class="widget clearfix"> {{-- quick-contact-widget --}}

					<h4>যোগাযোগ করুন</h4>

					<div class="quick-contact-form-result"></div>

					<form action="{{ route('send.message.from.site') }}" method="POST" class="">
						@csrf
						<div class="form-process"></div>

						<div class="input-group divcenter margin-bottom-five">
							<span class="input-group-addon"><i class="icon-user"></i></span>
							<input type="text" class="required form-control input-block-level" id="quick-contact-form-name" name="quick-contact-form-name" required="" placeholder="আপনার নাম" />
						</div>
						<div class="input-group divcenter margin-bottom-five">
							<span class="input-group-addon"><i class="icon-phone2"></i></span>
							<input type="text" class="required form-control input-block-level" id="quick-contact-form-phone" name="quick-contact-form-phone" required="" placeholder="ফোন নম্বর" />
						</div>
						<div class="input-group divcenter margin-bottom-five">
							<span class="input-group-addon"><i class="icon-email2"></i></span>
							<input type="text" class="required form-control email input-block-level" id="quick-contact-form-email" name="quick-contact-form-email" required="" placeholder="ইমেইল" />
						</div>
						<textarea class="required form-control input-block-level short-textarea margin-bottom-five" id="quick-contact-form-message" name="quick-contact-form-message" rows="4" cols="30" placeholder="কিভাবে সাহায্য করতে পারি?" required></textarea>
						<input type="text" class="hidden" id="quick-contact-form-botcheck" name="quick-contact-form-botcheck" value="" />
						<button class="btn btn-danger nomargin" type="submit">ইমেইল পাঠান</button>
					</form>

				</div>

			</div>

		</div><!-- .footer-widgets-wrap end -->

	</div>

	<!-- Copyrights
	============================================= -->
	<div id="copyrights">

		<div class="container clearfix">

			<div class="col_half">
				Copyrights &copy; {{ date('Y') }} All Rights Reserved by <b><a href="{{ url('/') }}">দোকান খাতা</a></b>
			</div>

			<div class="col_half col_last tright">
				<div class="fright clearfix">
					<a href="https://www.facebook.com/dokankhatabd" class="social-icon si-small si-borderless si-facebook" target="_blank">
						<i class="icon-facebook"></i>
						<i class="icon-facebook"></i>
					</a>

					<a href="#!" class="social-icon si-small si-borderless si-twitter">
						<i class="icon-twitter"></i>
						<i class="icon-twitter"></i>
					</a>

					<a href="#!" class="social-icon si-small si-borderless si-instagram">
						<i class="icon-instagram"></i>
						<i class="icon-instagram"></i>
					</a>

					<a href="#!" class="social-icon si-small si-borderless si-linkedin">
						<i class="icon-linkedin"></i>
						<i class="icon-linkedin"></i>
					</a>
				</div>

				<div class="clear"></div>

			</div>

		</div>

	</div>

</footer>