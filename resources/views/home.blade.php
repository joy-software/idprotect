@extends('layouts.app')

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
@endsection
