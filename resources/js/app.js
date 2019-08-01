
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

import VueEcho from 'vue-echo/vue-echo';

Vue.component('chat', require('./components/Chat.vue'));
Vue.component('chat-composer', require('./components/ChatComposer.vue'));
Vue.component('onlineuser', require('./components/OnlineUser.vue'));

window.onload = function () {

    const app = new Vue({
        el: '#app',
        data:{
            chats:'',
            onlineUsers:'',
            //typing:false
            typing:''
        },
        methods:{
            /*
            isTyping(){
                let channel = Echo.private('ch');

                setTimeout(function() {
                    channel.whisper('ty', {
                        //user: Laravel.user,
                        typing: true
                    });
                }, 300);
            },
            */
        },
        created()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            console.log('created of ap.js started');
            const userId = $('meta[name="userId"]').attr('content');
            const friendId = $('meta[name="friendId"]').attr('content');

            /*
            let _this = this;
            Echo.private('ch')
                .listenForWhisper('ty', (e) => {
                    //this.user = e.user;
                    this.typing = e.typing;

                    // remove is typing indicator after 0.9s
                    setTimeout(function() {
                        _this.typing = false
                    }, 900);
                });
            */


            if(friendId != undefined)
            {
                axios.post('/chat/getChat/' + friendId)
                    .then((response)=>{
                        this.chats = response.data;
                    });

                console.log('Chat.' + friendId + '.' + userId);

                Echo.private('Chat.' + friendId + '.' + userId)
                    .listen('BroadcastChat',(e) => {
                        console.log('listend');
                        document.getElementById('ChatAudio').play();
                        this.chats.push(e.chat);
                    });


                Echo.private('chat')
                    .listenForWhisper('typing',(e)=>{
                        if(e.name != ''){
                            //console.log('typing'+e.name);
                            this.typing = 'typing...';
                        }
                        else{
                            //console.log(''+e.name);
                            this.typing = "";
                        }
                });

            }

            if(userId != 'null')
            {
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
            /*
            Echo.channel('Typing.' + friendId + '.' + userId)
                .listenForWhisper('doing',(e)=>{
                    if(e.name != ''){
                        console.log('typing'+e.name);
                        this.typing = 'typing...';
                    }
                    else{

                        console.log('nothing');
                        this.typing = '';
                    }
                });
                */
        },


    });

}

