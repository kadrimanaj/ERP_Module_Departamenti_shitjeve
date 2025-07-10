<html lang="en" translate="no" class="notranslate">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Preventiv i produkteve te perzgjedhura </title>
    
        <link href="./LA POLLA GIOVANNIINV-1738321962 PIANO DI TRATTAMENTO E PREVENTIVO_files/app.875d269d.css" rel="stylesheet">

        <script>
            function goBackWithRefresh() {
                sessionStorage.setItem("needRefresh", "true"); // Set a flag before going back
                window.history.back();
            }
        </script>
    </head>

    <style>
       .d-none {
            display: none !important;
        }

        body {
            font-family: Poppins, sans-serif !important;
        }

        .d-lg-block {
           display: block !important;
        }

        .col-xl-12 {
            flex: 0 0 auto;
            width: 100%;
        }

        .col-lg-12 {
            flex: 0 0 auto;
            width: 100%;
        }

        .col-md-7 {
            flex: 0 0 auto;
            width: 100%;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: var(--bs-card-bg);
            background-clip: border-box;
            border: var(--bs-card-border-width) solid var(--bs-card-border-color);
            border-radius: var(--bs-card-border-radius);
        }

        .card-body {
            flex: 1 1 auto;
            padding: var(--bs-card-spacer-y) var(--bs-card-spacer-x);
        }

                                                                            
        .d-flex {
            display: flex !important;
        }

        .justify-content-center {
            justify-content: center !important;
        }

        .justify-content-start {
            justify-content: flex-start !important;
        }

        .ms-2 {
            margin-left: 0.5rem !important;
        }

        .ps-5 {
            padding-left: 3rem !important;
        }

        .text-center {
            text-align: center !important;
        }

        /* Row and column layout */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(var(--bs-gutter-y) * -1);
            margin-right: calc(var(--bs-gutter-x) * -0.5);
            margin-left: calc(var(--bs-gutter-x) * -0.5);
        }

        .col-11 {
            flex: 0 0 auto;
            width: 91.666667%;
        }

        .col-md-12 {
            flex: 0 0 auto;
            width: 100%;
        }

        /* SVG-specific styles */
        img.placeholder-image {
            max-width: 100%;
            height: 41px;
        }

        .not-print {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin: 20px 0;
        }

        .not-print .button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s;
        }

        .not-print .button:hover {
            background-color: #0056b3;
        }

        @media print {
            .not-print {
                display: none !important;
            }
            body {
                counter-reset: page;
            }

            .pm-preview-page-A4::after {
                counter-increment: page;
                content: "Page " counter(page);
                position: absolute;
                bottom: 6mm;
                right: 12mm;
                font-size: 3.5mm;
                color: #666;
            }

            .pm-preview-page-A4 {
                position: absolute;
                page-break-after: always;
            }

            .print-header-row {
                background-color: #343a40 !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .print-total-row {
                background-color: #d9d9d9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .costumTotal {
                background-color: #d9d9d9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
    <body>
        @php
            $total_pages = 0;
        @endphp
        <div data-app="true" class="application grey lighten-3 theme--light" id="app">
            <div class="application--wrap">
                <div id="pm-smart-plan" class="grey lighten-3">
                    <div class="white">
                        <div id="main-container" class="app-content-container" style="padding: 0px;">
                            <div class="webkit-scroll-fix">
                                <div style="padding: 20px 0px; margin: -10px 0px;" class="grey lighten-2">
                                    <div id="plan-preview" style="position: relative;">
                                        <div id="plan-preview--wrapper" style="margin: 0px auto; zoom: 1; width: 210mm; background:white">
                                            <div class="not-print">
                                                <div class="button" onclick="goBackWithRefresh();">
                                                    {{ _lang('Go Back') }}</div>
                                                <div class="button" onclick="window.print();"> {{ _lang('Print') }}
                                                </div>
                                            </div>
                                            <div style="overflow: hidden; height: 0px; position: relative; width: 210mm;">
                                                <div id="plan-pdf-header-block" class="plan-preview--page-element" style="padding: 9mm 12mm 0mm; line-height: 1.5; font-size: 3.8mm;">
                                                    <div style="text-align: left;">
                                                        <div xid="ce-header-info" class="plan-pdf-header-title" style="flex-grow: 1; padding-top: 1.5mm; font-size: 16px; font-weight: 900; color: rgb(102, 102, 102); line-height: 1.4;">
                                                            {{ _lang('Title') }}
                                                        </div>
                                                    </div>
                                                    <div style="padding: 5mm 0px; clear: both; line-height: 1.5;">
                                                        <div style="height: 0.5mm; clear: both; overflow: hidden; background: rgba(0, 0, 0, 0.2);">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="plan-preview--content-wrapper" class="plan-preview--A4" style="min-height: 280mm; width: 100%; padding-top: 0mm;">
                                                <div style="width: 210mm; height: 270mm; position: relative;" class="pm-preview-page pm-preview-page-A4">
                                                    <div id="plan-preview-cover-page" class="preview-element" style="position: relative; overflow: hidden; margin: 0px; padding: 0px; width: 210mm; height: 270mm;" data-height="1123">
                                                        <div id="plan-preview-cover-contents" style="height: 100%; width: 100%; overflow: hidden; background: rgb(255, 255, 255); position: relative;">
                                                            <img src="{{ url('ERP/assets/FutureERP.png') }}" alt="" style="position: absolute; width: 138px; height: 35px; top: 71px; left: 613px; z-index: 6; mix-blend-mode: normal;">

                                                            <div id="custom-cover-front5" style="position: absolute; white-space: nowrap; font-size: 4mm; color: rgb(255, 255, 255); font-weight: 500; font-style: normal; text-decoration: none; line-height: 1.2; width: auto; height: auto; top: 798px; left: 67px; letter-spacing: 0px; font-variant: normal; z-index: 5; text-align: left; right: auto;">
                                                                31 January 2025
                                                            </div>
                                                            <div id="custom-cover-front4" style="position: absolute; white-space: nowrap; font-size: 4.9mm; color: rgb(255, 255, 255); font-weight: 500; font-style: normal; text-decoration: none; line-height: 1.2; width: auto; height: auto; top: 720px; left: 68px; letter-spacing: 0px; font-variant: normal; z-index: 4; text-align: left; right: auto;">
                                                                {{ _lang('for') }} {{ client_name($project->project_client) }}
                                                            </div>
                                                            <div id="custom-cover-front3" style="position: absolute; white-space: nowrap; font-size: 55px; color: rgb(255, 255, 255); font-weight: 500; font-style: normal; text-decoration: none; line-height: 1.2; width: auto; height: auto; top: 653px; left: 62px; letter-spacing: 0px; font-variant: normal; z-index: 3; text-align: left; right: auto;">
                                                               {{ _lang('Financial Proposal') }} 
                                                            </div>
                                                            <img src="{{ url('ERP/assets/pdfLogo2.jpg') }}" alt="" 

                                                            style="position: absolute; width: 796px; height: 1105px; top: 0px; left: 0px; z-index: 1; mix-blend-mode: normal;">
                                                        </div>
                                                    </div>
                                                    @php $total_pages++; @endphp
                                                    <div style="position: absolute; bottom: 6mm; right: 12mm; font-size: 3.5mm; color: #666;">
                                                        {{ _lang('Page') }} {{ $total_pages }}
                                                    </div>
                                                </div>

                                                {{-- Combine your product chunks per section --}}
                                                @if ($costum_products->isNotEmpty())
                                                    @foreach ($costum_products->chunk(5) as $pageProducts)
                                                        <div style="width: 210mm; height: 280mm; position: relative; font-family: Poppins, sans-serif;" class="pm-preview-page pm-preview-page-A4">
                                                            {{-- HEADER --}}
                                                            <div id="plan-pdf-header-block" style="padding: 9mm 12mm 0mm; font-size: 3.8mm;">
                                                                <div style="text-align: left;">
                                                                    <img src="{{ get_image_storage(get_option('logo')) }}" alt="Logo" style="max-width: 60mm; float: right; max-height: 8mm;">
                                                                    <div style="font-size: 16px; font-weight: 900; color: #666;">
                                                                        {{ _lang('Products List – Custom Products') }}
                                                                    </div>
                                                                </div>
                                                                <div style="padding: 5mm 0; clear: both;">
                                                                    <div style="height: 0.5mm; background: rgba(0, 0, 0, 0.2);"></div>
                                                                </div>
                                                            </div>

                                                            {{-- TABLE HEADER + PRODUCT ROWS IN ONE TABLE --}}
                                                            <div class="preview-element pricelist-preview-element" style="padding: 0 12mm;">
                                                                <table style="width: 100%; border-collapse: collapse;">
                                                                    <thead>
                                                                        <tr style="font-size: 3mm; color: #999;">
                                                                            <td>{{ _lang('Product Details') }}</td>
                                                                            <td style="width: 13mm; text-align: right;">{{ _lang('Quantity') }}</td>
                                                                            <td style="width: 30mm; text-align: right;">{{ _lang('Unit Price') }}</td>
                                                                            <td style="width: 30mm; text-align: right;">{{ _lang('Price') }}</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($pageProducts as $product)
                                                                            <tr style="font-size: 3mm;">
                                                                                <td style="padding: 2mm; border-top: 0.3mm solid #ddd; height: 35mm; vertical-align: middle;">
                                                                                    @php $imageUrl = get_image_url($product->id); @endphp

                                                                                    <div style="display: flex; align-items: center; height: 100%;">
                                                                                        <!-- Left side image -->
                                                                                        @if($imageUrl)
                                                                                            <div style="border: 1px solid #ccc; padding: 1.5mm; box-sizing: border-box; width: 27mm; height: 27mm; display: flex; align-items: center; justify-content: center;">
                                                                                                <img src="{{ asset('storage/' . $imageUrl) }}"
                                                                                                    alt="Product Image"
                                                                                                    style="width: 25mm; height: 25mm; object-fit: cover;">
                                                                                            </div>
                                                                                        @endif

                                                                                        <!-- Spacer between image and text -->
                                                                                        <div style="width: 4mm;"></div>

                                                                                        <!-- Right side text -->
                                                                                        <div style="flex: 1;">
                                                                                            <div style="font-weight: bold; color: #000;">Name: {{ $product->product_name }}</div>
                                                                                            <div style="color: #555;">Dimension: {{ $product->dimension ?? '-' }}</div>
                                                                                            <div style="color: #555;">Color: {{ $product->color ?? '-' }}</div>
                                                                                            <div style="color: #555;">{{ $product->product_description ?? '' }}</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="padding: 2mm; text-align: right; border-top: 0.3mm solid #ddd;">
                                                                                    {{ $product->product_quantity }} ×
                                                                                </td>
                                                                                <td style="padding: 2mm; text-align: right; border-top: 0.3mm solid #ddd;">
                                                                                    {{ get_option('currency') }} {{ number_format($product->offert_price ?? 0, 2) }}
                                                                                </td>
                                                                                <td style="padding: 2mm; text-align: right; border-top: 0.3mm solid #ddd;">
                                                                                    {{ get_option('currency') }} {{ number_format($product->product_quantity * $product->offert_price, 2) }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            {{-- TOTAL (only on last page) --}}
                                                            @if ($loop->last)
                                                                <div class="preview-element pricelist-preview-element" style="padding: 1mm 12mm 8mm;">
                                                                    <div class="costumTotal" style="padding: 2mm; font-size: 3.8mm; background: #d9d9d9;">
                                                                        <b>{{ _lang('Custom Products Total') }}</b>
                                                                        <span style="float: right; font-weight: bold;">
                                                                            {{ get_option('currency') }} {{ number_format($total_costum, 2) }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @php $total_pages++; @endphp
                                                            <div style="position: absolute; bottom: 6mm; right: 12mm; font-size: 3.5mm; color: #666;">
                                                               {{ _lang('Page') }}  {{ $total_pages }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                @if ($normal_products->isNotEmpty())
                                                    @foreach ($normal_products->chunk(15) as $pageProducts)
                                                        <div style="width: 210mm; height: 280mm; position: relative; font-family: Poppins, sans-serif;" class="pm-preview-page pm-preview-page-A4">
                                                            {{-- HEADER --}}
                                                            <div id="plan-pdf-header-block" style="padding: 9mm 12mm 0mm; font-size: 3.8mm;">
                                                                <div style="text-align: left;">
                                                                    <img src="{{ get_image_storage(get_option('logo')) }}" alt="Logo" style="max-width: 60mm; float: right; max-height: 8mm;">
                                                                    <div style="font-size: 16px; font-weight: 900; color: #666;">
                                                                        {{ _lang('Products List – Normal Products') }}
                                                                    </div>
                                                                </div>
                                                                <div style="padding: 5mm 0; clear: both;">
                                                                    <div style="height: 0.5mm; background: rgba(0, 0, 0, 0.2);"></div>
                                                                </div>
                                                            </div>

                                                           <div class="preview-element pricelist-preview-element" style="padding: 0 12mm;">
                                                                <table style="width: 100%; border-collapse: collapse; font-size: 3mm;">
                                                                    <thead>
                                                                        <tr style="color: #999;">
                                                                            <td>{{ _lang('Product Name') }}</td>
                                                                            <td style="width: 13mm; text-align: right;">{{ _lang('Quantity') }}</td>
                                                                            <td style="width: 30mm; text-align: right;">{{ _lang('Unit Price') }}</td>
                                                                            <td style="width: 30mm; text-align: right;">{{ _lang('Price') }}</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($pageProducts as $product)
                                                                            <tr>
                                                                                <td style="padding: 2mm; border-top: 0.3mm solid #ddd;">
                                                                                    <div style="display: flex; align-items: center;">
                                                                                        @if($imageUrl)
                                                                                            <div style="border: 1px solid #ccc; padding: 0.5mm; box-sizing: border-box; width: 10mm; height: 10mm; display: flex; align-items: center; justify-content: center; margin-right: 2mm;">
                                                                                                <img src="{{ product_photo_warehouse($product->product_name) }}"
                                                                                                    alt="Product Image"
                                                                                                    style="width: 8mm; height: 8mm; object-fit: cover;">
                                                                                            </div>
                                                                                        @endif

                                                                                        <div style="display: flex; flex-direction: column;">
                                                                                            <div style="font-weight: bold; font-size: 3.5mm; color: #222;">
                                                                                                {{ product_name_warehouse2($product->product_name) }}
                                                                                            </div>

                                                                                            <div style="font-size: 2.5mm; color: #444; margin-top: 1mm;">
                                                                                                {{ product_for_warehouse_info($product->product_name)->details ?? '' }}
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </td>

                                                                                <td style="padding: 2mm; text-align: right; border-top: 0.3mm solid #ddd;">
                                                                                    {{ $product->product_quantity }} ×
                                                                                </td>
                                                                                <td style="padding: 2mm; text-align: right; border-top: 0.3mm solid #ddd;">
                                                                                    {{ get_option('currency') }} {{ number_format($product->offert_price ?? 0, 2) }}
                                                                                </td>
                                                                                <td style="padding: 2mm; text-align: right; border-top: 0.3mm solid #ddd;">
                                                                                    {{ get_option('currency') }} {{ number_format($product->product_quantity * $product->offert_price, 2) }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            {{-- PRODUCT ROWS --}}                                      


                                                            {{-- TOTAL (only on last page) --}}
                                                            @if ($loop->last)
                                                                <div class="preview-element pricelist-preview-element" style="padding: 1mm 12mm 8mm;">
                                                                    <div class="costumTotal" style="padding: 2mm; font-size: 3.8mm; background: #d9d9d9;">
                                                                        <b>{{ _lang('Normal Products Total') }}</b>
                                                                        <span style="float: right; font-weight: bold;">
                                                                            {{ get_option('currency') }} {{ number_format($total_normal, 2) }} <br>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                               
                                                            @endif
                                                            @php $total_pages++; @endphp
                                                            <div style="position: absolute; bottom: 6mm; right: 12mm; font-size: 3.5mm; color: #666;">
                                                                {{ _lang('Page') }} {{ $total_pages }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                <div id="plan-preview--content-wrapper" class="plan-preview--A4" style="min-height: 280mm; width: 100%; padding-top: 0mm;">
                                                    <div style="width: 210mm; height: 270mm; position: relative;" class="pm-preview-page pm-preview-page-A4">
                                                        <div id="plan-pdf-header-block" style="padding: 9mm 12mm 0mm; font-size: 3.8mm;">
                                                            <div style="text-align: left;">
                                                                <img src="{{ get_image_storage(get_option('logo')) }}" alt="Logo" style="max-width: 60mm; float: right; max-height: 8mm;">
                                                                <div style="font-size: 16px; font-weight: 900; color: #666;">
                                                                    Financial Proposal Total
                                                                </div>
                                                            </div>
                                                            <div style="padding: 5mm 0; clear: both;">
                                                                <div style="height: 0.5mm; background: rgba(0, 0, 0, 0.2);">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                        <div id="plan-preview-cover-page" class="preview-element" style="position: relative; overflow: hidden; margin: 0px; padding: 0px; width: 210mm; height: 270mm;" data-height="1123">
                                                            <div id="plan-preview-cover-contents" style="height: 100%; width: 100%; overflow: hidden; background: rgb(255, 255, 255); position: relative;">
                                                                <div class="preview-element pricelist-preview-element" style="padding: 0 12mm;">
                                                                    <div style="margin-top: 2mm;">
                                                                        <div style="font-size: 4mm; font-weight: bold; color: #222; margin-bottom: 4mm; text-align: center;">
                                                                            Order Details 
                                                                            <span style="font-weight: normal; font-size: 3.4mm;">
                                                                                ({{ $project->project_name ?? '-' }})
                                                                            </span>
                                                                        </div>


                                                                        <div style="font-size: 12px; color: black; line-height: 1.2;">
                                                                            @php
                                                                                $details = [
                                                                                    'Description' => $project->project_description ?? '-',
                                                                                    'Dates' => 
                                                                                        'Start: ' . ($project->project_start_date ?? '-') . 
                                                                                        ' | Client Deadline: ' . ($project->client_limit_date ?? '-'),
                                                                                    'Location' => 
                                                                                        ($project->order_address ?? '-') .
                                                                                        ', Rruga: ' . ($project->rruga ?? '-') .
                                                                                        ', Bashkia: ' . ($project->bashkia ?? '-') .
                                                                                        ', Qarku: ' . ($project->qarku ?? '-'),
                                                                                    'Object Details' =>
                                                                                        'Typology: ' . ($project->tipologjia_objektit ?? '-') .
                                                                                        ' | Floors: ' . ($project->kate ?? '-') .
                                                                                        ' | Lift: ' . ($project->lift ?? '-'),
                                                                                    'Additional Notes' =>
                                                                                        ($project->address_comment ?? '-') .
                                                                                        ' | Waiting Time: ' . ($project->orari_pritjes ?? '-'),
                                                                                ];
                                                                            @endphp
                                                                                <div style="margin-bottom: 1.2mm; border-bottom: 0.1mm solid #ccc; padding-bottom: 1mm; display: flex; flex-wrap: wrap; gap: 8mm;">
    
                                                                                    <div>
                                                                                        <span style="font-weight: bold; color: black;">Name:</span>
                                                                                        <span style="color: #222; margin-left: 2mm;">
                                                                                            {{ partner_info($project->project_client)->contact_name ?? '-' }}
                                                                                        </span>
                                                                                    </div>

                                                                                    <div>
                                                                                        <span style="font-weight: bold; color: black;"><span style="margin-right: 4mm"> | </span>   Email:</span>
                                                                                        <span style="color: #222; margin-left: 2mm;">
                                                                                            {{ partner_info($project->project_client)->contact_email ?? '-' }}
                                                                                        </span>
                                                                                    </div>

                                                                                    <div>
                                                                                        <span style="font-weight: bold; color: black;"><span style="margin-right: 4mm"> | </span>Phone Number:</span>
                                                                                        <span style="color: #222; margin-left: 2mm;">
                                                                                            {{ partner_info($project->project_client)->contact_phone ?? '-' }}
                                                                                        </span>
                                                                                    </div>

                                                                                </div>

                                                                                @foreach ($details as $label => $value)
                                                                                <div style="margin-bottom: 1.2mm; border-bottom: 0.1mm solid  #ccc; padding-bottom: 1mm;">
                                                                                    <span style="font-weight: bold; color: black;">{{ $label }}:</span>
                                                                                    <span style="color: #222; margin-left: 2mm;">{{ $value }}</span>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div style="padding: 2mm; font-size: 13px; margin-top: 10mm; line-height: 1.5; border-top: 0.3mm solid #ccc;"></div>

                                                                    <table style="width: 100%; font-size: 12px; border-collapse: separate; border-spacing: 0; margin-top: 10px; border: 0.3mm solid #ccc; border-radius: 2mm; overflow: hidden;">
                                                                        <!-- Table Header -->
                                                                        <thead>
                                                                            <tr class="print-header-row" style="background-color: #343a40; color: #ffffff;">
                                                                                <th style="padding: 3mm 2mm; text-align: left; font-size: 12px; font-weight: bold;">Description</th>
                                                                                <th style="padding: 3mm 2mm; text-align: center; font-size: 12px; font-weight: bold;">Models</th>
                                                                                <th style="padding: 3mm 2mm; text-align: center; font-size: 12px; font-weight: bold;">Quantity</th>
                                                                                <th style="padding: 3mm 2mm; text-align: right; font-size: 12px; font-weight: bold;">Total</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <!-- Table Body -->
                                                                        <tbody>
                                                                            <tr style="background-color: #ffffff;">
                                                                                <td style="padding: 2.5mm 2mm; border-bottom: 0.3mm solid #e0e0e0;">Custom Products Total</td>
                                                                                <td style="padding: 2.5mm 2mm; text-align: center; border-bottom: 0.3mm solid #e0e0e0;">
                                                                                    {{ $total_costum_models ?? '-' }}
                                                                                </td>
                                                                                <td style="padding: 2.5mm 2mm; text-align: center; border-bottom: 0.3mm solid #e0e0e0;">
                                                                                    {{ $total_costum_qty ?? '-' }} items
                                                                                </td>
                                                                                <td style="padding: 2.5mm 2mm; text-align: right; border-bottom: 0.3mm solid #e0e0e0;">
                                                                                    {{ get_option('currency') }} {{ number_format($total_costum, 2) }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr style="background-color: #ffffff;">
                                                                                <td style="padding: 2.5mm 2mm; border-bottom: 0.3mm solid #e0e0e0;">Normal Products Total</td>
                                                                                <td style="padding: 2.5mm 2mm; text-align: center; border-bottom: 0.3mm solid #e0e0e0;">
                                                                                    {{ $total_normal_models ?? '-' }}
                                                                                </td>
                                                                                <td style="padding: 2.5mm 2mm; text-align: center; border-bottom: 0.3mm solid #e0e0e0;">
                                                                                    {{ $total_normal_qty ?? '-' }} items
                                                                                </td>
                                                                                <td style="padding: 2.5mm 2mm; text-align: right; border-bottom: 0.3mm solid #e0e0e0;">
                                                                                    {{ get_option('currency') }} {{ number_format($total_normal, 2) }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="print-total-row" style="background-color: #d9d9d9;">
                                                                                <td style="padding: 3mm 2mm; font-weight: bold; font-size: 4mm;"> Total:</td>
                                                                                <td style="padding: 3mm 2mm; text-align: center; font-weight: bold; font-size: 4mm;">
                                                                                    {{ ($total_costum_models + $total_normal_models) ?? '-' }}
                                                                                </td>
                                                                                <td style="padding: 3mm 2mm; text-align: center; font-weight: bold; font-size: 4mm;">
                                                                                    {{ ($total_normal_qty + $total_costum_qty) ?? '-' }} items
                                                                                </td>
                                                                                <td style="padding: 3mm 2mm; text-align: right; font-weight: bold; font-size: 4mm;">
                                                                                    {{ get_option('currency') }} {{ number_format($total_normal + $total_costum, 2) }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                    <div style="padding: 2mm; font-size: 12px; margin-top: 10mm; line-height: 1.5; border-top: 0.3mm solid #ccc;">
                                                                        <strong>Payment Terms:</strong><br><br>
                                                                        Payment is due within 15 days from the date of invoice, unless otherwise agreed in writing. Accepted payment methods include bank transfer, credit/debit card, or PayPal. Customers also have the option to pay the total amount in 2 or 3 installments upon prior agreement. Please ensure that all payments reference the invoice number provided. Late payments may be subject to a 2% monthly interest charge on the outstanding balance.<br><br>
                                                                        All prices are listed in {{ get_option('currency') }} and exclude applicable taxes unless stated otherwise. The buyer is responsible for any additional bank charges or transaction fees associated with international payments. In case of dispute, the terms outlined in this invoice shall be governed by the laws and jurisdiction of [Your Country or Region].<br><br>
                                                                        If you have any questions regarding this invoice or wish to arrange installment payments, please contact our billing department in advance.

                                                                        <!-- Agreement box -->
                                                                        <div style="margin-top: 10mm; border: 0.3mm solid #999; border-radius: 2mm; padding: 4mm; font-size: 13px;">
                                                                            ☑  I agree to all payment terms stated above.
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php $total_pages++; @endphp
                                                        <div style="position: absolute; bottom: 6mm; right: 12mm; font-size: 3.5mm; color: #666;">
                                                            Page {{ $total_pages }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div style="width: 210mm; height: 270mm; position: relative;" class="pm-preview-page pm-preview-page-A4">
                                                    <div id="plan-pdf-header-block" class="plan-preview--page-element" style="padding: 9mm 12mm 0mm; line-height: 1.5; font-size: 3.8mm;">
                                                        <div style="text-align: left;"><img src="{{  get_image_storage(get_option('logo')) }}" alt="" style="max-width: 60mm; margin-top: 0px; float: right; max-height: 8mm;">
                                                            <div xid="ce-header-info" class="plan-pdf-header-title" style="flex-grow: 1; padding-top: 1.5mm; font-size: 16px; font-weight: 900; color: rgb(102, 102, 102); line-height: 1.4;" id="ce-dentists-title">
                                                               {{ _lang('Description') }}  
                                                            </div>
                                                        </div>
                                                        <div style="padding: 5mm 0px; clear: both; line-height: 1.5;">
                                                            <div style="height: 0.5mm; clear: both; overflow: hidden; background: rgba(0, 0, 0, 0.2);">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="plan-preview--footer-wrapper" class="plan-preview--page-element" style="position: absolute; bottom: 0px; width: 210mm;">
                                                        <div style="padding: 5mm 12mm 0px; clear: both; border: 1px solid rgba(255, 255, 255, 0);">
                                                            <div style="height: 0.5mm; clear: both; background: rgba(0, 0, 0, 0.2);">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="preview-element plan-preview-docs unpadded-paragraphs" id="ce-docs-dentists-0-34" style="margin: 0mm 12mm; outline: rgb(255, 255, 255) solid 1px; font-size: 13px; line-height: 1.5;" data-height="20">
                                                        <div style="font-family: Poppins, sans-serif;">

                                                        </div>
                                                    </div>
                                                    <div class="preview-element plan-preview-docs unpadded-paragraphs" id="ce-docs-dentists-0-35" style="margin: 0mm 12mm; outline: rgb(255, 255, 255) solid 1px; font-size: 13px; line-height: 1.5;" data-height="20">
                                                        <div style="font-family: Poppins, sans-serif;">

                                                        </div>
                                                    </div>
                                                    <div class="preview-element plan-preview-docs unpadded-paragraphs" id="ce-docs-dentists-0-36" style="margin: 0mm 12mm; outline: rgb(255, 255, 255) solid 1px; font-size: 13px; line-height: 1.5;" data-height="20">
                                                        <div style="font-family: Poppins, sans-serif;">

                                                        </div>
                                                    </div>
                                                    <div class="preview-element plan-preview-docs unpadded-paragraphs" id="ce-docs-dentists-0-37" style="margin: 0mm 12mm; outline: rgb(255, 255, 255) solid 1px; font-size: 13px; line-height: 1.5;" data-height="20">
                                                        <div style="font-family: Poppins, sans-serif;">

                                                        </div>
                                                    </div>
                                                    <div class="preview-element plan-preview-docs unpadded-paragraphs font-family: Poppins, sans-serif;" id="ce-docs-dentists-0-38" style="margin: 0mm 12mm; outline: rgb(255, 255, 255) solid 1px; font-size: 13px; line-height: 1.5;" data-height="23">
                                                        <div style="font-family: Poppins, sans-serif;">
                                                            <h3 style="text-align: center;">
                                                                <strong>{{ _lang('Terms and Conditions') }} </strong>
                                                            </h3>
                                                        </div>
                                                        <p>

                                                            Welcome to  {{ get_option('company_name') }}. By accessing or using our services, you agree to be bound by the following Terms and Conditions. Please read them carefully.
                                                        </p>
                                                        <p>
                                                            1. Services Provided
                                                            We offer [brief description of your services or products]. All services are subject to availability and may be modified or discontinued at any time without prior notice.
                                                        </p>
                                                        <p>
                                                            2. Pricing and Payment
                                                            All prices are listed in  {{ get_option('currency') }} and are subject to change without notice. Payment is due upon receipt of invoice unless otherwise agreed in writing. Late payments may incur additional charges.
                                                        </p>
                                                        <p>
                                                            3. Cancellations and Refunds
                                                            Orders or services may be canceled within [X] hours of placement. Refunds are issued only if the service has not been rendered or the product has not been delivered, subject to our approval.
                                                        </p>
                                                        <p>
                                                            4. Liability
                                                            We are not liable for any indirect, incidental, or consequential damages arising from the use or inability to use our services or products.
                                                        </p>
                                                        <p>
                                                            5. Intellectual Property
                                                            All content, including logos, graphics, and documents, are the intellectual property of {{ get_option('company_name') }} and may not be reproduced or used without prior written permission.
                                                        </p>
                                                        <p>
                                                            6. Privacy
                                                            We respect your privacy. Any personal information collected will be handled in accordance with our Privacy Policy and not shared with third parties without your consent.
                                                        </p>
                                                        <p>
                                                            7. Changes to Terms
                                                            We reserve the right to update or modify these terms at any time. Continued use of our services after changes are posted constitutes your acceptance of the new terms.
                                                        </p>
                                                        <p>
                                                            8. Governing Law
                                                            These Terms and Conditions are governed by the laws of Albania. Any disputes will be resolved in the courts of the Tirana District Court (Gjykata e Rrethit Gjyqësor Tiranë).
                                                        </p>
                                                        <p>
                                                            <b>Contact Us</b> <br>
                                                            If you have any questions about these Terms and Conditions, please contact us at: <br>
                                                            📧 {{ get_option('email') }} <br>
                                                            📞 +355 {{ get_option('phone') }}
                                                        </p>
                                                        <div style="margin-top: 3mm;margin-bottom: 3mm; border: 0.3mm solid #999; border-radius: 2mm; padding: 4mm; font-size: 13px;">
                                                            ☑  I agree to all terms and conditions.
                                                        </div>
                                                    </div>
                                                    <div class="preview-element plan-preview-docs unpadded-paragraphs" id="ce-docs-dentists-0-56" style="margin: 0mm 12mm; outline: rgb(255, 255, 255) solid 1px; font-size: 13px; line-height: 1.5;" data-height="20">
                                                        <div style="font-family: Poppins, sans-serif;">

                                                        </div>
                                                    </div>
                                                    <div class="preview-element plan-preview-docs unpadded-paragraphs" id="ce-docs-dentists-0-57" style="margin: 0mm 12mm; outline: rgb(255, 255, 255) solid 1px; font-size: 13px; line-height: 1.5;" data-height="20">
                                                        <div style="font-family: Poppins, sans-serif;">

                                                        </div>
                                                    </div>
                                                    <div class="preview-element plan-preview-docs unpadded-paragraphs" id="ce-docs-dentists-0-66" style="margin: 0mm 12mm; outline: rgb(255, 255, 255) solid 1px; font-size: 13px; line-height: 1.5;" data-height="20">
                                                        <div style="font-family: Poppins, sans-serif;">

                                                        </div>
                                                    </div>
                                                    <div class="preview-element plan-preview-docs unpadded-paragraphs" id="ce-docs-dentists-0-67" style="margin: 0mm 12mm; outline: rgb(255, 255, 255) solid 1px; font-size: 13px; line-height: 1.5;" data-height="20">
                                                        <div style="font-family: Poppins, sans-serif;">

                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="preview-element plan-preview-docs unpadded-paragraphs" id="ce-docs-dentists-0-67" style="margin: 0mm 12mm; outline: rgb(255, 255, 255) solid 1px; font-size: 13px; line-height: 1.5;" data-height="20">
                                                        <div style="font-family: Poppins, sans-serif;">
                                                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 10mm;">

                                                                <!-- Left Side (Company) -->
                                                                <div style="text-align: left;">
                                                                    <p style="margin-bottom: 8mm;">{{ get_option('company_name') }}</p>
                                                                    <div style="width: 50mm; padding: 2mm; font-size: 13px; margin-top: 10mm; line-height: 1.5; border-top: 0.3mm solid black;"></div>
                                                                </div>

                                                                <!-- Right Side (Client) -->
                                                                <div style="text-align: right;">
                                                                    <p style="margin-bottom: 8mm;">{{ client_name($project->project_client) }}</p>
                                                                    <div style="width: 50mm; padding: 2mm; font-size: 13px; margin-top: 10mm; line-height: 1.5; border-top: 0.3mm solid black;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @php $total_pages++; @endphp
                                                    <div style="position: absolute; bottom: 6mm; right: 12mm; font-size: 3.5mm; color: #666;">
                                                        {{ _lang('Page') }} {{ $total_pages }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>