<template lang="html">
    <div class="is-pulled-right">
        <!-- <i class="fa fa-circle red "></i>
        <i class="fa fa-circle green"></i> -->

        <i class="green" v-if="checkUser()">online</i>
        <i class="red" v-else>offline</i>
    </div>
</template>


<script>
    export default{
        props:['friend','onlineUsers'],
        methods:{
            checkUser(){
                return _.find(this.onlineUsers,{id:this.friend.id});
            }
        }
    }
</script>

<style lang="css">
    .red{
        color: red;
    }
    .green{
        color: green;
    }
</style>