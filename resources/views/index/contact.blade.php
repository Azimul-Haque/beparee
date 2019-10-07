@extends('layouts.app')

@section('css')

@endsection

@section('content')
   	<!-- Content
      ============================================= -->
      <section id="content">

         <div class="content-wrap">

            <div class="container clearfix">

               <!-- Contact Form
               ============================================= -->
               <div class="col_half">

                  <div class="fancy-title title-dotted-border">
                     <h3>আমাদের একটি ইমেইল পাঠান</h3>
                  </div>

                  <div class="contact-widget">

                     <div class="contact-form-result"></div>

                     <form class="nobottommargin" id="template-contactform" name="template-contactform" action="{{ route('send.message.from.site') }}" method="post">

                        <div class="form-process"></div>
                        @csrf
                        <div class="col_one_third">
                           <label for="template-contactform-name">নাম <small>*</small></label>
                           <input type="text" id="template-contactform-name" name="template-contactform-name" value="" class="sm-form-control required" />
                        </div>

                        <div class="col_one_third">
                           <label for="template-contactform-email">ইমেইল </label>
                           <input type="email" id="template-contactform-email" name="template-contactform-email" value="" class="required email sm-form-control" />
                        </div>

                        <div class="col_one_third col_last">
                           <label for="template-contactform-phone">মোবাইল <small>*</small></label>
                           <input type="text" id="template-contactform-phone" name="template-contactform-phone" value="" class="sm-form-control" />
                        </div>

                        <div class="clear"></div>

                  
                        <div class="col_full">
                           <label for="template-contactform-message">কিভাবে সাহায্য করতে পারি?<small>*</small></label>
                           <textarea class="required sm-form-control" id="template-contactform-message" name="template-contactform-message" rows="6" cols="30"></textarea>
                        </div>

                        <div class="col_full hidden">
                           <input type="text" id="template-contactform-botcheck" name="template-contactform-botcheck" value="" class="sm-form-control" />
                        </div>

                        <div class="col_full">
                           <button name="submit" type="submit" id="submit-button" tabindex="5" value="Submit" class="button button-3d nomargin">দাখিল করুন</button>
                        </div>

                     </form>
                  </div>

               </div><!-- Contact Form End -->

               <!-- Google Map
               ============================================= -->
               <div class="col_half col_last">

                  <div class="mapouter">
                     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d47716.03904442399!2d90.38875557984906!3d23.80306744665907!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b087026b81%3A0x8fa563bbdd5904c2!2sDhaka!5e0!3m2!1sen!2sbd!4v1570466286033!5m2!1sen!2sbd" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                  </div>
               </div><!-- Google Map End -->

               <div class="clear"></div>

               <!-- Contact Info
               ============================================= -->
               <div class="row clear-bottommargin">

                  <div class="col-md-3 col-sm-6 bottommargin clearfix">
                     <div class="feature-box fbox-center fbox-bg fbox-plain">
                        <div class="fbox-icon">
                           <a href="#"><i class="icon-map-marker2"></i></a>
                        </div>
                        <h3>অফিস <span class="subtitle">Melbourne, Australia</span></h3>
                     </div>
                  </div>

                  <div class="col-md-3 col-sm-6 bottommargin clearfix">
                     <div class="feature-box fbox-center fbox-bg fbox-plain">
                        <div class="fbox-icon">
                           <a href="#"><i class="icon-phone3"></i></a>
                        </div>
                        <h3>প্রয়োজনে কাল করুন<span class="subtitle">(123) 456 7890</span></h3>
                     </div>
                  </div>

                  <div class="col-md-3 col-sm-6 bottommargin clearfix">
                     <div class="feature-box fbox-center fbox-bg fbox-plain">
                        <div class="fbox-icon">
                           <a href="https://www.facebook.com/dokankhatabd"><i class="icon-facebook"></i></a>
                        </div>
                        <h3>ফেইসবুক পেজ<span class="subtitle">Dokan Khata - দোকান খাতা</span></h3>
                     </div>
                  </div>

                  <div class="col-md-3 col-sm-6 bottommargin clearfix">
                     <div class="feature-box fbox-center fbox-bg fbox-plain">
                        <div class="fbox-icon">
                           <a href="#"><i class="icon-email2"></i></a>
                        </div>
                        <h3>ইমেইল করুন<span class="subtitle">abc@gmail.com</span></h3>
                     </div>
                  </div>

               </div><!-- Contact Info End -->

            </div>

         </div>

      </section><!-- #content end -->
@endsection

@section('js')
   
@endsection

