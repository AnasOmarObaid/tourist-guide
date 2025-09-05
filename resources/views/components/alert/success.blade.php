@if (session()->has('success'))
      <script>
           $(document).ready(function (){
                Swal.fire({
                    position: 'top-right',
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                })
           })
      </script>
@endif
