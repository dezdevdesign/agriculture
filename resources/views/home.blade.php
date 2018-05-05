@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<style>

</style>
<header class="content__title">
    <h1>Dashboard</h1>
    <small>Welcome to your dashboard! You can view your cropping statistics and other information in this page.</small>
</header>
<div id="print-dashboard">
    <div class="card">
        <div class="card-block">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-control-label" for="harvest-crop">Crop</label>
                        <select name="harvest-crop" id="harvest-crop" style="width: 100%" required>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-control-label" for="harvest-year">Year</label>
                        <input name="harvest-year" id="harvest-year" type="text" class="form-control year-select" required>
                        <i class="form-group__bar"></i>
                    </div>
                </div>
                <div class="col-sm-2" style="padding-top: 20px">
                    <div class="btn-group btn-group-lg">
                        <button type="button" id="harvest-filter" class="btn btn-success">Filter</button>
                        <button type="button" id="harvest-reset" class="btn btn-info"><i class="zmdi zmdi-undo"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row quick-stats">
        <div class="col-sm-6 col-md-3">
            <div class="quick-stats__item bg-light-green">
                <div class="quick-stats__info">
                    <h2><span id="harvested">0</span> <small style="font-size: 10px">(Hectare)</small></h2>
                    <small>Total Harvest</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="quick-stats__item bg-light-blue">
                <div class="quick-stats__info">
                    <h2><span id="production">0</span> <small style="font-size: 10px">(Metric Ton)</small></h2>
                    <small>Total Production</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="quick-stats__item bg-red">
                <div class="quick-stats__info">
                    <h2><span id="yield">0</span> <small style="font-size: 10px">(Metric Ton / Hectare)</small></h2>
                    <small>Total Yield</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="quick-stats__item bg-orange">
                <div class="quick-stats__info">
                    <h2><span id="minimum_production">0</span></h2>
                    <small>Minimum Production Required</small>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Harvest Chart</h2>
        </div>
        <div class="card-block">
            <div id="chart-harvest" class="flot-chart flot-bar"></div>
            <div id="legend-harvest" class="flot-chart-legends"></div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Harvest Status</h2>
        </div>
        <div class="card-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group text-center">
                            <label>Harvest Status</label>
                            <span id="status"><h2 class="text-info">None</h2></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-success">
                            <div class="card-header text-center" style="padding: 1rem">
                                <a class="card-title" data-toggle="collapse" href="#good" style="color: white">Good Harvest Comments <span class="zmdi zmdi-check"></span></a>
                            </div>
                            <div id="good" class="collapse">
                                <div id="good-remarks" class="card-block text-white" style="padding: 1rem">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-danger">
                            <div class="card-header text-center" style="padding: 1rem">
                                <a class="card-title" data-toggle="collapse" href="#bad" style="color: white">Bad Harvest Comments <span class="zmdi zmdi-close"></span></a>
                            </div>
                            <div id="bad" class="collapse">
                                <div id="bad-remarks" class="card-block text-white" style="padding: 1rem">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-block">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-control-label" for="yield-crop">Crop</label>
                        <select name="yield-crop" id="yield-crop" style="width: 100%" required>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group year-range">
                        <label for="yield-year-from">Year</label>
                        <div class="input-daterange input-group" style="width: 100%">
                            <input id="yield-year-from" name="yield-year-from" type="text" class="form-control" required>
                            <span class="input-group-addon">To</span>
                            <input id="yield-year-to" name="yield-year-to" type="text" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-control-label" for="yield-municipality">Municipality</label>
                        <select name="yield-municipality" id="yield-municipality" style="width: 100%" required>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2" style="padding-top: 20px">
                    <div class="btn-group btn-group-lg">
                        <button type="button" id="yield-filter" class="btn btn-success">Filter</button>
                        <button type="button" id="yield-reset" class="btn btn-info"><i class="zmdi zmdi-undo"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Yield Summary Chart</h2>
        </div>

        <div class="card-block">
            <div id="chart-yield" class="flot-chart"></div>
            <div id="legend-yield" class="flot-chart-legends"></div>
        </div>
    </div>
    <div class="card">
        <div class="card-block">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-control-label" for="pie-municipality">Municipality</label>
                        <select name="pie-municipality" id="pie-municipality" style="width: 100%" required>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-control-label" for="pie-barangay">Barangay</label>
                        <select name="pie-barangay" id="pie-barangay" style="width: 100%" required>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2" style="padding-top: 20px">
                    <div class="btn-group btn-group-lg">
                        <button type="button" id="pie-filter" class="btn btn-success">Filter</button>
                        <button type="button" id="pie-reset" class="btn btn-info"><i class="zmdi zmdi-undo"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Watering Types With Good Harvests</h2>
                </div>
                <div class="card-block">
                    <div id="chart-water" class="flot-chart"></div>
                    <div id="legend-water" class="flot-chart-legends"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Soil Type With Good Harvests</h2>
                </div>

                <div class="card-block">
                    <div id="chart-soil" class="flot-chart"></div>
                    <div id="legend-soil" class="flot-chart-legends"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Reason Of Bad Harvests</h2>
                </div>

                <div class="card-block">
                    <div id="chart-bad" class="flot-chart"></div>
                    <div id="legend-bad" class="flot-chart-legends"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
