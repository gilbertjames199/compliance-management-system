<?php

use App\Models\ComplyingOffice;
use App\Models\Office;
use App\Models\Requirement;

if(!function_exists('getOffices')){
    function getOffices()
    {
        return Office::when(!in_array(auth()->user()->department_code, ['25', '26']), function ($query) {
                $query->where('department_code', auth()->user()->department_code);
            })
            ->where(function ($query) {
                $query->where('office', 'LIKE', '%Office%')
                      ->orWhere('office', 'LIKE', '%Hospital%');
            })
            ->orderBy('office','ASC')
            ->pluck('office', 'department_code');
    }
}

if(!function_exists('getRequirements')){
    function getRequirements()
    {
        return Requirement::when(!in_array(auth()->user()->department_code, ['25', '26']), function ($query) {
                $query->where('requiring_agency', auth()->user()->department_code);
            })
            ->pluck('requirement', 'id');
    }
}
if(!function_exists('getComplyingOffices')){
    function getComplyingOffices()
    {
        $user = auth()->user();

        $query = ComplyingOffice::with(['office'])->get()
                ->map(function($item){
                    return [
                        "office"=>optional(optional($item)->office)->office,
                        "id"=>$item->id
                    ];
                });

        // Only filter if user department_code is not 25 or 26
        if (!in_array($user->department_code, ['25', '26'])) {
            $query->where('department_code', $user->department_code);
        }

        return $query->pluck('office', 'id')->toArray();
    }
}
