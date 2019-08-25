function Film (film_id)
{
    this.film_id = film_id;
    // Render details for Review View
    this.render = function()
    {
        url = '/films/'+film_id+'/json';
        $.ajax({
            dataType: "json",
            url: url,
        }).done(function(data) {
            
            // Poster
            if (data.film.poster_url != null) {
                $('<div>', {
                    'id': 'poster'
                }).appendTo('#film-info');
                
                $('<img>', {
                    class: 'films-show-poster',
                    alt: data.film.title_english,
                    src: data.film.poster_url
                }).appendTo('#poster');
                $('#film-info').append($('<hr>'));
            }
            
            // Title in English
            $('<div>', {
                'id': 'title-english'
            }).appendTo('#film-info');
            
            if (data.film.imdb_id != null) {
                $('<h4>').appendTo('#title-english');
                $('<a>', {
                    href: "https://www.imdb.com/title/"+data.film.imdb_id,
                    text: data.film.title_english
                }).appendTo($('#title-english').children('h4'));
            } else {
                $('<h4>', {
                    text: data.film.title_english
                }).appendTo('#title-english');
            }
            
            // Title in Native Language
            $('<div>', {
                'id': 'title-native'
            }).appendTo('#film-info');  
            if (data.film.title_native != null) {
                $('<h6>', {
                    text: data.film.title_native+' (native title)'
                }).appendTo('#title-native');
            }
            
            // Release Date
            $('<div>', {
                'id': 'release-date'
            }).appendTo('#film-info');
            $('<h6>', {
                text: 'Release Date: '+data.film.release_date
            }).appendTo('#release-date');
            $('#film-info').append($('<hr>'));
            
            // Production Countries
            $('<div>', {
                'id': 'countries'
            }).appendTo('#film-info');
            $('<h5>', {
                'text': 'Countries of Production'
            }).appendTo('#countries');
            $('<p>').appendTo('#countries');
            $.each(data.countries, function(i, country) {
                $('<b>', {
                    text: country.name+' |'
                }).appendTo($('#countries').children('p'));
            });
            $('#film-info').append($('<hr>'));
            
            // Crew
            $('<h4>', {
                text: 'Crew'
            }).appendTo('#film-info');
            
            // Directors
            $('<div>', {
                'id': 'directors'
            }).appendTo('#film-info');
            $('<h6>', {
                'text': 'Directors',
                'style': 'font-weight: bold'
            }).appendTo('#directors');
            $.each(data.names, function(i, name) {
                if (name.pivot.credit == 'director') {
                    $('<b>').appendTo('#directors');
                    $('<a>', {
                        'text': name.name,
                        'href': '/names/'+name.id
                    }).appendTo($('#directors').children('b').last());
                    $('<span>', {
                        'text': ' | '
                    }).appendTo($('#directors').children('b').last());
                }
            });
            $('<hr>').appendTo('#directors');
            
            // Writers
            $('<div>', {
                'id': 'writers'
            }).appendTo('#film-info');
            $('<h6>', {
                'text': 'Writers',
                'style': 'font-weight: bold'
            }).appendTo('#writers');
            $.each(data.names, function(i, name) {
                if (name.pivot.credit == 'writer') {
                    $('<b>').appendTo('#writers');
                    $('<a>', {
                        'text': name.name,
                        'href': '/names/'+name.id
                    }).appendTo($('#writers').children('b').last());
                    $('<span>', {
                        'text': ' | '
                    }).appendTo($('#writers').children('b').last());
                }
            });
            
        });
    }
    // Render the edit form
    this.render_edit = function()
    {
        get_url = '/films/'+this.film_id+'/json';
        $.ajax({
            dataType: "json",
            url: get_url,
        }).done(function(data) {
            $.each(data.names, function(i, name) {
                if(name.pivot.credit == 'director') {
                    $('<a>', {
                        class : 'badge badge-pill badge-dark pill-rm',
                        text : name.name,
                        href: '#'
                    }).appendTo('#add-director');
                    $('<input>', {
                        'name': 'directors[]',
                        'value': name.id,
                        'hidden': 'hidden'
                    }).appendTo($('#add-director').children('a').last());
                } if (name.pivot.credit == 'writer') {
                    $('<a>', {
                        class : 'badge badge-pill badge-dark pill-rm',
                        text : name.name,
                        href: '#'
                    }).appendTo('#add-writer');
                    $('<input>', {
                        'name': 'writers[]',
                        'value': name.id,
                        'hidden': 'hidden'
                    }).appendTo($('#add-writer').children('a').last());
                }
            });
            $.each(data.countries, function(i, country) {
                $('<a>', {
                    class : 'badge badge-pill badge-dark pill-rm',
                    text : country.name,
                    href: '#'
                }).appendTo('#add-country');
                $('<input>', {
                    'name': 'countries[]',
                    'value': country.id,
                    'hidden': 'hidden'
                }).appendTo($('#add-country').children('a').last());
            });
        });
    }
}