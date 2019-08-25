function Review (review_id)
{
    this.render_edit = function()
    {
        url = '/reviews/'+review_id+'/json';
        $.ajax({
            dataType: "json",
            url: url,
        }).done(function(data) {
            console.log(data);
            $('<a>', {
                class : 'badge badge-pill badge-dark pill-rm',
                text : data.film.title_english,
                href: '#'
            }).appendTo('#add-film');
            $('<input>', {
                'name': 'film_id',
                'value': data.film.id,
                'hidden': 'hidden'
            }).appendTo($('#add-film').children('a').last());
        });
    }
}