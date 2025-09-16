<?php
use Illuminate\Support\Number;

$name = '';
$id = $fullname = $email = $username = $URLAvatar = $avatar = $status = $level = $password = '';
$statusValue = [
    'default' => 'Select Status',
    'active' => 'Active',
    'inactive' => 'Inactive',
];

$levelValue = [
    'default' => 'Select Level',
    'admin' => 'Admin',
    'member' => 'Member',
];

if ($item != null) {
    $id = $item['id'];
    $fullname = $item['fullname'];
    $email = $item['email'];
    $password = $item['password'];
    $username = $item['username'];
    $status = $item['status'];
    $level = $item['level'];

    if ($item['avatar'] != null) {
        $URLAvatar = asset('public/images/user/' . $fullname . '/' . $item['avatar']);
    }
}
?>
@extends('admin.main')
@section('content')
    <div class="content">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p class="text-white">{{ $error }}</p>
                @endforeach
                <button type="button" aria-hidden="true" class="close" data-dismiss="alert"
                    aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
        @endif
        <div class="row">
            @if ($id != null)
                @include('admin.pages.user.form_info')
                @include('admin.pages.user.form_change_password')
            @else
                @include('admin.pages.user.form_add')
            @endif
        </div>
    </div>
@endsection
