// Create Menu functions
$(document).ready(function() {
    
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
            console.log(data);
            $.each(data.names, function(i, item) {
                console.log(item.name);
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
        console.log('Working');
        var id = $(this).children('input').val();
        var name = $(this).text();
        console.log(name);
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
            console.log(data);
            $.each(data.countries, function(i, item) {
                console.log(item.name);
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
    
    // Remove Pill (applies for all)
    $(document).on('click', '.pill-rm', function() {
        $(this).remove();
    });
    
});