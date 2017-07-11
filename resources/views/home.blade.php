@extends('layouts.app')

@section('title')
    @lang('menu.home')
    @endsection

@section('content')
<!--div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</--div-->
<div v-show="this.$store.state.a.recherche">
    <tabs>
        <tab name="@lang('menu.nav_search_result_all')" icon="fa-university" :selected="true">
            <template slot="before">@lang('messages.beforeResult')</template>
            <template slot="after">@lang('messages.afterResult')</template>
            <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
        </tab>
        <tab name="@lang('menu.nav_search_result_social')" icon="fa-comments">
            <template slot="before">@lang('messages.beforeResult')</template>
            <template slot="after">@lang('messages.afterResult')</template>
            <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
        </tab>
        <tab name="@lang('menu.nav_search_result_document')" icon="fa-file">
            <template slot="before">@lang('messages.beforeResult')</template>
            <template slot="after">@lang('messages.afterResult')</template>
            <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
        </tab>
        <tab name="@lang('menu.nav_search_result_image')" icon="fa-photo">
            <template slot="before">@lang('messages.beforeResult')</template>
            <template slot="after">@lang('messages.afterResult')</template>
            <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
        </tab>
        <tab name="@lang('menu.nav_search_result_video')" icon="fa-video-camera">
            <template slot="before">@lang('messages.beforeResult')</template>
            <template slot="after">@lang('messages.afterResult')</template>
            <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
        </tab>
    </tabs>
</div>

<div v-show="this.$store.state.a.profil">
    <tabs>
        <tab-central name="@lang('menu.nav_create_profil')" icon="fa-university" :selected="true">
            <div class="tile is-child has-text-centered">

                <img src="/uploads/avatars/{{ Auth::user()->avatar ? Auth::user()->avatar : '128x128.png'}}" style="width:150px; height:150px; float:left; border-radius:50%; margin-left:75px;">
                <form enctype="multipart/form-data" action="/en/avatar" method="POST">
                    <div class="field">
                        <p class="control">
                            <input type="file" name="avatar">
                        </p>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="field has-text-centered" style="margin-left: 100px">
                        <p class="control" >
                            <button class="button is-primary">
                               @lang('messages.save')
                            </button>
                        </p>
                    </div>
                </form>
            </div>
            <div class="tile is-child">
                <form-profile name="{{Auth::user()->name ? Auth::user()->name : ''}}"
                              nickname="{{Auth::user()->nickname ? Auth::user()->nickname : ''}}"
                              email="{{Auth::user()->email ? Auth::user()->email : ''}}"
                              profession="{{Auth::user()->profession ? Auth::user()->profession : ''}}"
                              src="/uploads/avatars/{{ Auth::user()->avatar ? Auth::user()->avatar : '128x128.png'}}"
                              save="@lang('messages.save')">
                    @lang('messages.profile')
                </form-profile>
            </div>
        </tab-central>
        <tab-central name="@lang('menu.hero_create_social')" icon="fa-comments" v-if="this.$store.state.a.activaterecherche">
            <p>
                <a href="{{ url('/auth/facebook') }}" class="btn"><i class="fa fa-facebook-f fa-lg"></i></a>
                <a href="{{ url('/auth/twitter') }}" class="btn"><i class="fa fa-twitter fa-lg"></i></a>
                <a href="{{ url('/auth/google') }}" class="btn"><i class="fa fa-google-plus fa-lg"></i></a>
                <a href="{{ url('/auth/github') }}" class="btn"><i class="fa fa-github fa-lg"></i></a>
            </p>
        </tab-central>
    </tabs>
</div>

<div v-show="this.$store.state.a.rechercherprofil">
    <tabs>
        <tab-profile name="@lang('menu.nav_search_result_all')" icon="fa-university" :selected="true">
            <template slot="before">@lang('messages.beforeResult')</template>
            <template slot="after">@lang('messages.afterResult')</template>
            <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
        </tab-profile>
        <tab-profile name="@lang('menu.nav_search_result_social')" icon="fa-comments">
            <template slot="before">@lang('messages.beforeResult')</template>
            <template slot="after">@lang('messages.afterResult')</template>
            <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
        </tab-profile>
        <tab-profile name="@lang('menu.nav_search_result_document')" icon="fa-file">
            <template slot="before">@lang('messages.beforeResult')</template>
            <template slot="after">@lang('messages.afterResult')</template>
            <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
        </tab-profile>
        <tab-profile name="@lang('menu.nav_search_result_image')" icon="fa-photo">
            <template slot="before">@lang('messages.beforeResult')</template>
            <template slot="after">@lang('messages.afterResult')</template>
            <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
        </tab-profile>
        <tab-profile name="@lang('menu.nav_search_result_video')" icon="fa-video-camera">
            <template slot="before">@lang('messages.beforeResult')</template>
            <template slot="after">@lang('messages.afterResult')</template>
            <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
        </tab-profile>
    </tabs>
</div>




@endsection
