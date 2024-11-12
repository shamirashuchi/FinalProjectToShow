<template>
    <div class="col-lg-12">
        <div v-if="isLoading">
            <div class="half-circle-spinner">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
            </div>
        </div>

        <div class="swiper pb-5" v-if="!isLoading" v-swiper id="testimonial-slider">
            <div class="swiper-wrapper pb-70 pt-5">
                <div class="swiper-slide swiper-group-3" v-for="item in data">
                    <div class="card-grid-6 hover-up">
                        <div class="card-text-desc mt-10">
                            <p class="font-md color-text-paragraph" v-html="item.content"></p>
                        </div>
                        <div class="card-image">
                            <div class="image">
                                <figure><img alt="jobBox" :src="item.image" /></figure>
                            </div>
                            <div class="card-profile">
                                <h6>{{ item.name }}</h6><span>{{ item.company }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                    this.isLoading = false;
                })
                .catch(() => {
                    this.isLoading = false;
                });
        },
    },
}
</script>
