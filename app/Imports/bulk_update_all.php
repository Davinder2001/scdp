<?php
namespace App\Imports;

use App\Models\Soe_budget_allocation;
use App\Models\soe_budget_distribution;
use App\Models\Department;
use App\Models\District;
use App\Models\Majorhead;
use App\Models\Scheme_master;
use App\Models\Soe_master;
use App\Models\Finyear;
use App\Models\Plan;
use App\Models\Service;
use App\Models\Sector;
use App\Models\Subsector;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class bulk_update_all implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, WithEvents
{
    use Importable;

    private $department, $majorhead, $schememaster, $soemaster, $finyear,
        $plan, $service, $sector, $subsector;
    private $sheetName;

    private $lastRow;
    private $rowCount;

    public function __construct()
    {
        $this->department = Department::all();
        $this->majorhead = Majorhead::all();
        $this->schememaster = Scheme_master::all();
        $this->soemaster = Soe_master::all();
        $this->finyear = Finyear::all();
        $this->plan = Plan::all();
        $this->service = Service::all();
        $this->sector = Sector::all();
        $this->subsector = Subsector::all();
        $this->rowCount = 0;
    }




    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();
            },
        ];
    }
    
    public function model(array $row)
    {
        $this->rowCount++;        
        $fin_year = $_POST['fin_year'] ?? "";
        $quarter = $_POST['quarter'] ?? "";
        $plan_name =  $this->sheetName;

        $row = [
            'department_name'   => $row['department_name'] ?? "",
            'complete_head'     => $row['complete_head'] ?? "",
            'scheme_name'       => $row['scheme_name'] ?? "",
            'soe_name'          => $row['soe_name'] ?? "",
            'fin_year'          => $fin_year ?? "",
            'plan_name'         => $plan_name ?? "",
            'service_name'      => $row['service_name'] ?? "",
            'sector_name'       => $row['sector_name'] ?? "",
            'subsectors_name'   => $row['subsectors_name'] ?? "",
            'hod_outlay'        => $row['hod_outlay'] ?? "",
            'district_outlay'   => $row['district_outlay'] ?? "",
            'outlay'            => $row['outlay'] ?? "",
            'earmarked'         => $row['earmarked'] ?? "",
            'bilaspur'          => $row['bilaspur'] ?? "",
            'chamba'            => $row['chamba'] ?? "",
            'hamirpur'          => $row['hamirpur'] ?? "",
            'kangra'            => $row['kangra'] ?? "",
            'kullu'             => $row['kullu'] ?? "",
            'mandi'             => $row['mandi'] ?? "",
            'shimla'            => $row['shimla'] ?? "",
            'sirmour'           => $row['sirmour'] ?? "",
            'solan'             => $row['solan'] ?? "",
            'una'               => $row['una'] ?? "",
            'undistri_buted'    => $row['undistri_buted'] ?? "",
        ];


        // Extract the values for each district into an array
        $outlay_row_array = [
                $row['bilaspur'] ?? "",
                $row['chamba'] ?? "",
                $row['hamirpur'] ?? "",
                $row['kangra'] ?? "",
                $row['kullu'] ?? "",
                $row['mandi'] ?? "",
                $row['shimla'] ?? "",
                $row['sirmour'] ?? "",
                $row['solan'] ?? "",
                $row['una'] ?? "",
                $row['undistri_buted'] ?? "",
            ];
            
            // Retrieve district IDs from the database
            $districts = District::pluck('id')->toArray();
            
            $outlay_row = [];

            // Iterate over each district ID and assign the corresponding value from $outlay_row_array
            foreach ($districts as $index => $district) {
                // Check if $index exists in $outlay_row_array to avoid out-of-bound errors
                if (isset($outlay_row_array[$index])) {
                    $outlay_row[$district] = $outlay_row_array[$index];
                } else {
                    $outlay_row[$district] = ""; // Set a default value if $outlay_row_array[$index] is not set
                }
            }

            // Now $outlay_row_json will contain the JSON string you want, e.g. {"outlay":{"1":11,"2":12,...}}
            $data = [
                "outlay"            => $outlay_row,
                "expenditure"       => array_fill_keys($districts,null), // Initialize with "0"
                "opercentage"       => array_fill_keys($districts,null),
                "unit"              => array_fill_keys($districts,null),
                "unit_measure"      => array_fill_keys($districts,null),
                "achievement"       => array_fill_keys($districts,null),
                "upercentage"       => array_fill_keys($districts,null),
                "ben_total"         => array_fill_keys($districts,null),
                "women"             => array_fill_keys($districts,null),
                "disable"           => array_fill_keys($districts,null),
                "item_name"         => array_fill_keys($districts,null),
                "revised_outlay"    => array_fill_keys($districts,null),
            ];  

            $json_data = json_encode($data);
            

            
            $validatedData = ([
                'quarter'   => $quarter,
                'json_data' => $json_data,
            ]);
            
            $quarter_val = $validatedData['quarter'];
            $json_data_val = $validatedData['json_data'];
            

            $new_array_for_quarter = [
               
            ];
      
            $update_q_Data = [
                'q_1_data' => null,
                'q_2_data' => null,
                'q_3_data' => null,
                'q_4_data' => null,
            ];
            
            // Prepare the update array
            switch ($quarter_val) {
                case 1:
                    $update_q_Data['q_1_data'] = $json_data_val;
                    $new_array_for_quarter['q_1_data'] = $json_data_val;
                    break;
                case 2:
                    $update_q_Data['q_2_data'] = $json_data_val;
                    $new_array_for_quarter['q_2_data'] = $json_data_val;
                    break;
                case 3:
                    $update_q_Data['q_3_data'] = $json_data_val;
                    $new_array_for_quarter['q_3_data'] = $json_data_val;
                    break;
                case 4:
                    $update_q_Data['q_4_data'] = $json_data_val;
                    $new_array_for_quarter['q_4_data'] = $json_data_val;
                    break;
            }

             
            // echo "<pre> Fin Year : "; print_r($update_q_Data);
            // dd($json_data_val);
            
        $allEmpty = true;
        foreach ($row as $key => $value) {
            if (!empty($value)) {
                $allEmpty = false;
                break;
            }
        }
        // If all row empty
        if ($allEmpty) {
            return;
        }

        $getLast_row = $this->getLastRow();

        $department_name    = !empty($row['department_name']) ? $row['department_name'] : ($getLast_row['department_name'] ?? null);
        $complete_head      = !empty($row['complete_head']) ? $row['complete_head'] : ($getLast_row['complete_head'] ?? null);
        $scheme_name        = !empty($row['scheme_name']) ? $row['scheme_name'] : ($getLast_row['scheme_name'] ?? null);
        $soe_name           = !empty($row['soe_name']) ? $row['soe_name'] : ($getLast_row['soe_name'] ?? null);
        $plan_name          = !empty($plan_name) ? $plan_name: ($getLast_row['plan_name'] ?? null);
        $service_name       = !empty($row['service_name']) ? $row['service_name'] : ($getLast_row['service_name'] ?? null);
        $sector_name        = !empty($row['sector_name']) ? $row['sector_name'] : ($getLast_row['sector_name'] ?? null);
        $subsectors_name    = !empty($row['subsectors_name']) ? $row['subsectors_name'] : ($getLast_row['subsectors_name'] ?? null);
        $hod_outlay_        = !empty($row['hod_outlay']) ? $row['hod_outlay'] : ($getLast_row['hod_outlay'] ?? null);
        $district_outlay_   = !empty($row['district_outlay']) ? $row['district_outlay'] : ($getLast_row['district_outlay'] ?? null);
        $outlay             = !empty($row['outlay']) ? $row['outlay'] : ($getLast_row['outlay'] ?? null);
        $earmarked          = !empty($row['earmarked']) ? $row['earmarked'] : ($getLast_row['earmarked'] ?? null);
        $undistri_buted     = !empty($row['undistri_buted']) ? $row['undistri_buted'] : ($getLast_row['undistri_buted'] ?? null);
        $bilaspur           = !empty($row['bilaspur']) ? $row['bilaspur'] : ($getLast_row['bilaspur'] ?? null);
        $chamba             = !empty($row['chamba']) ? $row['chamba'] : ($getLast_row['chamba'] ?? null);
        $hamirpur           = !empty($row['hamirpur']) ? $row['hamirpur'] : ($getLast_row['hamirpur'] ?? null);
        $kangra             = !empty($row['kangra']) ? $row['kangra'] : ($getLast_row['kangra'] ?? null);
        $kullu              = !empty($row['kullu']) ? $row['kullu'] : ($getLast_row['kullu'] ?? null);
        $mandi              = !empty($row['mandi']) ? $row['mandi'] : ($getLast_row['mandi'] ?? null);
        $shimla             = !empty($row['shimla']) ? $row['shimla'] : ($getLast_row['shimla'] ?? null);
        $sirmour            = !empty($row['sirmour']) ? $row['sirmour'] : ($getLast_row['sirmour'] ?? null);
        $solan              = !empty($row['solan']) ? $row['solan'] : ($getLast_row['solan'] ?? null);
        $una                = !empty($row['una']) ? $row['una'] : ($getLast_row['una'] ?? null);
        
        
        
        // Get last row
        $lastRow = [
            'department_name'   => $department_name,
            'complete_head'     => $complete_head,
            'scheme_name'       => $scheme_name,
            'soe_name'          => $soe_name,
            'fin_year'          => $fin_year,
            'plan_name'         => $plan_name,
            'service_name'      => $service_name,
            'sector_name'       => $sector_name,
            'subsectors_name'   => $subsectors_name,
            'hod_outlay'        => $hod_outlay_,
            'district_outlay'   => $district_outlay_,
            'outlay'            => $outlay,
            'earmarked'         => $earmarked,
            'undistri_buted'    => $undistri_buted,
            'bilaspur'          => $bilaspur,
            'chamba'            => $chamba,
            'hamirpur'          => $hamirpur,
            'kangra'            => $kangra,
            'kullu'             => $kullu,
            'mandi'             => $mandi,
            'shimla'            => $shimla,
            'sirmour'           => $sirmour,
            'solan'             => $solan,
            'una'               => $una,
        ];
        


        $department_id      = $this->department->where('department_name', $department_name)->first();
        $majorhead_id       = $this->majorhead->where('complete_head', $complete_head)->first();
        $schememaster_id    = $this->schememaster->where('scheme_name', $scheme_name)->first();
        $soemaster_id       = $this->soemaster->where('soe_name', $soe_name)->first();
        $finyear_id         = $this->finyear->where('finyear', $fin_year)->first();
        $plan_id            = $this->plan->where('plan_name', $plan_name)->first();
        $service_id         = $this->service->where('service_name', $service_name)->first();
        $sector_id          = $this->sector->where('sector_name', $sector_name)->first();
        $subsector_id       = $this->subsector->where('subsectors_name', $subsectors_name)->first();

        $hod_outlay         = array_key_exists('hod_outlay', $row) ? $hod_outlay_ * 100000 : NULL;
        $district_outlay    = array_key_exists('district_outlay', $row) ? $district_outlay_ * 100000 : NULL;
       
        // Step 2: Check if the given fin_year_id exists in the retrieved values
        $quarter_data_all   = soe_budget_distribution::where('fin_year_id', $finyear_id->id)->where('plan_id', $plan_id->id)->first();
  
 

        $q_1_data_db = $quarter_data_all->q_1_data ?? '';
        $q_2_data_db = $quarter_data_all->q_2_data ?? '';
        $q_3_data_db = $quarter_data_all->q_3_data ?? '';
        $q_4_data_db = $quarter_data_all->q_4_data ?? '';

        
        $quarter_data_all->q_1_data = $new_array_for_quarter['q_1_data'] ?? $q_1_data_db;
        $quarter_data_all->q_2_data = $new_array_for_quarter['q_2_data'] ?? $q_2_data_db;
        $quarter_data_all->q_3_data = $new_array_for_quarter['q_3_data'] ?? $q_3_data_db;
        $quarter_data_all->q_4_data = $new_array_for_quarter['q_4_data'] ?? $q_4_data_db;
    
        // Save the updated model
        $quarter_data_all->save();


    }

    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        
        return [];
    }

    public function getLastRow()
    {
        return $this->lastRow;
    }    

    public function getRowCount()
    {
        return $this->rowCount;
    }
}
