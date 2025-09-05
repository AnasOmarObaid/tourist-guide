<script>
      $(document).ready(function() {
            $(document).on('click', '.btn-delete', function(event) {
                  event.preventDefault();

                  // dialog open
                  Swal.fire({
                        title: "Are you sure to continue?",
                        icon: 'question',
                        iconHtml: '?',
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        showCancelButton: true,
                        showCloseButton: true
                  }).then((result) => {
                        if (result.isConfirmed) {

                              // url
                              const url = $(this).closest('form').attr('action');

                              // send some value to method
                              const csrf_token = $("meta[name='csrf-token']").attr('content');

                            // remove the row
                              const row = $(this).closest('.tr');

                              // send ajax request
                              $.ajax({
                                    url: url,
                                    type: 'DELETE',
                                    data: {
                                          '_method': 'DELETE',
                                          '_token': csrf_token
                                    },
                                    success: function(data) {
                                            Swal.fire({
                                                    title: "Deleted!",
                                                    text: data.msg,
                                                    icon: "success",
                                                    timer: 1000,
                                                    showConfirmButton: true
                                            });
                                        console.log(data);
                                        row.remove();
                                    },
                                    error: function(error) {
                                          Swal.fire({
                                                title: "Oops.. " + error.responseJSON.message,
                                                icon: "error"
                                          });
                                          console.log(error);
                                    }
                              });
                        }
                  })
            });
      });
</script>
