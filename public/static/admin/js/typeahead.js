$(document).ready(function () {
   /*--------------------------------------------
           		Form typeahead.js  建議清單
     ---------------------------------------------*/
     $('.typeahead').each(function () {
        var $data = $(this).attr("data-name");
        var countries = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: './data/' + $data + '.json'
        });
        $(this).typeahead(null, {
            name: 'countries',
            limit: 10,
            source: countries
        });
    }); 
});