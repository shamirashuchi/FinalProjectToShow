import Vue from 'vue';
import TestimonialsComponent from './components/TestimonialsComponent';
import TestimonialStyleTwoComponent from './components/TestimonialStyleTwoComponent';

Vue.component('testimonials-component', TestimonialsComponent);
Vue.component('testimonial-style-two-component', TestimonialStyleTwoComponent);

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * This let us access the `__` method for localization in VueJS templates
 * ({{ __('key') }})
 */
Vue.prototype.__ = key => {
    window.trans = window.trans || {};

    return window.trans[key] !== 'undefined' && window.trans[key] ? window.trans[key] : key;
};

Vue.directive('swiper', {
    inserted: function (el) {

        new Swiper('#' + $(el).prop('id'), {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            breakpoints: {
                200: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                992: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
            }
        });
    },
});

if (document.getElementById('app-testimonials')) {
    new Vue({
        el: '#app-testimonials',
    });
}
