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
    create_pills(id, title_english, 'film');
});

$(document).ready(function() {
    var review_id = $('meta[name="review-id-meta"]').attr('content');
    const review = new Review(review_id);
    review.render_edit();
    $('#review-edit-icon').on('click', function() {
        $('#review-info').toggle('display');
        $('#edit-review-info').toggle('display');
    });
});