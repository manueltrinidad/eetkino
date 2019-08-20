<script>
    $(document).ready(function() {
        
        // CSRF used for all POST/PUT/DELETE
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        
        // ----------------
        // Search Directors
        // ----------------
        
        // Create dropdown
        $('#search-bar-director').on('keyup', function() {
            
            $('#search-director-dropdown').empty();
            var url = '/search/name/';
            var q = $(this).val();
            
            $.ajax({
                dataType: "json",
                url: url,
                data: {query: q}
            })
            .done(function(data) {
                $.each(data.names, function(i, item) {
                    $('#search-director-dropdown').append($('<a>', {
                        class : 'dropdown-item director-dropdown',
                        text : item.name,
                        href: '#'
                    }).append($('<input>', {
                        value : item.id,
                        class : 'dropdown-item',
                        hidden : 'hidden'
                    })));
                });
            });
            
        });
        
        // Create pills
        $('#search-director-dropdown').on('click', '.director-dropdown', function() {
            var id = $(this).children('input').val();
            var name = $(this).text();
            $('#add-director').append($('<a>', {
                class : 'badge badge-pill badge-dark pill-rm',
                text : name,
                href: '#'
            }).append($('<input>', {
                value : id,
                name : 'directors[]',
                hidden : 'hidden'
            })));
        });
        
        // ----------------
        // Search Writers
        // ----------------
        
        // Create dropdown
        $('#search-bar-writer').on('keyup', function() {
            
            $('#search-writer-dropdown').empty();
            var url = '/search/name/';
            var q = $(this).val();
            
            $.ajax({
                dataType: "json",
                url: url,
                data: {query: q}
            }).done(function(data) {
                $.each(data.names, function(i, item) {
                    $('#search-writer-dropdown').append($('<a>', {
                        class : 'dropdown-item writer-dropdown',
                        text : item.name,
                        href: '#'
                    }).append($('<input>', {
                        value : item.id,
                        class : 'dropdown-item',
                        hidden : 'hidden'
                    })));
                });
            });
            
        });
        
        // Create pills
        $('#search-writer-dropdown').on('click', '.writer-dropdown', function() {
            var id = $(this).children('input').val();
            var name = $(this).text();
            $('#add-writer').append($('<a>', {
                class : 'badge badge-pill badge-dark pill-rm',
                text : name,
                href: '#'
            }).append($('<input>', {
                value : id,
                name : 'writers[]',
                hidden : 'hidden'
            })));
        });
        
        // ----------------
        // Search Countries
        // ----------------
        
        // Create dropdown
        $('#search-bar-country').on('keyup', function() {
            
            $('#search-country-dropdown').empty();
            var url = '/search/country/';
            var q = $(this).val();
            
            $.ajax({
                dataType: "json",
                url: url,
                data: {query: q}
            }).done(function(data) {
                $.each(data.countries, function(i, item) {
                    $('#search-country-dropdown').append($('<a>', {
                        class : 'dropdown-item country-dropdown',
                        text : item.name,
                        href: '#'
                    }).append($('<input>', {
                        value : item.id,
                        class : 'dropdown-item',
                        hidden : 'hidden'
                    })));
                });
            });
            
        });
        
        // Create pills
        $('#search-country-dropdown').on('click', '.country-dropdown', function() {
            var id = $(this).children('input').val();
            var name = $(this).text();
            $('#add-country').append($('<a>', {
                class : 'badge badge-pill badge-dark pill-rm',
                text : name,
                href: '#'
            }).append($('<input>', {
                value : id,
                name : 'countries[]',
                hidden : 'hidden'
            })));
        });
        
        // ----------------
        // Search Films
        // ----------------
        
        // Create dropdown
        $('#search-bar-film').on('keyup', function() {
            
            $('#search-film-dropdown').empty();
            var url = '/search/film/';
            var q = $(this).val();
            
            $.ajax({
                dataType: "json",
                url: url,
                data: {query: q}
            }).done(function(data) {
                $.each(data.films, function(i, item) {
                    $('#search-film-dropdown').append($('<a>', {
                        class : 'dropdown-item film-dropdown',
                        text : item.title_english,
                        href: '#'
                    }).append($('<input>', {
                        value : item.id,
                        hidden : 'hidden'
                    })));
                });
            });
            
        });
        
        // Create pills
        $('#search-film-dropdown').on('click', '.film-dropdown', function() {
            $('.pill-rm').remove();
            var id = $(this).children('input').val();
            var title_english = $(this).text();
            $('#add-film').append($('<a>', {
                class : 'badge badge-pill badge-dark pill-rm',
                text : title_english,
                href: '#'
            }).append($('<input>', {
                value : id,
                name : 'film_id',
                hidden : 'hidden',
                required : 'required'
            })));
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
            $.ajax({
                dataType: "json",
                url: url,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN, 
                    name: name
                },
                success: function(data) {
                    // Create pills
                    $('#search-director-dropdown', function() {
                        var id = data.name.id;
                        var name = data.name.name;
                        $('#add-director').append($('<a>', {
                            class : 'badge badge-pill badge-dark pill-rm',
                            text : name,
                            href: '#'
                        }).append($('<input>', {
                            value : id,
                            name : 'directors[]',
                            hidden : 'hidden'
                        })));
                    });
                    
                }
            });
        });
        
        // ------------
        // Create Writer
        // ------------
        
        $(document).on('click', '#create-writer', function() {
            
            var url = '/names/ajax';
            var name = $('#writer-name').val();
            $.ajax({
                dataType: "json",
                url: url,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN, 
                    name: name
                },
                success: function(data) {
                    // Create pills
                    $('#search-writer-dropdown', function() {
                        var id = data.name.id;
                        var name = data.name.name;
                        $('#add-writer').append($('<a>', {
                            class : 'badge badge-pill badge-dark pill-rm',
                            text : name,
                            href: '#'
                        }).append($('<input>', {
                            value : id,
                            name : 'writers[]',
                            hidden : 'hidden'
                        })));
                    });
                    
                }
            });
        });
        
        // ------------
        // Create Country
        // ------------
        
        $(document).on('click', '#create-country', function() {
            
            var url = '/countries/ajax';
            var name = $('#country-name').val();
            $.ajax({
                dataType: "json",
                url: url,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN, 
                    name: name
                },
                success: function(data) {
                    // Create pills
                    $('#search-country-dropdown', function() {
                        var id = data.country.id;
                        var name = data.country.name;
                        $('#add-country').append($('<a>', {
                            class : 'badge badge-pill badge-dark pill-rm',
                            text : name,
                            href: '#'
                        }).append($('<input>', {
                            value : id,
                            name : 'countries[]',
                            hidden : 'hidden'
                        })));
                    });
                    
                }
            });
        });
        
    });
</script>