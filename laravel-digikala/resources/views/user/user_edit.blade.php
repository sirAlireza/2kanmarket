@extends('layouts/lay')
@section('style')
<style>

    form * {
        margin: 10px;
    }
</style>

    @endsection
@section('content')
    <div class="info" style="font-size: 22px;border: black solid; direction: rtl; text-align: right; margin: auto;background-color: white;color: black;padding: 30px;margin-top: 10px">
        <input style="text-align: left;direction: unset;float: left;padding: 20px;margin: 20px;" type="button" class="btn btn-primary button" value="بازگشت" onclick="location.href = '/user';" >
    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <br><br>
    <form action="/user_edit_info" method="post" >
        {{ csrf_field() }}
        <span>نام: </span><br>
        <input type="text" name="name" placeholder=" نام" value="{{$name or null}}"><br>
        <span>نام خانوادگی: </span><br>
        <input type="text" name="lastname" placeholder=" نام خانوادگی" value="{{$lastname or null}}"><br>
        <span>تاریخ تولد: </span><br>
        <input type="date" name="birthday"><br>
        <span>شماره موبایل: </span><br>
        <input type="number" name="phone" placeholder="شماره موبایل" value="{{$phone or null}}"><br>
        <span>کد ملی: </span><br>
        <input type="number" name="person_id" placeholder="کد ملی" value="{{$person_id or null}}"><br>
        <span>کد معرف: </span><br>
        <input type="number" name="moaref_id" placeholder="کد معرف" value="{{$moaref_id or null}}"><br>
        <input type="submit" class="btn btn-primary " value="ویرایش" >
    </form>
            <h2>تعویض رمز عبور</h2>
    <form action="/user_edit_pass" method="post" >
    {{ csrf_field() }}
        <span>رمز عبور: </span><br>
        <input type="password" name="password" placeholder="رمز عبور "/><br>
        <span>تکرار رمز عبور: </span><br>
        <input type="password" name="password_confirmation" placeholder="تکرار رمز عبور "/><br>
        <input type="submit" class="btn btn-primary " value="تعویض" >
    </form>
    </div>

@endsection

