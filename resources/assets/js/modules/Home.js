export default class Home {
    constructor() {
        initHarvestChart(0, 0, 0, 0);
        initLineChart(0, 0);
        loadPieChartData(null, null);
        initElements();
        initEventListeners();
    }
}

let chartHarvest, totalHarvest = [], totalProduction = [], totalYield = [], season = [];
let chartWatering, totalWateringType = [];
let chartSoil, totalSoilType = [];
let chartBad, totalBadReason = [];
let chartYield, lineYield = [], lineMonth = [], lineYear = []; 

// Initialize event listeners...
function initEventListeners() {
    // Yield line chart filter listener...
    $('#yield-filter').on('click', function() {
        if($('#yield-crop').val() != null) {
            if($('#yield-year-from').val() != '' && $('#yield-year-from').val() != null && $('#yield-year-to').val() != '' && $('#yield-year-to').val() != null) {
                loadLineChartData($('#yield-crop').val(), $('#yield-year-from').val(), $('#yield-year-to').val(), $('#yield-municipality').val());
            }else {
                helpers.showNotification('Please select year.', 'danger', 'zmdi zmdi-alert-triangle');
            }
        }else {
            helpers.showNotification('Please select crop first.', 'danger', 'zmdi zmdi-alert-triangle');
            $('#yield-crop').select2('open');
        }
    });

    // Yield line chart reset listener...
     $('#yield-reset').on('click', function() {
        $('#yield-crop, #yield-municipality').val(null).trigger('change');
        $('#yield-year-from').val(null).datepicker('update');
        $('#yield-year-to').val(null).datepicker('update');
        initLineChart(0, 0);
    });


    // Pie chart municipality select2 listener...
    $('#pie-municipality').on('select2:select', function() {
        axios.get('/api/loadBarangays/' + $(this).val())
        .then(response => {
            $('#pie-barangay').empty();
            $('#pie-barangay').select2({
                placeholder: 'Select Barangay',
                data: response.data,
                positionDropdown: true,
                allowClear: true
            });
            $('#pie-barangay').val(null).trigger('change');
        })
        .catch(error => console.log(error));
    });

    // Pie chart filter listener...
    $('#pie-filter').on('click', function() {
        if($('#pie-municipality').val() != null) {
            loadPieChartData($('#pie-municipality').val(), $('#pie-barangay').val());
        }else {
            helpers.showNotification('Please select municipality first.', 'danger', 'zmdi zmdi-alert-triangle');
            $('#pie-municipality').select2('open');
        }
    });

    // Pie chart reset listener...
    $('#pie-reset').on('click', function() {
        $('#pie-municipality').val(null).trigger('change');
        $('#pie-barangay').empty();
        loadPieChartData(null, null);
    });



    // Harvest bar chart filter listener...
    $('#harvest-filter').on('click', function() {
        if($('#harvest-crop').val() != null) {
            loadHarvestData($('#harvest-crop').val(), $('#harvest-year').val());
            loadHarvestWidget($('#harvest-crop').val(), $('#harvest-year').val());
        }else {
            helpers.showNotification('Please select crop first.', 'danger', 'zmdi zmdi-alert-triangle');
            $('#harvest-crop').select2('open');
        }

        if($('#harvest-crop').val() != null) {
            let good = '<ul class="multi-column">';
            let bad = '<ul class="multi-column">';
            axios.get('/api/checkCause', {
                params: {
                    crop: $('#harvest-crop').val(),
                    year: $('#harvest-year').val()
                }
            })
            .then(response => {
                response.data.forEach(element => {
                    switch (element.status) {
                        case "Good":
                            good += '<li>"' + element.remarks + '"</li>';
                            break;
                        case "Bad":
                            bad += '<li>"' + element.remarks + '"</li>';
                            break;
                        default:
                            break;
                    }
                });
                good += '</ul>';
                bad += '</ul>';
                $('#good-remarks').html(good);
                $('#bad-remarks').html(bad);
            })
            .catch(error => console.log(error));
        }else {
            $('#good-remarks').html('');
            $('#bad-remarks').html('');
        }
    });

    // Harvest bar chart reset listener...
    $('#harvest-reset').on('click', function() {
        $('#harvest-crop').val(null).trigger('change');
        $('#harvest-year').val(null).datepicker('update');
        $('#harvested').html('0');
        $('#production').html('0');
        $('#yield').html('0');
        $('#minimum_production').html('0');
        $('#status').html('');
        $('#good-remarks').html('');
        $('#bad-remarks').html('');
        initHarvestChart(0, 0, 0, 0);
    });
}

