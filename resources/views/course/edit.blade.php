@extends('app')
@section('content')

<div class="row" >
<div class="col-md-10 col-md-offset-1" >
<div class="panel panel-default">
<div class="panel-heading">{{$course->name}} Edit Page</div>

		  <div class="panel-body">
          <div class="page">


                  {!!Form::open(['url'=>'/course/'.$course->id,'method'=>'patch'])!!}
                  <div class="form-group">
                      {!!Form::label('課程名稱')!!}
                      {!!Form::text('input_name',$course->name,['class'=>'form-control'])!!}
                  </div>
                  <div class="form-group">
                      {!!Form::label('上課周期')!!}
                      {!!Form::select('input_weekday',['一'=>'一','二'=>'二','三'=>'三','四'=>'四','五'=>'五','六'=>'六','日'=>'日'],$course->weekday
                      ,['class'=>'form-control'])!!}
                  </div>
                  <div class="form-group">
                  <div class="row">
                            <div class="col-md-6">
                                {!!Form::label('開課日期')!!}
                                {!!Form::select('input_date_start',['2015-07-01'=>'2015-07-01','2015-08-01' =>'2015-08-01','2015-09-01' => '2015-09-01'],0
                                ,['class'=>'form-control'])!!}
                            </div>
                            <div class="col-md-6">
                                {!!Form::label('結束日期')!!}
                                {!!Form::select('input_date_end',['2015-10-01'=>'2015-10-01','2015-11-01'=>'2015-11-01','2015-12-01'=>'2015-12-01'],0
                                ,['class'=>'form-control'])!!}
                            </div>
                  </div>
                  </div>
                  <div class="form-group">
                  <div class="row">
                            <div class="col-md-6">
                                {!!Form::label('上課時間')!!}
                                {!!Form::select('input_time_start',['12:30:00'=>'12:30:00','13:30:00'=>'13:30:00','14:30:00'=>'14:30:00'],0
                                ,['class'=>'form-control'])!!}
                            </div>
                            <div class="col-md-6">
                                {!!Form::label('下課時間')!!}
                                {!!Form::select('input_time_end',['15:30:00'=>'15:30:00','16:30:00'=>'16:30:00','17:30:00'=>'17:30:00'],0
                                  ,['class'=>'form-control'])!!}
                            </div>
                  </div>
                  </div>
                  <div class="form-group">
                     {!!Form::label('課程介紹')!!}
                     {!!Form::textarea('input_introduction',$course->introduction,['class'=>'form-control'])!!}
                 
                  </div>

                  <div class="form-group">
                  {!!Form::submit('Submit',['class'=>'btn btn-info'])!!}
                  </div>
                  {!!Form::close()!!}




          </div>
    	  </div>





</div>
</div>
</div>

@stop