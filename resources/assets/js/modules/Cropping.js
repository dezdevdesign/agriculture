if(window.location.pathname.includes('/croppings/add')) {
    // Variables...
    let googleUrl = 'http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}',
    googleAttrib = 'google',
    google = L.tileLayer(googleUrl, { maxZoom: 18, attribution: googleAttrib }),
    map = new L.Map('map', { 
        center: new L.LatLng(16.184075, 119.8616), 
        zoom: 13
    }),
    drawnItems = L.featureGroup().addTo(map),
    label = new L.marker(),
    popup = new L.Popup();

    let tblHarvest, tblCropping;

    let map_id, tmpArea;

    $(document).ready(function() {
        initElements();
        initLeaflet();
        loadMaps();
        initModalCropping();

        $('#cropping-search').on('click', function() {
            axios.get('/api/getLotCenter', {
                params: {
                    lot_id: $('#lot_number').val()
                }
            })
            .then(response => {
                map.setView(new L.LatLng(response.data[0].lot_lat, response.data[0].lot_lng), 18);
            })
            .catch(error => console.log(error));
        });

        $('#form-cropping').on('submit', function(e) {
            e.preventDefault();
            axios.post('/croppings/add', $(this).serialize() + '&map_id=' + map_id)
            .then(response => {
                helpers.showNotification('Successfully added new cropping.', 'success', 'zmdi zmdi-check');
                clearForm();
                tblCropping.draw();
                tblHarvest.draw();
                $('#harvested').val(tmpArea);
            })
            .catch(error => {
                console.log(error)
            });
        });

        // Polygon on click event listener...
        drawnItems.on('click', event => {
            let layer = event.layer;
            if(layer.feature != undefined) {
                $('#lot_title').html('<strong>' + layer.feature.properties.lot + ' </strong>- Cropping Record');
                map_id = layer.feature.properties.id;
                $('#lot').val(layer.feature.properties.lot);
                $('#watering_type').html(layer.feature.properties.watering_type);
                $('#soil_type').html(layer.feature.properties.soil_type);
                $('#municipality').html(layer.feature.properties.municipality_name);
                $('#barangay').html(layer.feature.properties.barangay_name);
                tmpArea = layer.feature.properties.area;
                $('#harvested').val(tmpArea);
                $('#map-save').hide();
                $('#map-update').show();
            }
            $('#modal-cropping').modal('show');
        });

        // Action select event listener...
        $('#process').on('select2:select', function () {
            if($(this).val() == 'Harvesting') {
                $('#div-harvest').show();
                $('#div-harvest').find('input, select, textarea').removeAttr('disabled');
            }else {
                $('#div-harvest').hide();
                $('#div-harvest').find('input, select, textarea').attr('disabled', true);
            }
        });

        // Yield computation...
        $('#harvested, #production').on('keyup', function() {
            if($('#harvested').val() != '' && $('#production').val() != '') {
                $('#yield').val(($('#production').val() / $('#harvested').val()).toFixed(2));
            }
        });

        // Cropping status event listener...
        $('#status').on('select2:select', function() {
            if($(this).val() == 'Bad') {
                $('#div-reason').show();
                $('#div-reason').find('select').removeAttr('disabled');
            }else {
                $('#div-reason').hide();
                $('#div-reason').find('select').attr('disabled', true);
            }
        });

        // Modal show event listener...
        $('#modal-cropping').on('shown.bs.modal', function() {
            tblCropping.draw();
            tblHarvest.draw();
        });

        // Modal close event listener...
        $('#modal-cropping').on('hidden.bs.modal', function () {
            clearForm();
        });
    });
    // Javascript Functions... 

    // Init some elements...
    function initElements() {
        helpers.loadSelect('/api/loadLotSelect', $('#lot_number'), 'Lot');

        tblCropping = $('#table-cropping').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: '/api/getCroppings',
                data: function(d) {
                    d.map_id = map_id;
                }
            },
            columns: [
                {data: 'id', name: 'croppings.id', visible: false},
                {data: 'crop', name: 'crops.name'},
                {data: 'date_start', name: 'croppings.date_start'},
                {data: 'date_end', name: 'croppings.date_end'},
                {data: 'season', name: 'croppings.season'},
                {data: 'process', name: 'croppings.process'},
                {data: 'farmer', name: 'farmers.name'}
            ],
            lengthMenu: [[5,15,30,-1], ['5 Rows', '15 Rows', '30 Rows', 'Everything']]
        });


        tblHarvest = $('#table-harvest').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: '/api/getHarvests',
                data: function(d) {
                    d.map_id = map_id;
                }
            },
            columns: [
                {data: 'id', name: 'harvests.id', visible: false},
                {data: 'crop', name: 'crops.name'},
                {data: 'date_start', name: 'croppings.date_start'},
                {data: 'date_end', name: 'croppings.date_end'},
                {data: 'season', name: 'croppings.season'},
                {data: 'harvested', name: 'harvests.harvested'},
                {data: 'production', name: 'harvests.production'},
                {data: 'yield', name: 'harvests.yield'},
                {data: 'status', name: 'harvests.status'},
                {data: 'reason', name: 'harvests.reason'},
                {data: 'climate', name: 'harvests.climate'},
                {data: 'fertilizer', name: 'harvests.fertilizer'},
                {data: 'remarks', name: 'harvests.remarks'},
                {data: 'farmer', name: 'farmers.name'}
            ],
            lengthMenu: [[5,15,30,-1], ['5 Rows', '15 Rows', '30 Rows', 'Everything']]
        });

        $('.dataTables_filter input[type=search]').focus(function () {
            $(this).closest('.dataTables_filter').addClass('dataTables_filter--toggled');
        });

        $('.dataTables_filter input[type=search]').blur(function () {
            $(this).closest('.dataTables_filter').removeClass('dataTables_filter--toggled');
        });
    }

    function initModalCropping() {
        $('.capitalize').on('keyup', function() {
            $(this).capitalizeInput();
        });

        $('.capitalize-first-period').on('keyup', function() {
            $(this).capitalizeFirstAndPeriod();
        })

        $('select').on('select2:select', function() {
            $(this).parsley().validate();
        });

        $('#date_start, #date_end').on('change', function() {
            $(this).parsley().validate();
        });

        helpers.initParsley($('#form-cropping'));
        helpers.trimInput('#form-cropping input, textarea');

        $('#season').select2({
            placeholder: 'Select Season',
            data: [{id: 'Season 1', text: 'Season 1'}, {id: 'Season 2', text: 'Season 2'}, {id: 'Season 3', text: 'Season 3'}],
            positionDropdown: true
        });

        $('#process').select2({
            placeholder: 'Select Action',
            data: [{id: 'Planting', text: 'Planting'}, {id: 'Harvesting', text: 'Harvesting'}],
            positionDropdown: true
        });

        $('#status').select2({
            placeholder: 'Select Action',
            data: [{id: 'Good', text: 'Good'}, {id: 'Bad', text: 'Bad'}],
            positionDropdown: true
        });

        $('#reason').select2({
            placeholder: 'Select Action',
            data: [{id: 'Storm', text: 'Storm'}, {id: 'Pest', text: 'Pest'}, {id: 'El Nino', text: 'El Nino'}],
            positionDropdown: true
        });

        helpers.loadSelect('/api/getCrops',  $('#crop_id'), 'Crop');
        helpers.loadSelect('/api/getFarmers',  $('#farmer_id'), 'Farmer');

        $('#date_start, #date_end').datepicker( {
            format: "yyyy-mm",
            startView: "months", 
            minViewMode: "months",
            autoclose: true
        }); 
        hideModalElements();
    }

    function hideModalElements() {
        $('#div-harvest').hide();
        $('#div-harvest').find('input, select, textarea').attr('disabled', true);

        $('#div-reason').hide();
        $('#div-reason').find('select').attr('disabled', true);
    }

    function clearForm() {
        $('#form-cropping')[0].reset();
        $('#form-cropping select').val(null).trigger('change');
        $('#date_start, #date_end').val(null).datepicker('update');
        $('#form-cropping').parsley().reset();
        hideModalElements();
    }

    // Add methods on each layer...
    function onEachFeature(feature, layer) {
        drawnItems.addLayer(layer);
        layer.bindTooltip(feature.properties.lot, {
            permanent: true
        }).openTooltip();
    }

    // Load all maps from the database...
    function loadMaps() {
        axios.get('/api/loadMaps')
        .then(response => {
            var lots = [];
            for(let x = 0; x < response.data.length; x++) {
                lots.push({
                    type: 'Feature',
                    properties: {
                        id: response.data[x]['id'],
                        lot: response.data[x]['lot'],
                        watering_type: response.data[x]['watering_type'],
                        soil_type: response.data[x]['soil_type'],
                        municipality: response.data[x]['municipality'],
                        barangay: response.data[x]['barangay'],
                        area: response.data[x]['area'],
                        coordinates: response.data[x]['coordinates'],
                        lot_lat: response.data[x]['lot_lat'],
                        lot_lng: response.data[x]['lot_lng'],
                        municipality_name: response.data[x]['municipality_name'],
                        barangay_name: response.data[x]['barangay_name']
                    },
                    geometry: {
                        type: 'Polygon',
                        coordinates: JSON.parse(response.data[x]['coordinates'])
                    }
                });
            }
            L.geoJSON(lots, {
                onEachFeature: onEachFeature
            }).addTo(map);
        })
        .catch(error => {
            console.log(error);
        });  
    }

    // Convert layer to GeoJSON...
    function convertToGeoJSON(tmpLayer) {
        let shape = tmpLayer.toGeoJSON()
        return JSON.stringify(shape['geometry']['coordinates']);
    }

    // Leaflet init elements...
    function initLeaflet() {
        L.control.layers({
            google: google.addTo(map),
            osm: L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            })
        }, {
            drawlayer: drawnItems 
        }, { 
            position: 'topleft', collapsed: false
        }).addTo(map);
        map.addControl(new L.Control.Compass());
    }
}