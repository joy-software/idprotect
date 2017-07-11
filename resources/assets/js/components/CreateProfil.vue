<template>
    <form class="has-text-centered"  @submit.prevent="onSubmit" @keydown="form.errors.clear()">
        <alert v-if="alert" @close="CloseNotif">
            <slot></slot>
        </alert>
        <div class="field has-addons" >
            <p class="control has-icons-left">
                <input class="input" type="text" placeholder="name"  v-model="form.name" :value="name">
                <span class="icon is-small is-left">
                            <i class="fa fa-user"></i>
                        </span>
            </p>
            <p class="control">
                <a class="button is-info" @click.prevent="pname">
                    <span class="icon is-small is-left">
                        <i class="fa " :class="p_name"></i>
                    </span>
                </a>
            </p>
        </div>
        <div class="field has-addons">
            <p class="control has-icons-left">
                <input class="input" type="text" placeholder="nickname"  v-model="form.nickname">
                <span class="icon is-small is-left">
                            <i class="fa fa-user-o"></i>
                        </span>
            </p>
            <p class="control">
                <a class="button is-info" @click.prevent="pnickname">
                    <span class="icon is-small is-left">
                        <i class="fa " :class="p_nickname"></i>
                    </span>
                </a>
            </p>
        </div>
        <div class="field has-addons">
            <p class="control has-icons-left">
                <input class="input" type="email" placeholder="email"  v-model="form.email">
                <span class="icon is-small is-left">
                            <i class="fa fa-envelope"></i>
                        </span>
            </p>
            <p class="control">
                <a class="button is-info" @click.prevent="pemail">
                    <span class="icon is-small is-left">
                        <i class="fa " :class="p_email"></i>
                    </span>
                </a>
            </p>
        </div>
        <div class="field has-addons">
            <p class="control has-icons-left">
                <input class="input" type="text" placeholder="Profession" v-model="form.profession">
                <span class="icon is-small is-left">
                            <i class="fa fa-briefcase"></i>
                         </span>
            </p>
            <p class="control">
                <a class="button is-info" @click.prevent="pprofession">
                    <span class="icon is-small is-left">
                        <i class="fa " :class="p_profession"></i>
                    </span>
                </a>
            </p>
        </div>
        <div class="field has-text-centered " style="margin-right: 40px">
            <p class="control" >
                <button class="button is-info" :class="{'is-loading': requestOn}" v-text="save">

                 </button>
            </p>
        </div>
        <span v-show="form.errors.has('email')" class="text-warning has-text-centered is-medium" v-text="form.errors.get('email')"></span>
    </form>
</template>

<script>

    export default {
        props:{
            url: {required: false},
            error: {required: false},
            name: {required: true},
            nickname: {required: true},
            email: {required: true},
            profession: {required: true},
            src: {required: true},
            save: {required: true},


        },

        data(){
            return{
                //  isActive: false,
                form: new Form({name: '',nickname:'',email:'',profession:'',avatar:'',p_name:true,p_nickname:true,p_email:true,p_profession:true,p_avatar:true}),
               requestOn: false,
                counts: 0,
                p_name: 'fa-toggle-on',
                p_nickname: 'fa-toggle-on',
                p_email: 'fa-toggle-on',
                p_profession: 'fa-toggle-on',
                alert: false,

            }
        },

        computed:{

             /*href()
             {
             return '#'+this.name.toLowerCase().replace(/ /g,'-');
             }//*/


        },

        mounted(){
            this.form.email = this.email;
            this.form.profession = this.profession;
            this.form.nickname = this.nickname;
            this.form.name = this.name;
        },

        methods:{

            onSubmit(){
                this.form.errors.clear();
                //let show_error = true;
                //let erreur = new Object();
                this.requestOn = true;
                this.form.post_(this.$store.state.a.url+'/profile').then(result => {
                        console.log(result);
                    this.requestOn = false;
                    this.alert = true;
                    this.$store.commit('setactivaterecherche',true);
                    }).catch(error => {

                        // alert(error.indexOf('DOCTYPE'));
                         console.log(error);
                         this.requestOn = false;

                    });


                //this.form.post('/search').then(status => alert('All done'));
            },
            pname()
            {
                if(this.counts % 2)
                {
                    this.form.p_name = true;
                    this.p_name= 'fa-toggle-on';
                }
                else
                {
                    this.form.p_name = false;
                    this.p_name= 'fa-toggle-off';
                }
                this.counts = this.counts + 1;
            },
            pnickname()
            {
                if(this.counts % 2)
                {
                    this.form.p_nickname = true;
                    this.p_nickname= 'fa-toggle-on';
                }
                else
                {
                    this.form.p_nickname = false;
                    this.p_nickname= 'fa-toggle-off';
                }
                this.counts = this.counts + 1;
            },
            pemail()
            {
                if(this.counts % 2)
                {
                    this.form.p_email = true;
                    this.p_email= 'fa-toggle-on';
                }
                else
                {
                    this.form.p_email = false;
                    this.p_email= 'fa-toggle-off';
                }
                this.counts = this.counts + 1;
            },
            pprofession()
            {
                if(this.counts % 2)
                {
                    this.form.p_profession= true;
                    this.p_profession= 'fa-toggle-on';
                }
                else
                {
                    this.form.p_profession = false;
                    this.p_profession= 'fa-toggle-off';
                }
                this.counts = this.counts + 1;
            },
            CloseNotif(){
                this.alert = false;
            },


        }
    }
</script>



