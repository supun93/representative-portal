$(function() {

    var ms = $('#ms').magicSuggest({
        data: 'get_countries.php',
        valueField: 'idCountry',
        displayField: 'countryName',
        groupBy: 'continentName',
        mode: 'remote',
        renderer: function(data){
            return '<div class="country">' +
                    '<img src="img/flags/' + data.countryCode.toLowerCase() + '.png" />' +
                    '<div class="name">' + data.countryName + '</div>' +
                    '<div style="clear:both;"></div>' +
                    '<div class="prop">' +
                        '<div class="lbl">Population : </div>' +
                        '<div class="val">' + data.population + '</div>' +
                    '</div>' +
                    '<div class="prop">' +
                        '<div class="lbl">Capital : </div>' +
                        '<div class="val">' + data.capital + '</div>' +
                    '</div>' +
                    '<div style="clear:both;"></div>' +
                '</div>';
        },
        resultAsString: true,
        selectionRenderer: function(data){
            return '<img src="img/flags/' + data.countryCode.toLowerCase() + '.png" />' +
                    '<div class="name">' + data.countryName + '</div>';
        }
    });


});