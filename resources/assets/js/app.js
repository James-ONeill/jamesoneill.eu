
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

Vue.component('dashboard-navbar', require('./components/DashboardNavbar.vue'));
Vue.component('mailing-list-signup', require('./components/MailingListSignup.vue'));
Vue.component("post-card", require("./components/PostCard.vue"));
Vue.component('post-editor', require('./components/PostEditor.vue'));
Vue.component("talk-card", require("./components/TalkCard.vue"));
Vue.component("talk-editor", require("./components/TalkEditor.vue"));

const app = new Vue({
    el: '#app'
});
