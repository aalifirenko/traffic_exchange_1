@extends('layouts.base')

@section('title', 'Dashboard')

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h2 class="sub-header">Статистика</h2>
        <div class="table-responsive">
            <a class="btn btn-danger btn-large" href="/summary" target="_blank" role="button">
                Общая статистика
                <span class="glyphicon glyphicon-stats"></span>
            </a>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Страница</th>
                    <th>Статистика</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($pages as $page)
                    @if ($page['page_id'] != 'login')
                        <tr>
                            <td>страница: {{ $page['page_id'] }}</td>
                            <td>
                                <a href="/stats/{{$page['page_id'] }}">
                                    <span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
