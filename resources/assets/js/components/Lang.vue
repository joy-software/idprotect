<template>
    <a class="image is-32x32 is-pulled-left" :href="href">
        <img :src="src">
    </a>
</template>

<script>
    export default{
        props:{
            current : {required: true},
            french : {required: true},
            english : {required: true},
            url : {required: true},
            route : {required: true},
        },

        data(){
            return{
                lang: this.current,
            }
        },

        computed:{
            src(){
                if(this.lang === 'en')
                {
                    return this.french
                }
                else {
                    return this.english
                }
            },
            href(){
                return this.url+'/'+this.route+'/'+this.lang
            }
        },

        mounted(){

        },

        methods:{
            submit(){
                axios.post(this.url+'/changeLang').then(result => {
                  this.lang = 'fr'
                }).catch(errors => {

                });
            }
        }
    }
</script>