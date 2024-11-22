@extends('layout.master')

@section('content')
<style type="text/css">
    input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<style>
    .ms-table-section { display: none; }
    .ms-table-active { display: table-row-group; }
    .ms-table-heading { display: table-row; }
    .ms-table-hidden-heading { display: none; }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
    .btn-container {
        /* text-align: right; */
        margin-top: 10px;
    }
    .btn-cntnr-inner {
    display: flex;
    justify-content: space-between;
    }
    .btn-container button {
        margin-left: 10px;
    }
    .table-nxt-prv{
        display: none;
    }
    .show-btn{
        display: block;
    }
</style>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add SOE budget distribution</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item ms-table-active">Add SOE budget distribution</li>
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
                        <form id="soeBudgteDistributionForm" action="{{ route('soe-budget-distribution.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    @if (auth()->user())
                                        @if (auth()->user()->role_id == '1')
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="department_id">Department</label>
                                                    <select name="department_id" id="department_id" class="form-control">
                                                        <option value="">---Select Department---</option>
                                                        @if (isset($departmentlist))
                                                            @foreach ($departmentlist as $department)
                                                                <option value={{$department->id}}>{{$department->department_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="department_id">Department</label>
                                                    <select name="department_id" id="department_id" class="form-control" disabled
                                                        value={{ $user->department_id }}>
                                                        <option value={{ $user->department_id }}>
                                                            {{ $user->department->department_name }}</option>
                                                    </select>
                                                    <select name="department_id" id="department_id" class="form-control" hidden
                                                        value={{ $user->department_id }}>
                                                        <option value={{ $user->department_id }}>
                                                            {{ $user->department->department_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="majorhead_id">Majorhead</label>
                                            <select name="majorhead_id" id="majorhead_id" class="form-control">
                                                <option value="">---Select majorhead---</option>
                                            </select>
                                        </div>
                                    </div>

                                     <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="scheme_id">Scheme</label>
                                            <select name="scheme_id" id="scheme_id" class="form-control">
                                                <option value="">---Select scheme---</option>
                                            </select>
                                        </div>
                                    </div>
									
									 <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="soe_id">SOE</label>
                                            <select name="soe_id" id="soe_id" class="form-control">
                                                <option value="">---Select SOE---</option>
                                            </select>
                                        </div>
                                    </div>
									
									  <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="fin_year_id">Fin year</label>
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
                                            <label for="type">Type of Budget</label>
                                            <select name="plan_id" id="plan_id_disabled" class="form-control" disabled>
                                                <option value="">---Select Type of Budget---</option>
                                                @if (isset($planlist))
                                                    @foreach ($planlist as $plan)
                                                        <option value={{$plan->id}}>{{$plan->plan_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <input type="hidden" id="plan_id" name="plan_id">
                                        </div>
                                    </div>
                                     <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select name="type" id="type" class="form-control">
                                                    <option value="">---Select Type---</option>
                                                    <option value="1">Automatic</option>
                                                    <option value="2">Manual</option>
                                            </select>
                                       
                               


                                        </div>
                                    </div>
                                     <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="type">Current Quarter of Year </label>
                                            <input type="text" class="form-control" value="{{ $currentquarter }}" disabled>
                                        </div>
                                    </div>
                                     
									
									
                                </div>

                                <div class="row"> 
                             
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <table id="Undistributed_outlay_tbl" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><h6>Undistributed Outlay (in Lakh.)</h6></th>
                                                        <th>
                                                            <h6 id="undistributed_outlay_label" name="undistributed_outlay_label"></h6>
                                                            <input type="hidden" name="undistributed_outlay_label" id="undistributed_outlay_label_hidden"/>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th><h6>Total Outlay (in Lakh.)</h6></th>
                                                        <th>
                                                            <h6 id="total_outlay_label" name="total_outlay_label"></h6>
                                                            <input type="hidden" name="total_outlay_label" id="total_outlay_label_hidden"/>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                                                    
                                </div>
                                <div class="row"> 
                                    
                                    <div class="col-lg-12">
                                        <div class="form-group table-responsive">
                                            <table class="table table-bordered" name="district_outlay_tbl" id="district_outlay_tbl">
                                                <thead>
                                                    <tr class="ms-table-heading">
                                                        <th rowspan="2">District</th>
                                                        <th colspan="3" class="financial">Financial</th>
                                                        <th colspan="5" class="physical">Physical Achievement</th>
                                                        <th colspan="3" class="beneficiaries">Beneficiaries</th>
                                                    </tr>
                                                    <tr class="ms-table-heading">
                                                        <th class="financial">Outlay</th>
                                                        <th class="financial">Expenditure</th>
                                                        <th class="financial">Percentage (%)</th>
                                                        <th class="physical">Item Name</th>
                                                        <th class="physical">Unit Of Measure</th>
                                                        <th class="physical">Unit</th>
                                                        <th class="physical">Achievement</th>
                                                        <th class="physical">Percentage (%)</th>
                                                        <th class="beneficiaries">Total</th>
                                                        <th class="beneficiaries">Women (Out of Total)</th>
                                                        <th class="beneficiaries">Disable (Out of total)</th>
                                                    </tr>
                                                </thead>
                                                <tbody name="outlayarr" id="financial" class="ms-table-section">
                                                    <!-- Financial section content -->
                                                    @if (isset($districtlist))
                                                        @foreach ($districtlist as $i => $district)
                                                        <tr>
                                                            <td>{{$district->district_name}}</td>
                                                            <td>
                                                                <input required type="number" start="1" step="0.01" min="0" class="form-control trigger outlayamt" 
                                                                name="outlay[{{$district->id}}]" id="outlay{{$district->id}}" value="0" placeholder="Enter outlay">
                                                                <input required type="hidden" name="revised_outlay[{{$district->id}}]" id="revised_outlay{{$district->id}}" value="0">
                                                            </td>
                                                            <td>
                                                                <input type="number" start="1" step="0.01" min="0" class="form-control" 
                                                                name="expenditure[{{$district->id}}]" id="expenditure{{$district->id}}" value="0" placeholder="Enter expenditure" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="number" start="1" step="0.01" min="0" class="form-control" 
                                                                name="opercentage[{{$district->id}}]" id="opercentage{{$district->id}}" value="0" placeholder="Enter percentage" readonly>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                                <tbody name="outlayarr" id="physical" class="ms-table-section">
                                                    <!-- Physical Achievement section content -->
                                                    @if (isset($districtlist))
                                                        @foreach ($districtlist as $i => $district)
                                                        <tr>
                                                            <td>{{$district->district_name}}</td>
                                                            <td>
                                                                <input type="text" start="1" step="0.01" min="0" class="form-control" 
                                                                name="item_name[{{$district->id}}]" id="item_name{{$district->id}}" placeholder="Enter item name" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" start="1" step="0.01" min="0" class="form-control" 
                                                                name="unit_measure[{{$district->id}}]" id="unit_measure{{$district->id}}" placeholder="Enter unit of measure" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="number" start="1" step="0.01" min="0" class="form-control" 
                                                                name="unit[{{$district->id}}]" id="unit{{$district->id}}" value="0" placeholder="Enter unit" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="number" start="1" step="0.01" min="0" class="form-control" 
                                                                name="achievement[{{$district->id}}]" id="achievement{{$district->id}}" value="0" placeholder="Enter achievement" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="number" start="1" step="0.01" min="0" class="form-control" 
                                                                name="upercentage[{{$district->id}}]" id="upercentage{{$district->id}}" value="0" placeholder="Enter percentage" readonly>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                                <tbody name="outlayarr" id="beneficiaries" class="ms-table-section">
                                                    <!-- Beneficiaries section content -->
                                                    @if (isset($districtlist))
                                                        @foreach ($districtlist as $i => $district)
                                                        <tr>
                                                            <td>{{$district->district_name}}</td>
                                                            <td>
                                                                <input type="number" class="form-control" 
                                                                name="ben_total[{{$district->id}}]" id="ben_total{{$district->id}}" value="0" placeholder="Enter total" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="number" start="1" class="form-control" 
                                                                name="women[{{$district->id}}]" id="women{{$district->id}}" value="0" placeholder="Enter women" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control" 
                                                                name="disable[{{$district->id}}]" id="disable{{$district->id}}" value="0" placeholder="Enter disable" readonly>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            
                                
                                            <!-- Previous and Next buttons -->
                                            <div class="btn-container table-nxt-prv" id="table-nxt-prv">
                                                <div class="btn-cntnr-inner">
                                                <div>
                                                    <button type="button" class="btn btn-success" id="prevBtn" onclick="navigateSection(-1)" style="display: none;">Previous</button>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-success" id="nextBtn" onclick="navigateSection(1)">Next</button>
                                                </div>
                                            </div>     
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>                                
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
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
<script>
    document.getElementById('type').addEventListener('change', function() {
        var selectedType = this.value;
        var contentDiv = document.getElementById('table-nxt-prv');

                                         
        // Add the appropriate highlight class based on the selected type
        if (selectedType === '1') {
            contentDiv.classList.add('show-btn');
        } else if (selectedType === '2') {
            contentDiv.classList.add('show-btn');
        } else{
            contentDiv.classList.remove('show-btn');
        }
    });
</script>
<script>
    let currentSectionIndex = 0;
    const sections = ['financial', 'physical', 'beneficiaries'];

    function showSection(sectionId) {
        // Hide all sections
        document.querySelectorAll('.ms-table-section').forEach(section => {
            section.style.display = 'none';
        });

        // Hide all headings except District
        document.querySelectorAll('.ms-table-heading th').forEach(heading => {
            if (heading.textContent !== 'District') {
                heading.classList.add('ms-table-hidden-heading');
            }
        });

        // Show the selected section
        document.getElementById(sectionId).style.display = 'table-row-group';

        // Show the heading for the selected section
        document.querySelectorAll('.ms-table-heading .' + sectionId).forEach(heading => {
            heading.classList.remove('ms-table-hidden-heading');
        });

        // Update current section index
        currentSectionIndex = sections.indexOf(sectionId);

        // Update button visibility based on section index
        updateButtonVisibility();
    }

    function navigateSection(direction) {
        // Calculate next section index
        currentSectionIndex += direction;
        if (currentSectionIndex < 0) {
            currentSectionIndex = sections.length - 1; // Wrap around to last section
        } else if (currentSectionIndex >= sections.length) {
            currentSectionIndex = 0; // Wrap around to first section
        }

        // Show the corresponding section
        showSection(sections[currentSectionIndex]);
    }

    function updateButtonVisibility() {
        // Show or hide Previous and Next buttons based on currentSectionIndex
        if (currentSectionIndex === 0) {
            document.getElementById('prevBtn').style.display = 'none';
        } else {
            document.getElementById('prevBtn').style.display = 'inline-block';
        }

        if (currentSectionIndex === sections.length - 1) {
            document.getElementById('nextBtn').style.display = 'none';
        } else {
            document.getElementById('nextBtn').style.display = 'inline-block';
        }
    }

    // Initialize with the first section visible
    document.addEventListener('DOMContentLoaded', (event) => {
        showSection('financial');
        updateButtonVisibility(); // Initial button visibility setup
    });
</script>

    <script type="text/javascript">
        $(document).ready(function(){
    // Initialize page
    function initializePage() {
        $("#plan_id").val("");
        $("#plan_id_disabled").val("");
        $("#district_outlay_tbl").hide();
        $("#Undistributed_outlay_tbl").hide();
        var department_id = $("#department_id").val();
        if(department_id > 0){
            fetchMajorHeadAndScheme(department_id);
        }
    }

    // Fetch Major Head and Scheme
    function fetchMajorHeadAndScheme(department_id) {
        $.ajax({
            url: "{{ route('get_distribution_majorhead_by_department') }}?department_id=" + department_id,
            method: 'GET',
            success: function(data) {
                $('#majorhead_id').html(data.majorheadHtml);
                $('#scheme_id').html(data.schemeHtml);
                $('#soe_id').html(data.soeHtml);

                var majorhead_id = $("#majorhead_id").val();
                if(majorhead_id > 0){
                    fetchSchemeByMajorHead(majorhead_id);
                }
            }
        });
    }

    // Fetch Scheme by Major Head
    function fetchSchemeByMajorHead(majorhead_id) {
        $.ajax({
            url: "{{ route('get_distribution_scheme_by_majorhead') }}?majorhead_id=" + majorhead_id,
            method: 'GET',
            success: function(data) {
                $('#scheme_id').html(data.schemeHtml);
                $('#soe_id').html(data.soeHtml);

                var scheme_id = $("#scheme_id").val();
                if(scheme_id > 0){
                    fetchSoeByScheme(scheme_id);
                }
            }
        });
    }

    // Fetch SOE by Scheme
    function fetchSoeByScheme(scheme_id) {
        var department_id = $("#department_id").val();
        var majorhead_id = $("#majorhead_id").val();
        $.ajax({
            url: "{{ route('get_distribution_soe_by_scheme') }}?scheme_id=" + scheme_id + '&department_id=' + department_id + '&majorhead_id=' + majorhead_id,
            method: 'GET',
            success: function(data) {
                $('#soe_id').html(data.soeHtml);

                var soe_id = $("#soe_id").val();
                if(soe_id > 0){
                    fetchUndistributedOutlay(soe_id);
                }
            }
        });
    }

    // Fetch Undistributed Outlay
    function fetchUndistributedOutlay(soe_id) {
        var department_id = $("#department_id").val();
        var majorhead_id = $("#majorhead_id").val();
        var scheme_id = $("#scheme_id").val();
        var fin_year_id = $("#fin_year_id").val();

        if(department_id > 0 && majorhead_id > 0 && scheme_id > 0 && soe_id > 0 && fin_year_id > 0){
            $.ajax({
                url: "{{ route('get_soe_undistributed_outlay') }}?department_id=" + department_id + "&majorhead_id=" + majorhead_id + "&scheme_id=" + scheme_id + "&soe_id=" + soe_id + "&fin_year_id=" + fin_year_id,
                method: 'GET',
                success: function(data) {
                    if(data.totaloutlay == 0 && data.undistributed_outlay == 0){
                        $("#Undistributed_outlay_tbl").show();
                        $("#undistributed_outlay").val(data.undistributed_outlay);
                        $("#undistributed_outlay_label").html(data.undistributed_outlay);
                        $("#total_outlay_label").html(data.totaloutlay);
                        $("#undistributed_outlay_label_hidden").val(data.undistributed_outlay);
                        $("#total_outlay_label_hidden").val(data.totaloutlay);
                    } else if(data.distribute_outlay){
                        $('#type').val(2);
                        $("#district_outlay_tbl").show();
                        $("#Undistributed_outlay_tbl").show();
                        $("#undistributed_outlay").val(data.undistributed_outlay);
                        $("#undistributed_outlay_label").html(data.undistributed_outlay/100000);
                        $("#total_outlay_label").html(data.totaloutlay/100000);
                        $("#undistributed_outlay_label_hidden").val(data.undistributed_outlay/100000);
                        $("#total_outlay_label_hidden").val(data.totaloutlay/100000);
                        $("#plan_id").val(data.plan_id);
                        $("#plan_id_disabled").val(data.plan_id);
                        for (var i = 0; i < data.distribute_outlay.length; i++) {
                            $('#'+data.distribute_outlay[i]['district_id']).val(data.distribute_outlay[i]['outlay']/100000);
                            $('#'+data.distribute_outlay[i]['district_id']).prop('disabled', true);
                        }
                    } else {
                        $("#Undistributed_outlay_tbl").show();
                        $("#undistributed_outlay").val(data.undistributed_outlay);
                        $("#undistributed_outlay_label").html(data.undistributed_outlay/100000);
                        $("#total_outlay_label").html(data.totaloutlay/100000);
                        $("#undistributed_outlay_label_hidden").val(data.undistributed_outlay/100000);
                        $("#total_outlay_label_hidden").val(data.totaloutlay/100000);
                        $("#plan_id").val(data.plan_id);
                        $("#plan_id_disabled").val(data.plan_id);
                    }
                }
            });
        }
    }

    // Initialize page when document is ready
    initializePage();

    // Bind events
    $("#department_id").change(function(){
        $("#plan_id").val("");
        $("#plan_id_disabled").val("");
        $("#district_outlay_tbl").hide();
        $("#Undistributed_outlay_tbl").hide();
        fetchMajorHeadAndScheme($(this).val());
    });

    $("#majorhead_id").change(function(){
        $("#plan_id").val("");
        $("#plan_id_disabled").val("");
        $("#district_outlay_tbl").hide();
        $("#Undistributed_outlay_tbl").hide();
        fetchSchemeByMajorHead($(this).val());
    });

    $("#scheme_id").change(function(){
        var department_id = $("#department_id").val();
        var majorhead_id = $("#majorhead_id").val();
        $("#plan_id").val("");
        $("#plan_id_disabled").val("");
        $("#district_outlay_tbl").hide();
        $("#Undistributed_outlay_tbl").hide();
        fetchSoeByScheme($(this).val());
    });

    $("#soe_id").change(function(){
        fetchUndistributedOutlay($(this).val());
    });

    $("#fin_year_id").change(function(){
        fetchUndistributedOutlay($("#soe_id").val());
    });

    $("#type").change(function(){
        var type = $(this).val();

        if (type == 2) {
            $("input").remove(".hidden");
            $("input[dist_name^='district_']").val(0).prop('disabled', false);
            $("#district_outlay_tbl").show();
            fetchUndistributedOutlay($("#soe_id").val());
        } else if(type == 1){
            $("#district_outlay_tbl").show();
            var undist_amount = $("#undistributed_outlay_label_hidden").val();
            $.ajax({
                url: "{{ route('get_districtPercentage') }}",
                method: 'GET',
                success: function(data) {
                    var district_name = "";
                    for (var i = 0; i < data.districtpercentagelist.length; i++) {
                        var amount = (undist_amount * data.districtpercentagelist[i]['percentage']) / 100;
                        amount = amount.toFixed(2);
                        $('#outlay'+data.districtpercentagelist[i]['district_id']).val(amount);
                        for (var j = 0; j < data.districtlist.length; j++) {
                            if(data.districtlist[j]['id'] == data.districtpercentagelist[i]['district_id']){
                                district_name = data.districtlist[j]['district_name'];
                            }
                        }
                        $("<input type='hidden' />").attr("class", "hidden").attr("name", district_name).attr("value", amount).appendTo('#'+data.districtpercentagelist[i]['district_id']);
                    }
                    distributed_outlay_amount();
                }
            });
        } else {
            $("#district_outlay_tbl").hide();
        }
        distributed_outlay_amount();
    });

    $('input.trigger').focusout(function(){
        var input = $(this);
        if(input.val() === ''){
            input.val(0);
        }
        if(parseFloat(input.val()) > parseFloat($("#undistributed_outlay_label_hidden").val())){
            alert('Undistributed Outlay Exceeds Total Outlay, Please Enter Correct Outlay');
            input.val(0);
        }
        distributed_outlay_amount();
    });

    function distributed_outlay_amount(){
        var distributed_outlay = 0;
        $(".outlayamt").each(function(){
            distributed_outlay += parseInt($(this).val());
        });
        var undistributed_amount = $('#total_outlay_label').html() - distributed_outlay;
        $("#undistributed_outlay_label").html(undistributed_amount);
        $("#undistributed_outlay_label_hidden").val(undistributed_amount);
    }
});

    </script>
@endsection