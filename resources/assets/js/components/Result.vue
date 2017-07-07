<template>
    <div class="card">
        <div class="card-content" v-if="type !== 'images'">
            <div class="media">
                <div class="media-left " v-if="(type === 'video') && (video !== 'empty')">
                    <figure class="image">
                        <img :src="video" alt="Aperçu">
                    </figure>
                </div>
                <div class="media-content">
                    <p class="title is-5" v-html="title"></p>
                    <p class="subtitle is-6" ><a v-html="link" :href="link"></a></p>
                </div>
                <nav class="level">
                    <div class="has-text-centered">
                        <button class="level-item" v-show="!isLove" style="margin-bottom: 5px" @click.prevent="submitLove">
                            <span class="icon is-small"><i class="fa fa-heart"></i></span>
                        </button>
                        <a class="level-item" v-show="isLove" @click.prevent="submitFLove">
                            <span class="icon is-small"><i class="fa fa-heart"></i></span>
                        </a>
                        <button class="level-item" v-show="!isTrash" style="margin-bottom: 5px" @click.prevent="submitTrash">
                            <span class="icon is-small"><i class="fa fa-trash"></i></span>
                        </button>
                        <a class="level-item" v-show="isTrash" @click.prevent="submitFTrash">
                            <span class="icon is-small"><i class="fa fa-trash"></i></span>
                        </a>
                        <!--a class="level-item">
                            <span class="icon is-small"><i class="fa fa-legal"></i></span>
                        </a-->
                    </div>
                </nav>
            </div>

            <div class="content subtitle is-6" v-html="preview">
            </div>
        </div>
        <template v-if="type === 'images'">
            <div class="media">
                <div class="media-left ">
                    <figure class="image is-128x128">
                        <img :src="links" alt="Aperçu">
                    </figure>
                </div>
                <div class="media-content">
                    <p class="title is-5" v-html="title"></p>
                </div>
                <nav class="level">
                    <div class="has-text-centered">
                        <button class="level-item" v-show="!isLove" style="margin-bottom: 5px" @click.prevent="submitLove">
                            <span class="icon is-small"><i class="fa fa-heart"></i></span>
                        </button>
                        <a class="level-item" v-show="isLove" @click.prevent="submitFLove">
                            <span class="icon is-small"><i class="fa fa-heart"></i></span>
                        </a>
                        <button class="level-item" v-show="!isTrash" style="margin-bottom: 5px" @click.prevent="submitTrash">
                            <span class="icon is-small"><i class="fa fa-trash"></i></span>
                        </button>
                        <a class="level-item" v-show="isTrash" @click.prevent="submitFTrash">
                            <span class="icon is-small"><i class="fa fa-trash"></i></span>
                        </a>
                    </div>
                </nav>
            </div>
        </template>

    </div>
</template>

<script>

    export default {
        props:{
            title: {required: true},
            preview: {required: true},
            link: {required: true},
            links: {required: false},
            type: {required: true},
            id: {required: true},
            video: {required: false},
            statut: {required: true},
        },

        data(){
            return{
              //  isActive: false
                //title: this.title,
                //preview: this.preview,
                //link: this.link
                form: new Form({idResult: this.id}),
                isLove: false,
                isTrash: false,
            }
        },

        computed:{
          /*  href()
            {
                return '#'+this.name.toLowerCase().replace(/ /g,'-');
            }//*/

        },

        mounted(){
            if(this.statut === 'valid')
            {
                this.isLove = true;
            }
            if(this.statut === 'rejected')
            {
                this.isTrash = true;
            }
           // this.isActive = this.selected;
            //console.log('Result mounted.');
        },

        methods:{
            submitLove(){
                this.form.post_(this.$store.state.a.url+'/validSearchResult').then(result => {
                    //console.log(result);
                    this.isLove = true;
                }).catch(errors => {
                    console.log(errors);
                });
            },
            submitTrash(){
                this.form.post_(this.$store.state.a.url+'/rejectSearchResult').then(result => {
                    //console.log(result);
                    this.isTrash = true;
                }).catch(errors => {
                    console.log(errors);
                });
            },
            submitFLove(){
                this.isLove = false;
            },
            submitFTrash(){
                this.isTrash = false;
            }
        }
    }
</script>