@extends('layouts/lay')
@section('style')
    <style>

        .info * {
            line-height: 40px;
        }
        .button {
            margin-left: 50%;
            margin-right: 50%;

        }
    </style>

@endsection

@section('content')

    <div class="info" style="font-size: 22px;border: black solid; direction: rtl; text-align: right; margin: auto;background-color: white;color: black;padding: 30px;margin-top: 10px">
            <span>نام کاربری: </span>&nbsp;
            {{ Auth::user()->username }}<br>
            <span>نام: </span>&nbsp;
            {{ $name }}<br>
            <span>نام خانوادگی: </span>&nbsp;
            {{ $lastname }}<br>
            <span>تاریخ تولد: </span>&nbsp;
            {{ $birthday }}<br>
            <span>شماره موبایل: </span>&nbsp;
            {{ $phone }}<br>
            <span>کد ملی: </span>&nbsp;
            {{ $person_id }}<br>
            <span>کد معرف: </span>&nbsp;
            {{ $moaref_id }}<br>
            <input type="button" class="btn btn-primary button" value="ویرایش" onclick="location.href = '/user_edit';" >
            </div>

@endsection