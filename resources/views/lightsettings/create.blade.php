@extends('app')
@section('contentheader_title')
<h1>
    New Light Setting
</h1>
@endsection

@section('main-content')
    @include('errors.list')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
            <div class="box-header"><h3 class="box-title">Light Setting</h3></div>
                <div class="box-body">
                    {!! Form::model($lightsetting = new \App\LightSetting,['url'=> [action('LightSettingController@store')]]) !!}
                        @include('lightsettings._form',['submitButtonText'=>'Create Light Setting'])
                    {!! Form::close() !!} 
                </div>
            </div>
        </div>
    </div>
@stop