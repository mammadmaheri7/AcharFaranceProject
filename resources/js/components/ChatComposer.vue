<template lang="" html xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="panel-block field">
        <div class="control">
            <input type="text" class="input" v-on:keyup.enter="sendChat" v-model="chat">
        </div>
        <div class="control auto-width">
            <input type="button" class="button" value="Send" v-on:click="sendChat">
        </div>
    </div>
</template>

<script>
    export default{
        props:['chats','userid','friendid'],
        data()
        {
            return{
                chat:''
            };
        },
        methods:{
            sendChat:function (e) {
                if(this.chat != '')
                {
                    var data =
                    {
                        chat:this.chat,
                        friend_id:this.friendid,
                        user_id:this.userid

                    };

                    this.chat='';

                    axios.post('/chat/sendChat',data)
                            .then((response)=>{

                                this.chats.push(data);

                            })
                            .catch(error=>{
                                console.log(error);
                    })


                }
            }
        }

    }
</script>

<style scoped>
    .panel-block{
        flexdirection:row;
        width:100%;
        border: none;
        padding: 5px;
    }

    input{
        border-radius: 0;
    }
    .auto-width{
        width:auto;
    }
</style>