<template>
    <div class="has-text-centered" >

        <img :src="src" style="width:150px; height:150px; border-radius:50%;">
        <div class="field has-addons"  v-if="p_name">
            <p class="control has-icons-left">
                <input class="input" type="text" placeholder="name"  v-model="form.name" disabled>
                <span class="icon is-small is-left">
                            <i class="fa fa-user"></i>
                        </span>
            </p>
        </div>
        <div class="field has-addons"  v-if="p_nickname">
            <p class="control has-icons-left">
                <input class="input" type="text" placeholder="nickname"  v-model="form.nickname" disabled>
                <span class="icon is-small is-left">
                            <i class="fa fa-user-o"></i>
                        </span>
            </p>
        </div>
        <div class="field has-addons" v-if="p_email">
            <p class="control has-icons-left">
                <input class="input" type="email" placeholder="email"  v-model="form.email" disabled>
                <span class="icon is-small is-left">
                            <i class="fa fa-envelope"></i>
                        </span>
            </p>
        </div>
        <div class="field has-addons"  v-if="p_profession">
            <p class="control has-icons-left">
                <input class="input" type="text" placeholder="Profession" v-model="form.profession" disabled>
                <span class="icon is-small is-left">
                            <i class="fa fa-briefcase"></i>
                         </span>
            </p>
        </div>

    </div>
</template>

<script>

    export default {
        props:{
            url: {required: false},
            error: {required: false},


        },

        data(){
            return{
                //  isActive: false,
                //form: new Form({name: '',nickname:'',email:'',profession:'',avatar:'',p_name:true,p_nickname:true,p_email:true,p_profession:true,p_avatar:true}),
               //requestOn: false,
               // counts: 0,
               // alert: false,

            }
        },

        computed:{

             form()
             {
                return new Form(this.$store.state.a.profile);
             },//*/
            src()
            {
              return  this.form.avatar ? "/uploads/avatars/"+this.form.avatar : "/uploads/avatars/128x128.png";
            },
            p_name()
            {
                if(this.form.p_name)
                {
                    return this.form.name !== "";
                }
                else
                {
                    return false;
                }
            },
            p_nickname()
            {
                if(this.form.p_nickname)
                {
                    return this.form.nickname !== "";
                }
                else
                {
                    return false;
                }
            },
            p_email()
            {
                if(this.form.p_email)
                {
                    return this.form.email !== "";
                }
                else
                {
                    return false;
                }
            },
            p_profession()
            {
                if(this.form.p_profession)
                {
                    return ((this.form.profession !== "") && (this.form.profession !== null) );
                }
                else
                {
                    return false;
                }
            },

        },

        mounted(){

        },

        methods:{

          /*  onSubmit(){
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
            },//*/


        }
    }
</script>



