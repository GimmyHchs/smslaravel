@extends('app')
@section('content')

<script type="text/javascript">
  $(function () {
  $('[data-toggle="popover"]').popover({
    html : true
  });
});
</script>
<link href="print.css" rel="stylesheet" type="text/css" media="print" />
<div class="col-md-12 col-md-offset-0" >
<div class="panel panel-default">
<div class="panel-heading">所有學生列表</div>

		    
				<div class="panel-body">

        <div class="page">

              <div style="margin-bottom:10px" class="hidden-print">
              <div class="container">
              <div class="row">
                <div class="col-xs-1">
                <a class="btn btn-info" href="{{ url('/student/create') }}">新增學生</a>
                </div> 
                 <div class="col-xs-2">
                   {!!Form::open(['url'=>'/student/downloadexcel','method'=>'GET'])!!}
                   {!!Form::submit('下載Excel名單',['class' => 'btn btn-primary'])!!}
                   {!!Form::close()!!}
                </div>
                <div class="col-xs-1">
                   {!!Form::open(['url'=>'/student/uploadexcel','method'=>'Post','files'=>true])!!}
                   {!!Form::file('excelfile',[])!!}
                   {!!Form::submit('上傳檔案',['class' => ''])!!}
                   {!!Form::close()!!}
                </div>
              </div>
              </div>
              </div>
              <!-- Below Hiden when printmode  -->
              <div class="hidden-print">
    				  <table class="table table-hover">
              <tr>
                <th>學生姓名</th>
                <th>條碼</th> 
                <th>性別</th> 
                <th>電話</th>
                <th>家長電話</th>
                <th></th>
              </tr>

              @foreach($students as $student) 
              <?php
              DNS1D::setStorPath('png/');
              DNS1D::getBarcodePNGPath("$student->barcode", "C93",1,33);
              $mycourses=$coursestudents->where('student_id',$student->id);
              $str_course="";
              ?>
                        @foreach($mycourses as $mycourse)
                        <?php 
                          //串接課程名稱與換行
                          $str_course=$str_course.$mycourse->name."\n\r";
                        ?>
                        @endforeach
              
              <tr class="active">
                <td><a href="{{ url('/student/'.$student->id) }}">{{$student->name}}</a></td>
                <td>{!!Html::image('/png/'.$student->barcode.'.png')!!}</td>
                <td>{{$student->sex}}</td>
                <td>{{$student->tel}}</td>
                <td>{{$student->tel_parents}}</td>
                <td><div class="row">
                       <div class="col-md-2">
                       <a tabindex="0" role="button" class="btn btn-warning"
                       data-trigger="focus" 
                       data-container="body" data-toggle="popover" data-placement="right"
                       title="已加入的課程"
                       data-content="{!!nl2br($str_course)!!}
                      ">課程
                    </a></div>
                    <div class="col-md-2">
                      {!!Form::open(['method'=>'GET','url'=>'/student/'.$student->id.'/edit'])!!}
                      {!!Form::submit('修改',['class'=>'btn btn-info'])!!}
                      {!!Form::close()!!}
                    </div>
                    <div class="col-md-1">
                    {!!Form::open(['url'=>'student/'.$student->id,'method'=>'Delete'])!!}
                        {!!Form::submit('刪除',['class'=>'btn btn-danger'])!!}
                     {!!Form::close()!!}
                     </div>
                     </div>
                    </td>
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
        
          @endforeach
          </div>
          </div>
          </div>
          <!-- Above Show when printmode  -->

          </div>
    			</div>
    			</div>
  </div>

         @if (!empty($message))
            <script>webix.message("{{$message}}"); </script>
         @endif

@stop