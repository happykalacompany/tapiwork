<style lang="scss">
    div#login-modal{
        position: fixed;
        top: 0px;
        bottom: 0px;
        left:0px;
        right:0px;
        background-color: rgba(0, 0, 0, .6);

        div.login-box{
            max-width: 370px;
            min-width: 320px;
            padding: 0 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            -webkit-box-shadow: 0 1px 3px rgba(50, 50, 50, 0.08);
            box-shadow: 0 1px 3px rgba(50, 50, 50, 0.08);
            -webkit-border-radius: 4px;
            border-radius: 4px;
            font-size: 16px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

            a {
                display: block;
                margin: auto;
                width: 230px;
                margin-top: 10px;
                margin-bottom: 10px;
            }
        }
    }
</style>

<template>
    <div id="login-modal" v-show="show" v-on:click="show = false">
        <div class="login-box">
            <a href="/auth/github" v-on:click.stop=''>
                <img src="/storage/img/github-login.jpg">
            </a>
        </div>
    </div>
</template>

<script>
import {EventBus} from '../../event-bus.js';
export default {
    data(){
        return {
            show:false
        }
    },
    mounted(){
        EventBus.$on('promt-login',function(){
            this.show = true;
        }.bind(this));
    }
}
</script>    
