if(window.location.pathname == '/maps') {
    // Variables...
    let globalLayer;
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

    $(document).ready(function() {
        initLeaflet();
        loadMaps();
        initModalElements();
        helpers.loadSelect('/api/loadLotSelect', $('#lot_number'), 'Lot');

        $('#map-search').on('click', function() {
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

        // Poly Drawing Event...
        map.on(L.Draw.Event.CREATED, function (event) {
            let layer = event.layer;
            globalLayer = null;
            drawnItems.addLayer(layer);
            $('#map-save').show();
            $('#map-update').hide();
            $('#area').val((LGeo.area(layer) / 10000).toFixed(2));
            $('#coordinates').val(convertToGeoJSON(layer));
            $('#lot_lat').val(layer.getBounds().getCenter().lat);
            $('#lot_lng').val(layer.getBounds().getCenter().lng);
            $('#modal-map').modal('show');
        });

        // map.on('draw:deletestart', function(e) {
        //     alert('Delete started.');
        // });

         // Modal show event listener...
        $('#modal-map').on('shown.bs.modal', function() {
            if(globalLayer != null) {
                $('#lot').val(globalLayer.feature.properties.lot);
                $('#watering_type').val(globalLayer.feature.properties.watering_type).trigger('change');
                $('#soil_type').val(globalLayer.feature.properties.soil_type).trigger('change');
                $('#map-update').val(globalLayer.feature.properties.id);

                // Load Municipalities
                axios.get('/api/loadMunicipalities')
                .then(function(response) {
                    $('#municipality').empty().trigger('change');
                    $('#municipality').select2({
                        placeholder: 'Select Municipality',
                        data: response.data,
                        positionDropdown: true
                    });      
                    $('#municipality').val(globalLayer.feature.properties.municipality).trigger('change');
                    
                    // Load Barangays...
                    axios.get('/api/loadBarangays/' + $('#municipality').val())
                    .then(function(response) {
                        $('#barangay').empty().trigger('change');
                        $('#barangay').select2({
                            placeholder: 'Select Barangay',
                            data: response.data,
                            positionDropdown: true
                        });      
                        $('#barangay').val(globalLayer.feature.properties.barangay).trigger('change');
                    })
                });
            }else {
                axios.get('/api/loadMunicipalities')
                .then(function(response) {
                    $('#municipality').empty();
                    $('#municipality').select2({
                        placeholder: 'Select Municipality',
                        data: response.data,
                        positionDropdown: true
                    });      
                    $('#municipality').val('').trigger('change');
                });

                $('#barangay').select2({
                    placeholder: 'Select Barangay',
                    positionDropdown: true
                });    
            }
        });

        $('#modal-map').on('hidden.bs.modal', function() {
            clearForm();
        });

        // Polygon on click event...
        drawnItems.on('click', event => {
            let layer = event.layer;
            if(layer.feature != undefined) {
                globalLayer = layer;
                $('#map-save').hide();
                $('#map-update').show();
            }else {
                helpers.showNotification('This lot is not yet saved to the database.', 'info', 'zmdi zmdi-info-outline');
                $('#map-save').show();
                $('#map-update').hide();
            }
            $('#area').val((LGeo.area(layer) / 10000).toFixed(2));
            $('#coordinates').val(convertToGeoJSON(layer));
            $('#lot_lat').val(layer.getBounds().getCenter().lat);
            $('#lot_lng').val(layer.getBounds().getCenter().lng);
            $('#modal-map').modal('show');
        });

        // Submit form to add new map...
        $('#map-save').on('click', function() {
            $('#form-map').parsley().validate();
            if($('#form-map').parsley().isValid()) {
                axios.post('maps', $('#form-map').serialize())
                .then(response => {
                    helpers.showNotification('Successfully added new map.', 'success', 'zmdi zmdi-check');
                    $('#modal-map').modal('hide');
                    helpers.loadSelect('/api/loadLotSelect', $('#lot_number'), 'Lot');
                    clearForm();
                    drawnItems.clearLayers();
                    loadMaps();
                })
                .catch(error => {
                    helpers.displayErrors(error.response.data.errors, 'Failed to add map', $('#form-map'));
                    console.log(error);
                });    
            }
        }); 

        // Submit form to update map...
        $('#map-update').on('click', function() {
            $('#form-map').parsley().validate();
            if($('#form-map').parsley().isValid()) {
                axios.put('/maps/' + $(this).val(), $("#form-map").serialize())
                .then(response => {
                    helpers.showNotification('Successfully updated map.', 'success', 'zmdi zmdi-check');
                    $('#modal-map').modal('hide');
                    helpers.loadSelect('/api/loadLotSelect', $('#lot_number'), 'Lot');
                    clearForm();
                    drawnItems.clearLayers();
                    loadMaps();
                })
                .catch(error => {
                    helpers.displayErrors(error.response.data.errors, 'Failed to updated map', $('#form-map'));
                    console.log(error);
                });    
            }
        }); 

        // Municipality select event listener...
        $('#municipality').on('select2:select', function() {
            helpers.loadSelect('/api/loadBarangays/' + $(this).val(), $('#barangay'), 'Barangay');
        });
    });

    // Javascript Functions...
    function initModalElements() {
        $('.capitalize').on('keyup', function() {
            $(this).capitalizeInput();
        });
        helpers.initParsley($('#form-map'));
        helpers.trimInput('#form-map input');

        $('select').on('select2:select', function() {
            $(this).parsley().validate();
        });

        $('#watering_type').select2({
            placeholder: 'Select Watering Type',
            data: [{id: 'Flood Irrigation', text: 'Flood Irrigation'}, {id: 'Sprinkler Irrigation', text: 'Sprinkler Irrigation'}, {id: 'Drip Irrigation', text: 'Drip Irrigation'}, {id: 'Micro Irrigation', text: 'Micro Irrigation'}]
        });

        $('#soil_type').select2({
            placeholder: 'Select Soil Type',
            data: [{id: 'Clay', text: 'Clay'}, {id: 'Loam', text: 'Loam'}, {id: 'Sand', text: 'Sand'}]
        });
    }

    function clearForm() {
        $('#form-map')[0].reset();
        $('select').val('').trigger('change');
        $('#form-map').parsley().reset();
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
                        lot_lng: response.data[x]['lot_lng']
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

        map.addControl(new L.Control.Draw({
            draw: {
                polygon: {
                    allowIntersection: false,
                    showArea: true
                },
                marker: false,
                polyline: false,
                rectangle: false,
                circle: false,
                circlemarker: false
            },
            edit: {
                featureGroup: drawnItems,
                poly: {
                    allowIntersection: false
                },
                remove: false
            }
        }));
        map.addControl(new L.Control.Compass());
    }
}