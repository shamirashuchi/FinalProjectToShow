 $(document).ready(function () {
    'use strict';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const showError = message => {
        window.showAlert('alert-danger', message);
    }

    const showSuccess = message => {
        window.showAlert('alert-success', message);
    }

    const handleError = data => {
        if (typeof (data.errors) !== 'undefined' && data.errors.length) {
            handleValidationError(data.errors);
        } else if (typeof (data.responseJSON) !== 'undefined') {
            if (typeof (data.responseJSON.errors) !== 'undefined') {
                if (data.status === 422) {
                    handleValidationError(data.responseJSON.errors);
                }
            } else if (typeof (data.responseJSON.message) !== 'undefined') {
                showError(data.responseJSON.message);
            } else {
                $.each(data.responseJSON, (index, el) => {
                    $.each(el, (key, item) => {
                        showError(item);
                    });
                });
            }
        } else {
            showError(data.statusText);
        }
    }

    const handleValidationError = errors => {
        let message = '';
        $.each(errors, (index, item) => {
            if (message !== '') {
                message += '<br />';
            }
            message += item;
        });
        showError(message);
    }

    window.showAlert = (messageType, message) => {
        if (messageType && message !== '') {
            let alertId = Math.floor(Math.random() * 1000);

            let html = `<div class="alert ${messageType} alert-dismissible" id="${alertId}">
                            <span class="close mdi mdi-close-box" data-dismiss="alert" aria-label="close"></span>
                            <i class="` + (messageType === 'alert-success' ? 'mdi mdi-check' : 'mdi mdi-close') + ` message-icon"></i>
                            ${message}
                        </div>`;

            $('#alert-container').append(html).ready(() => {
                window.setTimeout(() => {
                    $(`#alert-container #${alertId}`).remove();
                }, 6000);
            });
        }
    }

     $('.newsletter-form button[type=submit]').on('click', function (event) {
         event.preventDefault();
         event.stopPropagation();

         let _self = $(this);
         $.ajax({
             type: 'POST',
             cache: false,
             url: _self.closest('form').prop('action'),
             data: new FormData(_self.closest('form')[0]),
             contentType: false,
             processData: false,
             beforeSend: () => {
                 _self.addClass('button-loading');
             },
             success: res => {
                 if (!res.error) {
                     _self.closest('form').find('input[type=email]').val('');
                     showSuccess(res.message);
                 } else {
                     showError(res.message);
                 }
             },
             error: res => {
                 handleError(res);
             },
             complete: () => {
                 if (typeof refreshRecaptcha !== 'undefined') {
                     refreshRecaptcha();
                 }
                 _self.removeClass('button-loading');
             },
         });
     });

    const loading = $('.loading-ring');

    loading.hide()

    function reloadReviewList(page) {
        let companyId = $('input[name=company_id]').val();
        $('.half-circle-spinner').toggle();
        $('.spinner-overflow').toggle();

        $.ajax({
            url: `/review/load-more?page=${page}&company_id=${companyId}`,
            success: function (data) {
                $('.review-list').html(data)
                $('.half-circle-spinner').toggle()
                $('.spinner-overflow').toggle()
            }
        });
    }

    $(document).on('click', '.company-review-form button[type=submit]', function (event) {
        event.preventDefault();
        event.stopPropagation();

        let _self = $(this);
        $.ajax({
            type: 'POST',
            cache: false,
            url: _self.closest('form').prop('action'),
            data: new FormData(_self.closest('form')[0]),
            contentType: false,
            processData: false,
            beforeSend: () => {
                _self.addClass('button-loading');
            },
            success: res => {
                if (!res.error) {
                    _self.closest('form').find('textarea').val('');
                    _self.closest('form').find('textarea').attr('disabled', true)
                    _self.attr('disabled', true)
                    showSuccess(res.message);
                    let page = $('.review-pagination').data('review-last-page')
                    reloadReviewList(page)
                } else {
                    showError(res.message);
                }
            },
            error: res => {
                handleError(res);
            },
            complete: () => {
                if (typeof refreshRecaptcha !== 'undefined') {
                    refreshRecaptcha();
                }
                _self.removeClass('button-loading');
            },
        });
    });

    $(() => {
        window.jobBoardMaps = {};

        function setJobBoardMap($el) {
            let uid = $el.data('uid');
            if (!uid) {
                uid = (Math.random() + 1).toString(36).substring(7) + (new Date().getTime());
                $el.data('uid', uid);
            }
            if (jobBoardMaps[uid]) {
                jobBoardMaps[uid].off();
                jobBoardMaps[uid].remove();
            }

            jobBoardMaps[uid] = L.map($el[0], {
                zoomControl: false,
                scrollWheelZoom: true,
                dragging: true,
                maxZoom: $el.data('max-zoom') || 20
            }).setView($el.data('center'), $el.data('zoom') || 14);

            let myIcon = L.divIcon({
                className: 'boxmarker',
                iconSize: L.point(50, 20),
                html: $el.data('map-icon')
            });
            L.tileLayer($el.data('tile-layer') ? $el.data('tile-layer') : 'https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}').addTo(jobBoardMaps[uid]);

            L.marker($el.data('center'), {icon: myIcon})
                .addTo(jobBoardMaps[uid])
                .bindPopup($($el.data('popup-id')).html())
                .openPopup();
        }

        let $jobMaps = $('.job-board-street-map');

        if ($jobMaps.length) {
            $jobMaps.each(function (i, e) {
                setJobBoardMap($(e));
            });
        }

        $(document).on('click', '.job-bookmark-action', function (e) {
            e.preventDefault();
            const $this = $(e.currentTarget);
            const $parent = $('.job-bookmark-saved');
            $.ajax({
                type: $this.prop('method') || 'POST',
                url: $this.prop('href'),
                data: {
                    job_id: $this.data('job-id')
                },
                beforeSend: () => {
                    $this.addClass('loading');
                },
                success: res => {
                    if (res.error) {
                        showError(res.message);
                        return false;
                    }
                    showSuccess(res.message);
                    if (res.data.is_saved) {
                        if ($parent.length) {
                            $parent.addClass('save-job-active');
                        } else {
                            $this.closest('.favorite-icon').parent().addClass('save-job-active');
                        }
                    } else {
                        if ($parent.length) {
                            $parent.removeClass('save-job-active');
                        } else {
                            $this.closest('.favorite-icon').parent().removeClass('save-job-active');
                        }
                    }
                },
                error: res => {
                    if (res.status === 401) {
                        $('#signupModal').modal('show');
                    } else {
                        handleError(res);
                    }
                },
                complete: () => {
                    $this.removeClass('loading');
                }
            });
        });

        let JobBoardApp = {};

        JobBoardApp.$formSearch = $('#jobs-filter-form');
        JobBoardApp.jobListing = '.jobs-listing';
        JobBoardApp.$jobListing = $(JobBoardApp.jobListing);
        JobBoardApp.parseParamsSearch = function (query, includeArray = false) {
            let pairs = query || window.location.search.substring(1);
            let re = /([^&=]+)=?([^&]*)/g;
            let decodeRE = /\+/g;  // Regex for replacing addition symbol with a space
            let decode = function (str) {
                return decodeURIComponent(str.replace(decodeRE, " "));
            };

            let params = {}, e;
            while (e = re.exec(pairs)) {
                let k = decode(e[1]), v = decode(e[2]);
                if (k.substring(k.length - 2) == '[]') {
                    if (includeArray) {
                        k = k.substring(0, k.length - 2);
                    }
                    (params[k] || (params[k] = [])).push(v);
                } else params[k] = v;
            }
            return params;
        }

        JobBoardApp.changeInputInSearchForm = function (parseParams) {
            JobBoardApp.$formSearch
                .find('input, select, textarea')
                .each(function (e, i) {
                    JobBoardApp.changeInputInSearchFormDetail($(i), parseParams);
                });


            $(':input[form=jobs-filter-form]')
                .each(function (e, i) {
                    JobBoardApp.changeInputInSearchFormDetail($(i), parseParams);
                });
        };

        JobBoardApp.changeInputInSearchFormDetail = function ($el, parseParams) {
            const name = $el.attr('name');
            let value = parseParams[name] || null;
            const type = $el.attr('type');
            switch (type) {
                case 'checkbox':
                case 'radio':
                    $el.prop('checked', false);
                    if (Array.isArray(value)) {
                        $el.prop('checked', value.includes($el.val()));
                    } else {
                        $el.prop('checked', !!value);
                    }
                    break;
                default:
                    if ($el.is('[name=max_price]')) {
                        $el.val(value || $el.data('max'));
                    } else if ($el.is('[name=min_price]')) {
                        $el.val(value || $el.data('min'));
                    } else if ($el.val() != value) {
                        $el.val(value);
                    }
                    break;
            }
        }

        JobBoardApp.convertFromDataToArray = function (formData) {
            let data = [];
            formData.forEach(function (obj) {
                if (obj.value) {
                    // break with price
                    if (['min_price', 'max_price'].includes(obj.name)) {
                        const dataValue = JobBoardApp.$formSearch
                            .find('input[name=' + obj.name + ']')
                            .data(obj.name.substring(0, 3));
                        if (dataValue == parseInt(obj.value)) {
                            return;
                        }
                    }
                    data.push(obj);
                }
            });
            return data;
        };

        JobBoardApp.jobsFilter = function () {
            let ajaxSending = null;
            $(document).on('submit', '#jobs-filter-form', function (e) {
                e.preventDefault();

                if (ajaxSending) {
                    ajaxSending.abort();
                }

                const $form = $(e.currentTarget);
                let formData = $form.serializeArray();
                let data = JobBoardApp.convertFromDataToArray(formData);
                let uriData = [];
                let location = window.location;
                let nextHref = location.origin + location.pathname;

                $.urlParam = function (name) {
                    let results = new RegExp('[\?&]' + name + '=([^&#]*)')
                        .exec(window.location.search);

                    return (results !== null) ? results[1] || 0 : false;
                }
                if ($.urlParam('limit')) {
                    data.push({name: 'limit', value: parseInt($.urlParam('limit'))})
                }

                // Paginate
                const $elPage = JobBoardApp.$jobListing.find('input[name=page]');
                if ($elPage.val()) {
                    data.push({name: 'page', value: $elPage.val()});
                }

                data.map(function (obj) {
                    if (obj.name === 'offered_salary_to') {
                        obj.value = Number(obj.value.replace(/[^0-9.-]+/g,""));
                    }
                    uriData.push(encodeURIComponent(obj.name) + '=' + obj.value);
                });

                if (uriData && uriData.length) {
                    nextHref += '?' + uriData.join('&');
                }
                // add to params get to popstate not show json
                data.push({name: '_', value: +new Date()});

                ajaxSending = $.ajax({
                    url: $form.attr('action'),
                    type: 'GET',
                    data: data,
                    beforeSend: function () {
                        // Show loading before sending
                        $('#loading').css('display', 'block')
                        $('.job-items').css('opacity', 0.2);
                    },
                    success: function (res) {
                        if (res.error == false) {
                            JobBoardApp.$jobListing.html(res.data);
                            if (res.additional?.message) {
                                JobBoardApp.$jobListing.closest('.jobs-listing-container')
                                    .find('.showing-of-results').html(res.additional.message);
                            }

                            JobBoardApp.executeMap()

                            if (nextHref !== window.location.href) {
                                window.history.pushState(
                                    data,
                                    res.message,
                                    nextHref
                                );
                            }
                        } else {
                            showError(res.message || 'Opp!');
                        }
                    },
                    error: function (res) {
                        if (res.statusText === 'abort') {
                            return; // ignore abort
                        }
                        handleError(res);
                    },
                    complete: function () {
                        setTimeout(function () {
                            $('#loading').css('display', 'none');
                            $('.loading-ring').hide()
                            $('.job-items').css('opacity', 1);
                        }, 500)

                    },
                });
            });

            window.addEventListener(
                'popstate',
                function () {
                    window.location.reload();
                },
                false
            );

            $(document).on(
                'click',
                JobBoardApp.jobListing + ' .pagination a',
                function (e) {
                    e.preventDefault();
                    let aLink = $(e.currentTarget).attr('href');

                    if (!aLink.includes(window.location.protocol)) {
                        aLink = window.location.protocol + aLink;
                    }

                    let url = new URL(aLink);
                    let page = url.searchParams.get('page');
                    JobBoardApp.$jobListing.find('input[name=page]').val(page);
                    JobBoardApp.$formSearch.trigger('submit');
                }
            );
        };

        JobBoardApp.jobsFilter();

        $('body').on('change, click', '.submit-form-filter', function (e) {
            JobBoardApp.$formSearch.find('input[name="page"]').val(1)
            submitForm(e)
        });

        String.prototype.interpolate = function (params) {
            const names = Object.keys(params);
            const vals = Object.values(params);
            return new Function(...names, `return \`${this}\`;`)(...vals);
        }
        let $templatePopup = $('#traffic-popup-map-template').html();

        JobBoardApp.initMaps = function ($map, force = false) {
            if (!$map.length) {
                return false;
            }

            let center = $map.data('center') || [];
            const $jobBoxes = $('.jobs-listing .job-box[data-latitude][data-longitude]');
            const centerFirst = $jobBoxes.filter(function () {
                return $(this).data('latitude') && $(this).data('longitude')
            });

            if (centerFirst && centerFirst.length) {
                center = [centerFirst.data('latitude'), centerFirst.data('longitude')]
            }

            let uid = $map.data('uid');
            if (!uid) {
                uid = (Math.random() + 1).toString(36).substring(7) + (new Date().getTime());
                $map.data('uid', uid);
            }

            let map;
            if (window.jobBoardMaps && window.jobBoardMaps[uid]) {
                if (force) {
                    window.jobBoardMaps[uid].off();
                    window.jobBoardMaps[uid].remove();
                } else {
                    map = window.jobBoardMaps[uid];
                    map.eachLayer(layer => {
                        layer.remove();
                    });
                }
            }

            const data = [];
            $jobBoxes.map(function (i, e) {
                const $el = $(e);
                data.push($el.data())
            });

            if (!map) {
                let zoom = $map.data('zoom') || 14;
                if (!data.length) {
                    zoom = $map.data('zoom-empty') || 12;
                }
                map = L.map($map[0], {
                    zoomControl: true,
                    scrollWheelZoom: true,
                    dragging: true,
                    maxZoom: $map.data('max-zoom') || 20
                }).setView(center, zoom);
            }

            L.tileLayer($map.data('tile-layer') ? $map.data('tile-layer') : 'https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}').addTo(map);

            let markers = new L.MarkerClusterGroup();
            let markersList = [];

            data.forEach(item => {
                if (item.latitude && item.longitude) {
                    const divIcon = L.divIcon({
                        className: 'boxmarker',
                        iconSize: L.point(50, 20),
                        html: item.map_icon
                    });

                    let popup = $templatePopup.interpolate({item});

                    let m = new L.Marker(new L.LatLng(item.latitude, item.longitude), {icon: divIcon})
                        .bindPopup(popup)
                        .addTo(map);
                    markersList.push(m);
                    markers.addLayer(m);

                    map.flyToBounds(L.latLngBounds(markersList.map(marker => marker.getLatLng())));
                }
            });

            map.addLayer(markers);

            $map.addClass('active');
            window.jobBoardMaps[uid] = map;
        }

        if ($('.jobs-list-sidebar').length) {
            if ($('.jobs-list-sidebar').is(':visible')) {
                JobBoardApp.initMaps($('.jobs-list-sidebar').find('.jobs-list-map'));
            }

            $(window).on('resize', function () {
                if ($('.jobs-list-sidebar').is(':visible')) {
                    JobBoardApp.initMaps($('.jobs-list-sidebar').find('.jobs-list-map'));
                }
            });
        }

        JobBoardApp.setCookie = function (cname, cvalue, exdays) {
            let d = new Date();
            let siteUrl = window.siteUrl;

            if (!siteUrl.includes(window.location.protocol)) {
                siteUrl = window.location.protocol + siteUrl;
            }

            let url = new URL(siteUrl);
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = 'expires=' + d.toUTCString();
            document.cookie = cname + '=' + cvalue + '; ' + expires + '; path=/' + '; domain=' + url.hostname;
        }

        JobBoardApp.executeMap = () => {
            const $map = $('.jobs-list-sidebar').find('.jobs-list-map');

            if ($map.length) {
                JobBoardApp.initMaps($map);
                JobBoardApp.setCookie('show_map_on_jobs_page', 1, 60);
            }
        }

        $('#offcanvas-jobs-map')
            .on('show.bs.offcanvas', function (e) {
                $('[data-bs-target="#offcanvas-jobs-map"]').addClass('active');
                const $this = $(e.currentTarget);
                const $map = $this.find('.jobs-list-map');
                if (!$map.hasClass('active')) {
                    JobBoardApp.initMaps($map);
                }
            })
            .on('hide.bs.offcanvas', function () {
                $('[data-bs-target="#offcanvas-jobs-map"]').removeClass('active');
            });
    });

    $(document).on('click', '.review-pagination a', function (e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        reloadReviewList(page);
    });

    $(document).on('click', '.layout-job', function (e) {
        e.preventDefault();

        $('#jobs-filter-form > input[name=layout]').val($(this).data('layout'))
        $('#jobs-filter-form').submit()
    });

    $(document).on('click', '.per-page-item', function (e) {
        e.preventDefault()
        $('#jobs-filter-form input[name=per_page]').val($(this).data('perPage'))
        $('#jobs-filter-form').submit()
    });

    $(document).on('click', '.dropdown-sort-by', function (e) {
        e.preventDefault()

        $('#jobs-filter-form input[name=sort_by]').val($(this).data('sortBy'))
        $('#jobs-filter-form').submit()
    });

    $(document).on('click', '.pagination-button', function (e) {
        e.preventDefault()

        $('#jobs-filter-form input[name=page]').val($(this).data('page'))
        $('#jobs-filter-form').submit()

        $('#form-page-categories input[name=page]').val($(this).data('page'))
        $('#form-page-categories').submit()
    });

    $(document).ready(function () {
        $('#selectCity').on('change', function(e) {
            submitForm(e);
        })

        $(".noUi-handle").on("click", function () {
            $(this).width(50);
        });

        let rangeSlider = $("#slider-range");

        if (rangeSlider.length > 0) {
            rangeSlider[0].noUiSlider.on("change", function (values, handle, e) {
                setTimeout(function () {
                    submitForm(e, $('#minValueMoney'))
                }, 1000);
            });
        }
    })

    let submitForm = (e, element = null) => {
        let $this = '';

        if (element) {
            $this = $('#minValueMoney')
        } else if (e) {
            $this = $(e.currentTarget)
        }

        let $form = $this.closest('form');
        if (!$form.length && $this.prop('form')) {
            $form = $($this.prop('form'));
        }

        if ($form.length) {
            $form.trigger('submit');
        }
    }

     let $applyNow = $('#ModalApplyJobForm');
     $applyNow.on('show.bs.modal', function (e) {
         const button = $(e.relatedTarget);
         const jobName = button.data('job-name');
         const jobId = button.data('job-id');

         $applyNow.find('.modal-job-name').text(jobName);
         $applyNow.find('.modal-job-id').val(jobId);
     });

     $applyNow.on('hide.bs.modal', function () {
         $applyNow.find('.modal-job-name').text('');
         $applyNow.find('.modal-job-id').val('');
     });

     let $applyExternalJob = $('#ModalApplyExternalJobForm');

     $applyExternalJob.on('show.bs.modal', function (e) {
         const button = $(e.relatedTarget);
         const jobName = button.data('job-name');
         const jobId = button.data('job-id');

         $applyExternalJob.find('.modal-job-name').text(jobName);
         $applyExternalJob.find('.modal-job-id').val(jobId);
     });

     $applyExternalJob.on('hide.bs.modal', function () {
         $applyExternalJob.find('.modal-job-name').text('');
         $applyExternalJob.find('.modal-job-id').val('');
     });

     $(document).on('submit', '.job-apply-form', function (e) {
         e.preventDefault();

         const $this = $(e.currentTarget);
         let _self = $this.find('button[type=submit]');

         $.ajax({
             type: 'POST',
             cache: false,
             url: $this.prop('action'),
             data: new FormData($this[0]),
             contentType: false,
             processData: false,
             beforeSend: () => {
                 _self.prop('disabled', true).addClass('button-loading');
             },
             success: res => {
                 if (!res.error) {
                     showSuccess(res.message);
                     setTimeout(function () {
                         if (res.data && res.data.url) {
                             window.location.replace(res.data.url);
                         } else {
                             window.location.reload();
                         }
                     }, 1000);
                 } else {
                     showError(res.message);
                 }
             },
             error: res => {
                 showError(res.responseJSON.message);
             },
             complete: () => {
                 if (typeof refreshRecaptcha !== 'undefined') {
                     refreshRecaptcha();
                 }
                 _self.prop('disabled', false).removeClass('button-loading');
             }
         });
     });

     $('.job-of-the-day').on('click', '.category-item', function (e) {
         e.preventDefault();
         let url = $(this).data('url');

         const $this = $(this);

         $.ajax({
             url: url,
             type: 'GET',
             data: {
                 style: $(this).data('style'),
             },
             dataType: 'json',
             beforeSend: function () {
                 loading.show()
             },
             success: function (res) {
                 if (! res.error) {
                     $('.job-of-the-day .category-item').removeClass('active');
                     $this.addClass('active');
                     $('.job-of-the-day-list').html(res.data);
                 }
             },
             error: function (res) {
                 if (res.statusText === 'abort') {
                     return; // ignore abort
                 }
                 handleError(res);
             },
             complete: function () {
                 setTimeout(function () {
                     $('.loading-ring').hide();
                 }, 500)
             },
         });
     })
     let rating = $('.company-detail-job-list .rating');
     if (rating.length) {
         rating.barrating({
             theme: 'css-stars'
         });
     }

     if (jQuery().mCustomScrollbar) {
         $('.ps-custom-scrollbar').mCustomScrollbar({
             theme: 'dark',
             scrollInertia: 0
         });
     }

     $(document).on('change', '#cover_image', function (event) {
         const imagePreview = $('.cover_image_preview');
         imagePreview.attr('src', URL.createObjectURL(event.target.files[0]));
         imagePreview.show();
     })
});
