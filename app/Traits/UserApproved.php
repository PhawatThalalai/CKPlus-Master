<?php

namespace App\Traits;

use App\Models\User;
use App\Models\TB_DataCus\Data_CusTags;
use Illuminate\Support\Facades\Auth;

trait UserApproved
{
    /**
     * Get users by roles
     *
     * @param int $zone
     * @param int $tag_id
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function getUsersByRoles($zone, $tag_id = null)
    {
        $roleNames = [];

        switch ($zone) {
            case 10:
                $roleNames = ['finances', 'admin', 'supervisor', 'manager', 'assistant manager', 'superadmin', 'administrator'];
                break;
            case 20:
                $roleNames = ['supervisor', 'manager'];
                break;
            case 30:

                $data = Data_CusTags::where('id', $tag_id)->first();
                $dataCal = $data->TagToCulculate;
                if (@$dataCal->Cash_Car > 180000) {
                    return User::where('zone', $zone)
                        ->whereIn('id', [386, 326])//คุณโค้ก,คุณหมู
                        ->get();
                } else {
                    $roleNames = ['supervisor'];
                }
                break;
            case 50:
                $roleNames = ['supervisor', 'manager'];
                break;
            case 40:
                $data = Data_CusTags::where('id', $tag_id)->first();
                $dataCal = $data->TagToCulculate;
                $cash = @$dataCal->Cash_Car;
                $ltv = @$dataCal->Percent_Car;
                $status_due = @$dataCal->Payment_Due;
                $CodeLoans = @$dataCal->CodeLoans;
                $ltvRate = @$dataCal->RatePrices >0?number_format(((@$dataCal->Cash_Car / @$dataCal->RatePrices) * 100), 0):0;
                if (@$dataCal->Cash_Car > 200000 || ($CodeLoans == "02" && $ltvRate > 70) || @$dataCal->Percent_Car > 100 || @$dataCal->Payment_Due == "less") {
                    $roleNames = ['manager'];
                } else {
                    $roleNames = ($dataCal->CodeLoans == "03")
                        ? ['finances', 'admin', 'supervisor', 'manager']
                        : ['supervisor', 'manager'];
                }
                break;
        }

        return User::where('zone', $zone)
            ->whereHas('roles', function ($query) use ($roleNames) {
                $query->whereIn('name', $roleNames);
            })->get();
    }

    public function getUserHandlerGroup()
    {
        $roleNames = ['supervisor', 'manager'];
        return User::where('zone', Auth::user()->zone)
            ->whereHas('roles', function ($query) use ($roleNames) {
                $query->whereIn('name', $roleNames);
            })->get();
    }

    public function getUserHandlerOTP()
    {
        $roleNames = ['manager', 'superadmin', 'administrator'];
        return User::where('zone', Auth::user()->zone)
            ->select('id', 'name')
            ->whereHas('roles', function ($query) use ($roleNames) {
                $query->whereIn('name', $roleNames);
            })
            ->get();
    }
    public function getUserFianacial()
    { //'manager', 'superadmin', 'administrator',
        $roleNames = ['financial'];
        return User::where('zone', Auth::user()->zone)
            ->select('id', 'name')
            ->whereHas('roles', function ($query) use ($roleNames) {
                $query->whereIn('name', $roleNames);
            })
            ->get();
    }
}
