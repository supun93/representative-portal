$(function() {

    $('#ms').magicSuggest({
        data: 'get_countries.php',
        valueField: 'idCountry',
        displayField: 'countryName'
    });

});