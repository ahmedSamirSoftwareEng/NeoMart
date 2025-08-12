<x-front-layout title="Order Details">
    <x-slot:breadcrumb>
        <!-- Start Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Order #{{$order->number}}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="{{ route('products.index') }}">Orders</a></li>
                            <li>Order #{{$order->number}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->
    </x-slot:breadcrumb>
    <x-alert />
    <!--====== Checkout Form Steps Part Start ======-->

    <section class="checkout-wrapper section">
        <div class="container">
            <div id="map" style="height:50vh;"></div>

        </div>
    </section>
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script>
        var map, marker;
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('a54c345d29e6cb646b71', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('deliveries');
        channel.bind('Location-updated', function(data) {
            marker.setPosition({
                lat: Number(data.lat),
                lng: Number(data.lng),
            });
        });
    </script>
    <script>
        function initMap() {
            const location = {
                lat: Number("{{$delivery->lat}}"),
                lng: Number("{{$delivery->lng}}"),
            };
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: location,
            });

            marker = new google.maps.Marker({
                position: location,
                map,
                title: "Hello World!",
            });
        }

        window.initMap = initMap;
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuyzVHAp08iNaxF4V65lEzmRbx1NtGO9Q&callback=initMap&v=weekly&libraries=marker"
        defer></script>
    <!--====== Checkout Form Steps Part Ends ======-->
</x-front-layout>