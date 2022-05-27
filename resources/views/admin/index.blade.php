@extends('layouts.masterbaru')
@section('style')
    {{-- chart --}}
@endsection
@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col">
                <div class="card" style="height:90px;">
                    <div class="card-body" >
                        <h3>Dashboard</h3>
                        <p style="margin-top: -10px;">{{Breadcrumbs::render('dashboard')}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <a href="{{route('item.index')}}">
                <div class="card radius-10 bg-primary bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Total Aset</p>
                                {{-- <h4 class="my-1 text-white">{{$jumlah_total_aset_all[0]['jumlah_stok_all']}}</h4> --}}
                                <h4 class="my-1 text-white">{{$jumlah_total_aset}}</h4>
                            </div>
                            <div class="text-white ms-auto font-35"><i class='bx bx-laptop'></i>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col">
                <a href="{{route('item.consumable')}}">
                <div class="card radius-10 bg-secondary bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Total Consumable</p>
                                {{-- <h4 class="my-1 text-white">{{$jumlah_total_aset_all[0]['jumlah_stok_all']}}</h4> --}}
                                <h4 class="my-1 text-white">{{$jumlah_consumable[0]['jumlah_stok_all']}}</h4>
                            </div>
                            <div class="text-white ms-auto font-35"><i class='bx bx-laptop'></i>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col">
                <a href="{{route('pengguna.index')}}">
                <div class="card radius-10 bg-danger bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Aset Digunakan </p>
                                <h4 class="my-1 text-white">{{$jumlah_item_keluar}}</h4>
                            </div>
                            <div class="text-white ms-auto font-35"><i class='bx bx-laptop'></i>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col">
                <a href="{{route('networkdevice.index')}}">
                <div class="card radius-10 bg-warning bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Network Device Terpasang</p>
                                <h4 class="my-1 text-white">{{$jumlah_item_nd_terinstall}}</h4>
                            </div>
                            <div class="text-white ms-auto font-35"><i class='bx bx-laptop'></i>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col">
                <a href="{{route('stok.index')}}">
                <div class="card radius-10 bg-success bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Aset Ready </p>
                                <h4 class="my-1 text-white">{{$jumlah_item_ready}}</h4>
                            </div>
                            <div class="text-white ms-auto font-35"><i class='bx bx-laptop'></i>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card" style="padding-bottom: 90px;">
                    <div class="card-body" style="">
                        <h5 style="padding:5px;"><b>Total Kategori Aset</b></h5>
                        <table class="table table-hover" style="color:#32393F; border-color: #CCCCCC">
                            @php
                                $bg = array('bg-primary','bg-danger','bg-success','bg-warning','bg-secondary','bg-info');
                                $nobg = 0;
                            @endphp
                            @foreach ($device as $key =>$d)
                                <tr style="margin-bottom: 10px;">
                                    <td>
                                        <b>{{$key}}</b>
                                    </td>
                                    <td style="text-align: right;">
                                        <span class="badge rounded-pill {{$bg[$nobg++]}}">{{$d}}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id="chart4"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        <h5>Total Order</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chart2" style="height:325px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section("script")
    <script src="{{asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/plugins/chartjs/js/Chart.min.js')}}"></script>

    <script>
        $(document).ready(function () {

            

            $.ajax({
                method: "get",
                url: "{{route('admin.permintaangrafik')}}",
                processData: false,
                contentType: false,
                success: function(response) {
                    var ctx = document.getElementById("chart2").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Tahun ' +response.tahun],
                            datasets: [{
                                label: 'Total',
                                data: [response.total],
                                barPercentage: .5,
                                backgroundColor: "#0d6efd"
                            }, {
                                label: 'selesai',
                                data: [response.complete],
                                barPercentage: .5,
                                backgroundColor: "#157d4c"
                            },
                            {
                                label: 'Pending',
                                data: [response.pending],
                                barPercentage: .5,
                                backgroundColor: "#ffc107"
                            }
                        ]
                        },
                        options: {
                            maintainAspectRatio: false,
                            legend: {
                                display: true,
                                labels: {
                                    fontColor: '#585757',
                                    boxWidth: 40
                                }
                            },
                            tooltips: {
                                enabled: true
                            },
                            scales: {
                                xAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        fontColor: '#585757'
                                    },
                                    gridLines: {
                                        display: true,
                                        color: "rgba(0, 0, 0, 0.07)"
                                    },
                                }],
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        fontColor: '#585757'
                                    },
                                    gridLines: {
                                        display: true,
                                        color: "rgba(0, 0, 0, 0.07)"
                                    },
                                }]
                            }
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                        
                }
            });

            $.ajax({
                method: "get",
                url: "{{route('admin.grafik')}}",
                processData: false,
                contentType: false,
                success: function(response) {
                    // chart 4
                    var options = {
                        series: [{
                            name: 'Total',
                            data: response.total
                        }, {
                            name: 'baik',
                            data: response.baik
                        }, {
                            name: 'Rusak',
                            data: response.rusak
                        }],
                        chart: {
                            foreColor: '#000',
                            type: 'bar',
                            height: 360
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        title: {
                            text: '',
                            align: 'left',
                            style: {
                                fontSize: '14px'
                            }
                        },
                        colors: ['#8833ff', "#29cc39", '#e62e2e'],
                        xaxis: {
                            categories: ['Laptop', 'Printer', 'PC', 'Network Device', 'Peripheral', 'Consumable'],
                        },
                        yaxis: {
                            title: {
                                text: ''
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    // return "$ " + val + " thousands"
                                    return val
                                }
                            }
                        }
                    };
                    var chart = new ApexCharts(document.querySelector("#chart4"), options);
                    chart.render();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                        
                }
            });

        });
        
    </script>
@endsection