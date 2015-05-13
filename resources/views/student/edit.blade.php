@extends('app')
@section('content')

<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">
				<div class="panel-heading">{{$student->name.'  Edit page'}}</div>
    	    	<div class="panel-body">
    	    	 @if (count($errors) > 0)
                <div class="alert alert-danger">
                  <strong>Whoops!</strong> There were some problems with your input.<br><br>
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              	@endif
    	    	 {!!Form::open(['url'=>'student/'.$student->id,'method'=>'patch'])!!}
		    	    	 <div class="form-group">
		    	    	 {!!Form::label('姓名')!!}
		    	    	 {!!Form::text('input_name',$student->name,['class'=>'form-control'])!!}
		    	    	 </div>
		    	    	 <div class="form-group">
		    	    	 {!!Form::label('手機')!!}
						 {!!Form::text('input_tel',$student->tel,['class'=>'form-control'])!!}
						 </div>
						 <div class="form-group">
		    	    	 {!!Form::label('家長手機')!!}
						 {!!Form::text('input_tel_parents',$student->tel_parents,['class'=>'form-control'])!!}
						 </div>
						 <div class="form-group">
						 {!!Form::label('關於我')!!}
						 {!!Form::textarea('input_about',$student->about,['class'=>'form-control'])!!}
						 </div>
						 {!!Form::submit('submit',['class'=>'btn btn-primary'])!!}
    	    	 {!!Form::close()!!}
        	    </div>
</div>
</div>
</div>

@stop

