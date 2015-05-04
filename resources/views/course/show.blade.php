@extends('app')
@section('content')

<div class="row" >
<div class="col-md-10 col-md-offset-1" >
<div class="panel panel-default">
<div class="panel-heading">課程{{$course->name}} - 學生列表</div>

		  
				<div class="panel-body">

        <div class="page">
    				  <table class="table table-hover">
              <tr>
                <th>學生姓名</th>
                <th>性別</th> 
                <th>電話</th>
                <th>家長電話</th>
              </tr>
              @foreach($students as $student)            
              <tr class="active">
              <div class="row">
                <div class="col-md-3"><td>{{$student->name}}</td></div>
                <div class="col-md-1"><td>{{$student->sex}}</td></div>
                <div class="col-md-4"><td>{{$student->tel}}</td></div>
                <div class="col-md-4"><td>{{$student->tel_parents}}</td></div>
              </div> 
                
              </tr>
              @endforeach
            
          </table>
          </div>
    			</div>
    			</div>
  </div>
</div>

@stop