@extends('base')

@section('content')
    @if (Auth::check())
        @if (App\Role::find(Auth::user()->id)->level == 0 or empty(App\Role::find(Auth::user()->id)->level))
            <div class="row justify-content-center my-auto">
                <div class="alert alert-danger" role="alert">
                    Your account don't have a permission to surf this site. Please contact administrator.
                </div>
            </div>
        @else
            <span class="lead text-muted"><i class="fas fa-chart-bar"></i> Reports</span>
            <hr>
            <div class="row row-cols-3 row-cols-md-5">
                <div class="col mb-4">
                    <div class="card bg-info text-light" style="width: 6rem; height: 6rem;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="fas fa-arrow-left"></i></h5>
                            <h5><span class="badge badge-danger position-absolute mx-4 my-n5">{{ $items_issue_in_count ?? 0 }}</span></h5>
                            <p class="card-text h4">{{ $items_warehouse_count - $items_issue_in_count ?? 0 }}</p>
                        </div>
                        
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="card bg-secondary text-light" style="width: 6rem; height: 6rem;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="fas fa-arrow-left"></i><i class="fas fa-arrow-right"></i></h5>
                            <p class="card-text h4">{{ $items_intransit_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="card bg-warning text-dark" style="width: 6rem; height: 6rem;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="fas fa-arrow-right"></i></h5>
                            <h5><span class="badge badge-danger position-absolute mx-4 my-n5">{{ $items_issue_out_count ?? 0 }}</span></h5>
                            <p class="card-text h4">{{ ($items_city_count - $items_issue_count + $items_issue_in_count) ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="card bg-danger text-light" style="width: 6rem; height: 6rem;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="fas fa-exclamation-triangle"></i></h5>
                            <p class="card-text h4">{{ $items_issue_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="card bg-light text-dark" style="width: 6rem; height: 6rem;">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total</h5>
                            <p class="card-text h4">{{ $items_total_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row row-cols-1 row-cols-md-2 mx-0">
                <div>
                    <span class="lead text-muted"><i class="fas fa-calendar-day"></i> Today - {{ date('Y-m-d') }}</span>
                    <hr>
                    <div class="row row-cols-2 row-cols-md-5">
                        <div class="col mb-4">
                            <div class="card bg-info text-light" style="width: 6rem; height: 6rem;">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><i class="fas fa-arrow-left"></i></h5>
                                    <p class="card-text h4">{{ $today_in_count ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card bg-warning text-dark" style="width: 6rem; height: 6rem;">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><i class="fas fa-arrow-right"></i></h5>
                                    <p class="card-text h4">{{ $today_out_count ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="lead text-muted"><i class="fas fa-chart-pie"></i> Total</span>
                    <hr>
                    <div class="row row-cols-2 row-cols-md-5">
                        <div class="col mb-4">
                            <div class="card bg-info text-light" style="width: 6rem; height: 6rem;">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><i class="fas fa-arrow-left"></i></h5>
                                    <p class="card-text h4">{{ $all_in_count ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card bg-warning text-dark" style="width: 6rem; height: 6rem;">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><i class="fas fa-arrow-right"></i></h5>
                                    <p class="card-text h4">{{ $all_out_count ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
               
            <span class="lead text-muted"><i class="fas fa-chart-line"></i> Charts</span>
            <hr>
            <div class="row">

                <?php
                    function dateDiff($date) {
                        $now = time();
                        $datediff = $now - strtotime($date);
                        return round($datediff / (60 * 60 * 24));
                    }
                ?>
                <div class="col-md-3">
                    <div class="card mb-5">
                        <div class="card-header bg-warning">
                            Items staying outside longer than 1 day.
                        </div>
                        <div class="table-responsive-sm" style="max-height: 21rem; overflow-y: auto; overflow-x: hidden;">
                            <table class="table table-striped table-hover table-sm m-0 collapse show" id="collapseToday">
                                <thead class="table-bordered px-3">
                                    <tr>
                                        <th>Code</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php 
                                        uasort($items_long_out, function ($a, $b) {
                                            return $a <=> $b;
                                        });
                                    ?>
                                    @foreach ($items_long_out as $item)
                                        <tr>
                                            <td><a class="text-dark" href="{{ url('item/' . $item->item_code) }}">{{ $item->item_code }}</a></td>
                                            <td><a title="{{ $item->created_at }}">{{ date_format($item->created_at, 'Y-m-d H:i') }}</a></td>
                                            <td>~{{ dateDiff($item->created_at) }}d.</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="col">
                        <div class="card">
                            <div class="chartWrapper">
                                <div class="chartContainer">
                                    <canvas id="TotalChart" height="400" width="0"></canvas>
                                </div>
                            </div>
                        </div>

                        <?php $datesArray = array(); ?>
                        <?php $monthsArray = array(); ?>
                
                        @foreach ($transfer_dates as $date)
                            <?php  array_push($monthsArray, date_format($date->created_at, 'Y-m')); ?>
                            <?php 
                                if (!isset($last_date)) {
                                    $last_date = date_format($date->created_at, 'Y-m-d');
                                    $switch = false;
                                }
                            ?>
                            @if (date_format($date->created_at, 'Y-m-d') == $last_date)
                                @if($switch == false)
                                    <?php  array_push($datesArray, date_format($date->created_at, 'Y-m-d')); ?>
                                    <?php $switch = true; ?>
                                @endif
                            @else
                                <?php $switch = false; ?>
                            @endif
                            <?php $last_date = date_format($date->created_at, 'Y-m-d'); ?>
                        @endforeach
                        <?php $monthsArray = array_unique($monthsArray); ?>

                        <?php $inArray = array(); ?>
                        <?php $outArray = array(); ?>
                        @foreach ($datesArray as $date)
                            <?php  array_push($inArray, App\Routing::where('created_at', 'like', '%'.$date.'%')->where('in_out', '=', 'in')->sum('quantity')); ?>
                            <?php  array_push($outArray, App\Routing::where('created_at', 'like', '%'.$date.'%')->where('in_out', '=', 'out')->sum('quantity')); ?>
                        @endforeach
                        
                        <script>
                            var xAxisLabelMinWidth = 15; // Replace this with whatever value you like
                            var ctx = document.getElementById('TotalChart').getContext('2d');
                            var chart = new Chart(ctx, {
                                // The type of chart we want to create
                                type: 'bar',
                                // The data for our dataset
                                data: {
                                    labels: {!! json_encode($datesArray) !!},
                                    datasets: [
                                        {
                                            label: 'In',
                                            backgroundColor: 'rgb(23, 162, 184)',
                                            borderColor: 'rgb(0, 0, 0, 0.125)',
                                            data: {!! json_encode($inArray) !!}
                                        },
                                        {
                                            label: 'Out',
                                            backgroundColor: 'rgb(255, 193, 7)',
                                            borderColor: 'rgba(0, 0, 0, 0.125)',
                                            data: {!! json_encode($outArray) !!}
                                        }
                                    ]
                                },
                                // Configuration options go here
                                options: {
                                    responsive: true
                                }
                            });
                            function fitChart(){
                                var chartCanvas = document.getElementById('TotalChart');
                                var maxWidth = chartCanvas.parentElement.parentElement.clientWidth;
                                var width = Math.max(chart.data.labels.length * xAxisLabelMinWidth, maxWidth);

                                chartCanvas.parentElement.style.width = width +'px';
                            }
                            fitChart();
                        </script>
                        
                    </div>
                </div>
                
            </div>
        @endif
    @endif
@stop