<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="adminId" content="{{ auth()->check() ? auth()->id() : '' }}">

    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">



    <!-- Custom styles for this template-->
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <!-- style summernote -->
    <link href="{{ asset('backend/vendor/summernote/summernote-bs4.min.css') }}" rel="stylesheet">

    <!-- style bootstrap-fileinput -->
    <link href="{{ asset('backend/vendor/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">

    @yield('style')
    @livewireStyles
</head>

<body id="page-top">