// Init harvest widgets after filtering...
function loadHarvestWidget(crop, year) {
    axios.get('/api/getHarvested', {
        params: {
          crop_id: crop,
          year: year
        }
    })
    .then(response => {
        $('#harvested').html(response.data);
    })
    .catch(error => console.log(error));

     axios.get('/api/getProduction', {
        params: {
          crop_id: crop,
          year: year
        }
    })
    .then(response => {
        if(response.data.length > 0) {
            $('#production').html(response.data[0].production);
            $('#minimum_production').html(response.data[0].minimum_production);
            if(response.data[0].production < response.data[0].minimum_production) {
                $('#status').html('<h2 class="text-danger">Bad</h2>');
            }else {
                $('#status').html('<h2 class="text-success">Good</h2>');
            }
        }else {
            $('#production').html('0');
            $('#minimum_production').html('0');
            $('#status').html('<h2 class="text-info">None</h2>');
        }
    })
    .catch(error => console.log(error));

     axios.get('/api/getYield', {
        params: {
          crop_id: crop,
          year: year
        }
    })
    .then(response => {
        $('#yield').html(response.data);
    })
    .catch(error => console.log(error));
}

// Init page elements...
function initElements() {
    axios.get('/api/getCrops')
    .then(response => {
        $('#harvest-crop, #yield-crop').select2({
            placeholder: 'Select Crop',
            data: response.data,
            positionDropdown: true,
            allowClear: true
        }); 
        $('#harvest-crop, #yield-crop').val(null).trigger('change');
    })
    .catch(error => console.log(error));

    $('.year-select').datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years",
        autoclose: true
    });

    $('.year-range .input-daterange').datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years",
        autoclose: true
    });

    axios.get('/api/loadMunicipalities')
    .then(response => {
        $('#pie-municipality, #yield-municipality').select2({
            placeholder: 'Select Municipality',
            data: response.data,
            positionDropdown: true,
            allowClear: true
        });
        $('#pie-municipality, #yield-municipality').val(null).trigger('change');
    })
    .catch(error => console.log(error));

    $('#pie-barangay').select2({
        placeholder: 'Select Barangay',
        allowClear: true
    });
}

// Load data for watering and soil types...
function loadPieChartData(municipality, barangay) {
    totalWateringType = [], totalSoilType = [], totalBadReason = [];
    axios.get('/api/getWateringChart', {
        params: {
            municipality: municipality,
            barangay: barangay
        }
    })
    .then(response => {
        let color;
        response.data.forEach(element => {
            switch(element.type) {
                case 'Flood Irrigation':
                    color = '#ff6b68';
                    break;
                case 'Sprinkler Irrigation':
                    color = '#03A9F4';
                    break;
                case 'Drip Irrigation':
                    color = '#32c787';
                    break;
                case 'Micro Irrigation':
                    color = '#f5c942';
                    break;
                default:
                    break;
            }
            totalWateringType.push({
                data: element.count, 
                label: element.type,
                color: color
            });
        });
        initWateringChart(totalWateringType);
    })
    .catch(error => console.log(error));

    axios.get('/api/getSoilTypeChart', {
        params: {
            municipality: municipality,
            barangay: barangay
        }
    })
    .then(response => {
        let color;
        response.data.forEach(element => {
            switch(element.type) {
                case 'Sand':
                    color = '#eab64f';
                    break;
                case 'Loam':
                    color = '#3e3117';
                    break;
                case 'Clay':
                    color = '#926829';
                    break;
                default:
                    break;
            }
            totalSoilType.push({
                data: element.count, 
                label: element.type,
                color: color
            });
        });
        initSoilChart(totalSoilType);
    })
    .catch(error => console.log(error));

    axios.get('/api/getBadReasonChart', {
        params: {
            municipality: municipality,
            barangay: barangay
        }
    })
    .then(response => {
        let color;
        response.data.forEach(element => {
            switch(element.type) {
                case 'Storm':
                    color = '#0073D5';
                    break;
                case 'Pest':
                    color = '#FFB257';
                    break;
                case 'El Nino':
                    color = '#E3C20C';
                    break;
                default:
                    break;
            }
            totalBadReason.push({
                data: element.count, 
                label: element.reason,
                color: color
            });
        });
        initBadChart(totalBadReason);
    })
    .catch(error => console.log(error));
}

