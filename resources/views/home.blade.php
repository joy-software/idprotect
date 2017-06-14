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
    <tab name="@lang('menu.nav_search_result_all')" :selected="true">
        <template slot="before">@lang('messages.beforeResult')</template>
        <template slot="after">@lang('messages.afterResult')</template>
        <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
    </tab>
    <tab name="@lang('menu.nav_search_result_social')">
        <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
    </tab>
    <tab name="@lang('menu.nav_search_result_document')">
        <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
    </tab>
    <tab name="@lang('menu.nav_search_result_site')">
        <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
    </tab>
    <tab name="@lang('menu.nav_search_result_image')">
        <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
    </tab>
    <tab name="@lang('menu.nav_search_result_video')">
        <template slot="emptyResultMessage">@lang('messages.emptyResultMessage')</template>
    </tab>
</tabs>
@endsection
