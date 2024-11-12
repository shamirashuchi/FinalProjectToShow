$(() => {
    'use strict'

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.select-location').select2({
        minimumInputLength: 0,
        ajax: {
            url: $(this).data('url') || (window.siteUrl + '/ajax/cities'),
            dataType: 'json',
            delay: 250,
            type: "GET",
            data: function (params) {
                return {
                    k: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: item.name,
                            id: item.id,
                            data: item
                        };
                    })
                };
            }
        }
    });

    $('.job-category').select2({
        minimumInputLength: 0,
        ajax: {
            url: $(this).data('url') || (window.siteUrl + '/ajax/categories'),
            dataType: 'json',
            delay: 250,
            type: "GET",
            data: function (params) {
                return {
                    k: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: item.name,
                            id: item.id,
                            data: item
                        };
                    })
                };
            }
        }
    });
})
