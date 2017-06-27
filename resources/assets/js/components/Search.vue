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
                    <button class="button is-info" :disabled="form.errors.any() || activate" :class="{'is-loading': requestOn}">
                        <slot></slot>
                    </button>
                </p>
            </div>
            <div class="progress-container is-flex" v-show="activate">
                <progress class="progress is-info" :value="progress" max="100">
                </progress>
                <span class="is-small">{{progress + '%'}}</span>
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

             /*href()
             {
             return '#'+this.name.toLowerCase().replace(/ /g,'-');
             }//*/
             progress()
             {
                 return this.$store.state.a.progress;
             },
             activate ()
             {
                 return this.$store.state.a.progressShown;
             }

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
                    this.$store.commit('deactivate');
                    this.$store.commit('load',[]);
                    this.requestOn = true;
                    this.$store.commit('activeP');
                    console.log(this.form.keywords);
                    this.form.post_(this.url+'/search').then(result => {
                        this.$store.commit('active');
                        this.$store.commit('setProgress',20);
                        this.$store.commit('load',result)
                        axios.get(this.url+'/searchV/'+this.form.keywords).then(result => {
                                this.$store.commit('setProgress',40);
                                this.$store.commit('add',result.data);
                                axios.get(this.url+'/searchI/'+this.form.keywords).then(result => {
                                    this.$store.commit('setProgress',60);
                                    this.$store.commit('add',result.data);
                                    axios.get(this.url+'/searchS/'+this.form.keywords +'/'+1).then(result => {
                                        this.$store.commit('setProgress',80);
                                        this.$store.commit('add',result.data)
                                        axios.get(this.url+'/searchD/'+this.form.keywords +'/'+1).then(result => {
                                            this.$store.commit('setProgress',100);
                                            this.$store.commit('add',result.data)
                                        }).catch(errors => {
                                            console.log(errors);
                                            let error = [];
                                            error.push(this.error);
                                            erreur.keywords = error;
                                            this.form.errors.record(erreur);
                                            this.requestOn = false
                                        });
                                    }).catch(errors => {
                                        console.log(errors);
                                        let error = [];
                                        error.push(this.error);
                                        erreur.keywords = error;
                                        this.form.errors.record(erreur);
                                        this.requestOn = false
                                    });
                                }).catch(errors => {
                                        console.log(errors);
                                        let error = [];
                                        error.push(this.error);
                                        erreur.keywords = error;
                                        this.form.errors.record(erreur);
                                        this.requestOn = false
                                    });
                            })
                            .catch(errors => {
                                console.log(errors);
                                let error = [];
                                error.push(this.error);
                                erreur.keywords = error;
                                this.form.errors.record(erreur);
                                this.requestOn = false
                            });

                        this.form.errors.clear();
                        this.requestOn = false;
                        show_error = false;
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

    .progress-container {
        align-items: center;
        margin-bottom: 20px;
    }
    .progress-container .progress {
        position: relative;
        margin-bottom: 0 !important;
    }
    .progress  span {
        margin-left: 10px;
        min-width: 36px;
        text-align: right;
    }

</style>

