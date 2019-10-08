@extends('layouts.app')

@section('title', 'দোকান খাতা (Dokan Khata)')

@section('css')
   	<!-- SLIDER REVOLUTION 5.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/canvas/include/rs-plugin/css/settings.css') }}" media="screen" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/canvas/include/rs-plugin/css/layers.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/canvas/include/rs-plugin/css/navigation.css') }}">
@endsection

@section('content')
   	@include('layouts._slider')

   	<section id="content">
   		<div class="content-wrap">

   			<div class="container clearfix">

   				<div class="divcenter center clearfix" style="max-width: 900px;">
   					<h1> <span>দোকানখাতায়</span> <span>আপনাকে স্বাগতম</span>.</h1>
   					<h1></h1>
   					<h2>দুই লাইনে বর্ণনা দুই লাইনে বর্ণনা লাইনে বর্ণনা দুই লাইনে বর্ণনা  দুই লাইনে বর্ণনা দুই লাইনে বর্ণনা  দুই লাইনে বর্ণনা দুই লাইনে বর্ণনা  </h2>
   					<a href="#section-features-homepage" data-href="" class="button button-3d button-dark button-large ">ফিচারগুলো দেখুন</a>
   					<a href="/contact" class="button button-3d button-large">যোগাযোগ করুন</a>
   				</div>

   			</div>

   			<div class="clear"></div>
   		</div>
   	</section>
   	<section id="content">

   		<div class="content-wrap" id="section-features-homepage">

   			<section id="section-services" class="section page-section topmargin-lg"><

   				<div class="heading-block title-center center bottommargin-lg">
   					<h2>ফিচার পর্যালোচনা</h2>
   				</div>

   				<div class="container clearfix">
   					<div class="col_one_third">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn">
   								<a href="#!"><img src="{{ asset('vendor/canvas/images/icons/features/responsive.png') }}" alt="Responsive Layout"></a>
   							</div>
   							<h3>মালামালের তালিকা</h3>
   							<p>Powerful Layout with Responsive functionality that can be adapted to any screen size. Resize browser to view.</p>
   						</div>
   					</div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="200">
   								<a href="#!"><img src="{{ asset('vendor/canvas/images/icons/features/retina.png') }}" alt="Retina Graphics"></a>
   							</div>
   							<h3>ক্রয়ের-বিক্রয়ের হিসাব</h3>
   							<p>Looks beautiful &amp; ultra-sharp on Retina Screen Displays. Retina Icons, Fonts &amp; all others graphics are optimized.</p>
   						</div>
   					</div>

   					<div class="col_one_third col_last">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="400">
   								<a href="#!"><img src="{{ asset('vendor/canvas/images/icons/features/performance.png') }}" alt="Powerful Performance"></a>
   							</div>
   							<h3>কর্মচারী ব্যবস্থাপনা</h3>
   							<p>Canvas includes tons of optimized code that are completely customizable and deliver unmatched fast performance.</p>
   						</div>
   					</div>

   					<div class="clear"></div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="600">
   								<a href="#!"><img src="{{ asset('vendor/canvas/images/icons/features/flag.png') }}" alt="Responsive Layout"></a>
   							</div>
   							<h3>দেনার-বকেয়ার হিসাব</h3>
   							<p>You have complete easy control on each &amp; every element that provides endless customization possibilities.</p>
   						</div>
   					</div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="800">
   								<a href="#!"><img src="{{ asset('vendor/canvas/images/icons/features/tick.png') }}" alt="Retina Graphics"></a>
   							</div>
   							<h3> ইনভয়েস ব্যবস্থাপনা</h3>
   							<p>Change your Website's Primary Scheme instantly by simply adding the dark class to the body.</p>
   						</div>
   					</div>

   					<div class="col_one_third col_last">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="1000">
   								<a href="#!"><img src="{{ asset('vendor/canvas/images/icons/features/tools.png') }}" alt="Powerful Performance"></a>
   							</div>
   							<h3>খরচের হিসাব</h3>
   							<p>Use any Font you like from Google Web Fonts, Typekit or other Web Fonts. They will blend in perfectly.</p>
   						</div>
   					</div>

   					<div class="clear"></div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="1200">
   								<a href="#!"><img src="{{ asset('vendor/canvas/images/icons/features/map.png') }}" alt="Responsive Layout"></a>
   							</div>
   							<h3>কাস্টমার ব্যবস্থাপনা</h3>
   							<p>Powerful Layout with Responsive functionality that can be adapted to any screen size. Resize browser to view.</p>
   						</div>
   					</div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="1400">
   								<a href="#!"><img src="{{ asset('vendor/canvas/images/icons/features/seo.png') }}" alt="Retina Graphics"></a>
   							</div>
   							<h3>ডিলার ব্যবস্থাপনা</h3>
   							<p>Looks beautiful &amp; ultra-sharp on Retina Screen Displays. Retina Icons, Fonts &amp; all others graphics are optimized.</p>
   						</div>
   					</div>

   					<div class="col_one_third col_last">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="1600">
   								<a href="#!"><img src="{{ asset('vendor/canvas/images/icons/features/support.png') }}" alt="Powerful Performance"></a>
   							</div>
   							<h3>রিপোর্ট </h3>
   							<p>Canvas includes tons of optimized code that are completely customizable and deliver unmatched fast performance.</p>
   						</div>
   					</div>

   					<div class="clear"></div>
   				</div>
   				
   	
   			</section>

   			<section id="section-services" class="page-section topmargin-lg">

   				<div class="heading-block center bottommargin-lg">
   					<h2>দোকানখাতার সুবিধাগুলো</h2>
   				</div>

   				<div class="container clearfix">

   					<div class="col_one_third">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn">
   							<div class="fbox-icon">
   								<a href="#!"><i class="icon-phone2"></i></a>
   							</div>
   							<h3>এক প্লাটফর্ম একাধিক দোকান </h3>
   							<p>Powerful Layout with Responsive functionality that can be adapted to any screen size.</p>
   						</div>
   					</div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="200">
   							<div class="fbox-icon">
   								<a href="#!"><i class="icon-eye"></i></a>
   							</div>
   							<h3>নির্ভুল হিসাবনিকাশ</h3>
   							<p>Looks beautiful &amp; ultra-sharp on Retina Displays with Retina Icons, Fonts &amp; Images.</p>
   						</div>
   					</div>

   					<div class="col_one_third col_last">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="400">
   							<div class="fbox-icon">
   								<a href="#!"><i class="icon-star2"></i></a>
   							</div>
   							<h3>সময়ের অপচয় রোধ</h3>
   							<p>Optimized code that are completely customizable and deliver unmatched fast performance.</p>
   						</div>
   					</div>

   					<div class="clear"></div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="600">
   							<div class="fbox-icon">
   								<a href="#!"><i class="icon-video"></i></a>
   							</div>
   							<h3>ক্লাউড বেসড</h3>
   							<p>Canvas provides support for Native HTML5 Videos that can be added to a Full Width Background.</p>
   						</div>
   					</div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="800">
   							<div class="fbox-icon">
   								<a href="#!"><i class="icon-params"></i></a>
   							</div>
   							<h3>নিরাপদ</h3>
   							<p>Display your Content attractively using Parallax Sections that have unlimited customizable areas.</p>
   						</div>
   					</div>

   					<div class="col_one_third col_last">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="1000">
   							<div class="fbox-icon">
   								<a href="#!"><i class="icon-fire"></i></a>
   							</div>
   							<h3>সম্পূর্ণ বাংলা ভাষায়</h3>
   							<p>Complete control on each &amp; every element that provides endless customization possibilities.</p>
   						</div>
   					</div>

   					<div class="clear"></div>

   					<div class="col_one_third nobottommargin">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="1200">
   							<div class="fbox-icon">
   								<a href="#!"><i class="icon-bulb"></i></a>
   							</div>
   							<h3>আনলিমিটেড ইউজার</h3>
   							<p>Change your Website's Primary Scheme instantly by simply adding the dark class to the body.</p>
   						</div>
   					</div>

   					<div class="col_one_third nobottommargin">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="1400">
   							<div class="fbox-icon">
   								<a href="#!"><i class="icon-heart2"></i></a>
   							</div>
   							<h3>২৪/৭ সাপোর্ট</h3>
   							<p>Stretch your Website to the Full Width or make it boxed to surprise your visitors.</p>
   						</div>
   					</div>

   					<div class="col_one_third nobottommargin col_last">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="1600">
   							<div class="fbox-icon">
   								<a href="#!"><i class="icon-note"></i></a>
   							</div>
   							<h3>ফ্রী মোবাইল অ্যাপ</h3>
   							<p>We have covered each &amp; everything in our Documentation including Videos &amp; Screenshots.</p>
   						</div>
   					</div>

   					<div class="clear"></div>

   				</div>

   				<div class="divider divider-short divider-center topmargin-lg"><i class="icon-star3"></i></div>

   			</section>

   			<section id="section-services" class="page-section topmargin-lg">

   				<div class="heading-block center bottommargin-lg">
   					<h2>সাবস্ক্রিপশন ফি</h2>
   				</div>

   				<div class="container clearfix">

   					<div class="pricing-box pricing-extended bottommargin clearfix">

   						<div class="pricing-desc">
   							<div class="pricing-title">
   								<h3>ইনস্টলেশন ফি বাবদ ১০০০০ টাকা প্রদান করে সার্ভিসটি চালু করতে হবে </h3>
   							</div>
   							<div class="pricing-features">
   								<ul class="clearfix">
   									<li><i class="icon-star2"></i> ২৪/৭ সাপোর্ট</li>
   									<li><i class="icon-star2"></i> আনলিমিটেড ইউজার</li>
   									<li><i class="icon-star2"></i> আনলিমিটেড ইনভয়েস</li>
   									<li><i class="icon-star2"></i> আনলিমিটেড স্টোরেজ</li>
   									<li><i class="icon-star2"></i> সহজে ব্যবহার যোগ্য</li>
   									<li><i class="icon-star2"></i> আনলিমিটেড প্রোডাক্ট </li>
   									<li><i class="icon-star2"></i> ডাটার ১০০% নিরাপত্তা</li>
   									<li><i class="icon-star2"></i> ফ্রী মোবাইল অ্যাপ</li>
   								</ul>
   							</div>
   						</div>
   	
   						<div class="pricing-action-area">
   							<div class="pricing-meta">
   								মাত্র
   							</div>
   							<div class="pricing-price">
   								<span class="price-unit"></span>৫০০ টাকা<span class="price-tenure">মাসিক</span>
   							</div>
   							<div class="pricing-action">
   								<a href="contact.html" class="button button-3d button-xlarge btn-block nomargin">শুরু করুন</a>
   							</div>
   						</div>
   	
   					</div>

   					<div class="clear"></div>

   				</div>

   			</section>

   			<section id="section-buy" class="section page-section footer-stick">

   				<div class="container clearfix">

   					<div class="heading-block title-center nobottomborder">
   						<h2>পছন্দ হয়েছে?</h2>
   						<span>আপনাকে সহায়তা করতে দোকানখাতা টীম সর্বদা প্রস্তুত</span>
   					</div>

   					<div class="center">

   						<a href="/contact" data-animate="tada" class="button button-3d button-teal button-xlarge nobottommargin"><i class="icon-star3"></i>যোগাযোগ করুন</a> - অথবা - <a href="/demo" data-scrollto="#section-pricing" class="button button-3d button-red button-xlarge nobottommargin"><i class="icon-user2"></i>ডেমো দেখুন</a>

   					</div>

   				</div>

   			</section>

   		</div>

   	</section>
   	{{-- <public-main></public-main> --}}
