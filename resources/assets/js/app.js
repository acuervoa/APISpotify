
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('result', {
    props: {
        'item': {
            type: Object,
            required: true,
        },
        'index': {
            default: 0,
            type: Number,
        },
    },
    template: `<div class="item">
        <div :class="{ row: index != 0 }">
            <div
                :class="{ 'col-md-6': index != 0 }"
                class="image-container">
                <img class="image img-fluid rounded" :src="item.image"/>
            </div>
            <div
                :class="{ 'col-md-6': index != 0 }"
                class="info-container">
                <p class="artist"> {{ item.artist }} </p>
                <p class="name"> {{ item.name }} </p>
            </div>
        </div>
    </div>`
})

const app = new Vue({
    el: '#app',
    data: {
        albums: [],
        tracks: [],
    },
    methods: {
        first: function(items) {
            return items[0]
        },
        fetch() {
            var self = this
            $.ajax({
                type: 'get',
                url: '/api/tops/3',
                success: function (response) {
                    self.tracks = response.tracks
                    self.albums = response.albums
                }
            })
        },
    },
    created() {
        this.fetch()
        setInterval(this.fetch, 1000 * 10 * 1)
    },
});
