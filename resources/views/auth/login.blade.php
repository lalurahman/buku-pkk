<!doctype html>
<html
    lang="en"
    class=" layout-wide  customizer-hide"
    dir="ltr"
    data-skin="default"
    data-assets-path="admin/"
    data-template="vertical-menu-template"
    data-bs-theme="light"
>

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    {{-- meta description --}}
    <meta
        name="description"
        content="PKK Takalar"
    />
    <meta
        name="keywords"
        content="PKK Takalar, Admin Panel"
    />
    <meta
        name="author"
        content="PKK Takalar Team"
    />
    <meta
        name="robots"
        content="index, follow"
    />

    <title>Masuk Admin Panel</title>

    <!-- Favicon -->
    <link
        rel="icon"
        type="image/x-icon"
        href="{{ asset('admin/img/logo.png') }}"
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

    <!-- Core CSS -->
    <!-- build:css admin/vendor/css/theme.css  -->


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

    <!-- Vendor -->
    {{-- <link
        rel="stylesheet"
        href="{{ asset('admin/vendor/libs/%40form-validation/form-validation.css') }}"
    /> --}}

    <!-- Page CSS -->
    <!-- Page -->
    <link
        rel="stylesheet"
        href="{{ asset('admin/vendor/css/pages/page-auth.css') }}"
    />

    <!-- Helpers -->
    <script src="{{ asset('admin/vendor/js/helpers.js') }}"></script>
    {{-- <script src="{{ asset('admin/vendor/js/template-customizer.js') }}"></script> --}}


    <script src="{{ asset('admin/js/config.js') }}"></script>
    <style>
        body {
            min-height: 100vh;
            position: relative;
            background: linear-gradient(135deg, #1e3a8a 0%, #0891b2 50%, #dc2626 100%);
            overflow-x: hidden;
        }

        /* Animated gradient */
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        body {
            background-size: 200% 200%;
            animation: gradientShift 15s ease infinite;
        }

        /* Dark overlay */
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.25);
            z-index: 1;
            pointer-events: none;
        }

        /* Subtle Pattern */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            background-size: 60px 60px;
            opacity: 0.4;
            z-index: 1;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            25% {
                transform: translateY(-10px) rotate(1deg);
            }

            50% {
                transform: translateY(-20px) rotate(-1deg);
            }

            75% {
                transform: translateY(-5px) rotate(0.5deg);
            }
        }

        .authentication-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .authentication-inner {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            padding: 1rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.2),
                0 10px 30px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #1e3a8a, #0891b2, #dc2626, #1e3a8a);
            background-size: 300% 100%;
            animation: shimmer 4s ease-in-out infinite;
        }

        0% {
            background-position: 0% 0;
        }

        100% {
            background-position: 300% 0;
        }

        .card-body {
            position: relative;
            z-index: 2;
            padding: 2rem 2rem 1.75rem;
        }

        .app-brand {
            margin-bottom: 1.5rem !important;
        }

        .logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 24px;
            margin-bottom: 0;
            flex-wrap: wrap;
        }

        .logos img:first-child {
            height: 85px;
            width: auto;
            max-width: 85px;
            filter: drop-shadow(0 4px 12px rgba(30, 58, 138, 0.3));
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .logos img:last-child {
            height: 90px;
            width: auto;
            max-width: 90px;
            filter: drop-shadow(0 4px 12px rgba(220, 38, 38, 0.3));
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 1);
            border-color: #0891b2;
            box-shadow: 0 0 0 4px rgba(8, 145, 178, 0.12);
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            border: none;
            border-radius: 14px;
            padding: 13px 24px;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;

            box-shadow: 0 4px 14px rgba(8, 145, 178, 0.3) .form-control:focus {
                background: rgba(255, 255, 255, 1);
                border-color: #0286c6;
                box-shadow: 0 0 0 3px rgba(2, 134, 198, 0.1);
            }

            .btn-primary {
                background: linear-gradient(135deg, #0286c6 0%, #0286c6 100%);
                border: none;
                border-radius: 12px;
                padding: 12px 24px;
                font-weight: 600;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 14px;
            border: none;

            h4.mb-1 {
                font-weight: 700;
                color: #1e293b;
                font-size: 1.5rem;
                margin-bottom: 0.5rem !important;
            }

            p.mb-6 {
                color: #64748b;
                margin-bottom: 1.5rem !important;
                font-size: 0.95rem;
            }

            .form-label {
                font-weight: 600;
                color: #475569;
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }

            .mb-6 {
                margin-bottom: 1.25rem !important;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .card-body {
                    padding: 1.75rem 1.5rem 1.5rem;
                }

                .authentication-inner {
                    padding: 0.75rem;
                }

                .logos img:first-child {
                    height: 70px;
                    max-width: 70px;
                }

                .logos img:last-child {
                    height: 75px;
                    max-width: 75px;
                }

                h4.mb-1 {
                    font-size: 1.35rem transform: translateY(-2px);
                    box-shadow: 0 8px 20px rgba(220, 38, 38, 0.4);
                }

                .alert {
                    border-radius: 12px;
                    border: none;
                    background: rgba(2, 134, 198, 0.1);
                    backdrop-filter: blur(10px);
                    color: #0286c6;
                }

                /* Responsive adjustments */
                @media (max-width: 768px) {
                    .card-body {
                        padding: 1.5rem;
                    }

                    .logos img {
                        width: 140px;
                        max-width: 100%;
                    }

                    body::after {
                        background-size: 30px 30px, 25px 25px, 35px 35px;
                    }
                }

                /* Add subtle animation to form elements */
                .form-control,
                .btn {
                    animation: slideInUp 0.6s ease-out;
                }

                @keyframes slideInUp {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            }
    </style>

</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Login -->
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <div class="logos">
                                <img
                                    src="{{ asset('admin/img/logo.png') }}"
                                    alt="Logo PKK Takalar"
                                >
                                <img
                                    src="{{ asset('admin/img/logo-takalar.png') }}"
                                    alt="Logo PKK Takalar"
                                >
                            </div>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1">Selamat Datang 👋</h4>
                        <p class="mb-6">
                            Silahkan masuk untuk melanjutkan
                        </p>
                        @if ($errors->any())
                            <div
                                class="alert alert-danger alert-dismissible fade show"
                                role="alert"
                            >
                                {{ $errors->first() }}
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Close"
                                ></button>
                            </div>
                        @endif
                        <form
                            id="formAuthentication"
                            class="mb-6"
                            action="{{ route('login') }}"
                            method="POST"
                        >
                            @csrf
                            <div class="mb-6 form-control-validation">
                                <label
                                    for="email"
                                    class="form-label"
                                >Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    placeholder="Masukkan email anda"
                                    value="{{ old('email') }}"
                                    autofocus
                                />
                            </div>
                            <div class="mb-6 form-password-toggle form-control-validation">
                                <label
                                    class="form-label"
                                    for="password"
                                >Password</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="password"
                                        class="form-control"
                                        name="password"
                                        aria-describedby="password"
                                        placeholder="Masukkan password"
                                    />
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-6">
                                <button
                                    class="btn btn-primary d-grid w-100"
                                    type="submit"
                                >Masuk</button>
                            </div>
                        </form>
                        <span class="d-block text-center">
                            &copy; {{ date('Y') }} <br> PKK Kabupaten Takalar
                        </span>
                    </div>
                </div>
                <!-- /Login -->
            </div>
        </div>
    </div>

    <!-- / Content -->


    <!-- Core JS -->
    <!-- build:js admin/vendor/js/theme.js  -->


    <script src="{{ asset('admin/vendor/libs/jquery/jquery.js') }}"></script>

    <script src="{{ asset('admin/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin/vendor/js/bootstrap.js') }}"></script>
    {{-- <script src="{{ asset('admin/vendor/libs/%40algolia/autocomplete-js.js') }}"></script> --}}



    <script src="{{ asset('admin/vendor/libs/pickr/pickr.js') }}"></script>



    <script src="{{ asset('admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>


    <script src="{{ asset('admin/vendor/libs/hammer/hammer.js') }}"></script>

    <script src="{{ asset('admin/vendor/libs/i18n/i18n.js') }}"></script>


    <script src="{{ asset('admin/vendor/js/menu.js') }}"></script>

    <script src="{{ asset('admin/js/main.js') }}"></script>


    <!-- Page JS -->
    <script src="{{ asset('admin/js/pages-auth.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>

    <script>
        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
            });
        @endif
    </script>
</body>

</html>
