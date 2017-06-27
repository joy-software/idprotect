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
                <nav class="level is-mobile">
                    <div class="has-text-centered">
                        <button class="level-item" v-show="!isLove" style="margin-bottom: 5px" @click.prevent="submitLove">
                            <span class="icon is-small"><i class="fa fa-heart"></i></span>
                        </button>
                        <a class="level-item" v-show="isLove">
                            <span class="icon is-small"><i class="fa fa-trash"></i></span>
                        </a>
                        <button class="level-item" v-show="!isTrash" style="margin-bottom: 5px" @click.prevent="submitTrash">
                            <span class="icon is-small"><i class="fa fa-heart"></i></span>
                        </button>
                        <a class="level-item" v-show="isLove">
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
            <figure class="image">
                <img :src="links">
            </figure>
            <p class="title is-6" v-html="title"></p>
        </template>

    </div>
</template>

<script>

    export default {
        props:{
            title: {required: true},
            preview: {required: true},
            link: {required: true},
            type: {required: true},
            id: {required: true},
            video: {required: false}
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
           // this.isActive = this.selected;
            //console.log('Result mounted.');
        },

        methods:{
            submitLove(){
                this.isLove = true;
            },
            submitTrash(){
                this.isTrash = true;
            }
        }
    }
</script>