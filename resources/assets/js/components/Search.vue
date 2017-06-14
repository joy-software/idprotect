<template>
    <form style="margin-left: 20%" id="form_app_hero"  @submit.prevent="onSubmit" @keydown="form.errors.clear()">
        <div class="column is-three-quarters has-text-centered">
            <div class="field has-addons">
                <p class="control has-icons-left is-expanded">
                    <input class="input has-text-centered"  type="text" :placeholder="name" v-model="form.keywords">
                    <span class="icon is-small is-left">
                                                <i class="fa fa-search"></i>
                                            </span>
                </p>

                <p class="control">
                    <button class="button is-info" :disabled="form.errors.any()" :class="{'is-loading': requestOn}">
                        <slot></slot>
                    </button>
                </p>
            </div>
            <span v-show="form.errors.has('keywords')" class="text-warning has-text-centered is-medium" v-text="form.errors.get('keywords')"></span>

        </div>
    </form>
</template>

<script>

    export default {
        props:{
            name: {required: true},
            url: {required: false},
            error: {required: false},
            keywords: {required: false},
        },

        data(){
            return{
                //  isActive: false,
                form: new Form({keywords: ''}),
               requestOn: false


            }
        },

        computed:{

            /*  href()
             {
             return '#'+this.name.toLowerCase().replace(/ /g,'-');
             }//*/

        },

        mounted(){
            // this.urls = this.url;
            $(window).scroll(function () {
                if ($(window).scrollTop() > 280) {
                    $('#nav_tab').addClass('search-fixed');
                }
                if ($(window).scrollTop() < 281) {
                    $('#nav_tab').removeClass('search-fixed');
                }
            });
        },

        methods:{

            onSubmit(){
                this.form.errors.clear();
                let show_error = true;
                let erreur = new Object();
                if(this.form.keywords === "")
                {
                    let error = [];
                    error.push(this.keywords);
                    erreur.keywords = error;
                    this.form.errors.record(erreur);
                }
                else
                {
                    this.$store.commit('load',[]);
                    this.requestOn = true;
                    this.form.post_(this.url).then(result => {
                        this.$store.commit('active');
                        this.form.errors.clear();
                        this.requestOn = false;
                        show_error = false;
                        this.$store.commit('load',result)
                    }).catch(error => {

                        // alert(error.indexOf('DOCTYPE'));
                        if(error.hasOwnProperty('keywords'))
                        {
                            show_error = false;
                            this.requestOn = false
                        }
                        else
                        {
                            let error = [];
                            error.push(this.error);
                            erreur.keywords = error;
                            this.form.errors.record(erreur);
                        }

                        this.requestOn = false
                        //console.log(error)
                    });
                }


                //this.form.post('/search').then(status => alert('All done'));
            },



        }
    }
</script>

<style>
    .search-fixed {
    position: fixed;
    top: 0px;
        width: 100%;
        z-index: 1002
    }
</style>