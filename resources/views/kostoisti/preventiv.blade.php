@extends('layouts.new')

@section('content')
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4><a href="{{ route('departamentishitjes.kostoisti.projekti',$product->product_project_id) }}"><i class="ri-arrow-left-fill"></i> Back</a></h4>
            <h4 class="mb-sm-0"> Project Details</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('departamentishitjes.arkitekti.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('departamentishitjes.kostoisti.projekti', $product->product_project_id ) }}">Project Details</a></li>
                    <li class="breadcrumb-item active">Product Details</li>
                </ol>
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
                    <div class="col-12 mb-2 d-flex justify-content-end">
                    @if ($product->kostoisti_product_confirmation == 2)
                        <button class="btn btn-sm btn-success " disabled> <i class="ri-check-line"></i> Konfirmuar</button>
                    @elseif ($product->kostoisti_product_confirmation == 3)
                        <button class="btn btn-sm btn-danger " disabled> <i class="ri-check-line"></i> Refuzuar</button>
                    @else
                     <button class="btn btn-sm btn-primary me-1"  id="confirmButton"> <i class="ri-check-line"></i> Konfirmo Preventivin</button>
                        <button class="btn btn-sm btn-danger "  id="cancelButton"> <i class="ri-close-line"></i> Anullo</button>
                    @endif
                    </div>
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
        <div class="col-2 mb-2 d-flex justify-content-end">
            @if ($product->kostoisti_product_confirmation != 2 && $product->kostoisti_product_confirmation != 3)
            <button type="button" class="btn btn-sm btn-success" style="margin-left: 10px;" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
                + Shto Material
            </button>
            @endif
            @include('departamentishitjes::kostoisti.modals.first_material')
        </div>
            <div class="table-responsive">
                <table id="model-datatables" class="table table-bordered nowrap table-striped align-middle model-datatables" style="width:100%">
                    <thead>
                 <tr>
    <th>{{ _lang('ID') }}</th>
    <th>{{ _lang('Foto') }}</th>
    <th>{{ _lang('Kodi') }}</th>
    <th>{{ _lang('Emertimi') }}</th>
    <th>{{ _lang('Njesia') }}</th>
    <th>{{ _lang('Sasia') }}</th>
    <th>{{ _lang('Cmimi/Njesi') }}</th>
    <th>{{ _lang('Kosto Total') }}</th>
    <th><center>{{ _lang('Actions') }}</center></th>
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
        <div class="col-2 mb-2 d-flex justify-content-end">
            @if ($product->kostoisti_product_confirmation != 2 && $product->kostoisti_product_confirmation != 3)
            <button type="button" class="btn btn-sm btn-success" style="margin-left: 10px;" data-bs-toggle="modal" data-bs-target="#addMaterialModal2">
                + Shto Material
            </button>
            @endif
            @include('departamentishitjes::kostoisti.modals.second_material')
        </div>
            <div class="table-responsive">
                <table id="model-datatables2" class="table table-bordered nowrap table-striped align-middle model-datatables2" style="width:100%">
                    <thead>
                   <tr>
    <th>{{ _lang('ID') }}</th>
    <th>{{ _lang('Kodi') }}</th>
    <th>{{ _lang('Emertimi') }}</th>
    <th>{{ _lang('Njesia') }}</th>
    <th>{{ _lang('Sasia') }}</th>
    <th>{{ _lang('Cmimi/Njesi') }}</th>
    <th>{{ _lang('Kosto Total') }}</th>
    <th><center>{{ _lang('Actions') }}</center></th>
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
            <div class="col-2 mb-2 d-flex justify-content-end">
            @if ($product->kostoisti_product_confirmation != 2 && $product->kostoisti_product_confirmation != 3)
                <button type="button" class="btn btn-sm btn-success" style="margin-left: 10px;" data-bs-toggle="modal" data-bs-target="#addMaterialModal3">
                    + Shto Kosto
                </button>
                @endif
                @include('departamentishitjes::kostoisti.modals.third_material')
            </div>

            <div class="table-responsive">
                <table id="model-datatables3" class="table table-bordered nowrap table-striped align-middle model-datatables3" style="width:100%">
                    <thead>
                       <tr>
    <th>{{ _lang('ID') }}</th>
    <th>{{ _lang('Emertimi') }}</th>
    <th>{{ _lang('Njesia') }}</th>
    <th>{{ _lang('Sasia') }}</th>
    <th>{{ _lang('Cmimi/Njesi') }}</th>
    <th>{{ _lang('Kosto Total') }}</th>
    <th><center>{{ _lang('Actions') }}</center></th>
</tr>

                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end fw-bold p-3" style="background-color: #d6d7da ">
                    <div class="me-2">TOTAL:</div>
                    <div id="kostoTotalOutputTotal2">{{  code_currency(1) }} 0.00</div>
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

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- jQuery should already be included before Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Target both selects
        const selects = ['product_id_first', 'product_id_ndihmese'];

        selects.forEach(selectId => {
            const productSelect = document.getElementById(selectId);

            // If the select exists, bind event
            if (productSelect) {
                productSelect.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];
                    const unitName = selectedOption.getAttribute('data-unit-name');

                    // Try to find the next sibling label with class 'unitLabel'
                    let unitLabel = this.closest('.col-4').parentElement.querySelector(`#${selectId}_unitLabel`);

                    if (unitLabel) {
                        unitLabel.textContent = unitName ? ` /${unitName}` : '';
                    }

                    console.log(`[${selectId}] Selected product unit:`, unitName);
                });
            }
        });
    });
