$(function() {

    $('#ms').magicSuggest({
        data: 'get_countries.php',
        valueField: 'idCountry',
        displayField: 'countryName',
        groupBy: 'continentName',
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
        selectionRenderer: function(data){
            var img = data.countryCode ? ('<img src="img/flags/' + data.countryCode.toLowerCase() + '.png" />') : '';
            return img + '<div class="name">' + data.countryName + '</div>';
        }

    });

});