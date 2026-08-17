@if(session('success'))

<script>

Swal.fire({

    icon: 'success',

    title: 'Success',

    text: "{{ session('success') }}",

    confirmButtonColor: '#0d6efd',

    timer: 2500,

    showConfirmButton: false

});

</script>

@endif


@if(session('error'))

<script>

Swal.fire({

    icon: 'error',

    title: 'Error',

    text: "{{ session('error') }}",

    confirmButtonColor: '#dc3545'

});

</script>

@endif


@if(session('warning'))

<script>

Swal.fire({

    icon: 'warning',

    title: 'Warning',

    text: "{{ session('warning') }}",

    confirmButtonColor: '#f39c12'

});

</script>

@endif


@if(session('info'))

<script>

Swal.fire({

    icon: 'info',

    title: 'Information',

    text: "{{ session('info') }}",

    confirmButtonColor: '#0dcaf0'

});

</script>

@endif