@extends('layouts.user')
@section('title')
    {{trans('dashboard.dashboard')}}
@stop
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/c3.min.css') }}">
@stop
@section('content')
    <div class="row mar-20">
        <div class="col-md-3 col-xs-6">
            <div class="cnts bg-primary">
                <div class="row">
                    <div class="col-md-12 text-white">
                        <p class="text-left nopadmar">{{trans('left_menu.contracts')}}</p>
                        <div id="countno1"></div>
                        <i class="material-icons md-36 mar-top pull-right">contacts</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="cnts bg-warning">
                <div class="row">
                    <div class="col-md-12 text-white">
                        <p class="text-left nopadmar">{{trans('left_menu.products')}}</p>
                        <div id="countno2"></div>
                        <i class="material-icons md-36 mar-top pull-right">layers</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="cnts bg-danger">
                <div class="row">
                    <div class="col-md-12 text-white">
                        <p class="text-left nopadmar">{{trans('left_menu.opportunities')}}</p>
                        <div id="countno3"></div>
                        <i class="material-icons md-36 mar-top pull-right">chrome_reader_mode</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xs-6 ">
            <div class="cnts bg-info">
                <div class="row">
                    <div class="col-md-12 text-white">
                        <p class="text-left nopadmar">{{trans('left_menu.customers')}}</p>
                        <div id="countno4"></div>
                        <i class="material-icons md-36 mar-top pull-right">supervisor_account</i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mar-20">
        <div class="col-lg-8">
            <div class="box1">
                <h4>{{trans('dashboard.opportunities_leads')}}</h4>
                <div id='chart'></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="box1">
                <h4>{{trans('dashboard.opportunities')}}</h4>
                <div id="sales"></div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="box1">
                <h4>{{trans('dashboard.customers_map')}}</h4>
                <div class="world" style="height:350px; width:100%;"></div>
            </div>
        </div>
        <div class="col-md-4">
            <meta name="_token" content="{{ csrf_token() }}">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <i class="livicon" data-name="inbox" data-size="18" data-color="white" data-hc="white"
                           data-l="true"></i>
                        My task list
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row list_of_items">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p></p>
@stop

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.v3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/c3.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/countUp.min.js') }}"></script>
    <script src="{{ asset('js/todolist.js') }}"></script>
    <script>

        /*c3 line chart*/
        $(function () {

            var data = [
                ['Opportunity', 'Leads'],
                    @foreach($opportunity_leads as $item)
                [{{$item['opportunity']}}, {{$item['leads']}}],
                @endforeach
            ];

//c3 customisation
            var chart = c3.generate({
                bindto: '#chart',
                data: {
                    rows: data,
                    type: 'area-spline'
                },
                color: {
                    pattern: ['#FD9883', '#4FC1E9']
                },
                axis: {
                    x: {
                        tick: {
                            format: function (d) {
                                return formatMonth(d);
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom'
                },
                padding: {
                    top: 10
                }
            });

            function formatMonth(d) {

                @foreach($opportunity_leads as $id => $item)
                if ('{{$id}}' == d) {
                    return '{{$item['month']}}' + ' ' + '{{$item['year']}}'
                }
                @endforeach
            }

            setTimeout(function () {
                chart.resize();
            }, 2000);

            setTimeout(function () {
                chart.resize();
            }, 4000);

            setTimeout(function () {
                chart.resize();
            }, 6000);
            $("[data-toggle='offcanvas']").click(function (e) {
                chart.resize();
            });
            /*c3 line chart end*/

            /*c3 pie chart*/
            var chart = c3.generate({
                bindto: '#sales',
                data: {
                    columns: [
                            @foreach($stages as $item)
                        ['{{$item['title']}}', {{$item['opprotunities']}}],
                        @endforeach
                    ],
                    type: 'pie',
                    colors: {
                        @foreach($stages as $item)
                        '{{$item['title']}}': '{{$item['color']}}',
                        @endforeach
                    },
                    labels: true
                }
            });
            /*c3 pie chart end*/
            // c3 chart end


            /*dashboard countup*/
            var useOnComplete = false,
                    useEasing = false,
                    useGrouping = false,
                    options = {
                        useEasing: useEasing, // toggle easing
                        useGrouping: useGrouping, // 1,000,000 vs 1000000
                        separator: ',', // character to use as a separator
                        decimal: '.' // character to use as a decimal
                    };

            var demo = new CountUp("countno1", 0, "{{$contracts}}", 0, 3, options);
            demo.start();
            var demo = new CountUp("countno2", 0, "{{$products}}", 0, 3, options);
            demo.start();
            var demo = new CountUp("countno3", 0, "{{$opportunities}}", 0, 3, options);
            demo.start();
            var demo = new CountUp("countno4", 0, "{{$customers}}", 0, 3, options);
            demo.start();

            /*countup end*/

            $('.world').vectorMap(
                    {
                        map: 'world_mill_en',
                        markers: [
                                @foreach($customers_world as $item)
                            {
                                latLng: [{{$item['latitude']}}, {{$item['longitude']}}], name: '{{$item['city']}}'
                            },
                            @endforeach
                        ],
                        normalizeFunction: 'polynomial',
                        backgroundColor: 'transparent',
                        regionsSelectable: true,
                        markersSelectable: true,
                        regionStyle: {
                            initial: {
                                fill: 'rgba(120,130,140,0.2)'
                            },
                            hover: {
                                fill: '#37BC9B',
                                stroke: '#fff'
                            }
                        },
                        markerStyle: {
                            initial: {
                                fill: '#A0D468',
                                stroke: '#fff',
                                r: 10
                            },
                            hover: {
                                fill: '#0cc2aa',
                                stroke: '#fff',
                                r: 15
                            }
                        }
                    }
            );

        });
    </script>

@stop