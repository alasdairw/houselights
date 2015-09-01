@extends('app')
@section('contentheader_title')
<h1>
  List Light Settings
</h1>
@endsection

@section('main-content')
<div class="box">
  <div class="box-header">
    <h3 class="box-title">Light Settings</h3>
  </div><!-- /.box-header -->
  <div class="box-body no-padding">
    <table class="table table-striped">
      <tbody><tr>
        <th>Name</th>
        <th>Edit</th>
      </tr>
      @foreach($lightsettings as $lightsetting)
          <tr>
            <td>{{$lightsetting->name}}</td>
            <td><a href="{{action('LightSettingController@edit',['id'=>$lightsetting->id])}}" class="btn btn-block btn-primary">Edit</a></td>
          </tr>
      @endforeach
    </tbody></table>
  </div><!-- /.box-body -->
</div>
@stop