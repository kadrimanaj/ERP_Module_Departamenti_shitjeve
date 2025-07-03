@extends('layouts.new')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4><a href="{{ route('departamentishitjes.ofertuesi.projekti',$product->product_project_id) }}"><i class="ri-arrow-left-fill"></i> Back</a></h4>
            <h4 class="mb-sm-0"> Products Details</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('departamentishitjes.ofertuesi.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('departamentishitjes.ofertuesi.projekti', $product->product_project_id ) }}">Project Details</a></li>
                    <li class="breadcrumb-item active">Product Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="card page-title-box d-sm-flex  justify-content-between p-3" style="background-color: #fef4e4;">
    <div class="row mb-1">
        <div class="col-md">
            <div class="row align-items-center g-3">
                <div class="col-md-auto">
                    <div class="avatar-md">
                        <div class="avatar-title bg-white rounded-circle d-flex align-items-center justify-content-center overflow-hidden" style="width: 70px; height: 70px; margin-top: 10px; margin-left: 20px">
                            <!-- Image thumbnail -->
                            <img src="{{ asset($image->file_path) }}" class="img-thumbnail clickable-image" alt="Image" data-bs-toggle="modal" data-bs-target="#imageModal" data-src="{{ asset($image->file_path) }}" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;" />
                            <!-- Centered Bootstrap Modal -->
                            <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content bg-transparent border-0">
                                        <div class="modal-body p-0 text-center">
                                        <img id="modalImage" src="" alt="Enlarged image" class="img-fluid rounded" style="max-height: 80vh; object-fit: contain;" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>

                <div class="col-md">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="fw-bold mb-1">{{ $product->product_name }} - {{$product->product_quantity}} cope</h4>
                        </div>
                        <div class="col-12">
                            <div class="badge rounded-pill bg-{{ getStatusColor($product->product_status) }} fs-12">Status: {{getStatusName($product->product_status)}} </div>
                        </div>
                        <div class="col-12">
                            <i class="ri-paint-brush-fill"></i>  Ngjyra: {{$product->color}}<span class="fw-medium"></span>
                        </div>
                        <div class="col-12">
                            <i class="ri-ruler-fill"></i>  Permasat: {{$product->dimension}}<span class="fw-medium"></span>
                        </div>
                        <div class="col-12">
                            <i class="ri-text-block align-bottom"></i> Pershkrimi: <span class="fw-medium">{{$product->product_description}}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-3" style="max-width: 350px; margin-left: auto;">
                    <div class="d-flex justify-content-between mb-1">
                      <div>Lenda e pare:</div>
                       
                      <div id="kostoTotalOutput1">{{  code_currency(1) }} 0.00</div>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                      <div>Lenda ndihmese:</div>
                      <div id="kostoTotalOutput2">{{  code_currency(1) }} 0.00</div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                      <div>Kosto te tjera:</div>
                      <div id="kostoTotalOutput3">{{  code_currency(1) }} 0.00</div>
                    </div>
                    <hr style="width: 100%; border-top: 1px dashed #000000;">
                    <div class="d-flex justify-content-between fw-bold">
                      <div>TOTAL:</div>
                      <div id="kostoTotalOutputTotal">{{  code_currency(1) }} 0.00</div>
                    </div>

                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card p-5">
    <div class="row">
        <hr>
        <div class="col-10">
            <h5>Lenda e Pare</h5>
        </div>
            <div class="table-responsive">
                <table id="model-datatables" class="table table-bordered nowrap table-striped align-middle model-datatables" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Kodi</th>
                            <th>Emertimi</th>
                            <th>Njesia</th>
                            <th>Sasia</th>
                            <th>Cmimi/Njesi</th>
                            <th>Kosto Total</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        <hr class="mb-5">
        <div class="col-10">
            <h5>Lenda Ndihmese</h5>
        </div>
            <div class="table-responsive">
                <table id="model-datatables2" class="table table-bordered nowrap table-striped align-middle model-datatables2" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Kodi</th>
                            <th>Emertimi</th>
                            <th>Njesia</th>
                            <th>Sasia</th>
                            <th>Cmimi/Njesi</th>
                            <th>Kosto Total</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <hr class="mb-5">

            <div class="col-10">
                <h5>Kosto Te Tjera</h5>
            </div>
            <div class="table-responsive">
                <table id="model-datatables3" class="table table-bordered nowrap table-striped align-middle model-datatables3" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Emertimi</th>
                            <th>Njesia</th>
                            <th>Sasia</th>
                            <th>Cmimi/Njesi</th>
                            <th>Kosto Total</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
    </div>
</div>

@section('js-script')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ asset('assets/libs/dropzone/dropzone-min.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll(".clickable-image").forEach(function (img) {
        img.addEventListener("click", function () {
          const src = this.getAttribute("data-src");
          document.getElementById("modalImage").setAttribute("src", src);
        });
      });
    });
