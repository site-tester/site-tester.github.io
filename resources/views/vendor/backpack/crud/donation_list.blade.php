@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        $crud->entity_name_plural => url($crud->route),
        trans('backpack::crud.list') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none"
        bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</h1>
        <p class="ms-2 ml-2 mb-0" id="datatable_info_stack" bp-section="page-subheading">{!! $crud->getSubheading() ?? '' !!}</p>
    </section>
@endsection

@section('content')
    {{-- Default box --}}
    <div class="row pb-5" bp-section="crud-operation-list">

        {{-- THE ACTUAL CONTENT --}}
        <div class="row {{ $crud->getListContentClass() }}">
            <div class="col">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-9">
                        @if ($crud->buttons()->where('stack', 'top')->count() || $crud->exportButtons())
                            <div class="d-print-none {{ $crud->hasAccess('create') ? 'with-border' : '' }}">

                                @include('crud::inc.button_stack', ['stack' => 'top'])

                            </div>
                        @endif
                    </div>
                    @if ($crud->getOperationSetting('searchableTable'))
                        <div class="col-sm-3">
                            <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                            <path d="M21 21l-6 -6"></path>
                                        </svg>
                                    </span>
                                    <input type="search" class="form-control"
                                        placeholder="{{ trans('backpack::crud.search') }}..." />
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Backpack List Filters --}}
                @if ($crud->filtersEnabled())
                    @include('crud::inc.filters_navbar')
                @endif

                <div class="{{ backpack_theme_config('classes.tableWrapper') }}">
                    <table id="crudTable"
                        class="{{ backpack_theme_config('classes.table') ?? 'table table-striped table-hover nowrap rounded card-table table-vcenter card d-table shadow-xs border-xs' }}"
                        data-responsive-table="{{ (int) $crud->getOperationSetting('responsiveTable') }}"
                        data-has-details-row="{{ (int) $crud->getOperationSetting('detailsRow') }}"
                        data-has-bulk-actions="{{ (int) $crud->getOperationSetting('bulkActions') }}"
                        data-has-line-buttons-as-dropdown="{{ (int) $crud->getOperationSetting('lineButtonsAsDropdown') }}"
                        data-line-buttons-as-dropdown-minimum="{{ (int) $crud->getOperationSetting('lineButtonsAsDropdownMinimum') }}"
                        data-line-buttons-as-dropdown-show-before-dropdown="{{ (int) $crud->getOperationSetting('lineButtonsAsDropdownShowBefore') }}"
                        cellspacing="0">
                        <thead>
                            <tr>
                                {{-- Table columns --}}
                                @foreach ($crud->columns() as $column)
                                    @php
                                        $exportOnlyColumn = $column['exportOnlyColumn'] ?? false;
                                        $visibleInTable =
                                            $column['visibleInTable'] ?? ($exportOnlyColumn ? false : true);
                                        $visibleInModal =
                                            $column['visibleInModal'] ?? ($exportOnlyColumn ? false : true);
                                        $visibleInExport = $column['visibleInExport'] ?? true;
                                        $forceExport =
                                            $column['forceExport'] ??
                                            (isset($column['exportOnlyColumn']) ? true : false);
                                    @endphp
                                    <th data-orderable="{{ var_export($column['orderable'], true) }}"
                                        data-priority="{{ $column['priority'] }}" data-column-name="{{ $column['name'] }}"
                                        {{--
                    data-visible-in-table => if developer forced column to be in the table with 'visibleInTable => true'
                    data-visible => regular visibility of the column
                    data-can-be-visible-in-table => prevents the column to be visible into the table (export-only)
                    data-visible-in-modal => if column appears on responsive modal
                    data-visible-in-export => if this column is exportable
                    data-force-export => force export even if columns are hidden
                    --}}
                                        data-visible="{{ $exportOnlyColumn ? 'false' : var_export($visibleInTable) }}"
                                        data-visible-in-table="{{ var_export($visibleInTable) }}"
                                        data-can-be-visible-in-table="{{ $exportOnlyColumn ? 'false' : 'true' }}"
                                        data-visible-in-modal="{{ var_export($visibleInModal) }}"
                                        data-visible-in-export="{{ $exportOnlyColumn ? 'true' : ($visibleInExport ? 'true' : 'false') }}"
                                        data-force-export="{{ var_export($forceExport) }}">
                                        {{-- Bulk checkbox --}}
                                        @if ($loop->first && $crud->getOperationSetting('bulkActions'))
                                            {!! View::make('crud::columns.inc.bulk_actions_checkbox')->render() !!}
                                        @endif
                                        {!! $column['label'] !!}
                                    </th>
                                @endforeach

                                @if ($crud->buttons()->where('stack', 'line')->count())
                                    <th data-orderable="false" data-priority="{{ $crud->getActionsColumnPriority() }}"
                                        data-visible-in-export="false" data-action-column="true">
                                        {{ trans('backpack::crud.actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                {{-- Table columns --}}
                                @foreach ($crud->columns() as $column)
                                    <th>
                                        {{-- Bulk checkbox --}}
                                        @if ($loop->first && $crud->getOperationSetting('bulkActions'))
                                            {!! View::make('crud::columns.inc.bulk_actions_checkbox')->render() !!}
                                        @endif
                                        {!! $column['label'] !!}
                                    </th>
                                @endforeach

                                @if ($crud->buttons()->where('stack', 'line')->count())
                                    <th>{{ trans('backpack::crud.actions') }}</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if ($crud->buttons()->where('stack', 'bottom')->count())
                    <div id="bottom_buttons" class="d-print-none text-sm-left">
                        @include('crud::inc.button_stack', ['stack' => 'bottom'])
                        <div id="datatable_button_stack" class="float-right float-end text-right hidden-xs"></div>
                    </div>
                @endif
            </div>
            {{-- <div class="col-3 m-1 overview">
                <div class="card py-3 px-4 h-100">
                    <div class="h3">Overview</div>
                    <a href="{{ url()->current() }}?status=pending" class="border-bottom px-1 py-2">Total Pending Request <span class="float-end">{{ $overviewData['pendingDonation'] }}</span></a>
                    <a href="{{ url()->current() }}?date=today" class="border-bottom px-1 py-2">This Day <span class="float-end">{{ $overviewData['thisDayDonation'] }}</span></a>
                    <a href="{{ url()->current() }}?status=approved" class="border-bottom px-1 py-2">Accepted This Day <span class="float-end">{{ $overviewData['approvedDonation'] }}</span></a>
                </div>
            </div> --}}
        </div>
    </div>
    <!-- Modal -->
    <div class="modal" id="approveModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Donation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="approveForm">
                        <div class="mb-3">
                            <label for="approverName" class="form-label">Approver's Name</label>
                            <input type="text" class="form-control" id="approverName" name="approver_name"
                                placeholder="Enter approver's name" required>
                        </div>
                        <input type="hidden" id="donationId" name="donation_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitApproval">Approve</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="receiveModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Receive Donation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="receiveForm">
                        <div class="mb-3">
                            <label for="receiverName" class="form-label">Receiver's Name</label>
                            <input type="text" class="form-control" id="receiverName" name="receiver_name"
                                placeholder="Enter Receiver's Name" required>
                        </div>
                        <input type="hidden" id="donationId" name="donation_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitReceive">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="distributeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Distribute Donation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="distributeForm">
                        <div class="mb-3">
                            <label for="distributorName" class="form-label">Distributor's Name</label>
                            <input type="text" class="form-control" id="distributorName" name="distributor_name"
                                placeholder="Enter Distributor's name" required>
                        </div>
                        <div class="mb-3">
                            <label for="distributorImg" class="form-label">Distributor Image Proof</label>
                            <input type="file" class="form-control" id="distributorImg" name="distributor_img"
                                placeholder="Enter Distributor's name" required>
                        </div>
                        <input type="hidden" id="donationId" name="donation_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitDistribution">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    {{-- DATA TABLES --}}
    @basset('https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css')
    @basset('https://cdn.datatables.net/fixedheader/3.3.1/css/fixedHeader.dataTables.min.css')
    @basset('https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css')

    {{-- CRUD LIST CONTENT - crud_list_styles stack --}}
    @stack('crud_list_styles')
@endsection

@push('after_styles')
    <style>
        .modal-backdrop {
            z-index: 1040 !important;
        }

        .modal {
            z-index: 1050 !important;
        }
    </style>
@endpush

@section('after_scripts')
    @include('crud::inc.datatables_logic')

    {{-- CRUD LIST CONTENT - crud_list_scripts stack --}}
    @stack('crud_list_scripts')

    <script>
        document.getElementById('approveModal').addEventListener('show.bs.modal', function() {
            this.style.display = 'block';
            document.body.appendChild(this);
        });
        document.getElementById('receiveModal').addEventListener('show.bs.modal', function() {
            this.style.display = 'block';
            document.body.appendChild(this);
        });
        document.getElementById('distributeModal').addEventListener('show.bs.modal', function() {
            this.style.display = 'block';
            document.body.appendChild(this);
        });

        function updateDonationStatus(id, status) {
            // Send an AJAX request to the server
            $.ajax({
                url: '{{ route('update.donation.verification.status', ':id') }}'.replace(':id',
                    id), // Update URL with the actual entry ID
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security
                    status: status // The new status to be updated ('Approved' or 'Rejected')
                },
                success: function(response) {
                    if (response.success) {
                        // Reload the page to see the updated status (or you can selectively update the button states in the UI)
                        new Noty({
                            type: 'success',
                            text: 'Donation ' + status + '. Reloading in 3 seconds.',
                            timeout: 3000, // Automatically close after 3 seconds
                            progressBar: true,
                        }).show();

                        setTimeout(function() {
                            location.reload();
                        }, 3000);

                    } else {
                        // If there's an error updating the status, show an alert
                        alert('Failed to update status: ' + data.error);
                        new Noty({
                            type: 'error',
                            text: 'Failed to update status.',
                            timeout: 3000,
                            progressBar: true,
                        }).show();
                    }
                },
                error: function() {
                    // If the AJAX request fails, show an error message
                    console.log('AJAX Error:', error);
                    new Noty({
                        type: 'error',
                        text: 'An error occurred while updating the status.',
                        timeout: 3000,
                        progressBar: true,
                    }).show();
                }
            });
        }

        // function submitApproval(donationId) {
        //     // Get the input value
        //     const approvedByInput = document.querySelector(`#approved_by-${donationId}`);
        //     const approvedBy = approvedByInput.value;

        //     if (!approvedBy) {
        //         alert('Please fill in the "Approved By" field.');
        //         return;
        //     }

        //     // Perform AJAX request
        //     fetch(`{{ url('/admin/donation/') }}/${donationId}/approve`, {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
        //             },
        //             body: JSON.stringify({
        //                 approved_by: approvedBy
        //             }),
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data.success) {
        //                 alert(data.message);
        //                 // Optionally reload the page or refresh the table
        //                 location.reload();
        //             } else {
        //                 alert(data.message || 'An unknown error occurred.');
        //             }
        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //             alert('An error occurred while approving the donation.');
        //         });
        // }

        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener to handle modal opening
            $('#approveModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const donationId = button.data('id'); // Extract the donation ID from data-id attribute
                $('#approveModal #donationId').val(donationId);
            });

            $('#submitApproval').click(function() {
                const approverName = $('#approveModal #approverName').val();
                const donationId = $('#approveDonationId').val();

                console.log('Donation ID:', donationId);
                console.log('Approver Name:', approverName);

                // Make sure the approver's name is not empty
                if (!approverName) {
                    alert('Please enter the approver\'s name');
                    return;
                }

                // Send the data via AJAX
                $.ajax({
                    url: '/admin/approve-donation/' + donationId, // URL to handle the request
                    method: 'POST',
                    data: {
                        approver_name: approverName,
                        _token: $('meta[name="csrf-token"]').attr(
                            'content') // CSRF Token for Laravel
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Donation approved successfully');
                            $('#approveModal').modal('hide'); // Close the modal
                            location.reload(); // Reload the page to reflect the changes
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    },
                    error: function() {
                        alert('Something went wrong!');
                    }
                });
            });

            // Receive Modal
            $('#receiveModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const donationId = button.data('id'); // Extract donation ID from data-id attribute
                $('#receiveModal #donationId').val(donationId);
            });

            $('#submitReceive').click(function() {
                const receiverName = $('#receiverName').val();
                const donationId = $('#receiveModal #donationId').val();

                if (!receiverName) {
                    alert("Please enter the receiver's name.");
                    return;
                }

                // AJAX request to submit the "Receive Donation" form
                $.ajax({
                    url: '/admin/receive-donation/' + donationId,
                    method: 'POST',
                    data: {
                        receiver_name: receiverName,
                        _token: $('meta[name="csrf-token"]').attr(
                            'content') // CSRF token for Laravel
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Donation marked as received successfully.');
                            $('#receiveModal').modal('hide');
                            location.reload();
                        } else {
                            alert(response.message || 'An error occurred. Please try again.');
                        }
                    },
                    error: function() {
                        alert('Something went wrong while receiving the donation.');
                    }
                });
            });

            // Distribute Modal
            $('#distributeModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const donationId = button.data('id'); // Extract donation ID from data-id attribute
                $('#distributeModal #donationId').val(donationId);
            });

            $('#submitDistribution').click(function() {
                const distributorName = $('#distributorName').val();
                const distributorImg = $('#distributorImg')[0].files[0];
                const donationId = $('#distributeModal #donationId').val();

                if (!distributorName || !distributorImg) {
                    alert("Please fill in the distributor's name and upload the image proof.");
                    return;
                }

                // FormData to send file and other data via AJAX
                const formData = new FormData();
                formData.append('distributor_name', distributorName);
                formData.append('distributor_img', distributorImg);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                // AJAX request to submit the "Distribute Donation" form
                $.ajax({
                    url: '/admin/distribute-donation/' + donationId,
                    method: 'POST',
                    processData: false, // Prevent jQuery from auto-processing the data
                    contentType: false, // Set the appropriate content type for FormData
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert('Donation marked as distributed successfully.');
                            $('#distributeModal').modal('hide');
                            location.reload();
                        } else {
                            alert(response.message || 'An error occurred. Please try again.');
                        }
                    },
                    error: function() {
                        alert('Something went wrong while distributing the donation.');
                    }
                });
            });
        });
    </script>
@endsection
