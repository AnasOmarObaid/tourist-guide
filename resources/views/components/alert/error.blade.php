@if (session()->has('error'))
      <script>
           $(document).ready(function (){
                Swal.fire({
                    position: 'top-right',
                    icon: "error",
                    title: "{{ session('error') }}",
                    showConfirmButton: true,
                })
           })
      </script>
@endif
