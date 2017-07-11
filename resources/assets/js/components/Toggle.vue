<template>
    <h1>
    <a class="button is-info" @click.prevent="change">
        <span class="icon is-small is-left">
            <i class="fa " :class="name"></i>
        </span>
    </a>
    </h1>
</template>

<script>
    export default{
        props:{
        },

        data(){
            return{
                name: 'fa-toggle-on',
                counts: 0,
            }
        },

        computed:{
        },

        mounted(){

        },

        methods:{
            change(){
                if(this.counts%2)
                {
                    this.name = 'fa-toggle-on';
                }
                else
                {
                    this.name = 'fa-toggle-off';
                }

                this.counts = this.counts+1;
            }
        }
    }
</script>