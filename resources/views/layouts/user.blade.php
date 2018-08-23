<!DOCTYPE html>
<html>
<head>
    @include('layouts._meta')
    @include('layouts._assets')

    @yield('styles')
</head>
<body>

<header class="header">
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('uploads/site/'.Settings::get('site_logo')) }}"
                 alt="{{ Settings::get('site_name') }}" class="img-responsive"
                 style="margin:auto;width:100px;height:35px;">

        </a>

        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button"> <i
                        class="fa fa-fw fa-navicon"></i>
            </a>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                @include("left_menu._header-right")
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar-->
        <section class="sidebar">
            <div id="menu" role="navigation">

                <!-- / .navigation -->
                @if(Sentinel::inRole('admin') || Sentinel::inRole('staff'))
                    @include('left_menu._user')
                @elseif(Sentinel::inRole('customer'))
                    @include('left_menu._customer')
                @endif
            </div>
            <!-- menu -->
        </section>
        <!-- /.sidebar -->
    </aside>
    <aside class="right-side right-padding">
        <div class="right-content">
            <h1>{{ $title or 'Welcome to Freelance Office' }}</h1>

            <!-- Notifications -->

            <!-- Content -->
            @yield('content')
                    <!-- /.content -->
        </div>
    </aside>
    <!-- /.right-side -->
</div>
<!-- /.right-side -->
<!-- ./wrapper -->
<!-- global js -->
@include('layouts._assets_footer')
@yield('scripts')
<script>
	var product = new Array();
	var n = [];
	var i;
		<?php $productPopup = DB::table('products')->select('*')->get(); ?>
		<?php foreach($productPopup as $eachProduct) { ?>
				product.push({ "id":"<?php echo $eachProduct->id;?>", "value": { "name":"<?php echo $eachProduct->product_name;?>","product_image":"<?php echo $eachProduct->product_image;?>",  "quantity_on_hand":"<?php echo $eachProduct->quantity_on_hand;?>",  "quantity_available":"<?php echo $eachProduct->quantity_available;?>",  "sale_price":"<?php echo $eachProduct->sale_price;?>"} });
		<?php } ?>
	function hidePopup(){
		$( "#popuptext" ).removeClass( "show" );
	}

	function popupfunction(id,type){//runs second
			var popup = document.getElementById("popuptext");
			popup.classList.toggle("show");
			if(type == 1){
			$( "#popuptext" ).addClass( "show" );

			}
			for(i in product){
				  n.push(parseInt(product[i].id));
				}
			for (i in product) {
				if(product[i].id == id){
					var curr = n.indexOf(id);
					var next = curr+1;
					var prev = curr -1;
					var imgPath;
					if(product[i].value.product_image == ''){
						imgPath = 'http://93.158.221.197/files/public/uploads/products/no-pic-image_1493817948.png';
					} else{
					    imgPath = 'http://93.158.221.197/files/public/uploads/products/'+product[i].value.product_image;
					}
					var html = '<div class="popup"><div class="part-1"><div class="pro-img"><img src="'+imgPath+'" alt="no-image"></div><div class="part-1-1"><div class="pro-name"><strong>'+product[i].value.name+'</strong></div><div class="pro-id"><i>#'+product[i].id+'</i></div></div></div><hr><div class="part-2"><div class="pro-qoh">Quantity on Hand: '+product[i].value.quantity_on_hand+'</div><div class="pro-qa">Quantity Available: '+product[i].value.quantity_available+'</div><div class="pro-price">Sale Price: '+product[i].value.sale_price+'</div></div><a class="closed" onclick="hidePopup()" href="">X</a>';
					if(typeof(n[next]) != "undefined"){
						html += '<a id="nxt" onclick="popupfunction('+n[next]+',1);"><i class="fa fa-chevron-right"></i></a>';
					}
					if(typeof(n[prev]) != "undefined"){
						html += '<a id="prev" onclick="popupfunction('+n[prev]+',1)"><i class="fa fa-chevron-left"></i></a>';
					}


					$( ".popuptext").html( html  );
				}
			}
	}
    $(document).ready(function () {

		 setInterval(function() {
        $('table.custom-products tbody tr').each(function() {

			   x = $(this).find("[title='Edit']").attr('href');
			   a = x.split('/');
			   $(this).attr("id","popup-"+a[6]);
			   $(this).attr("onclick","popupfunction("+a[6]+",'fst')");
				 //$("<div class='popuptext' id='popuptext'></div>").appendTo(".right-content");
		});
    },2000);


        $('.date').datetimepicker({format: '{{ isset($jquery_date)?$jquery_date:"MMMM D,GGGG" }}',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }});
        $('.datetime').datetimepicker({format: '{{ isset($jquery_date_time)?$jquery_date_time:"MMMM D,GGGG H:mm" }}',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }});
    })

</script>

</body>
</html>
