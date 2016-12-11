<?php
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Helpers\StatisticHelper;
?>

@extends('layouts.base')

@section('title', 'Page Stat')

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 class="page-header">Общая статистика по всем страницам</h1>
        Browsers:
        <table class="table table-hover">
            <thead>
            <th>Браузер</th>
            <th>Хиты</th>
            <th>уники по IP</th>
            <th>уники по кукам</th>
            <th>уники по IP за 24ч/7д/31д</th>
            <th>уники по кукам за 24ч/7д/31д</th>
            </thead>
            @foreach ($browsers as $browser)
                <tr>
                    <?php
                        $browserArraydata = explode(":", $browser);
                        $datetimeCollectionUniqIp = Redis::smembers("stat:page:".$page_id.":browser:".$browserArraydata[4].":datetime_ip");
                        $datetimeCollectionUniqCookies = Redis::smembers("stat:page:".$page_id.":browser:".$browserArraydata[4].":datetime_session");
                    ?>
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
                    <td>
                        {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqIp, '24h') }} /
                        {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqIp, '7d') }} /
                        {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqIp, '31d') }}
                    </td>
                    <td>
                        {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqCookies, '24h') }} /
                        {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqCookies, '7d') }} /
                        {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqCookies, '31d') }}
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
            <th>уники по IP за 24ч/7д/31д</th>
            <th>уники по кукам за 24ч/7д/31д</th>
            </thead>
            @foreach ($platforms as $platform)
            <tr>
                <?php
                    $platformArraydata = explode(":", $platform);
                    $datetimeCollectionUniqIp = Redis::smembers("stat:page:".$page_id.":os:".$platformArraydata[4].":datetime_ip");
                    $datetimeCollectionUniqCookies = Redis::smembers("stat:page:".$page_id.":os:".$platformArraydata[4].":datetime_session");
                ?>
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
                <td>
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqIp, '24h') }} /
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqIp, '7d') }} /
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqIp, '31d') }}
                </td>
                <td>
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqCookies, '24h') }} /
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqCookies, '7d') }} /
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqCookies, '31d') }}
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
            <th>уники по IP за 24ч/7д/31д</th>
            <th>уники по кукам за 24ч/7д/31д</th>
            </thead>
            @foreach ($geodata as $geo)
            <tr>
                <?php
                    $geoArraydata = explode(":", $geo);
                    $datetimeCollectionUniqIp = Redis::smembers("stat:page:".$page_id.":geo:".$geoArraydata[4].":datetime_ip");
                    $datetimeCollectionUniqCookies = Redis::smembers("stat:page:".$page_id.":geo:".$geoArraydata[4].":datetime_session");
                ?>
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
                <td>
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqIp, '24h') }} /
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqIp, '7d') }} /
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqIp, '31d') }}
                </td>
                <td>
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqCookies, '24h') }} /
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqCookies, '7d') }} /
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqCookies, '31d') }}
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
            <th>уники по IP за 24ч/7д/31д</th>
            <th>уники по кукам за 24ч/7д/31д</th>
            </thead>
            @foreach ($refs as $ref)
            <tr>
                <?php
                    $refArrayData = explode(":", $ref);
                    $datetimeCollectionUniqIp = Redis::smembers("stat:page:".$page_id.":ref:".$refArrayData[4].":datetime_ip");
                    $datetimeCollectionUniqCookies = Redis::smembers("stat:page:".$page_id.":ref:".$refArrayData[4].":datetime_session");
                ?>
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
                <td>
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqIp, '24h') }} /
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqIp, '7d') }} /
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqIp, '31d') }}
                </td>
                <td>
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqCookies, '24h') }} /
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqCookies, '7d') }} /
                    {{ StatisticHelper::getDatetimeCount($datetimeCollectionUniqCookies, '31d') }}
                </td>
            </tr>
            @endforeach
        </table>

    </div>
@endsection