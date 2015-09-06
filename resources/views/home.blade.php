@extends('app')

@section('styles')
    <link rel="stylesheet" href="../../plugins/colorpicker/bootstrap-colorpicker.min.css">
@endsection

@section('htmlheader_title')
    Home
@endsection

@section('contentheader_title')
    Dashboard
@endsection


@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Lights</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Light Name</th>
                                <th>On/Off</th>
                                <th>Colour</th>
                                <th>Change</th>
                            </tr>
                            @foreach($lights as $light)
                            <tr>
                                <td>{{$light->light_id}}</td>
                                <td>{{$light->name}}</td>
                                <td>
                                    @if($light->reachable==1)
                                        <a href="{{action('HouseLightController@toggle',['houselight'=>$light->id])}}" id="light_toggle_{{$light->light_id}}">
                                        @if($light->state==0)
                                            <i class="fa fa-fw fa-toggle-off"></i> Off
                                        @else
                                            <i class="fa fa-fw fa-toggle-on" id="light_toggle_{{$light->light_id}}"></i> On
                                        @endif
                                        </a>
                                    @else
                                        <i class="fa fa-fw fa-power-off"></i> Power Off
                                    @endif

                                </td>
                                <td style="background-color: rgb({{$light->red}},{{$light->green}},{{$light->blue}})">
                                </td>
                                <td>

                                    {!! Form::open(['url'=> [action('HouseLightController@colorchange_setting',$light->id)]]) !!}
                                    {!! Form::select('lightsetting',\App\LightSetting::lists('name','id'),null,['class'=>'form-control'])!!}
                                    {!! Form::submit('Change',['class'=>'btn btn-primary form-control'])!!}
                                    {!! Form::close()!!}
<!--                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td style="background-color: rgb(255,0,0)"><a href="{{action('HouseLightController@colorchange_xy',['houselight'=>$light->id,'x'=>0.7,'y'=>0.2986])}}">...</a></td>
                                                <td style="background-color: rgb(0,0,255)"><a href="{{action('HouseLightController@colorchange_xy',['houselight'=>$light->id,'x'=>0.139,'y'=>0.081])}}">...</a></td>
                                                <td style="background-color: rgb(0,255,0)"><a href="{{action('HouseLightController@colorchange_xy',['houselight'=>$light->id,'x'=>0.241,'y'=>0.709])}}">...</a></td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: rgb(255,255,255)"><a href="{{action('HouseLightController@colorchange_xy',['houselight'=>$light->id,'x'=>0.3227,'y'=>0.329])}}">...</a></td>
                                                <td style="background-color: rgb(255,214,0)"><a href="{{action('HouseLightController@colorchange_xy',['houselight'=>$light->id,'x'=>0.4947,'y'=>0.472])}}">...</a></td>
                                                <td style="background-color: rgb(63,104,224)"><a href="{{action('HouseLightController@colorchange_xy',['houselight'=>$light->id,'x'=>0.1649,'y'=>0.1338])}}">...</a></td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: rgb(127,0,127)"><a href="{{action('HouseLightController@colorchange_xy',['houselight'=>$light->id,'x'=>0.3787,'y'=>0.1724])}}">...</a></td>
                                                <td style="background-color: rgb(219,112,147)"><a href="{{action('HouseLightController@colorchange_xy',['houselight'=>$light->id,'x'=>0.4658,'y'=>0.2773])}}">...</a></td>
                                                <td style="background-color: rgb(107,142,35)"><a href="{{action('HouseLightController@colorchange_xy',['houselight'=>$light->id,'x'=>0.354,'y'=>0.5561])}}">...</a></td>
                                            </tr>
                                        </tbody>
                                    </table>-->
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</div>
@endsection