@extends('layouts.app')

@section('title', 'আমাদের সম্পর্কে | দোকান খাতা (Dokan Khata)')

@section('css')

@endsection

@section('content')
	<section id="section-about" class="page-section" style="margin-top: 5%;">

      <div class="container clearfix">

         <div class="heading-block center">
            <h2>আমরা <span>দোকানখাতা</span> পরিবার</h2>
            <span><a href="https://loencebd.com"> লোয়েন্স বাংলাদেশ</a> এর একটি অঙ্গ প্রতিষ্ঠান</span>
         </div>

         <div class="col_one_third nobottommargin">
            <div class="feature-box media-box">
               <div class="fbox-media">
                  <img src="/vendor/canvas/images/services/1.jpg" alt="Why choose Us?">
               </div>
               <div class="fbox-desc">
                  <h3>আমাদের ইতিহাস</h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi rem, facilis nobis voluptatum est voluptatem accusamus molestiae eaque perspiciatis mollitia.</p>
               </div>
            </div>
         </div>

         <div class="col_one_third nobottommargin">
            <div class="feature-box media-box">
               <div class="fbox-media">
                  <img src="/vendor/canvas/images/services/2.jpg" alt="Why choose Us?">
               </div>
               <div class="fbox-desc">
                  <h3>আমাদের মিশন</h3>
                  <p>Quos, non, esse eligendi ab accusantium voluptatem. Maxime eligendi beatae, atque tempora ullam. Vitae delectus quia, consequuntur rerum molestias quo.</p>
               </div>
            </div>
         </div>

         <div class="col_one_third nobottommargin col_last">
            <div class="feature-box media-box">
               <div class="fbox-media">
                  <img src="/vendor/canvas/images/services/3.jpg" alt="Why choose Us?">
               </div>
               <div class="fbox-desc">
                  <h3>আমরা যা করি</h3>
                  <p>Porro repellat vero sapiente amet vitae quibusdam necessitatibus consectetur, labore totam. Accusamus perspiciatis asperiores labore esse ab accusantium ea modi ut.</p>
               </div>
            </div>
         </div>

         <div class="clear"></div>

      </div>

      <div class="section dark parallax nobottommargin" style="padding: 80px 0;background-image: url('images/parallax/1.jpg');" data-stellar-background-ratio="0.3">

         <div class="container clearfix">

            <div class="col_one_fourth nobottommargin center" data-animate="bounceIn">
               <i class="i-plain i-xlarge divcenter nobottommargin icon-code"></i>
               <div class="counter counter-lined"><span data-from="0" data-to="64" data-refresh-interval="2" data-speed="3500"></span></div>
               <h5>জেলা</h5>
            </div>

            <div class="col_one_fourth nobottommargin center" data-animate="bounceIn" data-delay="200">
               <i class="i-plain i-xlarge divcenter nobottommargin icon-magic"></i>
               <div class="counter counter-lined"><span data-from="3000" data-to="480" data-refresh-interval="2" data-speed="2500"></span>+</div>
               <h5>উপজেলা</h5>
            </div>

            <div class="col_one_fourth nobottommargin center" data-animate="bounceIn" data-delay="400">
               <i class="i-plain i-xlarge divcenter nobottommargin icon-file-text"></i>
               <div class="counter counter-lined"><span data-from="10" data-to="386" data-refresh-interval="5" data-speed="3500"></span>*</div>
               <h5>দোকান</h5>
            </div>

            <div class="col_one_fourth nobottommargin center col_last" data-animate="bounceIn" data-delay="600">
               <i class="i-plain i-xlarge divcenter nobottommargin icon-time"></i>
               <div class="counter counter-lined"><span data-from="60" data-to="1200" data-refresh-interval="10" data-speed="3000"></span>+</div>
               <h5>ব্যবহারকারী</h5>
            </div>

         </div>

      </div>

   </section>
   	{{-- <public-main></public-main> --}}
@endsection

@section('js')
   
@endsection

