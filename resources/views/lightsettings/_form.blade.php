<div class="form-group"> 
    {!! Form::label('name','Name:')!!}
    {!! Form::text('name',null,['class'=>'form-control'])!!}
</div>
<div class="form-group"> 
    {!! Form::label('brightness','Brightness:')!!}
    {!! Form::text('brightness',null,['class'=>'form-control'])!!}
</div> 
<div class="form-group"> 
    {!! Form::label('hue','Hue:')!!}
    {!! Form::text('hue',null,['class'=>'form-control'])!!}
</div> 
<div class="form-group"> 
    {!! Form::label('saturation','Saturation:')!!}
    {!! Form::text('saturation',null,['class'=>'form-control'])!!}
</div>
<div class="form-group"> 
    {!! Form::label('x','X:')!!}
    {!! Form::text('x',null,['class'=>'form-control'])!!}
</div> 
<div class="form-group"> 
    {!! Form::label('y','Y:')!!}
    {!! Form::text('y',null,['class'=>'form-control'])!!}
</div>  
<div class="form-group"> 
    {!! Form::label('colormode','ColourMode:')!!}
    {!! Form::select('colormode',['xy'=>'xy','ct'=>'ct'],$lightsetting->colormode,['class'=>'form-control'])!!}
</div>
<div class="form-group">
    {!! Form::submit($submitButtonText,['class'=>'btn btn-primary form-control'])!!}
</div>
