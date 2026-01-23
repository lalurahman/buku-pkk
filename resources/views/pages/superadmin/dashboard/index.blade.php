@extends('layouts.superadmin')

@section('title', 'Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Welcome Banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div
                    class="card bg-primary text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"
                >
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="text-white mb-2">👋 Selamat Datang, {{ auth()->user()->name }}!</h2>
                                <p
                                    class="mb-0 text-white"
                                    style="opacity: 0.9;"
                                >
                                    Berikut adalah ringkasan statistik sistem Anda hari ini
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div
                                    class="text-white"
                                    style="opacity: 0.9;"
                                >
                                    <i
                                        class="bx bx-calendar"
                                        style="font-size: 16px;"
                                    ></i>
                                    {{ now()->isoFormat('dddd, D MMMM YYYY') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
