<!-- Header
============================================= -->
<header id="header" class="" data-sticky-class="not-dark"> 

	<!-- class="full-header" -->

	<div id="header-wrap">

		<div class="container clearfix">

			<div id="primary-menu-trigger"><i class="fa fa-bars"></i></div>

			<!-- Logo
			============================================= -->
			<div id="logo">
				<a href="/" class="standard-logo" data-dark-logo=""><img src="/images/logo.png" alt="দোকানখাতা"></a>
				<a href="/" class="retina-logo" data-dark-logo=""><img src="/images/logo.png" alt="দোকানখাতা"></a>
			</div><!-- #logo end -->

			<!-- Primary Navigation
			============================================= -->
			<nav id="primary-menu">

				<ul>
					<li><a href="/"><div>হোম</div></a></li>
					<li><a href="/about"><div>আমাদের সম্পর্কে</div></a></li>
					<li><a href="/contact"><div>যোগাযোগ</div></a></li>
					@guest
						<li><a href="/login"><div>লগইন</div></a></li>
					@else
						<li><a href="/dashboard"><div>{{ Auth::user()->name }}</div></a></li>
					@endguest
				</ul>

				<!-- Top Search
				============================================= -->
				<div id="top-search">
					<a href="#" id="top-search-trigger"><i class="fa fa-search"></i><i class="icon-line-cross"></i></a>
					<form action="search.html" method="get">
						<input type="text" name="q" class="form-control" value="" placeholder="সার্চ করুন">
					</form>
				</div><!-- #top-search end -->

			</nav><!-- #primary-menu end -->

		</div>

	</div>

</header><!-- #header end -->