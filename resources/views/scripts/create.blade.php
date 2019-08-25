<script>
    $(document).ready(function() {

        // Functions -----------------------------------------
        
        // CSRF used for all POST/PUT/DELETE
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        
        // Create Dropdown
        function search_bar(title, q)
        {
            $('#search-'+title+'-dropdown').empty();
            if (title == 'director' || title == 'writer') {
                var url = '/search/name/';
            } else if (title == 'country') {
                var url = '/search/country/';
            } else if (title == 'film') {
                var url = '/search/film/';
            }  
            
            $.ajax({
                dataType: "json",
                url: url,
                data: {query: q}
            })
            .done(function(data) {
                if (title == 'country') {
                    $.each(data.countries, function(i, item) {            
                        $('#search-'+title+'-dropdown').append($('<a>', {
                            class : 'dropdown-item '+title+'-dropdown',
                            text : item.name,
                            href: '#'
                        }).append($('<input>', {
                            value : item.id,
                            class : 'dropdown-item',
                            hidden : 'hidden'
                        })));
                    });
                } else if (title == 'film') {
                    $.each(data.films, function(i, item) {
                        $('#search-'+title+'-dropdown').append($('<a>', {
                            class : 'dropdown-item '+title+'-dropdown',
                            text : item.name,
                            href: '#'
                        }).append($('<input>', {
                            value : item.id,
                            class : 'dropdown-item',
                            hidden : 'hidden'
                        })));
                    });
                } else if (title == 'director' || title == 'writer') {
                    $.each(data.names, function(i, item) {
                        $('#search-'+title+'-dropdown').append($('<a>', {
                            class : 'dropdown-item '+title+'-dropdown',
                            text : item.name,
                            href: '#'
                        }).append($('<input>', {
                            value : item.id,
                            class : 'dropdown-item',
                            hidden : 'hidden'
                        })));
                    });
                }
            }); 
        }
        
        // Create Pills
        function create_pills(id, name, title)
        {
            if (title == 'director') {
                var input_name = 'directors[]';
            } else if (title == 'writer') {
                var input_name = 'writers[]';
            } else if (title == 'country') {
                var input_name = 'countries[]';
            }
            $('<a>', {
                class : 'badge badge-pill badge-dark pill-rm',
                text : name,
                href: '#'
            }).appendTo('#add-'+title);
            $('<input>', {
                value : id,
                name : input_name,
                hidden : 'hidden'
            }).appendTo($('#add-'+title).children('a').last());
            
        }
        // Create Entities in Database and Pill in Return
        function create_entity(name, url, title)
        {
            $.ajax({
                dataType: "json",
                url: url,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN, 
                    name: name
                },
                success: function(data) {
                    if (title == 'director' || title == 'writer') {
                        create_pills(data.name.id, data.name.name, title);
                    } else if (title == 'country') {
                        create_pills(data.country.id, data.country.name, title);
                    }
                }
            });
        }

        // Remove Pill (applies for all .pill-rm)
        $(document).on('click', '.pill-rm', function() {
            $(this).remove();
        });

        //----------------------------------------------

        // ----------------
        // Search Directors
        // ----------------
        
        $(document).on('keyup', '#search-bar-director', function() {
            var q = $(this).val();
            search_bar('director', q);
        });
        
        $(document).on('click', '.director-dropdown', function() {
            var id = $(this).children('input').val();
            var name = $(this).text();
            create_pills(id, name, 'director');
        });
        
        // ----------------
        // Search Writers
        // ----------------
        
        $('#search-bar-writer').on('keyup', function() {
            var q = $(this).val();
            search_bar('writer', q);
        });
        
        $('#search-writer-dropdown').on('click', '.writer-dropdown', function() {
            var id = $(this).children('input').val();
            var name = $(this).text();
            create_pills(id, name, 'writer');
        });
        
        // ----------------
        // Search Countries
        // ----------------
        
        $('#search-bar-country').on('keyup', function() {
            var q = $(this).val();
            search_bar('country', q);
        });
        
        $('#search-country-dropdown').on('click', '.country-dropdown', function() {
            var id = $(this).children('input').val();
            var name = $(this).text();
            create_pills(id, name, 'country');
        });
        
        // ----------------
        // Search Films
        // ----------------
        
        // Create dropdown
        $('#search-bar-film').on('keyup', function() {
            var q = $(this).val();
            search_bar('film', q);
        });
        
        // Create pills
        $('#search-film-dropdown').on('click', '.film-dropdown', function() {
            $('.pill-rm').remove(); // Since there can only be one film.
            var id = $(this).children('input').val();
            var title_english = $(this).text();
            create_pills(id, name, 'film');
        });
        
        
        // Remove Pill (applies for all)
        $(document).on('click', '.pill-rm', function() {
            $(this).remove();
        });
        
        // ------------
        // Create Director
        // ------------
        
        $(document).on('click', '#create-director', function() {
            var url = '/names/ajax';
            var name = $('#director-name').val();
            create_entity(name, url, 'director');
        });
        
        // ------------
        // Create Writer
        // ------------
        
        $(document).on('click', '#create-writer', function() {
            
            var url = '/names/ajax';
            var name = $('#writer-name').val();
            create_entity(name, url, 'writer');
        });
        
        // ------------
        // Create Country
        // ------------
        
        $(document).on('click', '#create-country', function() {
            var url = '/countries/ajax';
            var name = $('#country-name').val();
            create_entity(name, url, 'country');
        });       
    });
</script>