</script>

<script>
    var elementId = @json($id); // Get the ID from Blade template
    
    // Initialize a variable to hold the total sum
    var totalSum = 0;

    // Make this function available globally in this script
    function getKostoTotalPerElement(elementId, type) {
        $.ajax({
            url: "{{ route('kostoisti.getKostoTotalPerElement', ['id' => '__elementId__', 'type' => '__type__']) }}".replace('__elementId__', elementId).replace('__type__', type),
            type: "GET",
            success: function(response) {
                console.log("Kosto totale for type " + type + ": " + response);

                // If response is a number (ensure it's a valid number)
                if (!isNaN(response)) {
                    // Format the number with 2 decimal places
                    var formattedValue = parseFloat(response).toFixed(2);
                    
                    // Add the formatted value to the total sum
                    totalSum += parseFloat(formattedValue);

                    // Insert the formatted value into the appropriate div
                    if (type === 1) {
                        animateNumber('#kostoTotalOutput1', formattedValue); // Animate value for type 1
                    } else if (type === 2) {
                        animateNumber('#kostoTotalOutput2', formattedValue); // Animate value for type 2
                    } else if (type === 3) {
                        animateNumber('#kostoTotalOutput3', formattedValue); // Animate value for type 3
                    }
                } else {
                    // If response is not a valid number, handle accordingly
                    $('#kostoTotalOutput' + type).text('Invalid value');
                }

                // Animate the total sum update
                animateNumber('#kostoTotalOutputTotal', totalSum.toFixed(2)); // Animate the total sum
                
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    }

    function animateNumber(selector, targetValue) {
        var currentValue = 0;
        var moneySymbol = '{{  code_currency(1) }} ';
        var step = parseFloat(targetValue) / 100; // Slower step increase (divide by a larger number for slower animation)
        var intervalTime = 5; // Slower updates (increase this value to slow down the animation)

        var interval = setInterval(function() {
            currentValue += step;
            if (currentValue >= parseFloat(targetValue)) {
                currentValue = parseFloat(targetValue); // Set the final value
                clearInterval(interval); // Stop the interval when it reaches the target value
            }
            $(selector).text(moneySymbol  + currentValue.toFixed(2)); // Update the displayed value
        }, intervalTime);
    }

    // Call the function for each type
    getKostoTotalPerElement(elementId, 1);
    getKostoTotalPerElement(elementId, 2);
    getKostoTotalPerElement(elementId, 3);
</script>

<script>
    var col = ["1","2","3","4","5"];
    var fil = ["1"];

    $(function() {
        $(document).ready(function() {
            initializeDataTable(null, null);
        });

        function initializeDataTable(itemId, itemName) {
            if ($.fn.DataTable.isDataTable('.model-datatables')) {
                $('.model-datatables').DataTable().destroy();
            }

            $('.model-datatables').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ route('kostoisti.projektet.list', ['id' => $id]) }}",
                    data: function(d) {
                        d.name = $('#search-client').val();
                        d.status = $('#search-status').val();
                        d.date = $('#search-date').val();
                        d.project_name = $('#search-project-name').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'image', name: 'image', orderable: false },
                    { data: 'sku_code', name: 'sku_code', orderable: false },
                    { data: 'product_id', name: 'product_id', orderable: false },
                    { data: 'unit_id', name: 'unit_id', orderable: false },
                    { data: 'quantity', name: 'quantity', orderable: false },
                    { data: 'cost', name: 'cost', orderable: false },
                    { data: 'total', name: 'total', orderable: false, searchable: false },
                ],
                dom: 
                    '<"row mb-3"' +
                        '<"col-sm-6 mt-2"l>' + 
                        '<"col-sm-6 d-flex justify-content-end align-items-center gap-2"' +
                            '<"dt-buttons mt-2"f>' +
                            '<"dt-search"B>' +
                        '>' +
                    '>' +
                    'rt' +
                    '<"row"' +
                        '<"col-sm-6"i>' + 
                        '<"col-sm-6 d-flex justify-content-end"p>' +
                    '>',

                buttons: [
                    {
                    extend: 'excel',
                    text: '<i class="ri-file-excel-2-line"></i> Export Excel',
                    className: 'btn btn-success btn-sm'
                },
                {
                    extend: 'pdf',
                    text: '<i class="ri-file-pdf-line"></i> Export PDF',
                    className: 'btn btn-danger btn-sm'
                },
                {
                    extend: 'print',
                    text: '<i class="ri-printer-line"></i> Print',
                    className: 'btn btn-primary btn-sm'
                }
                ],
                language: {
                    lengthMenu: " _MENU_ ", 
                    search: "",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "Prev",
                        next: "Next"
                    }
                },
                info: true ,
                autoWidth: false,
                paging: true,
                ordering: true,
                searching: true,
                initComplete: function () {
                    $('.model-datatables').removeClass('dataTable');
                }
            });
        }

        // Custom search input to filter table
        $('#search-client, #search-architect, #search-status').on('keyup change', function() {
            $('.model-datatables').DataTable().ajax.reload();
        });
        $(document).ready(function() {
        // Select the search input
        $('input[type="search"]').each(function() {
                var icon = '<i class="ri-search-2-line"></i>';

                // Add a wrapper around the input field to position the icon
                $(this).wrap('<div class="input-wrapper" style="position: relative;"></div>');

                // Add the icon inside the input-wrapper and position it absolutely
                $(this).before(icon);

                // Adjust padding of the input field to make space for the icon
                $(this).css('padding-left', '30px');
                
                // Position the icon inside the input field
                $(this).prev('i').css({
                    position: 'absolute',
                    left: '10px',
                    top: '50%',
                    transform: 'translateY(-50%)',
                    color: '#ccc'
                });
            });
        });


        $.fn.dataTable.ext.errMode = 'none';
    });

    $(document).on('click', '.filter-status', function () {
        var status = $(this).data('status'); // Get the status from the button
        var table = $('#model-datatables').DataTable(); // Use your actual table ID

        // Adjust this number to match the index of your 'project_status' column
        var columnIndex = 3;

        table.column(columnIndex).search(status).draw();
        console.log(status);
    });



    $(document).ready(function() {

        $('#addMaterialForm').submit(function(e) {
            e.preventDefault(); // Prevent default form submission



            var form = $(this);
            var formData = form.serialize();
            var actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: formData,
                success: function(response) {
                    $('#addMaterialModal').modal('hide');
                    $('.model-datatables').DataTable().ajax.reload();
                    toastr.success('Materiali u ruajt me sukses!');

                    // Call the function here
                    getKostoTotalPerElement(elementId, 1);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value + '<br>';
                        });
                        toastr.error(errorMessage);
                    } else {
                        toastr.error('Ndodhi një gabim gjatë ruajtjes.');
                    }
                }
            });
        });

    });

