@extends('app')
@section('content')

<div class="row" >
<div class="col-md-10 col-md-offset-1" >
<div class="panel panel-default">
<div class="panel-heading">課程{{$course->name}} - 學生列表</div>

		  
				<div class="panel-body">

        <div class="page">
        <!-- Below Hiden when printmode  -->
              <div class="hidden-print">
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
                <td>{{$student->name}}</td>
                <td>{!!Html::image('/png/'.$student->barcode.'.png')!!}</td>
                <td>{{$student->sex}}</td>
                <td>{{$student->tel}}</td>
                <td>{{$student->tel_parents}}</td>
              </tr>
                
              </tr>
              @endforeach
            
          </table>
          </div>
         <!-- Above Hiden when printmode  -->


          <!-- Blow Show when printmode  -->
          <div class="visible-print-inline">
          @foreach($students as $index=>$student)
          @if($index%4==0)
          <div class="container">
          <div class="row">
          @endif
       
            <div class="col-xs-3" style=" border-width:1px;border-style:dotted;">
              <div align="center">{{$student->name}}</div>
              <div align="center" style="margin-bottom:1px">{!!Html::image('/png/'.$student->barcode.'.png')!!}</div>
            </div>

          @if($index%4==0&&$index/4>=1)
          </div>
          </div>
          @endif
        

          @endforeach
          </div>
          <!-- Above Show when printmode  -->
          </div>
    			</div>
    			</div>
  </div>
</div>

@stop