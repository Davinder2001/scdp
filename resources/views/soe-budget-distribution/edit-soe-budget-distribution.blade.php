@extends('layout.master')

@section('content')
<style type="text/css">
    input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
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
        text-align: right;
        margin-top: 10px;
    }
    .btn-container button {
        margin-left: 10px;
    }
    tr.total-allocation th:first-child {
    display: block !important;
}
div#table-nxt-prv {
    display: flex;
    justify-content: space-between;
}
/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Update SOE budget distribution</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Update SOE budget distribution</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
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
                        <form id="updatesoeBudgteDistributionForm" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                                <div class="row">
                                    @if (auth()->user())
                                        @if (auth()->user()->role_id == '1')
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="department_id">Department</label>
                                                    <select name="department_id" id="department_id_disabled" class="form-control" disabled>
                                                        <option value="">---Select Department---</option>
                                                        @if (isset($departmentlist))
                                                            @foreach ($departmentlist as $department)
                                                                <option value={{$department->id}}>{{$department->department_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <input type="hidden" name="department_id" id="department_id">
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

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="majorhead_id">Majorhead</label>
                                            <select name="majorhead_id" id="majorhead_id_disabled" class="form-control" disabled>
                                                <option value="">---Select Majorhead---</option>
                                            </select>
                                            <input type="hidden" name="majorhead_id" id="majorhead_id">
                                        </div>
                                    </div>

                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <label for="scheme_id">Scheme</label>
                                            <select name="scheme_id" id="scheme_id_disabled" class="form-control" disabled>
                                                <option value="">---Select Scheme---</option>
                                            </select>
                                            <input type="hidden" name="scheme_id" id="scheme_id">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="soe_id">SOE</label>
                                            <select name="soe_id" id="soe_id_disabled" class="form-control" disabled>
                                                <option value="">---Select SOE---</option>
                                            </select>
                                            <input type="hidden" name="soe_id" id="soe_id">
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="fin_year_id">Fin year</label>
                                            <select name="fin_year_id" id="fin_year_id_disabled" class="form-control" disabled>
                                                <option value="">---Select Fin year---</option>
                                                @if (isset($finyearlist))
                                                    @foreach ($finyearlist as $year)
                                                            <option value={{$year->id}}>{{$year->finyear}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <input type="hidden" name="fin_year_id" id="fin_year_id">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="type">Type of Budget</label>
                                            <select name="plan_id" id="plan_id_disabled" class="form-control" disabled>
                                            </select>
                                            <input type="hidden" id="plan_id" name="plan_id">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select name="type" id="type" class="form-control">
                                                    <option value="">---Select Type---</option>
                                                    <option value="1">Automatic</option>
                                                    <option value="2">Manual</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-lg-2">
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
                                                        <th colspan="4" class="financial">Financial</th>
                                                        <th colspan="5" class="physical">Physical Achievement</th>
                                                        <th colspan="3" class="beneficiaries">Beneficiaries</th>
                                                        
                                                    </tr>
                                                    <tr class="ms-table-heading">
                                                        <th></th>
                                                        <th class="financial">Outlay</th>
                                                        <th class="financial">Latest Revised Outlay</th>
                                                        <th class="financial">Expenditure</th>
                                                        <th class="financial">Percentage (%)</th>
                                                        <th class="physical">Item Name</th>
                                                        <th class="physical">Unit Of Measure</th>
                                                        <th class="physical">Unit</th>
                                                        <th class="physical">Achievement</th>
                                                        <th class="physical">Percentage (%)</th>
                                                        <th class="beneficiaries">Total</th>
                                                        <th class="beneficiaries">Women (Out of Total )</th>
                                                        <th class="beneficiaries">Disable (Out of total)</th>
                                                    </tr>
                                                </thead>
                                                <tbody name="outlayarr" id="financial" class="ms-table-section">
                                                    @if (isset($districtlist))
                                                    @php
                                                    // dd($$districtlist); 
                                                    $i = 0;
                                                        $outlay=0;
                                                        $expenditure=0;
                                                        $opercentage=0;
                                                        $unit=0;
                                                       
                                                        $achievement=0;
                                                        $upercentage=0;
                                                        $ben_total=0;
                                                        $women=0;
                                                        $disable=0;
                                                        $resvised_outlay=0;
                                                    @endphp
                                                        @foreach ($districtlist as $i => $district)
                                                        <?php 

                                                        $i=$district->id;

                                                        if(sizeof($districtdata['outlay'])==$i){

                                                            continue;
                                                        }
                                                        ?>
                                                        <tr>
                                                            {{-- Financial Data Table --}}
                                                            <td>{{$district->district_name}}</td>
                                                            <td>
                                                                <?php
                                                                if(!empty($districtdata['outlay'][$i])) {
                                                                    $outlay=$outlay+$districtdata['outlay'][$i];
                                                                    ?>
                                                                        <input required type="number" start="1" step="0.01" min="0"class="form-control trigger outlayamt" 
                                                                        name="outlay[{{$district->id}}]" 
                                                                        id="outlay{{$district->id}}" value="{{$districtdata['outlay'][$i]}}" placeholder="Enter outlay" data-id="{{$district->id}}" <?php if($districtdata['outlay'][$i]!=0 && auth()->user()->role_id != '1'){echo "readonly";}?> readonly>
                                                                        <?php
                                                                } else {
                                                                    ?>
                                                                        <input required type="number" start="1" step="0.01" min="0"class="form-control trigger outlayamt" 
                                                                        name="outlay[{{$district->id}}]" 
                                                                        id="outlay{{$district->id}}" <?php if($districtdata['outlay'][$i]!=0 && auth()->user()->role_id != '1'){echo "readonly";}?> placeholder="Enter outlay" data-id="{{$district->id}}">
                                                                        <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                if(!empty($districtdata['resvised_outlay'][$i])) {
                                                                    $resvised_outlay=$resvised_outlay+$districtdata['resvised_outlay'][$i];
                                                                    ?>
                                                                        <input required type="number" start="1" step="0.01" min="0"class="form-control  resvised_outlayamt" 
                                                                        name="resvised_outlay[{{$district->id}}]" 
                                                                        id="resvised_outlay{{$district->id}}"  placeholder="Enter resvised_outlay" data-id="{{$district->id}}" value="{{$districtdata['resvised_outlay'][$i]}}" <?php if($districtdata['outlay'][$i]!=0 && auth()->user()->role_id != '1'){echo "readonly";}?> readonly>

                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <input required type="number" start="1" step="0.01" min="0"class="form-control  resvised_outlayamt" 
                                                                        name="resvised_outlay[{{$district->id}}]" 
                                                                        id="resvised_outlay{{$district->id}}"  placeholder="Enter resvised_outlay" data-id="{{$district->id}}" <?php if($districtdata['outlay'][$i]!=0 && auth()->user()->role_id != '1'){echo "readonly";}?> readonly>
                                                                        <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if(!empty($districtdata['expenditure'][$i])) {
                                                                    $expenditure=$expenditure+$districtdata['expenditure'][$i];
                                                                    ?>
                                                                        <input required type="number" start="1" step="0.01" min="0"class="form-control  expenditure" 
                                                                        name="expenditure[{{$district->id}}]" 
                                                                        id="expenditure{{$district->id}}" value="{{$districtdata['expenditure'][$i]}}" placeholder="Enter expenditure" data-id="{{$district->id}}">
                                                                        <?php
                                                                } else {
                                                                    ?>
                                                                        <input required type="number" start="1" step="0.01" min="0"class="form-control  expenditure" 
                                                                        name="expenditure[{{$district->id}}]" 
                                                                        id="expenditure{{$district->id}}" value="" placeholder="Enter expenditure" data-id="{{$district->id}}">
                                                                        <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                   
                                                                if(!empty($districtdata['opercentage'][$i])) {
                                                                    $opercentage=$opercentage+$districtdata['opercentage'][$i];
                                                                    ?>
                                                                        <input type="number" start="1" step="0.01" min="0"class="form-control " 
                                                                        name="opercentage[{{$district->id}}]" 
                                                                        id="opercentage{{$district->id}}" value="{{$districtdata['opercentage'][$i]}}" placeholder="Enter outlay" readonly data-id="{{$district->id}}" >

                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <input type="number" start="1" step="0.01" min="0"class="form-control " 
                                                                        name="opercentage[{{$district->id}}]" 
                                                                        id="opercentage{{$district->id}}" readonly placeholder="Enter outlay" data-id="{{$district->id}}">
                                                                        <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                      
                                                    <tbody name="outlayarr" id="physical" class="ms-table-section">
                                                        <tr class="the tr">
                                                            @foreach ($districtlist as $i => $district)
                                                            {{-- Physical Achievement data table --}}
                                                            <td>{{$district->district_name}}</td>
                                                            <td>
                                                                <?php
                                                                if(!empty($districtdata['item_name'][$i])) {
                                                                    ?>
                                                                        <input type="text" class="form-control " 
                                                                        name="item_name[{{$district->id}}]" 
                                                                        id="item_name{{$district->id}}"  placeholder="Enter Item Name" value="{{$districtdata['item_name'][$i]}}" data-id="{{$district->id}}" <?php if($districtdata['item_name'][$i]!=0 && auth()->user()->role_id != '1'){echo "readonly";}?>>

                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <input type="text" class="form-control " 
                                                                        name="item_name[{{$district->id}}]" 
                                                                        id="item_name{{$district->id}}"  placeholder="Enter Item Name" data-id="{{$district->id}}" >
                                                                        <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if(!empty($districtdata['unit_measure'][$i])) {
                                                                    ?>
                                                                        <input type="text" class="form-control " 
                                                                        name="unit_measure[{{$district->id}}]" 
                                                                        id="unit_measure{{$district->id}}"  placeholder="Enter Unit Of Measure" value="{{$districtdata['unit_measure'][$i]}}" data-id="{{$district->id}}" <?php if($districtdata['unit_measure'][$i]!=0 && auth()->user()->role_id != '1'){echo "readonly";}?>>

                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <input type="text" class="form-control " 
                                                                        name="unit_measure[{{$district->id}}]" 
                                                                        id="unit_measure{{$district->id}}"  placeholder="Enter Unit Of Measure" data-id="{{$district->id}}">
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if(!empty($districtdata['unit'][$i])) {
                                                                    $unit=$unit+$districtdata['unit'][$i];
                                                                    ?>
                                                                        <input required  type="number" start="1" step="0.01" min="0"class="form-control unit" 
                                                                        name="unit[{{$district->id}}]" 
                                                                        id="unit{{$district->id}}" value="{{$districtdata['unit'][$i]}}" placeholder="Enter outlay" data-id="{{$district->id}}" <?php if($districtdata['unit'][$i]!=0 && auth()->user()->role_id != '1'){echo "readonly";}?>>

                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <input required  type="number" start="1" step="0.01" min="0"class="form-control unit" 
                                                                        name="unit[{{$district->id}}]" 
                                                                        id="unit{{$district->id}}" placeholder="Enter outlay" data-id="{{$district->id}}">
                                                                        <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if(!empty($districtdata['achievement'][$i])) {
                                                                    $achievement=$achievement+$districtdata['achievement'][$i];
                                                                    ?>
                                                                        <input required type="number" start="1" step="0.01" min="0"class="form-control  achievement" 
                                                                        name="achievement[{{$district->id}}]" 
                                                                        id="achievement{{$district->id}}" value="{{$districtdata['achievement'][$i]}}" placeholder="Enter outlay" data-id="{{$district->id}}" <?php if($districtdata['achievement'][$i]!=0 && auth()->user()->role_id != '1'){echo "readonly";}?>>

                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <input required type="number" start="1" step="0.01" min="0"class="form-control  achievement" 
                                                                        name="achievement[{{$district->id}}]" 
                                                                        id="achievement{{$district->id}}" placeholder="Enter outlay" data-id="{{$district->id}}">
                                                                        <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                if(!empty($districtdata['upercentage'][$i])) {
                                                                    $upercentage=$upercentage+$districtdata['upercentage'][$i];
                                                                    ?>
                                                                        <input type="number" start="1" step="0.01" min="0"class="form-control " 
                                                                        name="upercentage[{{$district->id}}]" 
                                                                        id="upercentage{{$district->id}}" value="{{$districtdata['upercentage'][$i]}}" placeholder="Enter outlay" readonly data-id="{{$district->id}}">
                                                                        <?php
                                                                } else {
                                                                    ?>
                                                                        <input type="number" start="1" step="0.01" min="0"class="form-control " 
                                                                        name="upercentage[{{$district->id}}]" 
                                                                        id="upercentage{{$district->id}}" readonly placeholder="Enter outlay" data-id="{{$district->id}}">
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                           @endforeach
                                                        </tbody>
                                                   
                                                        <tbody name="outlayarr" id="beneficiaries" class="ms-table-section">
                                                            @foreach ($districtlist as $i => $district)
                                                        <tr>
                                                            {{-- Beneficiaries data --}}
                                                            <td>{{$district->district_name}}</td>
                                                            <td>
                                                                <?php
                                                                if(!empty($districtdata['ben_total'][$i])) {
                                                                    $ben_total=$ben_total+$districtdata['ben_total'][$i];
                                                                    ?>
                                                                        <input required type="number" start="1" class="form-control ben_total" 
                                                                        name="ben_total[{{$district->id}}]" 
                                                                        id="ben_total{{$district->id}}" value="{{$districtdata['ben_total'][$i]}}" placeholder="Enter outlay" data-id="{{$district->id}}" <?php if($districtdata['ben_total'][$i]!=0 && auth()->user()->role_id != '1'){echo "readonly";}?>>

                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <input required type="number" start="1" class="form-control ben_total" 
                                                                        name="ben_total[{{$district->id}}]" 
                                                                        id="ben_total{{$district->id}}" placeholder="Enter outlay" data-id="{{$district->id}}">
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                if(!empty($districtdata['women'][$i])) {
                                                                    $women=$women+$districtdata['women'][$i];
                                                                    ?>
                                                                        <input required type="number" class="form-control women" 
                                                                        name="women[{{$district->id}}]" 
                                                                        id="women{{$district->id}}" value="{{$districtdata['women'][$i]}}" placeholder="Enter outlay" data-id="{{$district->id}}" <?php if($districtdata['women'][$i]!=0 && auth()->user()->role_id != '1'){echo "readonly";}?>>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <input required type="number" class="form-control women" 
                                                                        name="women[{{$district->id}}]" 
                                                                        id="women{{$district->id}}" placeholder="Enter outlay" data-id="{{$district->id}}" >
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                if(!empty($districtdata['disable'][$i])) {
                                                                    $disable=$disable+$districtdata['disable'][$i];
                                                                    ?>
                                                                        <input required type="number" class="form-control disable" 
                                                                        name="disable[{{$district->id}}]" 
                                                                        id="disable{{$district->id}}" value="{{$districtdata['disable'][$i]}}" placeholder="Enter outlay" data-id="{{$district->id}}" <?php if($districtdata['disable'][$i]!=0 && auth()->user()->role_id != '1'){echo "readonly";}?>>

                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <input required type="number" class="form-control disable" 
                                                                        name="disable[{{$district->id}}]" 
                                                                        id="disable{{$district->id}}" placeholder="Enter outlay" data-id="{{$district->id}}" >
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                           
                                                        </tr>
                                                        @endforeach 
                                                    </tbody>
  
                                                    
                                                       
                                                    <tr class="ms-table-heading total-allocation">
                                                        <th>Total</th>
                                                        <th class="financial">{{$outlay}}</th>
                                                        <th class="financial">{{$resvised_outlay}}</th>
                                                        <th class="financial">{{$expenditure}}</th>
                                                        <th class="financial">
                                                            <?php 
                                                            $both_numbers = $resvised_outlay && $expenditure;
                                                            if($both_numbers){
                                                            $count1 = $expenditure / $resvised_outlay;
                                                            $count2 = $count1 * 100;
                                                            ?>
                                                            {{ number_format($count2, 2) }}
                                                            <?php 
                                                            }else{

                                                                ?>
                                                                0
                                                                <?php

                                                            }
                                                            
                                                            ?>
                                                        </th>
                                                         <th class="physical"></th> 
                                                         <th class="physical"></th>
                                                        <th class="physical">{{$unit}}</th>
                                                        <th class="physical"> {{$achievement}}</th>
                                                        <th class="physical">
                                                            <?php 
                                                            if($achievement != 0)
                                                            {
                                                                $count3 = $achievement / $unit;
                                                                $count4 = $count3 * 100;
                                                            } else {
                                                                $count4 = 0;
                                                            }
                                                            ?>
                                                            {{ number_format($count4, 2) }}
                                                        </th>
                                                        <th class="beneficiaries">{{$ben_total}}</th>
                                                        <th class="beneficiaries">{{$women}}</th>
                                                        <th class="beneficiaries">{{$disable}}</th>
                                                    </tr>
                                                @endif
                                                       
                                             
                                           
                                            </table>
                                             <!-- Previous and Next buttons -->
                                                <div class="btn-container table-nxt-prv" id="table-nxt-prv">
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
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <input type="hidden" name="logval" value="entereditlog"/>
                                <button type="submit" id="update" class="btn btn-success">Update</button>
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
        $("#update").click(function() {
        var soe_budget_distribution_id = window.location.search.substring(1);
            var formAction = '{{URL::to('/')}}/soe-budget-distribution/' + soe_budget_distribution_id;
            $('#updatesoeBudgteDistributionForm').attr('action', formAction);
            $('#updatesoeBudgteDistributionForm').submit();
        });

        $('document').ready(function(){
            var soe_budget_distribution_id = window.location.search.substring(1);
            //$("#district_outlay_tbl").hide();
           /// $("#Undistributed_outlay_tbl").hide();
            $.ajax({
                url: "{{ route('get_soe_budget_distribution_data') }}?soe_budget_distribution_id=" + soe_budget_distribution_id,
                method: 'GET',
                success: function(data) {
                    var soebudgetdistribution = data.soebudgetdistribution;
                    var departmentlist = data.departmentlist;
                    var majorheadlist = data.majorheadlist;
                    var schemelist = data.schemelist;
                    var soelist = data.soelist;
                    var districtlist = data.districtlist;
                    var finyearlist = data.finyearlist;
                    var planlist = data.planlist;
                    var htmlDepartment = "<option value=''>---Select Department---</option>";
                    var htmlMajorhead = "<option value=''>---Select Majorhead---</option>";
                    var htmlScheme = "<option value=''>---Select Scheme---</option>";
                    var htmlSoe = "<option value=''>---Select Soe---</option>";
                    var htmlDistrict = "<option value=''>---Select District---</option>";
                    var htmlFinyear = "<option value=''>---Select Fin year---</option>";
                    var htmlPlan = "<option value=''>---Select Plan---</option>";
                    $('#outlay').val(soebudgetdistribution[0]['outlay']/100000);
                    $('#type').val(2);

                    $('#plan_id_disabled').val(soebudgetdistribution[0]['plan_id']);
                    $('#plan_id').val(soebudgetdistribution[0]['plan_id']);

                    $('#type').prop('disabled', true);

                    for (var i = 0; i < departmentlist.length; i++) {
                        if(soebudgetdistribution[0]['department_id'] == departmentlist[i]['id']){
                            htmlDepartment += `<option value="`+departmentlist[i]['id']+`" selected>`+departmentlist[i]['department_name']+`</option>`;
                            $('#department_id').val(departmentlist[i]['id']);
                        }else{
                            htmlDepartment += `<option value="`+departmentlist[i]['id']+`">`+departmentlist[i]['department_name']+`</option>`;
                        }
                    }

                    for (var i = 0; i < majorheadlist.length; i++) {
                        if(soebudgetdistribution[0]['majorhead_id'] == majorheadlist[i]['id']){
                            htmlMajorhead += `<option value="`+majorheadlist[i]['id']+`" selected>`+majorheadlist[i]['complete_head']+`</option>`;
                            $('#majorhead_id').val(majorheadlist[i]['id']);
                        }else{
                            htmlMajorhead += `<option value="`+majorheadlist[i]['id']+`">`+majorheadlist[i]['complete_head']+`</option>`;
                        }
                    }


                    for (var i = 0; i < schemelist.length; i++) {
                        if(soebudgetdistribution[0]['scheme_id'] == schemelist[i]['id']){
                            htmlScheme += `<option value="`+schemelist[i]['id']+`" selected>`+schemelist[i]['scheme_name']+`</option>`;
                            $('#scheme_id').val(schemelist[i]['id']);
                        }else{
                            htmlScheme += `<option value="`+schemelist[i]['id']+`">`+schemelist[i]['scheme_name']+`</option>`;
                        }
                    }

                    for (var i = 0; i < soelist.length; i++) {
                        if(soebudgetdistribution[0]['soe_id'] == soelist[i]['id']){
                            htmlSoe += `<option value="`+soelist[i]['id']+`" selected>`+soelist[i]['soe_name']+`</option>`;
                            $('#soe_id').val(soelist[i]['id']);
                        }else{
                            htmlSoe += `<option value="`+soelist[i]['id']+`">`+soelist[i]['soe_name']+`</option>`;
                        }
                    }

                    for (var i = 0; i < districtlist.length; i++) {
                        if(soebudgetdistribution[0]['district_id'] == districtlist[i]['id']){
                            htmlDistrict += `<option value="`+districtlist[i]['id']+`" selected>`+districtlist[i]['district_name']+`</option>`;
                        }else{
                            htmlDistrict += `<option value="`+districtlist[i]['id']+`">`+districtlist[i]['district_name']+`</option>`;
                        }
                    }

                    for (var i = 0; i < finyearlist.length; i++) {
                        if(soebudgetdistribution[0]['fin_year_id'] == finyearlist[i]['id']){
                            htmlFinyear += `<option value="`+finyearlist[i]['id']+`" selected>`+finyearlist[i]['finyear']+`</option>`;
                            $('#fin_year_id').val(finyearlist[i]['id']);
                        }else{
                            htmlFinyear += `<option value="`+finyearlist[i]['id']+`">`+finyearlist[i]['finyear']+`</option>`;
                        }
                    }

                    for (var i = 0; i < planlist.length; i++) {
                        if(soebudgetdistribution[0]['plan_id'] == planlist[i]['id']){
                            htmlPlan += `<option value="`+planlist[i]['id']+`" selected>`+planlist[i]['plan_name']+`</option>`;
                            $('#plan_id').val(planlist[i]['id']);
                            
                        }else{
                            htmlPlan += `<option value="`+planlist[i]['id']+`">`+planlist[i]['plan_name']+`</option>`;
                        }
                    }

                    $('#department_id_disabled').html(htmlDepartment);
                    $('#majorhead_id_disabled').html(htmlMajorhead);
                    $('#scheme_id_disabled').html(htmlScheme);
                    $('#soe_id_disabled').html(htmlSoe);                    
                    $('#fin_year_id_disabled').html(htmlFinyear);                    
                    $('#district_id').html(htmlDistrict);
                    $('#plan_id_disabled').html(htmlPlan);
                    get_table();
                }
            });

            
        });

        function get_table(){
            var department_id = $("#department_id").val();
            var majorhead_id = $("#majorhead_id").val();
            var scheme_id = $("#scheme_id").val();
            var soe_id = $("#soe_id").val();
            var fin_year_id = $("#fin_year_id").val();
            var soe_budget_distribution_id = window.location.search.substring(1);
            if(department_id > 0 && majorhead_id > 0 && scheme_id > 0 && soe_id > 0 && fin_year_id > 0){
                $.ajax({
                    url: "{{ route('get_soe_undistributed_outlay') }}?department_id="+department_id+"&majorhead_id="+majorhead_id+"&scheme_id="+scheme_id+"&soe_id="+soe_id+"&fin_year_id="+fin_year_id+"&soe_budget_distribution_id="+soe_budget_distribution_id,
                    method: 'GET',
                    success: function(data) {
                        //console.log(data)
                       // if(data.distribute_outlay){
                            //alert()
                            $('#type').val(2);
                            $("#district_outlay_tbl").show();
                            $("#Undistributed_outlay_tbl").show();
                            $("#undistributed_outlay").val(data.undistributed_outlay);
                            $("#undistributed_outlay_label").html(data.undistributed_outlay/100000);
                            $("#total_outlay_label").html(data.totaloutlay/100000);
                            $("#undistributed_outlay_label_hidden").val(data.undistributed_outlay/100000);
                            $("#total_outlay_label_hidden").val(data.totaloutlay/100000);
                            for (var i = 0; i < data.distribute_outlay.length; i++) {
                                $('#'+data.distribute_outlay[i]['district_id']).val(data.distribute_outlay[i]['outlay']/100000);
                                $('#'+data.distribute_outlay[i]['district_id']).prop('disabled', false);
                            }
                      //  }
                    }
                });
            } 
        }
        $('.expenditure').focusout(function(e){
                id=$(this).data('id');
                input=parseFloat($(this).val());
                total=parseFloat($('#resvised_outlay'+id).val())
                //alert(total)
               // alert($(this).val())
            if(total==0){

                alert("Outlay budget is 0");
                  $('#expenditure'+id).val(0);
            }else if(total<input){

                alert("Expenditure  is less than or equal to outlay");
                $('#expenditure'+id).val(0);
            }else{

                per=(input*100)/total;
                 per =per.toFixed(2)
                total=$('#opercentage'+id).val(per)
                
            }
        });
        $('.resvised_outlayamt').focusin(function(e){
             id=$(this).data('id');
             oldvalue=parseFloat($(this).val())
          $('.resvised_outlayamt').focusout(function(e){
               
                input=parseFloat($(this).val());
                expenditure=parseFloat($('#expenditure'+id).val())
                //alert(total)
               // alert($(this).val())
            if(input<expenditure){

                alert("Revised Outlay can not be less than expenditure amount");
                  $('#resvised_outlay'+id).val(oldvalue);
            }if(input==''){
                  $('#resvised_outlay'+id).val(oldvalue);
            }else{

                per=(expenditure*100)/input;
                 per =per.toFixed(2)
                total=$('#opercentage'+id).val(per)
                
            }
        })
      });
        $('.achievement').focusout(function(e){


                if($(this).val()==''){

                    $(this).val(0);

                }
                id=$(this).data('id');
                input=parseFloat($(this).val());
                total=parseFloat($('#unit'+id).val())
                //alert(total)
            if(total==0){

                alert("unit is 0");
                  $('#achievement'+id).val(0);
            }else if(total<input){

                alert("Achievement  should be less than or equal to Unit");
                $('#achievement'+id).val(0);
            }else{

                per=(input*100)/total;
                 per =per.toFixed(2)
                total=$('#upercentage'+id).val(per)
                
            }
        });
        $('input.trigger').focusout(function(e){
            
            var input =$(this);
             if(input.val()==''){

                input.val(0);

            }
            if(parseFloat(input.val())>parseFloat($("#undistributed_outlay_label_hidden").val())){


                alert('Undistributed Outlay Exceeds Total Outlay , Please Enter Correct Outlay');
                input.val(0);
                //return;

            }
            distributed_outlay_amount();
        });

    
        function distributed_outlay_amount(){
            var distributed_outlay = 0;

            $(".outlayamt").each(function(){
            console.log($(this).val())
           distributed_outlay = distributed_outlay+parseFloat($(this).val());
        });
            var undistributed_amount = $('#total_outlay_label').html() - distributed_outlay;
            $("#undistributed_outlay_label").html(undistributed_amount);
            $("#undistributed_outlay_label_hidden").val(undistributed_amount);
        }


        $('input.ben_total').focusout(function(e){
            
            var input =$(this);
             if(input.val()==''){

                input.val(0);

            }
            
        });
         $('input.women').focusout(function(e){


            
            var input =$(this);
             if(input.val()==''){

                input.val(0);

            }
            var id=input.data('id');
            var total= parseFloat(input.val())+parseFloat($('#disable'+id).val())
            if(total>parseFloat($('#ben_total'+id).val())){
                alert('Total of women and disable beneficiaries should be less than total beneficiaries');
                input.val(0);
            }
            
        });
          $('input.disable').focusout(function(e){
            
            var input =$(this);
             if(input.val()==''){

                input.val(0);

            }
            var id=input.data('id');
            var total= parseFloat(input.val())+parseFloat($('#women'+id).val())
            if(total>parseFloat($('#ben_total'+id).val())){
                //alert('Disable beneficiaries less than total');
                alert('Total of women and disable beneficiaries less than total beneficiaries');
                input.val(0);
            }
            
        });
           $('input.unit,.expenditure').focusout(function(e){
            
            var input =$(this);
             if(input.val()==''){

                input.val(0);

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
                document.getElementById('prevBtn').style.display = 'block';
            }
    
            if (currentSectionIndex === sections.length - 1) {
                document.getElementById('nextBtn').style.display = 'none';
            } else {
                document.getElementById('nextBtn').style.display = 'block';
            }
        }
    
        // Initialize with the first section visible
        document.addEventListener('DOMContentLoaded', (event) => {
            showSection('financial');
            updateButtonVisibility(); // Initial button visibility setup
        });



        // Expandature cannot be more then outlay 
        document.querySelectorAll('.expenditure').forEach(input => {
        input.addEventListener('input', function () {
            const districtId = this.dataset.id;
            const outlayInput = document.querySelector(`#outlay${districtId}`);
            const outlayValue = parseFloat(outlayInput.value) || 0;
            const expenditureValue = parseFloat(this.value) || 0;

            if (expenditureValue > outlayValue) {
                alert(`Expenditure cannot exceed the outlay of ${outlayValue}`);
                this.value = '';
            }
        });
    });

    </script>
@endsection