</script>

<script>
    var col = ["1","2","3","4","5"];
    var fil = ["1"];

    $(function() {
        $(document).ready(function() {
            initializeDataTable(null, null);
        });

        function initializeDataTable(itemId, itemName) {
            if ($.fn.DataTable.isDataTable('.model-datatables2')) {
                $('.model-datatables2').DataTable().destroy();
            }

            $('.model-datatables2').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ route('kostoisti.second.list', ['id' => $id]) }}",
                    data: function(d) {
                        d.name = $('#search-client').val();
                        d.status = $('#search-status').val();
                        d.date = $('#search-date').val();
                        d.project_name = $('#search-project-name').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'image', name: 'image', orderable: false },
                    { data: 'sku_code', name: 'sku_code', orderable: false },
                    { data: 'product_id', name: 'product_id', orderable: false },
                    { data: 'unit_id', name: 'unit_id', orderable: false },
                    { data: 'quantity', name: 'quantity', orderable: false },
                    { data: 'cost', name: 'cost', orderable: false },
                    { data: 'total', name: 'total', orderable: false, searchable: false },
                ],
                dom: 
                    '<"row mb-3"' +
                        '<"col-sm-6 mt-2"l>' + 
                        '<"col-sm-6 d-flex justify-content-end align-items-center gap-2"' +
                            '<"dt-buttons mt-2"f>' +
                            '<"dt-search"B>' +
                        '>' +
                    '>' +
                    'rt' +
                    '<"row"' +
                        '<"col-sm-6"i>' + 
                        '<"col-sm-6 d-flex justify-content-end"p>' +
                    '>',

                buttons: [
                    {
                    extend: 'excel',
                    text: '<i class="ri-file-excel-2-line"></i> Export Excel',
                    className: 'btn btn-success btn-sm'
                },
                {
                    extend: 'pdf',
                    text: '<i class="ri-file-pdf-line"></i> Export PDF',
                    className: 'btn btn-danger btn-sm'
                },
                {
                    extend: 'print',
                    text: '<i class="ri-printer-line"></i> Print',
                    className: 'btn btn-primary btn-sm'
                }
                ],
                language: {
                    lengthMenu: " _MENU_ ", 
                    search: "",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "Prev",
                        next: "Next"
                    }
                },
                info: true ,
                autoWidth: false,
                paging: true,
                ordering: true,
                searching: true,
                initComplete: function () {
                    $('.model-datatables2').removeClass('dataTable');
                }
            });
        }

        // Custom search input to filter table
        $('#search-client, #search-architect, #search-status').on('keyup change', function() {
            $('.model-datatables2').DataTable().ajax.reload();
        });
        $(document).ready(function() {
        // Select the search input
        $('input[type="search"]').each(function() {
                var icon = '<i class="ri-search-2-line"></i>';

                // Add a wrapper around the input field to position the icon
                $(this).wrap('<div class="input-wrapper" style="position: relative;"></div>');

                // Add the icon inside the input-wrapper and position it absolutely
                $(this).before(icon);

                // Adjust padding of the input field to make space for the icon
                $(this).css('padding-left', '30px');
                
                // Position the icon inside the input field
                $(this).prev('i').css({
                    position: 'absolute',
                    left: '10px',
                    top: '50%',
                    transform: 'translateY(-50%)',
                    color: '#ccc'
                });
            });
        });


        $.fn.dataTable.ext.errMode = 'none';
    });

    $(document).on('click', '.filter-status', function () {
        var status = $(this).data('status'); // Get the status from the button
        var table = $('#model-datatables2').DataTable(); // Use your actual table ID

        // Adjust this number to match the index of your 'project_status' column
        var columnIndex = 3;

        table.column(columnIndex).search(status).draw();
        console.log(status);
    });


    $(document).ready(function() {
        $('#addMaterialForm2').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            var form = $(this);
            var formData = form.serialize();
            var actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: formData,
                success: function(response) {
                    // Hide modal
                    $('#addMaterialModal2').modal('hide');

                    // Reload the DataTable
                    $('.model-datatables2').DataTable().ajax.reload();

                    // Optionally, show success message
                    toastr.success('Materiali u ruajt me sukses!');
                    getKostoTotalPerElement(elementId, 2);

                },
                error: function(xhr) {
                    // Handle validation errors
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value + '<br>';
                        });
                        toastr.error(errorMessage);
                    } else {
                        toastr.error('Ndodhi një gabim gjatë ruajtjes.');
                    }
                }
            });
        });
    });
