var my_handlers = {
    fill_provinces:  function(){
        var region_code = $( "option:selected" , this).data('psgc-code');
        $('#province').ph_locations('fetch_list', [
            { 
                "filter": {
                    "region_code": region_code
                }
            }
        ]);
        // Enable province dropdown when changing region
        $('#province').prop('disabled', false);
        $('#province').val('');
        // Disable city and barangay dropdowns until a province is selected
        $('#cityMunicipality').prop('disabled', true);
        $('#cityMunicipality').val('');
        $('#barangay').prop('disabled', true);
        $('#barangay').val('');
    },

    fill_cities: function(){
        var province_code = $( "option:selected" , this).data('psgc-code');
        $('#cityMunicipality').ph_locations('fetch_list', [
            { 
                "filter": {
                    "province_code": province_code
                }
            }
        ]);
        // Enable city dropdown when changing province
        $('#cityMunicipality').prop('disabled', false);
        $('#cityMunicipality').val('');
        // Disable barangay dropdown until a city is selected
        $('#barangay').prop('disabled', true);
        $('#barangay').val('');
    },

    fill_barangays: function(){
        var city_code = $( "option:selected" , this).data('psgc-code');
        var province_code = $( "#province option:selected").data('psgc-code');
        $('#barangay').ph_locations('fetch_list', [
            { 
                "filter": {
                    "province_code": province_code,
                    "city_code": city_code
                }
            }
        ]);
        // Enable barangay dropdown when a city is selected
        $('#barangay').prop('disabled', false);
    }
};

$(function(){
    $('#region').on('change', my_handlers.fill_provinces);
    $('#province').on('change', my_handlers.fill_cities);
    $('#cityMunicipality').on('change', my_handlers.fill_barangays);

    $('#region').ph_locations({'location_type': 'regions'});
    $('#province').ph_locations({'location_type': 'provinces'});
    $('#cityMunicipality').ph_locations({'location_type': 'cities'});
    $('#barangay').ph_locations({'location_type': 'barangays'});

    $('#region').ph_locations('fetch_list', [{'location_type': 'regions', "selected_value" : "REGION I (ILOCOS REGION)"}]);

    // Disable province, city, and barangay dropdowns initially
    $('#province').prop('disabled', true);
    $('#cityMunicipality').prop('disabled', true);
    $('#barangay').prop('disabled', true);
});
