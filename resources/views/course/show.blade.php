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
                <th>條碼</th> 
                <th>性別</th> 
                <th>電話</th>
                <th>家長電話</th>
              </tr>
              @foreach($students as $student)   
              <?php
              DNS1D::setStorPath('png/');
              DNS1D::getBarcodePNGPath("$student->barcode", "C93",1,33);
              ?>         
              <tr class="active">
                <td><a href="{{ url('/student/'.$student->id) }}">{{$student->name}}</a></td>
                <td>{!!Html::image('/png/'.$student->barcode.'.png')!!}</td>
                <td>{{$student->sex}}</td>
                <td>{{$student->tel}}</td>
                <td>{{$student->tel_parents}}</td>
              </tr>
                
              </tr>
              @endforeach
            
          </table>
          </div>
    			</div>
    			</div>
  </div>
</div>

@stop