</script>

<script>
    var col = ["1","2","3","4","5"];
    var fil = ["1"];

    $(function() {
        $(document).ready(function() {
            initializeDataTable(null, null);
        });

        function initializeDataTable(itemId, itemName) {
            if ($.fn.DataTable.isDataTable('.model-datatables3')) {
                $('.model-datatables3').DataTable().destroy();
            }

            $('.model-datatables3').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ route('kostoisti.third.list', ['id' => $id]) }}",
                    data: function(d) {
                        d.name = $('#search-client').val();
                        d.status = $('#search-status').val();
                        d.date = $('#search-date').val();
                        d.project_name = $('#search-project-name').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'product_name', name: 'product_name', orderable: false },
                    { data: 'unit_id', name: 'unit_id', orderable: false },
                    { data: 'quantity', name: 'quantity', orderable: false },
                    { data: 'cost', name: 'cost', orderable: false },
                    { data: 'total', name: 'total', orderable: false, searchable: false },
                ],
                dom: 
                    '<"row mb-3"' +
                        '<"col-sm-6 mt-2"l>' + 
                        '<"col-sm-6 d-flex justify-content-end align-items-center gap-2"' +
                            '<"dt-buttons mt-2"f>' +
                            '<"dt-search"B>' +
                        '>' +
                    '>' +
                    'rt' +
                    '<"row"' +
                        '<"col-sm-6"i>' + 
                        '<"col-sm-6 d-flex justify-content-end"p>' +
                    '>',

                buttons: [
                    {
                    extend: 'excel',
                    text: '<i class="ri-file-excel-2-line"></i> Export Excel',
                    className: 'btn btn-success btn-sm'
                },
                {
                    extend: 'pdf',
                    text: '<i class="ri-file-pdf-line"></i> Export PDF',
                    className: 'btn btn-danger btn-sm'
                },
                {
                    extend: 'print',
                    text: '<i class="ri-printer-line"></i> Print',
                    className: 'btn btn-primary btn-sm'
                }
                ],
                language: {
                    lengthMenu: " _MENU_ ", 
                    search: "",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "Prev",
                        next: "Next"
                    }
                },
                info: true ,
                autoWidth: false,
                paging: true,
                ordering: true,
                searching: true,
                initComplete: function () {
                    $('.model-datatables3').removeClass('dataTable');
                }
            });
        }

        // Custom search input to filter table
        $('#search-client, #search-architect, #search-status').on('keyup change', function() {
            $('.model-datatables3').DataTable().ajax.reload();
        });
        $(document).ready(function() {
        // Select the search input
        $('input[type="search"]').each(function() {
                var icon = '<i class="ri-search-2-line"></i>';

                // Add a wrapper around the input field to position the icon
                $(this).wrap('<div class="input-wrapper" style="position: relative;"></div>');

                // Add the icon inside the input-wrapper and position it absolutely
                $(this).before(icon);

                // Adjust padding of the input field to make space for the icon
                $(this).css('padding-left', '30px');
                
                // Position the icon inside the input field
                $(this).prev('i').css({
                    position: 'absolute',
                    left: '10px',
                    top: '50%',
                    transform: 'translateY(-50%)',
                    color: '#ccc'
                });
            });
        });


        $.fn.dataTable.ext.errMode = 'none';
    });

    $(document).on('click', '.filter-status', function () {
        var status = $(this).data('status'); // Get the status from the button
        var table = $('#model-datatables3').DataTable(); // Use your actual table ID

        // Adjust this number to match the index of your 'project_status' column
        var columnIndex = 3;

        table.column(columnIndex).search(status).draw();
        console.log(status);
    });

    $(document).ready(function() {
        $('#addMaterialForm3').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            var form = $(this);
            var formData = form.serialize();
            var actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: formData,
                success: function(response) {
                    // Hide modal
                    $('#addMaterialModal3').modal('hide');

                    // Reload the DataTable
                    $('.model-datatables3').DataTable().ajax.reload();

                    // Optionally, show success message
                    toastr.success('Materiali u ruajt me sukses!');
                    getKostoTotalPerElement(elementId, 3);

                },
                error: function(xhr) {
                    // Handle validation errors
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value + '<br>';
                        });
                        toastr.error(errorMessage);
                    } else {
                        toastr.error('Ndodhi një gabim gjatë ruajtjes.');
                    }
                }
            });
        });
    });
</script>
@endsection

@endsection