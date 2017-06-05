<template>
    <form style="margin-left: 20%" id="form_app_hero"  @submit.prevent="onSubmit" @keydown="form.errors.clear()">
        <div class="column is-three-quarters">
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
            console.log('Search mounted.');
        },

        methods:{

            onSubmit(){
               this.requestOn = true,
                this.form.post_(this.url).then(result => {
                    alert('All done'),
                        this.requestOn = false
                        this.$store.commit('load',result)
                });
                //this.form.post('/search').then(status => alert('All done'));
            },



        }
    }
</script>