import './bootstrap';
require('@fortawesome/fontawesome-free/js/all.js');


import { createApp } from 'vue'

// import HelloWorld from './components/HelloWorld.vue';
import UserNotification from './components/UserNotification.vue';
// import AdminNotification from './components/AdminNotification.vue';



// const app = createApp({});
// app.component('hello-world', HelloWorld).mount('#app');

const user = createApp({});
user.component('user-notification', UserNotification).mount('#userNotification');

// const admin = createApp({});
// admin.component('admin-notification', AdminNotification).mount('#adminNotification');


