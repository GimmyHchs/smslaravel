@extends('app')
@section('content')

<div class="row" >
<div class="col-md-6 col-md-offset-3" >
<div class="panel panel-default">
<div class="panel-heading">新增學生</div>

		  
				<div class="panel-body">

        <div class="page">
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
            {!!Form::open(['url'=>'/student','method'=>'POST'])!!}
            <div class="form-group">
                {!!Form::label('姓名')!!}
                {!!Form::text('input_name','',['class' => 'form-control','placeholder'=>'Enter name'])!!}
            </div>
            <div class="form-group">
                {!!Form::label('姓別')!!}
                {!!Form::select('input_sex',['男'=>'男','女'=>'女'],0,['class' => 'form-control'])!!}
            </div>
            <div class="form-group">
                {!!Form::label('年齡')!!}
                {!!Form::selectRange('input_age',7,25,17,['class' => 'form-control'])!!}
            </div>
            <div class="form-group">
                {!!Form::label('電話')!!}
                {!!Form::text('input_tel','',['class' => 'form-control','placeholder' => 'Enter Tel'])!!}
            </div>
            <div class="form-group">
                {!!Form::label('家長電話')!!}
                {!!Form::text('input_tel_parents','',['class' => 'form-control','placeholder' => 'Enter Parents Tel'])!!}
            </div>
            <div class="form-group">
                {!!Form::label('關於學生')!!}
                {!!Form::textarea('input_about','',['class' => 'form-control'])!!}
            </div>
            <div class="form-group">
                {!!Form::submit('新增學生',['class' => 'btn btn-info'])!!}
            </div>
            {!!Form::close()!!}

          </div>
    			</div>
    			</div>
  </div>
</div>

@stop