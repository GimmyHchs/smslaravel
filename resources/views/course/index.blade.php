@extends('app')
@section('content')

<div class="row" >
  <div class="col-md-12 col-md-offset-0" >
  <div class="panel panel-default">
<div class="panel-heading">課程列表</div>


	<table class="table table-bordered">
		  
				<div class="panel-body">

            {!!Form::open(['url'=>'/course/create','method'=>'GET'])!!}
            {!!Form::submit('新增課程',['class' => 'btn btn-info'])!!}
            {!!Form::close()!!}


    				@foreach($courses as $course)

                       <hr>
                       <div class="page">
                          {!!Form::open(['url'=>'/course/'.$course->id,'method'=>'GET'])!!}
                          <div class="content">
                            <h2>{{$course->name}}</h2>

                         	  <div class="form-group">
                         	  	<h3>課程介紹</h3>
                         	  	<p class="text-muted">
                         	  		{{$course->introduction}}		
                         	  	</p>
                         	  </div>
                         	 <div class="row">
								  <div class="col-md-8">
									               <h3>上課日</h3>
                         	  	   <p class="text-muted">
                         	  		 每周{{$course->weekday}}
                                 </p>
								  </div>
								  <div class="col-md-2">
								  	               <h3>開課時間</h3>
                         	  	     <p class="text-muted">
                         	  		  {{$course->date_start}} ~ {{$course->date_end}}
								  </div>
								  <div class="col-md-2">
								  	               <h3>上課時間</h3>
                         	  	     <p class="text-muted">
                         	  		  {{$course->time_start}} ~ {{$course->time_end}}

								  </div>
							    </div>
                  <div class="form-group">  	  			

                          {!!Form::submit('學生詳細資訊',['class'=>'btn btn-primary'])!!}
                          
                   </div>
                          {!!Form::close()!!}
                          {!!Form::open(['url'=>'/course/'.$course->id,'method'=>'DELETE'])!!}
                          <div style="margin-left:15px">
                          <div class="row">
                          <a class="btn btn-info" href="{{url('/course/'.$course->id.'/edit')}}">編輯</a>
                          {!!Form::submit('刪除',['class'=>'btn btn-danger'])!!}
                          </div>
                          </div>
                          {!!Form::close()!!}

                  
                  </div>

                       
            
                       
    				@endforeach
    			</div>
    			</div>
  </div>
</div>


         @if (!empty($message))
            <script>webix.message("{{$message}}"); </script>
         @endif

@stop