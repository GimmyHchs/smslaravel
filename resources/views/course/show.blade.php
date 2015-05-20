@extends('app')
@section('content')

  <script type="text/javascript">
    $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').focus()
  });
  </script>

<div class="row" >
<div class="col-md-10 col-md-offset-1" >
<div class="panel panel-default">
<div class="panel-heading">課程{{$course->name}} - 學生列表</div>

		  
				<div class="panel-body">

        <div class="page">
        <!-- Below Hiden when printmode  -->
              <div class="hidden-print">
              <a class="btn btn-primary" style="margin-bottom:4px" data-toggle="modal" data-target="#myModal">加入學生</a>
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

            <!--Jquery+Boostrap Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                          {!!Form::open(['url'=>'course/'.$course->id.'/patchstudent','method'=>'post'])!!}
                     <div class="checkbox">
                          {!!Form::label('發送對象')!!}
                          {!!Form::text('input_target','',['class'=>'form-control disable', 'placeholder'=>"Enter Cellphone number"])!!}
                          @foreach($allstudents as $mystudent)
                          <label>
                          {!!Form::checkbox('checkbox'.$mystudent->id,$mystudent->id,true,[])!!}
                          {{$mystudent->name}}
                          </label>
                          @endforeach
                     </div>
                    </div>
                    <div class="modal-footer">
                        {!!Form::button('Close',['class'=>"btn btn-default",'data-dismiss'=>"modal"])!!}
                        {!!Form::submit('Submit',['class'=>'btn btn-primary'])!!}
                    {!!Form::close()!!}
                   </div>
                </div>
              </div>
            </div>
            <!--Jquery+Boostrap Modal -->
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
                

          @endforeach
          </div>
          </div>
          
          </div>
          <!-- Above Show when printmode  -->
          </div>
    			</div>
    			</div>
  </div>
</div>

@stop