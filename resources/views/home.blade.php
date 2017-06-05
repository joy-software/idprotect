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

        <result>

            <template slot="title"> "<b>Joy</b>"<b>Joy</b></template>
            <template slot="link"> "<b>Joy</b>"<b>Joy</b></template>
            <template> "<b>Joy</b>"<b>Joy</b></template>
        </result>
        <h1>Here is the content of the About me Tab</h1>

    </tab>
    <tab name="@lang('menu.nav_search_result_social')">
        <h1>Here is the content of the About Us Tab</h1>
    </tab>
    <tab name="@lang('menu.nav_search_result_document')">
        <h1>Here is the content of the About couple Tab</h1>
    </tab>
    <tab name="@lang('menu.nav_search_result_site')">
        <h1>Here is the content of the About our mariage Tab</h1>
    </tab>
    <tab name="@lang('menu.nav_search_result_image')">
        <h1>Here is the content of the About our mariage Tab</h1>
    </tab>
    <tab name="@lang('menu.nav_search_result_video')">
        <h1>Here is the content of the About our mariage Tab</h1>
    </tab>
</tabs>
@endsection