function loadLineChartData(crop, from, to, municipality) {
    lineMonth = [], lineYield = [], lineYear = [];
    if(from == to) {
        axios.get('/api/getMonthlyYield', {
            params: {
                crop: crop,
                from: from,
                municipality: municipality
            }
        })
        .then(response => {
            let x = 1;
            response.data.forEach(element => {
                lineMonth.push([x, element.monthname]);
                lineYield.push([x, element.total_yield]);
                x++;
            });
            initLineChart(lineMonth, lineYield);
        })  
        .catch(error => console.log(error));
    }else {
        axios.get('/api/getYearlyYield', {
            params: {
                crop: crop,
                from: from, 
                to: to,
                municipality: municipality
            }
        })
        .then(response => {
            let x = 1;
            response.data.forEach(element => {
                lineYear.push([x, element.year]);
                lineYield.push([x, element.total_yield]);
                x++;
            });
            initLineChart(lineYear, lineYield);
        })  
        .catch(error => console.log(error));
    }
}

function initLineChart(label, yld) {
    // Chart Data
    var lineChartData = [
        {
            label: 'Yield',
            data: yld,
            color: '#32c787'
        }
    ];

    // Chart Options
    var lineChartOptions = {
        series: {
            lines: {
                show: true,
                barWidth: 0.05,
                fill: 0
            },
            points: { show: true }
        },
        shadowSize: 0.1,
        grid : {
            borderWidth: 1,
            borderColor: '#edf9fc',
            show : true,
            hoverable : true,
            clickable : true
        },

        yaxis: {
            tickColor: '#edf9fc',
            tickDecimals: 0,
            font :{
                lineHeight: 13,
                style: 'normal',
                color: '#9f9f9f',
            },
            shadowSize: 0
        },

        xaxis: {
            ticks: label,
            tickColor: '#fff',
            tickDecimals: 0,
            font :{
                lineHeight: 13,
                style: 'normal',
                color: '#9f9f9f'
            },
            shadowSize: 0,
        },
        legend:{
            container: '#legend-yield',
            backgroundOpacity: 0.5,
            noColumns: 0,
            backgroundColor: '#fff',
            lineWidth: 0,
            labelBoxBorderColor: '#fff'
        }
    };

    // Create chart
    if ($('#chart-yield')[0]) {
        $.plot($('#chart-yield'), lineChartData, lineChartOptions);
    }

    // Tool tip for line chart...
    if ($('#chart-yield')[0]) {
        if(!$('#tooltip-yield')[0]) {
            $('#chart-yield').bind('plothover', function (event, pos, item) {
                if(item) {
                    var y = item.datapoint[1].toFixed(2);
                    $('#tooltip-yield').html(item.series.label + ': ' + y).css({top: item.pageY+5, left: item.pageX+5}).show();
                }
                else {
                    $('#tooltip-yield').hide();
                }
            });
            $('<div id="tooltip-yield" class="flot-tooltip"></div>').appendTo('body');
        }
    }
}

// Initialize watering type pie chart options and data...
function initWateringChart(watering) {
    if($('#chart-water')[0]){
        $.plot('#chart-water', watering, {
           series: {
                pie: { 
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3/4,
                        background: { 
                            opacity: 0.5,
                            color: '#000'
                        },
                        formatter: function (label, series) {
                            return '<div style="font-size:6pt;text-align:center;padding:2px;color:white;">' + label + '<br/>' + series.data[0][1] + '</div>';
                        }
                    }
                }
            },
            legend: {
                container: '#legend-water',
                backgroundOpacity: 0.5,
                noColumns: 0,
                backgroundColor: "white",
                lineWidth: 0,
                labelBoxBorderColor: '#fff'
            }
        });
    }
}

