@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Scheme wise NDB(Non Development Budget)</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Scheme wise NDB(Non Development Budget)</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 float-sm-right">

                    @if (session()->has('success'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        </div>
                    @endif

                    @if (session()->has('update'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                            <div class="alert alert-success">
                                {{ session()->get('update') }}
                            </div>
                        </div>
                    @endif

                    @if (session()->has('delete'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                            <div class="alert alert-danger">
                                {{ session()->get('delete') }}
                            </div>
                        </div>
                    @endif
                    @if (session()->has('alert'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 8000)" x-show="show">
                        <div class="alert alert-warning">
                            {{ session()->get('alert') }}
                        </div>
                    </div>
                @endif
                    <div class="card">
                        <div class="card-header">
                            <form action="{{ route('export-scheme-wise-non-db') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="quarter">Quarter</label>
                                            <select name="quarter" id="quarter" class="form-control change">
                                                <option value="0">---Select Quarter---</option>
                                                <option value="1">First Quarter</option>
                                                <option value="2">Second Quarter</option>
                                                <option value="3">Third Quarter</option>
                                                <option value="4">Fourth Quarter</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="department">Department</label>
                                            <select name="department" id="department" class="form-control change">
                                                <option value="">---Select Department---</option>
                                                @foreach($department as $key => $value)
                                                    <option value="{{$value->id}}">{{$value->department_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="majorhead_id">Majorhead</label>
                                            <select name="majorhead_id" id="majorhead" class="form-control">
                                                <option value="">---Select Majorhead---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="scheme_id">Scheme name</label>
                                            <select name="scheme_id" id="scheme" class="form-control">
                                                <option value="">---Select Scheme---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="soe_id">SOE name</label>
                                            <select name="soe_id" id="soe" class="form-control">
                                                <option value="">---Select SOE---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="sector_id">District</label>
                                            <select name="district_id" id="district_id" class="form-control">
                                                <option value="">--- Select District ---</option>
                                                    @if (isset($districtList))
                                                        @foreach ($districtList as $district)
                                                                <option value={{$district->id}}>{{$district->district_name}}</option>
                                                        @endforeach
                                                    @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="quarter" style="color: transparent;">Filter</label>
                                            <a href="#" id="filter" class="form-control btn btn-success btn-right"> Filter </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input type="hidden" name="plan_id" id="plan_id" value="{{$plan_id}}">
                                            <label for="quarter" style="color: transparent;">Export</label>
                                            <button type="submit" id="export" class="form-control btn btn-success btn-right">
												<i class="fas fa-file-download"></i>&nbsp; Export </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
							<div class="table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="5" style="text-align: center">
                                            Department/Scheme wise  Non Development Budget & Expenditure  under Scheduled Castes Development Programme of the year 2022-23 (Rs. In Lakhs)
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>MAJ/SM/MIN/SMIN/BUD</th>
                                        <th>Sector/ Department/ Scheme/SOE</th>
                                        <th>Outlay for 2022-23</th>
                                        <th>Revised Outlay (Rs. in Lakh)</th>
                                        <th>Expenditure 31-03-2023</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @php
                                        $grand_dep_outley = [];
                                        $grand_revised_outley = [];
                                        $grand_exp_revised_outley = [];
                                    @endphp
                                    @foreach($department as $key => $value)
                                        @php
                                            $dep_outley = [];
                                            $revised_outley = [];
                                            $exp_revised_outley = [];
                                        @endphp
                                        <tr>
                                            <td></td>
                                            <th>{{$key + 1}}. {{$value->department_name}}</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @foreach(App\Models\Majorhead::where('department_id',$value->id)->get() as $headkey => $headvalue)
                                            
                                            @foreach(App\Models\Scheme_master::where('majorhead_id',$headvalue->id)->get() as $schemekey => $schemevalue)
                                                @php
                                                    $outley_soe = [];
                                                    $revised_outley_soe = [];
                                                    $exp_revised_outley_soe = [];
                                                @endphp
                                                <tr>
                                                    <td> {{ $headvalue->complete_head }} </td>
                                                    <td> {{ $schemevalue->scheme_name }} </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @foreach(App\Models\Soe_master::where('scheme_id',$schemevalue->id)->get() as $soekey => $soevalue)
                                                    <tr>
                                                        <td></td>
                                                        <td> {{ $soevalue->soe_name }} </td>
                                                        @php
                                                            $soe_outlay = App\Models\Soe_budget_allocation::where('plan_id',$plan_id)->where('soe_id',$soevalue->id)->pluck('outlay')->toArray();
                                                            $soe_revised_outlay = App\Models\Soe_budget_distribution::where('soe_id',$soevalue->id)->get();
                                                            $arr = [];
                                                            $exp_arr = [];
                                                            foreach($soe_revised_outlay as $soe_revised_outlay_key => $soe_revised_outlay_value)
                                                            {
                                                                if($soe_revised_outlay_value->q_1_data)
                                                                {
                                                                    $decode1 = json_decode($soe_revised_outlay_value->q_1_data);
                                                                    $count1 = count($decode1) - 1;
                                                                    if($decode1[$count1]->resvised_outlay)
                                                                    {
                                                                        array_push($arr, array_sum(get_object_vars(($decode1[$count1]->resvised_outlay))));
                                                                    }
                                                                    if($decode1[$count1]->expenditure)
                                                                    {
                                                                        array_push($exp_arr, array_sum(get_object_vars(($decode1[$count1]->expenditure))));
                                                                    }
                                                                }
                                                                if($soe_revised_outlay_value->q_2_data)
                                                                {
                                                                    $decode2 = json_decode($soe_revised_outlay_value->q_2_data);
                                                                    $count2 = count($decode2) - 1;
                                                                    if($decode2[$count2]->resvised_outlay)
                                                                    {
                                                                        array_push($arr, array_sum(get_object_vars(($decode2[$count2]->resvised_outlay))));
                                                                    }
                                                                    if($decode2[$count2]->expenditure)
                                                                    {
                                                                        array_push($exp_arr, array_sum(get_object_vars(($decode2[$count2]->expenditure))));
                                                                    }
                                                                }
                                                                if($soe_revised_outlay_value->q_3_data)
                                                                {
                                                                    $decode3 = json_decode($soe_revised_outlay_value->q_3_data);
                                                                    $count3 = count($decode3) - 1;
                                                                    if($decode3[$count3]->resvised_outlay)
                                                                    {
                                                                        array_push($arr, array_sum(get_object_vars(($decode3[$count3]->resvised_outlay))));
                                                                    }
                                                                    if($decode3[$count3]->expenditure)
                                                                    {
                                                                        array_push($exp_arr, array_sum(get_object_vars(($decode3[$count3]->expenditure))));
                                                                    }
                                                                }
                                                                if($soe_revised_outlay_value->q_4_data)
                                                                {
                                                                    $decode4 = json_decode($soe_revised_outlay_value->q_4_data);
                                                                    $count4 = count($decode4) - 1;
                                                                    if($decode4[$count4]->resvised_outlay)
                                                                    {
                                                                        array_push($arr, array_sum(get_object_vars(($decode4[$count4]->resvised_outlay))));
                                                                    }
                                                                    if($decode4[$count4]->expenditure)
                                                                    {
                                                                        array_push($exp_arr, array_sum(get_object_vars(($decode4[$count4]->expenditure))));
                                                                    }
                                                                }
                                                            }
                                                            array_push($outley_soe , array_sum($soe_outlay));
                                                            array_push($revised_outley_soe , array_sum($arr));
                                                            array_push($exp_revised_outley_soe , array_sum($exp_arr));
                                                        @endphp
                                                        <td class="change_numaric"> {{ number_format(array_sum($soe_outlay)) }} </td>
                                                        <td class="change_numaric"> {{ number_format(array_sum($arr)) }} </td>
                                                        <td class="change_numaric"> {{ number_format(array_sum($exp_arr)) }} </td>
                                                    </tr>
                                                @endforeach
                                                @php
                                                    array_push($dep_outley , array_sum($outley_soe));
                                                    array_push($revised_outley , array_sum($revised_outley_soe));
                                                    array_push($exp_revised_outley , array_sum($exp_revised_outley_soe));
                                                @endphp
                                                <tr>
                                                    <td></td>
                                                    <th> Total: {{ $schemevalue->scheme_name }} </th>
                                                    <th class="change_numaric"> {{ number_format(array_sum($outley_soe)) }} </th>
                                                    <th class="change_numaric"> {{ number_format(array_sum($revised_outley_soe)) }} </th>
                                                    <th class="change_numaric"> {{ number_format(array_sum($exp_revised_outley_soe)) }} </th>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        @php
                                            array_push($grand_dep_outley , array_sum($dep_outley));
                                            array_push($grand_revised_outley , array_sum($revised_outley));
                                            array_push($grand_exp_revised_outley , array_sum($exp_revised_outley));
                                        @endphp
                                        <tr>
                                            <th></th>
                                            <th> <b>{{ $value->department_name }} TOTAL: </b> </th>
                                            <th class="change_numaric"> <b>{{ number_format(array_sum($dep_outley)) }}</b> </th>
                                            <th class="change_numaric"> <b>{{ number_format(array_sum($revised_outley)) }}</b> </th>
                                            <th class="change_numaric"> <b>{{ number_format(array_sum($exp_revised_outley)) }}</b> </th>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th></th>
                                        <th>GRAND TOTAL</th>
                                        <th class="change_numaric"> <b>{{ number_format(array_sum($grand_dep_outley)) }}</b> </th>
                                        <th class="change_numaric"> <b>{{ number_format(array_sum($grand_revised_outley)) }}</b> </th>
                                        <th class="change_numaric"> <b>{{ number_format(array_sum($grand_exp_revised_outley)) }}</b> </th>
                                    </tr>
                                </tbody>
                            </table>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">

        $("#filter").click(function(){
            var qut_id = $("#quarter").val();
            var dep_id = $("#department").val();
            var marjor_id = $("#majorhead").val();
            var scheme_id = $("#scheme").val();
            var soe_id = $("#soe").val();
            var plan_id = <?php echo $plan_id; ?>;
            var district_id = $("#district_id").val();
            var url = "{{ route('get.scheme.wise.non.db.data') }}";
            url = url.replace(':id', dep_id);
            $.ajax({
                url: url,
                data: {
                    qut_id: qut_id,
                    dep_id: dep_id,
                    marjor_id: marjor_id,
                    scheme_id: scheme_id,
                    soe_id: soe_id,
                    plan_id: plan_id,
                    district_id: district_id
                },
                method: 'GET',
                success: function(data) {
                    $('#tbody').html(data);
                }
            });
        });

        $("#department").change(function() {
            var department_sector_id = $(this).val();
            $.ajax({
                url: "{{ route('get_allocation_majorhead_by_department') }}?department_id=" + $(this)
                    .val(),
                method: 'GET',
                success: function(data) {
                    $('#majorhead').html(data.majorheadHtml);
                    $('#scheme').html(data.schemeHtml);
                    $('#soe').html(data.soeHtml);
                    $("#service").removeAttr('disabled');
                }
            });
        });

        $("#majorhead").change(function() {
            $.ajax({
                url: "{{ route('get_allocation_scheme_by_majorhead') }}?majorhead_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#scheme').html(data.schemeHtml);
                    $('#soe').html(data.soeHtml);
                }
            });
        });

        $("#scheme").change(function() {
            $.ajax({
                url: "{{ route('get_allocation_soe') }}?scheme_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#soe').html(data.soeHtml);
                }
            });
        });
        

    </script>
@endsection