@endsection

@section('js')
   	<!-- SLIDER REVOLUTION 5.x SCRIPTS  -->
   	<script type="text/javascript" src="{{ asset('vendor/canvas/include/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
   	<script type="text/javascript" src="{{ asset('vendor/canvas/include/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>

   	<script type="text/javascript" src="{{ asset('vendor/canvas/include/rs-plugin/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
   	<script type="text/javascript" src="{{ asset('vendor/canvas/include/rs-plugin/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
   	<script type="text/javascript" src="{{ asset('vendor/canvas/include/rs-plugin/js/extensions/revolution.extension.navigation.min.js') }}"></script>
   	<script type="text/javascript" src="{{ asset('vendor/canvas/include/rs-plugin/js/extensions/revolution.extension.parallax.min.js') }}"></script>
   	{{-- <script type="text/javascript" src="{{ asset('vendor/canvas/include/rs-plugin/js/extensions/revolution.extension.video.min.js') }}"></script> --}}


   	<!-- main scripts -->
   	{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
   	
   	<script type="text/javascript">
   	    var tpj=jQuery;
   	    var revapi34;
   	    tpj(document).ready(function() {
   	        if(tpj("#rev_slider_34_1").revolution == undefined){
   	            revslider_showDoubleJqueryError("#rev_slider_34_1");
   	        }else{
   	            revapi34 = tpj("#rev_slider_34_1").show().revolution({
   	                sliderType:"standard",
   	                jsFileLocation:"include/rs-plugin/js/",
   	                sliderLayout:"fullwidth",
   	                dottedOverlay:"none",
   	                delay:9000,
   	                navigation: {
   	                    keyboardNavigation:"on",
   	                    keyboard_direction: "horizontal",
   	                    mouseScrollNavigation:"off",
   	                    onHoverStop:"on",
   	                    touch:{
   	                        touchenabled:"on",
   	                        swipe_threshold: 75,
   	                        swipe_min_touches: 1,
   	                        swipe_direction: "horizontal",
   	                        drag_block_vertical: false
   	                    }
   	                    ,
   	                    arrows: {
   	                        style:"gyges",
   	                        enable:true,
   	                        hide_onmobile:false,
   	                        hide_over:778,
   	                        hide_onleave:false,
   	                        tmp:'',
   	                        left: {
   	                            h_align:"right",
   	                            v_align:"bottom",
   	                            h_offset:40,
   	                            v_offset:0
   	                        },
   	                        right: {
   	                            h_align:"right",
   	                            v_align:"bottom",
   	                            h_offset:0,
   	                            v_offset:0
   	                        }
   	                    }
   	                    ,
   	                    tabs: {
   	                        style:"erinyen",
   	                        enable:true,
   	                        width:250,
   	                        height:100,
   	                        min_width:250,
   	                        wrapper_padding:0,
   	                        wrapper_color:"transparent",
   	                        wrapper_opacity:"0",
   	                        tmp:'<div class="tp-tab-title">@{{title}}</div><div class="tp-tab-desc">@{{description}}</div>',
   	                        visibleAmount: 3,
   	                        hide_onmobile: true,
   	                        hide_under:778,
   	                        hide_onleave:false,
   	                        hide_delay:200,
   	                        direction:"vertical",
   	                        span:false,
   	                        position:"inner",
   	                        space:10,
   	                        h_align:"right",
   	                        v_align:"center",
   	                        h_offset:30,
   	                        v_offset:0
   	                    }
   	                },
   	                viewPort: {
   	                    enable:true,
   	                    outof:"pause",
   	                    visible_area:"80%"
   	                },
   	                responsiveLevels:[1240,1024,778,480],
   	                gridwidth:[1240,1024,778,480],
   	                gridheight:[500,450,400,350],
   	                lazyType:"none",
   	                parallax: {
   	                    type:"scroll",
   	                    origo:"enterpoint",
   	                    speed:400,
   	                    levels:[5,10,15,20,25,30,35,40,45,50],
   	                },
   	                shadow:0,
   	                spinner:"off",
   	                stopLoop:"off",
   	                stopAfterLoops:-1,
   	                stopAtSlide:-1,
   	                shuffle:"off",
   	                autoHeight:"off",
   	                hideThumbsOnMobile:"off",
   	                hideSliderAtLimit:0,
   	                hideCaptionAtLimit:0,
   	                hideAllCaptionAtLilmit:0,
   	                debugMode:false,
   	                fallbacks: {
   	                    simplifyAll:"off",
   	                    nextSlideOnWindowFocus:"off",
   	                    disableFocusListener:false,
   	                }
   	            });
   	        }
   	    });
   	</script>
@endsection

