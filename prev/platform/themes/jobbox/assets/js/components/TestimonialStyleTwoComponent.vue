<template>
    <div class="swiper-container swiper-group-4-border swiper" v-swiper id="testimonial-slider-2">
        <div class="swiper-wrapper pb-70 pt-5">
            <div class="swiper-slide hover-up" v-for="item in data">
                <div class="card-review-1">
                    <div class="image-review"> <img :src="item.image" :alt="item.name"></div>
                    <div class="review-info">
                        <div class="review-name">
                            <h5>{{ item.name }}</h5><span class="font-xs">{{ item.company }}</span>
                        </div>
                        <div class="review-comment" :title="item.content" v-html="item.content"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination swiper-pagination-style-border"></div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            isLoading: true,
            data: []
        };
    },
    props: {
        url: {
            type: String,
            default: () => null,
            required: true
        },
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            this.data = [];
            this.isLoading = true;
            axios.get(this.url)
                .then(res => {
                    this.data = res.data.data ? res.data.data : [];
                })
                .catch(() => {
                }).finally(() => {
                    this.isLoading = false;
                });
        },
    },
}
</script>
