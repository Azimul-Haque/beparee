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
   					<h1>দোকান খাতা<span>য়</span> <span>আপনাকে স্বাগতম</span></h1>
   					<h1></h1>
   					<h2>দোকান খাতা (Dokan Khata) অনলাইন প্লাটফর্ম, সব হিসাব এখানেই! আপনার যাবতীয় ব্যবসায়ী হিসাব এখন সহজ করে দিতে আমরা এসেছি আপনার প্রতিষ্ঠানে!</h2>
   					<a href="#section-features-homepage" data-href="" class="button button-3d button-dark button-large ">ফিচারগুলো দেখুন</a>
   					<a href="/contact" class="button button-3d button-large">যোগাযোগ করুন</a>
   				</div>

   			</div>

   			<div class="clear"></div>
   		</div>
   	</section>
   	<section id="content">

   		<div class="content-wrap" id="section-features-homepage">

   			<section id="section-services" class="section page-section topmargin-lg">

   				<div class="heading-block title-center center bottommargin-lg">
   					<h2>ফিচার পর্যালোচনা</h2>
   				</div>

   				<div class="container clearfix">
   					<div class="col_one_third">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn">
   								<a href="#!"><img src="{{ asset('/images/icons/features/malamal.png') }}" alt="মালামালের তালিকা"></a>
   							</div>
   							<h3>মালামালের তালিকা</h3>
   							<p>মালামালের ধরণ, পরিমাণভিত্তিক তালিকা, ডিলার/ ভেন্ডর ভিত্তিক মালামাল তালিকা, মালামাল ক্রয়, মালামালের বিস্তারিত রিপোর্ট </p>
   						</div>
   					</div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="200">
   								<a href="#!"><img src="{{ asset('/images/icons/features/shopping.png') }}" alt="ক্রয়ের-বিক্রয়ের হিসাব"></a>
   							</div>
   							<h3>ক্রয়ের-বিক্রয়ের হিসাব</h3>
   							<p>ক্রয় কার্যক্রম, ক্রয় রশিদ নং সহ তালিকা, ডিলা/ ভেন্ডরের দেনা/ পরিশোধনীয়সহ যাবতীয় ক্রিয়াকলাপ, ক্রয়ের রশিদ ডাউনলোড ইত্যাদি</p>
   						</div>
   					</div>

   					<div class="col_one_third col_last">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="400">
   								<a href="#!"><img src="{{ asset('/images/icons/features/employee.png') }}" alt="কর্মচারী ব্যবস্থাপনা"></a>
   							</div>
   							<h3>কর্মচারী ব্যবস্থাপনা</h3>
   							<p>কর্মচারী উপস্থিতি, ছুটি ব্যবস্থাপনা, বেতন-ভাতা প্রদান কার্যক্রম, উপস্থিতির রিপোর্ট, বেতন-ভাতার রিপোর্ট ইত্যাদি</p>
   						</div>
   					</div>

   					<div class="clear"></div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="600">
   								<a href="#!"><img src="{{ asset('/images/icons/features/dena-bokyea.png') }}" alt="দেনার-বকেয়ার হিসাব"></a>
   							</div>
   							<h3>দেনার-বকেয়ার হিসাব</h3>
   							<p>ডিলার/ ভেন্ডরের দেনার যাবতীয় হিসাব, রশিদ ও রিপোর্ট, কাস্টমারের বকেয়ার যাবতীয় হিসাব, রশিদ ও রিপোর্ট, দেনা ও বকেয়া পরিশোধ কার্যক্রম</p>
   						</div>
   					</div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="800">
   								<a href="#!"><img src="{{ asset('/images/icons/features/invoice.png') }}" alt="ইনভয়েস ব্যবস্থাপনা"></a>
   							</div>
   							<h3>ইনভয়েস ব্যবস্থাপনা</h3>
   							<p>পণ্য বিক্রয়ের ইনভয়েস/ রশিদ, বিক্রয়সমূহের তালিকা, কাস্টমারের বাকী-বকেয়াসহ বিক্রয়ের লাভ-লোকশানের রিপোর্ট, গ্রাফ ইত্যাদি</p>
   						</div>
   					</div>

   					<div class="col_one_third col_last">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="1000">
   								<a href="#!"><img src="{{ asset('/images/icons/features/expenses.png') }}" alt="খরচের হিসাব"></a>
   							</div>
   							<h3>খরচের হিসাব</h3>
   							<p>খাতভিত্তিক খরচের হিসাব সংরক্ষণ ক্রিয়াকলাপ, বেতন-ভাতা, নানাবিধ বিল, আপ্যায়ন ইত্যাদি খরচ লিপিবদ্ধকরণ, সকল খরচের রিপোর্ট</p>
   						</div>
   					</div>

   					<div class="clear"></div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="1200">
   								<a href="#!"><img src="{{ asset('/images/icons/features/customer.png') }}" alt="কাস্টমার ব্যবস্থাপনা"></a>
   							</div>
   							<h3>কাস্টমার ব্যবস্থাপনা</h3>
   							<p>কাস্টমার সংযোজন, কাস্টমার সম্পাদনা, কাস্টোমারের বাকী-বকেয়া ও হালখাতার রিপোর্ট, কাস্টমারের ক্রয়-তালিকা, বকেয়া পরিশোধ কার্যক্রম ইত্যাদি</p>
   						</div>
   					</div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="1400">
   								<a href="#!"><img src="{{ asset('/images/icons/features/dealer.png') }}" alt="ডিলার/ ভেন্ডর ব্যবস্থাপনা"></a>
   							</div>
   							<h3>ডিলার/ ভেন্ডর ব্যবস্থাপনা</h3>
   							<p>ডিলার/ ভেন্ডর সংযোজন, সম্পাদনা, ডিলার/ ভেন্ডরের দেনার রিপোর্ট, ডিলার থেকে ক্রয়-তালিকা, দেনা পরিশোধ কার্যক্রম ইত্যাদি</p>
   						</div>
   					</div>

   					<div class="col_one_third col_last">
   						<div class="feature-box fbox-plain">
   							<div class="fbox-icon" data-animate="bounceIn" data-delay="1600">
   								<a href="#!"><img src="{{ asset('/images/icons/features/report.png') }}" alt="রিপোর্ট"></a>
   							</div>
   							<h3>রিপোর্ট</h3>
   							<p>সুবিধামাফিক পিডিএফ ফরম্যাটে রিপোর্ট ডাউনলোড ও প্রিন্টের ব্যবস্থা, মালামাল, ক্রয়, বিক্রয়, দেনা-বকেয়া, ডিলার-কাস্টমার-কর্মচারী ইত্যাদির রিপোর্ট তৈরি</p>
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
   								<a href="#!"><i class="fa fa-list-ol"></i></a>
   							</div>
   							<h3>এক প্লাটফর্ম একাধিক দোকান </h3>
   							<p>একটিমাত্র একাউন্ট ব্যবহার করে একাধিক দোকান ব্যবস্থাপনা আমাদের অভিনব সংযোজন!</p>
   						</div>
   					</div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="200">
   							<div class="fbox-icon">
   								<a href="#!"><i class="fa fa-bar-chart"></i></a>
   							</div>
   							<h3>নির্ভুল হিসাবনিকাশ</h3>
   							<p>সফটওয়্যারের মাধ্যমে শতভাগ নির্ভুল ও নিখুঁত হিসাব-নিকাশ!</p>
   						</div>
   					</div>

   					<div class="col_one_third col_last">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="400">
   							<div class="fbox-icon">
   								<a href="#!"><i class="fa fa-clock-o"></i></a>
   							</div>
   							<h3>সময়ের অপচয় রোধ</h3>
   							<p>সারা সপ্তাহের হিসাব নিমেষেই, দৈনিক কমপক্ষে ৮ ঘণ্টা সাশ্রয়!</p>
   						</div>
   					</div>

   					<div class="clear"></div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="600">
   							<div class="fbox-icon">
   								<a href="#!"><i class="fa fa-cloud-upload"></i></a>
   							</div>
   							<h3>ক্লাউড বেসড</h3>
   							<p>সম্পূর্ণরূপে ক্লাউডবেসড হওয়ায় আপনার মূল্যবান ব্যবসায়ী তথ্যগুলো হারাবার কোন ভয় নেই!</p>
   						</div>
   					</div>

   					<div class="col_one_third">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="800">
   							<div class="fbox-icon">
   								<a href="#!"><i class="fa fa-lock"></i></a>
   							</div>
   							<h3>নিরাপদ</h3>
   							<p>দোকান খাতা ১০০% নিরাপদ ও ঝুকিমুক্ত একটি অনলাইন প্লাটফর্ম!</p>
   						</div>
   					</div>

   					<div class="col_one_third col_last">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="1000">
   							<div class="fbox-icon">
   								<a href="#!"><i class="fa fa-language"></i></a>
   							</div>
   							<h3>সম্পূর্ণ বাংলা ভাষায়</h3>
   							<p>আমরাই প্রথম ব্যবসায়ী সফটওয়্যারকে সম্পূর্ণ বাংলায় ব্যবহারের উপযোগী করে এনেছি আপনাদের সামনে!</p>
   						</div>
   					</div>

   					<div class="clear"></div>

   					<div class="col_one_third nobottommargin">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="1200">
   							<div class="fbox-icon">
   								<a href="#!"><i class="fa fa-users"></i></a>
   							</div>
   							<h3>আনলিমিটেড ইউজার</h3>
   							<p>সামান্য খরচের এ প্লাটফর্মে আমরাই দিচ্ছি একটি দোকানের জন্য সীমাহীন ব্যবহারকারীর থাকার সুযোগ!</p>
   						</div>
   					</div>

   					<div class="col_one_third nobottommargin">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="1400">
   							<div class="fbox-icon">
   								<a href="#!"><i class="fa fa-phone"></i></a>
   							</div>
   							<h3>২৪/৭ সাপোর্ট</h3>
   							<p>আপনার ছোট ছোট সমস্যাগুলো সমাধানকল্পে আমাদের প্রতিনিধিদের পাচ্ছেন ২৪ ঘণ্টা, ৭ দিন!</p>
   						</div>
   					</div>

   					<div class="col_one_third nobottommargin col_last">
   						<div class="feature-box fbox-center fbox-effect nobottomborder" data-animate="fadeIn" data-delay="1600">
   							<div class="fbox-icon">
   								<a href="#!"><i class="fa fa-android"></i></a>
   							</div>
   							<h3>ফ্রি মোবাইল অ্যাপ</h3>
   							<p>দোকান খাতা ব্যবহারকারীদের জন্য আমাদের আরেকটি অভিনব সংযোজন, ফ্রি মোবাইল অ্যাপ (অ্যান্ড্রয়েড)</p>
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
   								<h3>ইনস্টলেশন বাবদ মাত্র ১০০০০ টাকা প্রদান করে সার্ভিসটি চালু করতে হবে</h3>
   							</div>
   							<div class="pricing-features">
   								<ul class="clearfix">
   									<li><i class="fa fa-star-o"></i> ২৪/৭ সাপোর্ট</li>
   									<li><i class="fa fa-star-o"></i> আনলিমিটেড ইউজার</li>
   									<li><i class="fa fa-star-o"></i> আনলিমিটেড ইনভয়েস</li>
   									<li><i class="fa fa-star-o"></i> আনলিমিটেড স্টোরেজ</li>
   									<li><i class="fa fa-star-o"></i> সহজে ব্যবহার যোগ্য</li>
   									<li><i class="fa fa-star-o"></i> আনলিমিটেড প্রোডাক্ট </li>
   									<li><i class="fa fa-star-o"></i> ডাটার ১০০% নিরাপত্তা</li>
   									<li><i class="fa fa-star-o"></i> ফ্রী মোবাইল অ্যাপ</li>
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
   								<a href="/contact" class="button button-3d button-xlarge btn-block nomargin">শুরু করুন</a>
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
   						<span>আপনাকে সহায়তা করতে দোকানখাতা টিম সর্বদা প্রস্তুত</span>
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

