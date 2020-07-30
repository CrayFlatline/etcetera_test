(function($) {

    var filterForm = $(".faceted-filter-form");
    var filterFormInputs = $(".faceted-filter-form :input");
    var filterResultContainer = $("#realty-filter-result");
    var postNavContainer = $('#realty-filter-nav');
    var postPagenumHidden = $('#faceted-filter-form-page');
    var postPage = 1;

    postNavContainer.on('click', 'a', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        var matches = url.match(/page\/(\d+)/);
        postPage = matches != null ? matches[1] : 1;

        postPagenumHidden.val(postPage);

        console.log(postPage);
        updateListWithAjax();
    })

    filterFormInputs.change(function() {
        updateListWithAjax();
    });

    filterForm.on('submit', function(e) {
        e.preventDefault();
        updateListWithAjax();
    });

    filterForm.on('reset', function(e) {
        setTimeout(function() {
            updateListWithAjax();
        }, 10);
    });

    function updateListWithAjax() {
        var formData = filterForm.find(':input').serialize();

        $.ajax({
            url:    params.ajaxurl,
            type:   'post',
            data:   formData
        })
            .done( function( response ) { // response from the PHP action
                filterResultContainer.html(response.list);
                postNavContainer.html(response.nav);
            })

            // something went wrong
            .fail( function(response) {
                console.log(response);
            });

        // after all this time?
        // .always( function() {
        //     $(form).target.reset();
        // });
    }
})(jQuery);