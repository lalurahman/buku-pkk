<script src="{{ asset('admin/vendor/libs/jquery/jquery.js') }}"></script>

<script src="{{ asset('admin/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('admin/vendor/js/bootstrap.js') }}"></script>
{{-- <script src="{{ asset('admin/vendor/libs/%40algolia/autocomplete-js.js') }}"></script> --}}



<script src="{{ asset('admin/vendor/libs/pickr/pickr.js') }}"></script>


<script src="{{ asset('admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>


<script src="{{ asset('admin/vendor/libs/hammer/hammer.js') }}"></script>

{{-- <script src="{{ asset('admin/vendor/libs/i18n/i18n.js') }}"></script> --}}


<script src="{{ asset('admin/vendor/js/menu.js') }}"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('admin/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->

<script src="{{ asset('admin/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('admin/js/dashboards-analytics.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const semiDarkToggle = document.querySelector('[data-semi-dark-toggle]');

        // Load current state from localStorage
        const isSemiDark = localStorage.getItem('templateCustomizer-' + document.documentElement.getAttribute(
            'data-template') + '--SemiDark') === 'true';
        if (semiDarkToggle) {
            semiDarkToggle.checked = isSemiDark;
        }

        semiDarkToggle?.addEventListener('change', function(e) {
            const isChecked = e.target.checked;
            if (isChecked) {
                document.documentElement.setAttribute('data-semidark-menu', 'true');
                document.getElementById('layout-menu')?.setAttribute('data-bs-theme', 'dark');
            } else {
                document.documentElement.removeAttribute('data-semidark-menu');
                document.getElementById('layout-menu')?.removeAttribute('data-bs-theme');
            }

            // Save state to localStorage
            const layoutName = document.documentElement.getAttribute('data-template');
            localStorage.setItem(`templateCustomizer-${layoutName}--SemiDark`, isChecked);
        });
    });
</script>
<script>
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });
    @if (session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
        });
    @endif

    @if (session('error'))
        Swal.fire({
            title: 'Gagal!',
            text: '{{ session('error') }}',
            icon: 'error',
        });
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            Swal.fire({
                title: 'Gagal!',
                text: '{{ $error }}',
                icon: 'error',
            });
        @endforeach
    @endif
    $(document).on('click', '#btn-logout', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        Swal.fire({
            title: 'Apakah anda yakin ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal!',
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                form.submit();
            }
        });
    });
</script>

<script>
    if ("connection" in navigator) {
        const connection = navigator.connection;
        if (connection.effectiveType === '2g' || connection.effectiveType === 'slow-2g' || connection.saveData) {
            console.log('Koneksi internet lambat!');
        } else {
            console.log('Koneksi cepat!');
        }
        console.log('Connection type:', connection.effectiveType);
        console.log('Downlink speed:', connection.downlink, 'Mb/s');
        console.log('RTT:', connection.rtt, 'ms');
        console.log('Save Data (Mode Hemat):', connection.saveData);

    } else {
        console.log('The Network Information API is not supported in this browser.');
    }
</script>
