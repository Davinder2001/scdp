@extends('layout.master')

@if (auth()->user()->role_id != '1')
    <script type="text/javascript">
        window.location = "/dashboard";
    </script>
@endif

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add SOE budget allocation</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Add SOE budget allocation</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        @php
            $user = auth()->user();
        @endphp
        <div class="container-fluid">
            @if ($errors->any())
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="col-lg-6 alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </div>
                </div>
            @endif
            <section class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- /.card-header -->
                        <!-- form start -->
						<div class="card">
                        <form id="soeBudgteAllocationForm" action="{{ route('soe-budget-allocation.store') }}"
                            method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    @if (auth()->user())
                                        @if (auth()->user()->role_id == '1')
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="department_id">Department*</label>
                                                    <select name="department_id" id="department_id" class="form-control">
                                                        <option value="">--- Select Department ---</option>
                                                        @if (isset($departmentlist))
                                                            @foreach ($departmentlist as $department)
                                                                <option value={{ $department->id }}>
                                                                    {{ $department->department_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="department_id">Department*</label>
                                                    <select name="department_id" id="department_id" class="form-control"
                                                        disabled value={{ $user->department_id }}>
                                                        <option value={{ $user->department_id }}>
                                                            {{ $user->department->department_name }}</option>
                                                    </select>
                                                    <select name="department_id" id="department_id" class="form-control"
                                                        hidden value={{ $user->department_id }}>
                                                        <option value={{ $user->department_id }}>
                                                            {{ $user->department->department_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="majorhead_id">Majorhead*</label>
                                            <select name="majorhead_id" id="majorhead_id" class="form-control">
                                                <option value="">---Select Majorhead---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="scheme_id">Scheme name*</label>
                                            <select name="scheme_id" id="scheme_id" class="form-control">
                                                <option value="">---Select Scheme---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="soe_id">SOE name*</label>
                                            <select name="soe_id" id="soe_id" class="form-control">
                                                <option value="">---Select SOE---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="fin_year_id">Fin year*</label>
                                           <select name="fin_year_id" id="fin_year_id" class="form-control" disabled>
                                                <option value="">---Select Fin year---</option>
                                                @if (isset($finyearlist))
                                                    @foreach ($finyearlist as $year)
                                                            <option value={{$year->id}} @if(Session::get('finyear')==$year->id) selected @endif>{{$year->finyear}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                             <input type="hidden" id="fin_year_id" name="fin_year_id" value="{{Session::get('finyear')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="earmarked">Earmarked*</label>
                                            <select name="earmarked" id="earmarked" class="form-control">
                                                <option value="">---Select Earmarked---</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="plan_id">Type of Budget*</label>
                                            <select name="plan_id" id="plan_id" class="form-control">
                                                <option value="">---Select Plan---</option>
                                                @if (isset($planlist))
                                                    @foreach ($planlist as $plan)
                                                        <option value={{ $plan->id }}>{{ $plan->plan_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="service_id">Service name*</label>
                                            <select name="service_id" id="service_id" class="form-control">
                                                <option value="">---Select Service---</option>
                                                @if (isset($servicelist))
                                                    @foreach ($servicelist as $service)
                                                        <option value={{ $service->id }}>{{ $service->service_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="sector_id">Sector name*</label>
                                            <select name="sector_id" id="sector_id" class="form-control">
                                                <option value="">---Select Sector---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="subsector_id">Sub sector name*</label>
                                            <select name="subsector_id" id="subsector_id" class="form-control">
                                                <option value="">---Select Sub sector---</option>
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="hod_outlay">HOD Outlay (Rs. in Lakh)*</label>
                                            <input type="number" start="1" step="0.01" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                class="form-control" id="hod_outlay" name="hod_outlay"
                                                placeholder="Enter HOD outlay">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="district_outlay">District Outlay (Rs. in Lakh)*</label>
                                            <input type="number" start="1" step="0.01" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                class="form-control" id="district_outlay" name="district_outlay"
                                                placeholder="Enter District outlay">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="outlay">Outlay (Rs. in Lakh)*</label>
                                            <input type="number" start="1" step="0.01" min="0"
                                                class="form-control" id="outlayHidden" name="outlayHidden" disabled>
                                            <input type="hidden" id="outlay" name="outlay">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
							<div class="card-footer">
                                <input type="hidden" id="department_sector_id">
								<button type="submit" class="btn btn-success">Add</button>
							</div>
                        </form>
                    </div>
					</div>
                </div>
            </section>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
$(document).ready(function () {
    // Initially disable the service select box
    $("#service_id").attr('disabled', 'disabled');

    // Reset the dropdown and automatically select the first valid option
    function resetAndSelectFirst(dropdown) {
        dropdown.html('<option value="">---Select---</option>');
        dropdown.val(dropdown.find('option:not([value=""])').first().val());
    }

    // Handle change event for Department dropdown
    $("#department_id").change(function () {
        var department_id = $(this).val();

        // Make an AJAX call to fetch Majorhead options
        $.ajax({
            url: "{{ route('get_allocation_majorhead_by_department') }}?department_id=" + department_id,
            method: 'GET',
            success: function (data) {
                var majorheadDropdown = $('#majorhead_id');
                if (data.majorheadHtml.trim() === '') {
                    resetAndSelectFirst(majorheadDropdown);
                } else {
                    majorheadDropdown.html(data.majorheadHtml);
                    majorheadDropdown.val(majorheadDropdown.find('option:not([value=""])').first().val());
                }

                // Clear and reset dependent dropdowns (Scheme and SOE)
                resetAndSelectFirst($('#scheme_id'));
                resetAndSelectFirst($('#soe_id'));

                // Enable the service select box
                $("#service_id").removeAttr('disabled');

                // Trigger the change event for Majorhead to continue the chain
                majorheadDropdown.change();
            }
        });
    });
    $(document).ready(function () {
    // Function to calculate the Outlay
    function calculateOutlay() {
        // Get values from HOD Outlay and District Outlay fields
        var hodOutlay = parseFloat($("#hod_outlay").val()) || 0; // Default to 0 if NaN
        var districtOutlay = parseFloat($("#district_outlay").val()) || 0; // Default to 0 if NaN
        
        // Calculate the total Outlay
        var totalOutlay = hodOutlay + districtOutlay;
        
        // Set the result in the Outlay field
        $("#outlayHidden").val(totalOutlay.toFixed(2)); // Display result in hidden field
        $("#outlay").val(totalOutlay.toFixed(2)); // Set value in hidden input field
    }

    // Event listener for changes in HOD Outlay or District Outlay fields
    $("#hod_outlay, #district_outlay").on("input", function () {
        calculateOutlay(); // Recalculate whenever values change
    });

    // Optionally, call calculateOutlay initially to ensure the Outlay field is updated if there are any pre-filled values
    calculateOutlay();
});


    // Handle change event for Majorhead dropdown
    $("#majorhead_id").change(function () {
        var majorhead_id = $(this).val();

        // Fetch Scheme options
        $.ajax({
            url: "{{ route('get_allocation_scheme_by_majorhead') }}?majorhead_id=" + majorhead_id,
            method: 'GET',
            success: function (data) {
                var schemeDropdown = $('#scheme_id');
                if (data.schemeHtml.trim() === '') {
                    resetAndSelectFirst(schemeDropdown);
                } else {
                    schemeDropdown.html(data.schemeHtml);
                    schemeDropdown.val(schemeDropdown.find('option:not([value=""])').first().val());
                }

                // Reset SOE dropdown
                resetAndSelectFirst($('#soe_id'));

                // Trigger the change event for Scheme to continue the chain
                schemeDropdown.change();
            }
        });
    });

    // Handle change event for Scheme dropdown
    $("#scheme_id").change(function () {
        var scheme_id = $(this).val();

        // Fetch SOE options
        $.ajax({
            url: "{{ route('get_allocation_soe_by_scheme') }}?scheme_id=" + scheme_id,
            method: 'GET',
            success: function (data) {
                var soeDropdown = $('#soe_id');
                if (data.soeHtml.trim() === '') {
                    resetAndSelectFirst(soeDropdown);
                } else {
                    soeDropdown.html(data.soeHtml);
                    soeDropdown.val(soeDropdown.find('option:not([value=""])').first().val());
                }
            }
        });
    });

    // Handle change event for Service dropdown
    $("#service_id").change(function () {
        $.ajax({
            url: "{{ route('get_allocation_sector_by_service') }}",
            method: 'GET',
            data: {
                service_id: $(this).val(),
                department_id: $('#department_id').val() // Pass the department ID to fetch sector data
            },
            success: function (data) {
                $('#sector_id').html(data.sectorhtml);
                $('#subsector_id').html(data.subsectorhtml);
            }
        });
    });

    // Handle change event for Sector dropdown
    $("#sector_id").change(function () {
        $.ajax({
            url: "{{ route('get_allocation_subsector_by_sector') }}?sector_id=" + $(this).val(),
            method: 'GET',
            success: function (data) {
                $('#subsector_id').html(data.subsectorhtml);
            }
        });
    });

    // Automatically trigger department change on page load to apply changes
    $("#department_id").change();
});

    </script>
@endsection
