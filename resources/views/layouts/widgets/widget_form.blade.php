@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb d-flex">
            <div class="pull-left">
                <a class="btn btn-sm btn-success" href="{{ route('main.index', ['method' => 'createUser']) }}"> {{ 'Заполнить форму' }}</a>
            </div>

            <div class="pull-right">
                <a class="btn btn-sm btn-success" href="{{ route('main.index', ['method' => 'getData']) }}"> {{ 'Посмотреть данные' }}</a>
            </div>
        </div>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($method == 'createUser')
    {!! Form::open(array('route' => ['main.create.user'],'method'=>'POST')) !!}
    <div>
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('first_name', 'Имя') !!}
                {!! Form::text('first_name', null, ['placeholder' => 'Имя','class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('second_name', 'Фамилия') !!}
                {!! Form::text('second_name', null, ['placeholder' => 'Фамилия','class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::text('email', null, ['placeholder' => 'Email','class' => 'form-control', 'required']) !!}
            </div>
        </div>
        {!! Form::hidden('page_uid', $page_uid) !!}
        <div class="col-12 text-left">
            {!! Form::button('Подвтердить', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
    @endif
    @if($method == 'getData')
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">

        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready( function () {
                $('#table_data').DataTable({
                    serverSide: true,
                    "ajax": {
                        "type": "GET",
                        "url": "{{ route('main.show.data') }}",
                        "dataSrc": "data"
                    },
                });

            } );
        </script>
        <table id="table_data" class="display">
            <thead>
            <tr>
                <th>First name</th>
                <th>Second name</th>
                <th>email</th>
                <th>page_uid</th>
                <th>created_at</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Row 1 Data 1</td>
                <td>Row 1 Data 1</td>
                <td>Row 1 Data 1</td>
                <td>Row 1 Data 1</td>
                <td>Row 1 Data 2</td>
            </tr>
            <tr>
                <td>Row 2 Data 1</td>
                <td>Row 2 Data 1</td>
                <td>Row 2 Data 1</td>
                <td>Row 2 Data 1</td>
                <td>Row 2 Data 2</td>
            </tr>
            </tbody>
        </table>
    @endif
@endsection
