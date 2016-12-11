@extends('layouts.base')

@section('title', 'Детальная статистика')

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 class="page-header">Детальная статистика</h1>

        <form method="post" action="" class="form-inline">
            <div class="form-group">
                <label for="exampleInputName2">Браузер:</label>
                <select name="browser" class="form-control">
                    @foreach($uniq_browsers as $uniq_browser)
                        <option value="{{$uniq_browser}}">{{$uniq_browser}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputName2">ОС:</label>
                <select name="os" class="form-control">
                    @foreach($uniq_os as $os)
                        <option value="{{$os}}">{{$os}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputName2">Ref:</label>
                <select name="ref" class="form-control">
                    @foreach($uniq_ref as $ref)
                        <option value="{{$ref}}">{{$ref}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputName2">Страница:</label>
                <select name="page" class="form-control">
                    <option value="summary">Общая</option>
                    @foreach($pages as $page_id => $page_param)
                        @if($page_id != 'login')
                            <option value="{{$page_param['title']}}">{{$page_param['title']}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <button type="submit" class="btn btn-default">Показать</button>
        </form>
    </div>
@endsection