</script>


<script>
    document.getElementById('cancelButton').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Jeni i sigurt?',
            text: "Dëshironi të anulloni këtë veprim?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Po, anulloje!',
            cancelButtonText: 'Jo'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ route('product.kostoisti.cancel', $id) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                }).then(response => {
                    if (response.ok) {
                        window.location.reload(); // Reload or redirect as needed
                    } else {
                        Swal.fire('Gabim', 'Ndodhi një gabim!', 'error');
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        // For each category select
        $('.category-select').on('change', function () {
            let categoryId = $(this).val();
            let baseUrl = $(this).data('url');
            let targetSelectId = $(this).data('target'); // id of related product select

             $('#product-details-table, #product-details-table2').hide();
            let $targetSelect = $('#' + targetSelectId);
            $targetSelect.html('<option value="">Loading...</option>');

            let url = baseUrl.replace('__ID__', categoryId);

            $.ajax({
                url: url,
                method: 'GET',
                success: function (data) {
                    let options = '<option value="">Zgjidh Produktin</option>';
                    data.forEach(function (product) {
                        options += `<option value="${product.id}" data-unit-name="${product.unit_name}">${product.product_name}</option>`;
                    });
                    $targetSelect.html(options);
                },
                error: function () {
                    $targetSelect.html('<option value="">Error loading products</option>');
                }
            });
        });
    });
</script>


<script>
$(document).ready(function () {
    // Listen to both selects
    $('#product_id_first, #product_id_ndihmese').on('change', function () {
        let productId = $(this).val();
        let targetTableId = $(this).attr('id') === 'product_id_first' ? '#product-details-table' : '#product-details-table2';
        let targetBodyId = targetTableId + ' tbody';

        if (!productId) {
            $(targetTableId).hide();
            return;
        }

        $.ajax({
            url: '{{ route("kostoisti.getProductDetails", ["id" => "__ID__"]) }}'.replace('__ID__', productId),
            method: 'GET',
            success: function (product) {
                let row = `
                    <tr>
                        <td><img src="${product.image_url}" class="preview-image"  data-image="${product.image_url}"  data-name="${product.product_name}"  alt="Image"  width="60" style="cursor:pointer;"/></td>
                        <td>${product.product_name}</td>
                        <td>${product.qty}</td>
                        <td>${product.price}</td>
                    </tr>
                `;
                $(targetBodyId).html(row);
                $(targetTableId).show();
            },
            error: function () {
                $(targetBodyId).html('<tr><td colspan="4">Unable to load product details</td></tr>');
                $(targetTableId).show();
            }
        });
    });
});
</script>


<script>
    $(document).on('click', '.preview-image', function () {
        const imageUrl = $(this).data('image');
        const name = $(this).data('name');

        Swal.fire({
            title: name,
            imageUrl: imageUrl,
            imageAlt: 'Product Image',
            imageWidth: 400,
            imageHeight: 'auto',
            showCloseButton: true,
            showConfirmButton: false
        });
    });
</script>



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
    document.getElementById('confirmButton').addEventListener('click', function () {
        let productId = "{{ $id }}";

        // Get the numeric value from the div (strip the currency symbol)
        let rawText = document.getElementById('kostoTotalOutputTotal').innerText.trim();
        let totalCost = parseFloat(rawText.replace(/[^\d.-]/g, '')) || 0; // removes currency symbols and parses number

        let rawTextlendaPare = document.getElementById('kostoTotalOutput1').innerText.trim();
        let lendaPare = parseFloat(rawTextlendaPare.replace(/[^\d.-]/g, '')) || 0; // removes currency symbols and parses number

        let rawTextlendaNdihmese = document.getElementById('kostoTotalOutput2').innerText.trim();
        let lendaNdihmese = parseFloat(rawTextlendaNdihmese.replace(/[^\d.-]/g, '')) || 0; // removes currency symbols and parses number

        let rawTextotherCosts = document.getElementById('kostoTotalOutput3').innerText.trim();
        let otherCosts = parseFloat(rawTextotherCosts.replace(/[^\d.-]/g, '')) || 0; // removes currency symbols and parses number

        Swal.fire({
            title: 'Konfirmo!',
            text: "Jeni i sigurt per konfirmimin e ketij preventivi?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Po, konfirmo!',
            cancelButtonText: 'Anullo',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                let url = "{{ route('product.kostoisti.confirm', ':id') }}".replace(':id', productId);

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        total_cost: totalCost, // this sends the value to your controller
                        lenda_pare: lendaPare, // this sends the value to your controller
                        lenda_ndihmese: lendaNdihmese, // this sends the value to your controller
                        other_costs: otherCosts // this sends the value to your controller
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Konfirmuar!', data.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error!', 'Ndodhi nje gabim. Provo perseri.', 'error');
                });
            }
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

                animateNumber('#kostoTotalOutputTotal', totalSum, {
                    duration: 1000, // Optional: adjust animation duration
                    onComplete: function () {
                        // Optional: anything after it's done
                        console.log('Done!');
                    }
                });

                animateNumber('#kostoTotalOutputTotal2', totalSum.toFixed(2));

            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    }

