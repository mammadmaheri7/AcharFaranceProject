
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

Vue.component('chat', require('./components/Chat.vue'));
Vue.component('chat-composer', require('./components/ChatComposer.vue'));
Vue.component('onlineuser', require('./components/OnlineUser.vue'));

const app = new Vue({
    el: '#app',
    data:{
        chats:'',
        onlineUsers:''
    },
    created()
    {

        console.log('created of ap.js started');
        const userId = $('meta[name="userId"]').attr('content');
        const friendId = $('meta[name="friendId"]').attr('content');

        if(friendId != undefined)
        {
            axios.post('/chat/getChat/' + friendId)
                .then((response)=>{
                    this.chats = response.data;
                });

            console.log('Chat.' + friendId + '.' + userId);


            //var triggered = channel.trigger("hi", data);

            Echo.private('Chat.' + friendId + '.' + userId)
                .listen('BroadcastChat',(e) => {
                    console.log('listend');
                    document.getElementById('ChatAudio').play();
                    this.chats.push(e.chat);
                });
            console.log('done');

        }

        if(userId != 'null')
        {
            console.log('in if');
            Echo.join('Online')
                .here((users)=>{
                    this.onlineUsers = users;
                })
                .joining((user)=>{
                    this.onlineUsers.push(user);
                })
                .leaving((user)=>{
                    this.onlineUsers = this.onlineUsers.filter((u)=>{u != user});
                });
        }
    }
});
