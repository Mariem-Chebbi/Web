$(document).ready(function() {
    $('#search-input').on('keyup', function() {
        var query = $(this).val();
        if (query.length >= 1) { // ne déclenche la recherche que si la requête contient au moins 1 caractères
            search(query);
        }
    });
});

function search(query) {
    $.ajax({
        url: "http://127.0.0.1:8000/search",
        type: "GET",
        data: { q: query },
        dataType: "json",
        success: function(data) {
           console.log(data.resultss);
           
            // mettre à jour la vue avec les résultats de la recherche
         // vider les résultats de la recherche précédente
         $('#Product-table').html(data.resultss);
       },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });

}