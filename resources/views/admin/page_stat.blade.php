<?php
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
?>

@extends('layouts.base')

@section('title', 'Page Stat')

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 class="page-header">Статистика для страницы: {{ $page_id }}</h1>
        Browsers:
        <table class="table table-hover">
            <thead>
            <th>Браузер</th>
            <th>Хиты</th>
            <th>уники по IP</th>
            <th>уники по кукам</th>
            </thead>
            @foreach ($browsers as $browser)
            <tr>
                <?php $browserArraydata = explode(":", $browser);?>
                <td>
                    {{ $browserArraydata[4] }}</td>
                <td>
                    {{ Redis::scard("stat:page:".$page_id.":browser:".$browserArraydata[4].":hit") }}
                </td>
                <td>
                    {{ Redis::scard("stat:page:".$page_id.":browser:".$browserArraydata[4].":ip") }}
                </td>
                <td>
                    {{ Redis::scard("stat:page:".$page_id.":browser:".$browserArraydata[4].":session") }}
                </td>
            </tr>
            @endforeach
        </table>

        OS:
        <table class="table table-hover">
            <thead>
            <th>Платформа</th>
            <th>Хиты</th>
            <th>уники по IP</th>
            <th>уники по кукам</th>
            </thead>
            @foreach ($platforms as $platform)
            <tr>
                <?php $platformArraydata = explode(":", $platform);?>
                <td>
                    {{$platformArraydata[4]}}</td>
                <td>
                    {{Redis::scard("stat:page:".$page_id.":os:".$platformArraydata[4].":hit")}}
                </td>
                <td>
                    {{Redis::scard("stat:page:".$page_id.":os:".$platformArraydata[4].":ip")}}
                </td>
                <td>
                    {{Redis::scard("stat:page:".$page_id.":os:".$platformArraydata[4].":session")}}
                </td>
            </tr>
            @endforeach
        </table>

        GEO:
        <table class="table table-hover">
            <thead>
            <th>Локация</th>
            <th>Хиты</th>
            <th>уники по IP</th>
            <th>уники по кукам</th>
            </thead>
            @foreach ($geodata as $geo)
            <tr>
                <?php $geoArraydata = explode(":", $geo);?>
                <td>
                    {{ $geoArraydata[4] }}</td>
                <td>
                    {{ Redis::scard("stat:page:".$page_id.":geo:".$geoArraydata[4].":hit") }}
                </td>
                <td>
                    {{ Redis::scard("stat:page:".$page_id.":geo:".$geoArraydata[4].":ip") }}
                </td>
                <td>
                    {{ Redis::scard("stat:page:".$page_id.":geo:".$geoArraydata[4].":session") }}
                </td>
            </tr>
            @endforeach
        </table>

        Referals:
        <table class="table table-hover">
            <thead>
            <th>Ref</th>
            <th>Хиты</th>
            <th>уники по IP</th>
            <th>уники по кукам</th>
            </thead>
            @foreach ($refs as $ref)
            <tr>
                <?php $refArrayData = explode(":", $ref);?>
                <td>
                    {{$refArrayData[4]}}
                </td>
                <td>
                    {{Redis::scard("stat:page:".$page_id.":ref:".$refArrayData[4].":hit") }}
                </td>
                <td>
                    {{ Redis::scard("stat:page:".$page_id.":ref:".$refArrayData[4].":ip") }}
                </td>
                <td>
                    {{ Redis::scard("stat:page:".$page_id.":ref:".$refArrayData[4].":session") }}
                </td>
            </tr>
            @endforeach
        </table>

    </div>
@endsection