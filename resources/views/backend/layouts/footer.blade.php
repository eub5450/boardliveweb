            <footer class="footer-content">
                    <div class="footer-text d-flex align-items-center justify-content-between">
                        <div class="copy">© 2021  Dashboard </div>
                        <div class="credit">Designed by: <a href="#">Minhaz </a></div>
                    </div>
                </footer><!--/.footer content-->
                <div class="overlay"></div>
            </div><!--/.wrapper-->
        </div>
     
     <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/jQuery/jquery-3.4.1.min.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/dist/js/popper.min.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/metisMenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js" integrity="sha512-zT3zHcFYbQwjHdKjCu6OMmETx8fJA9S7E6W7kBeFxultf75OPTYUJigEKX58qgyQMi1m1EgenfjMXlRZG8BXaw==" crossorigin="anonymous"></script>
        <!-- Third Party Scripts(used by this page)-->
 <!-- Third Party Scripts(used by this page)-->
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/chartJs/Chart.min.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/sparkline/sparkline.min.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/datatables/dataTables.min.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
       
        <script src="{{asset('public/backend/it-solutionsbd/assets/dist/js/pages/dashboard.js')}}"></script>
       
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/datatables/dataTables.min.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
        <!--Page Active Scripts(used by this page)-->
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/datatables/data-basic.active.js')}}"></script>
        <!--Page Scripts(used by all page)-->
        <script src="{{asset('public/backend/it-solutionsbd/assets/dist/js/sidebar.js')}}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        {{-- <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/toastr/toastr.min.js')}}"></script> --}}
         <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/summernote/summernote.min.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
        <!--Page Active Scripts(used by this page)-->
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/summernote/summernote.active.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/summernote/summernote.active.js')}}">
          
        </script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/modals/classie.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/modals/modalEffects.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/dropzone/dist/min/dropzone.min.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/dropzone/dropzone.active.js')}}"></script>

         <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/bootstrap-wizard/jquery.backstretch.min.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/bootstrap-wizard/form.scripts.js')}}"></script>
        <!-- Third Party Scripts(used by this page)-->
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/plugins/jquery.sumoselect/jquery.sumoselect.min.js')}}"></script>
        <!--Page Active Scripts(used by this page)-->
        <script src="{{asset('public/backend/it-solutionsbd/assets/dist/js/pages/demo.select2.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/dist/js/pages/demo.jquery.sumoselect.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/dist/js/pages/newsletter.active.js')}}"></script>
        <script src="{{asset('public/backend/it-solutionsbd/assets/dist/js/pages/invoice.active.js')}}"></script>
        <!--<script src=" {{asset('public/backend/it-solutionsbd/assets/dist/css/dark-theme.css')}}"></script>-->
        <!-- Make sure these are in your layout -->
<!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
       
        <script>
        // ============================================================
        // PRINT FUNCTION
        // ============================================================
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
        </script>
        
        @yield('script')
            @stack('scripts')

        
        <script>
        // ============================================================
        // DOCUMENT READY - INITIALIZATION
        // ============================================================
        $(document).ready(function() {
            // Initialize Select2 dropdowns
            $('.select').select2();
            $('.select_host_id').select2();
            $('.select_agency_id').select2();
        });
        </script>
        
        <script>
        // ============================================================
        // DELETE CONFIRMATION WITH SWEETALERT
        // ============================================================
        $(document).on("click", "#delete", function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            
            swal({
                title: "Are you sure you want to delete?",
                text: "Once deleted, this will be permanently removed!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = link;
                } else {
                    swal("Your data is safe!");
                }
            });
        });
        </script>
        
        <script>
        // ============================================================
        // TOASTR NOTIFICATIONS FOR SESSION MESSAGES
        // ============================================================
        @if(Session::has('messege'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            var message = "{{ Session::get('messege') }}";
            
            switch(type) {
                case 'info':
                    toastr.info(message);
                    break;
                case 'success':
                    toastr.success(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
            }
        @endif
        </script>
        
        <script>
        // ============================================================
        // AGENCY USER INFO FETCH
        // ============================================================
        $(document).ready(function() {
            $(document).on('keyup change', '#agency_user_id', function() {
                var number = $(this).val();
                var check_number = number.toString().length;
                $('#has_order_text').text('');
                
                if (check_number == 6 || check_number == 5) {
                    $.ajax({
                        url: "{{ URL::to('get/user_info') }}/" + number,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#name').val(data.user.name);
                            $('#agencycode').val(data.next_agency_code);
                            
                            if ($.isEmptyObject(data.error)) {
                                toastr.success(data.success);
                            } else {
                                toastr.error(data.error);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching user info:", error);
                            toastr.error("An error occurred while fetching user information.");
                        }
                    });
                }
            });
        });
        </script>
        
        <script>
        // ============================================================
        // USER RECALL INFO FETCH
        // ============================================================
        $(document).ready(function() {
            $(document).on('keyup change', '#user_id', function() {
                var number = $(this).val();
                
                $.ajax({
                    url: "{{ URL::to('get/user_recall_info') }}/" + number,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data.data);
                        $('#deposit').val(data.data.balance);
                        
                        if ($.isEmptyObject(data.error)) {
                            toastr.success(data.success);
                        } else {
                            toastr.error(data.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching recall info:", error);
                        toastr.error("An error occurred while fetching recall information.");
                    }
                });
            });
        });
        </script>