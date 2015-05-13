@extends('app')
@section('content')

	 <div class="row">
     <div class="col-md-10 col-md-offset-1">
     <div class="panel panel-default">
    	    	<div class="panel-heading">{{$student->name}}</div>
    	    	<div class="panel-body">

    	    		<div class="page">
 								<div class="content">
 								{!!Form::open(['method'=>'GET','url'=>'/student/'.$student->id.'/edit'])!!}
	    	    						<div class="form-gruop">
	    	    						    <h2>關於我</h2>
	                         	  			<p class="text-muted">{!!nl2br($student->about)!!}</p>
	                         	  			<hr>
	                       				</div>
	                       				<div class="form-group">
	    	    							<h2>年齡</h2>
	                         	  			<p class="text-muted">{!!nl2br($student->age)!!}</p>
	                         	  			<hr>
	    	    						</div>
	    	    						<div class="form-group">
	    	    							<h2>手機</h2>
	                         	  			<p class="text-muted">{!!nl2br($student->tel)!!}</p>
	                         	  			<hr>
	    	    						</div>
	    	    						<div class="form-group">
	    	    							<h2>家長手機</h2>
	                         	  			<p class="text-muted">{!!nl2br($student->tel_parents)!!}</p>
	                         	  			<hr>
	    	    						</div>
	                       				<div class="form-group">
	    	    							{!!Form::submit('修改學生資料',['class'=>'btn btn-primary'])!!}
	    	    						</div>
	    	    				{!!Form::close()!!}
    	    					</div>
    	    		</div>

    	    	</div>
     </div>
     </div>
     </div>

         @if (!empty($message))
            <script>webix.message("You Modified {{$message}}\'s profile"); </script>
         @endif

@stop