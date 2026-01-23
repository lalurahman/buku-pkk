<!-- Canonical SEO -->
<meta
    name="csrf-token"
    content="{{ csrf_token() }}"
>
<meta
    name="description"
    content="Smart School Dinas Pendidikan Provinsi Sulawesi Selatan"
/>

<meta
    name="keywords"
    content="Smart School, Dinas Pendidikan, E-Andalan, E Andalan, EAndalan"
/>
<meta
    property="og:title"
    content="Smart School Dinas Pendidikan Provinsi Sulawesi Selatan"
/>
<meta
    property="og:type"
    content="website"
/>
<meta
    property="og:image"
    content="{{ asset('admin/img/logo-sm.png') }}"
/>
<meta
    property="og:description"
    content="Smart School Dinas Pendidikan Provinsi Sulawesi Selatan"
/>
<link
    rel="icon"
    type="image/x-icon"
    href="{{ asset('assets/img/logo-icon.png') }}"
/>
<!-- Fonts -->
<link
    rel="preconnect"
    href="https://fonts.googleapis.com/"
/>
<link
    rel="preconnect"
    href="https://fonts.gstatic.com/"
    crossorigin
/>
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
    rel="stylesheet"
/>

<link
    rel="stylesheet"
    href="{{ asset('admin/vendor/fonts/iconify-icons.css') }}"
/>

<link
    rel="stylesheet"
    href="{{ asset('admin/vendor/libs/pickr/pickr-themes.css') }}"
/>

<link
    rel="stylesheet"
    href="{{ asset('admin/vendor/css/core.css') }}"
/>
<link
    rel="stylesheet"
    href="{{ asset('admin/css/demo.css') }}"
/>


<!-- Vendors CSS -->

<link
    rel="stylesheet"
    href="{{ asset('admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"
/>

<!-- endbuild -->

<link
    rel="stylesheet"
    href="{{ asset('admin/vendor/fonts/flag-icons.css') }}"
/>
<link
    rel="stylesheet"
    href="{{ asset('admin/vendor/libs/apex-charts/apex-charts.css') }}"
/>

<!-- Page CSS -->
{{-- <script src="{{ asset('admin/vendor/js/template-customizer.js') }}"></script> --}}

<!-- Select2 CSS -->
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css"
/>
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
/>

<style>
    #template-customizer .template-customizer-open-btn {
        display: none !important;
    }

    /* Custom Select2 styling */
    .select2-container--bootstrap-5 .select2-selection {
        min-height: 38px;
    }

    .select2-container--bootstrap-5 .select2-selection--single {
        height: auto;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        line-height: 1.5;
        padding-left: 12px;
        padding-right: 12px;
        padding-top: 2px;
        padding-bottom: 2px;
    }
</style>
<!-- Helpers -->
<script src="{{ asset('admin/vendor/js/helpers.js') }}"></script>
<script src="{{ asset('admin/js/config.js') }}"></script>
