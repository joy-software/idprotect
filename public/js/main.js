/**
 * Created by hp on 24/05/2017.
 */
/*let app = new Vue({
    el: '#root',
    data: {
        message: 'Hello World',
        newName: '',
        names: ['Joy','Jed','Lydienne','Glory','Josiane','Rostand','Alex'],
        tasks:[
            {description:'Open the Browser' , completed:true},
            {description:'Compile the page' , completed:false},
            {description:'View the result' , completed:false},
            {description:'It\'s Ok' , completed:false},
            {description:'Clear the Browser' , completed:true}

        ]
    },

    methods: {
        addName()
        {
            this.names.push(this.newName)
            this.newName = '';
        }
    },

    computed:{
        reverseMessage(){
            return this.message.split('').reverse().join('');
        },

        IncompleteTasks()
        {
            return this.tasks.filter(task => ! task.completed)
        }
    }
})//*/
/*
Vue.component('message',{
    data(){
        return {
            isVisible: true,
        }
    },

    props: ['title','body'],

    template: '<article class="message" v-show="isVisible">'
    +'<div class="message-header">'
    +'<p>{{title}}</p>'
    +'<button type="button" @click="hideModal" class="pull-right">X</button>'
    +'</div>'
    +'<div class="message-body">'
   +'{{body}}'
    +'</div>'
    +'</article>',

    methods:{
        hideModal(){
            this.isVisible = false;
        }
    }
})
//*/
window.Event = new Vue();

Vue.component('modal',{



    template: '<div class="modal is-active">'+
    '<div class="modal-background"></div>'+
        '<div class="modal-card">'+
        '<header class="modal-card-head">'+
            '<p class="modal-card-title"><slot name="title"></slot></p>'+
            '<button class="delete"></button>'+
        '</header>'+
        '<section class="modal-card-body">'+
            '<slot></slot>'+
        '</section>'+
        '<footer class="modal-card-foot">'+
            '<slot name="footer"></slot>'+
        '</footer>'+
        '</div>'+
    '</div>',
});

Vue.component('tab',{
    template: '<div v-show="isActive"><slot></slot></div>',

    props:{
        name: {required: true},
        selected: {default: false},
    },

    data(){
        return{
            isActive: false,

        }
    },

    computed:{

        href()
            {
                return '#'+this.name.toLowerCase().replace(/ /g,'-');
            }

    },

    mounted(){
        this.isActive = this.selected;
    }
});

Vue.component('tabs',{
   template: '<div>'+
   '<div class="tabs">'+
         '<ul>'+
                '<li v-for="tab in tabs" :class="{\'is-active\': tab.isActive}" @click="selectTab(tab)">' +
                    '<a :href="tab.href">{{tab.name}}</a>' +
                '</li>'+
            '</ul>'+
        '</div>'+
        '<div class="tab-details">'+
            '<slot></slot>'+
        '</div>'+
    '</div>',

    data(){
       return {
           tabs: []
       }
    },

    created(){
       this.tabs = this.$children;
    },

    methods:{
      selectTab(clickedtab){
        this.tabs.forEach(tab => {
            tab.isActive = (tab.name == clickedtab.name)
        })
      }
    }
});

Vue.component('coupon',{
    template: '<input placeholder="Entrer le code de votre coupon" @blur="couponApplied">',

    methods:{
        couponApplied(){
            Event.$emit('applied');
        }
    }
})

let app = new Vue(
    {
     el: '#root',
        data: {
         showModal: false,
        },

        created(){
            Event.$on('applied',() => alert('handling it'))
        }
    }
)