//  function animateNumber(selector, end, options = {}) {
//     const element = document.querySelector(selector);
//     let start = 0;
//     const duration = options.duration || 1000; // 1 second default
//     const startTime = performance.now();

//     function step(currentTime) {
//         const progress = Math.min((currentTime - startTime) / duration, 1);
//         const value = start + (end - start) * progress;

//         element.textContent = value.toLocaleString('en-US', {
//             minimumFractionDigits: 2,
//             maximumFractionDigits: 2
//         });

//         if (progress < 1) {
//             requestAnimationFrame(step);
//         } else if (options.onComplete) {
//             options.onComplete();
//         }
//     }

//     requestAnimationFrame(step);
// }



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
    $(document).ready(function() {
        $('#product_id').select2({
            dropdownParent: $('#addMaterialModal'), // Optional: so it works inside modal
            width: '100%',
            placeholder: "Zgjidh Produktin"
        });
    });
</script>

<script>
   $(document).on('click', '.confirm-project-btn', function () {
        const projectId = $(this).data('id'); // Get the project ID
        const form = $('#confirmProjectForm'); // Get the form
        const action = form.attr('action').replace('__ID__', projectId); // Replace __ID__ with the actual project ID
        form.attr('action', action); // Update the form action attribute with the correct URL

        // Set the project ID in the modal
        $('#selected-project-id').text(projectId);

        // Show the modal
        $('#confirmProjectModal').modal('show');
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
                    { data: 'action', name: 'action', orderable: false, searchable: false },
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
                    { data: 'action', name: 'action', orderable: false, searchable: false },
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
                    { data: 'action', name: 'action', orderable: false, searchable: false },
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


<script>
    $(document).on('click', '.delete-btn-project', function() {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var itemId = $(this).data('id'); // Get the ID of the item to delete
    var url = "{{ route('product.kostoisti.delete', ['id' => '__id__']) }}".replace('__id__', itemId);

    // Show SweetAlert confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: "Cancel",
        reverseButtons: true // <-- this flips the buttons
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform the AJAX request to delete the item
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function(response) {
                    // Handle success, e.g., refresh the page or remove the item from the DOM
                    Swal.fire(
                        'Deleted!',
                        'The item has been deleted.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the item.',
                        'error'
                    );
                }
            });

        }
    });
});

</script>
@endsection

@endsection
