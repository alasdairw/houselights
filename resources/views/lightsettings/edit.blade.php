@extends('app')
@section('contentheader_title')
<h1>
    Edit LightSetting
</h1>
@endsection

@section('main-content')
    @include('errors.list')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
            <div class="box-header"><h3 class="box-title">{{$lightsetting->name}}</h3></div>
                <div class="box-body">
                    {!! Form::model($lightsetting,['method'=>'PATCH','url'=> [action('LightSettingController@update', $lightsetting->id)]]) !!}
                        @include('lightsettings._form',['submitButtonText'=>'Update Light Setting'])
                    {!! Form::close() !!} 
                </div>
            </div>
        </div>
    </div>
@stop