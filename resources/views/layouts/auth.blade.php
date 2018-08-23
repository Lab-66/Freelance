<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts._meta')
    @include('layouts._assets')
</head>
<?php 
  $arr = DB::table("bg_slider")->orderBy('id', 'asc')->get();
?>
<body id="bg-img">
<!-- #################### slider ################## -->
  <div id="slides">
    <div class="slides-container">
    <?php foreach($arr as $eachImg){ ?>
      <img src="uploads/<?php echo $eachImg->img_path; ?>" alt="Cinelli">
    <?php } ?>
    </div>

 
 
 
<!-- #################### slider ################## -->
<div class="app" id="app">
    <!-- ############ LAYOUT START-->
    <div class="login animated fadeIn">
        <div class="navbar">
                <!-- brand -->
            <a class="navbar-brand text-center" style="float:none;">
                <img src="{{ asset('uploads/site/'.Settings::get('site_logo')) }}"
                     alt="{{ Settings::get('site_name') }}" class="img-responsive"
                     style="margin:auto;width:100px;height:35px;">
                </a>
                <!-- / brand -->
        </div>
        @include('flash::message')
        @yield('content')
    </div>

    <!-- ############ LAYOUT END-->

</div>
<nav class="slides-navigation">
      <a href="#" class="next">Next</a>
      <a href="#" class="prev">Previous</a>
    </nav>
  </div>
  <link rel="stylesheet" href="slider/css/superslides.css">
 <script src="slider/javascripts/jquery.min.js"></script>
  <script src="slider/javascripts/jquery.easing.1.3.js"></script>
  <script src="slider/javascripts/jquery.animate-enhanced.min.js"></script>
  <script src="slider/javascripts/jquery.superslides.js" type="text/javascript" charset="utf-8"></script>
  <script>
  var j = jQuery.noConflict();
    j(function() {
      j('#slides').superslides({
        animation: 'fade',
        play: 3000
      });
    });
  </script>
@include('layouts._assets_footer')
</body>
</html>