// Initialize soil type pie chart options and data...
function initSoilChart(soil) {
    if($('#chart-soil')[0]){
        $.plot('#chart-soil', soil, {
           series: {
                pie: { 
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3/4,
                        background: { 
                            opacity: 0.5,
                            color: '#000'
                        },
                        formatter: function (label, series) {
                            return '<div style="font-size:6pt;text-align:center;padding:2px;color:white;">' + label + '<br/>' + series.data[0][1] + '</div>';
                        }
                    }
                }
            },
            legend: {
                container: '#legend-soil',
                backgroundOpacity: 0.5,
                noColumns: 0,
                backgroundColor: "white",
                lineWidth: 0,
                labelBoxBorderColor: '#fff'
            }
        });
    }
}

// Initialize soil type pie chart options and data...
function initBadChart(bad) {
    if($('#chart-bad')[0]){
        $.plot('#chart-bad', bad, {
           series: {
                pie: { 
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3/4,
                        background: { 
                            opacity: 0.5,
                            color: '#000'
                        },
                        formatter: function (label, series) {
                            return '<div style="font-size:6pt;text-align:center;padding:2px;color:white;">' + label + '<br/>' + series.data[0][1] + '</div>';
                        }
                    }
                }
            },
            legend: {
                container: '#legend-bad',
                backgroundOpacity: 0.5,
                noColumns: 0,
                backgroundColor: "white",
                lineWidth: 0,
                labelBoxBorderColor: '#fff'
            }
        });
    }
}

// Load harvest chart data via http request...
function loadHarvestData(crop, year) {
    totalHarvest = [], totalProduction = [], totalYield = [], season = [];
    axios.get('/api/getHarvestChart', {
        params: {
          crop_id: crop,
          year: year
        }
    })
    .then(response => {
        let x = 1;
        response.data.forEach(element => {
            totalHarvest.push([x, element.harvest]);
            totalProduction.push([x, element.production]);
            totalYield.push([x, element.yield]);
            season.push([x, element.season])
            x++;
        });
        initHarvestChart(season, totalHarvest, totalProduction, totalYield);
    })
    .catch(error => console.log(error));
}

// Initialize harvest chart options and data...
function initHarvestChart(season, harvest, production, yld) {
    // Harvest Chart Options
    let barChartOptions = {
        series: {
            bars: {
                show: true,
                barWidth: 0.15,
                fill: 1,
            }
        },
        grid : {
            borderWidth: 1,
            borderColor: '#f8f8f8',
            show : true,
            hoverable : true,
            clickable : true
        },
        yaxis: {
            tickColor: '#f8f8f8',
            tickDecimals: 0,
            font :{
                lineHeight: 13,
                style: "normal",
                color: "#9f9f9f",
            },
            shadowSize: 0
        },
        xaxis: {
            ticks: season,
            tickColor: '#fff',
            tickDecimals: 0,
            font :{
                lineHeight: 13,
                style: "normal",
                color: "#9f9f9f"
            },
            shadowSize: 0,
        },
        legend:{
            container: '#legend-harvest',
            backgroundOpacity: 0.5,
            noColumns: 0,
            backgroundColor: '#fff',
            lineWidth: 0,
            labelBoxBorderColor: '#fff'
        }
    };

     // Harvest Chart Data
    let barChartData = [
        {
            label: 'Harvest <small class="text-muted">(Hectare)</small>',
            data: harvest,
            color: '#32c787',
            bars: {
                order: 0
            }
        },
        {
            label: 'Production <small class="text-muted">(Metric Ton)</small>',
            data: production,
            color: '#03A9F4',
            bars: {
                order: 1
            }
        },
        {
            label: 'Yield <small class="text-muted">(Metric Ton / Hectare)</small>',
            data: yld,
            color: '#f5c942',
            bars: {
                order: 2
            }
        }
    ];

    // Create harvet chart...
    if ($('#chart-harvest')[0]) {
        chartHarvest = $.plot($('#chart-harvest'), barChartData, barChartOptions);
    }

    // Create harvest chart hover tooltips...
    if ($('#chart-harvest')[0]) {
        if(!$('#tooltip-harvest')[0]) {
            $('#chart-harvest').bind('plothover', function (event, pos, item) {
                if(item) {
                    var y = item.datapoint[1].toFixed(2);
                    $('#tooltip-harvest').html(item.series.label + ': ' + y).css({top: item.pageY+5, left: item.pageX+5}).show();
                }
                else {
                    $('#tooltip-harvest').hide();
                }
            });
            $('<div id="tooltip-harvest" class="flot-tooltip"></div>').appendTo('body');
        }
    }
}