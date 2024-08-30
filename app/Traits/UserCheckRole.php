<?php

namespace App\Traits;

use Spatie\Permission\Models\Role;

trait UserCheckRole
{
    /**
     * Get users by roles
     *
     * @param int $codeLoan
     * @param int $statusCon
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function checkRoleEditLoans($codeLoan, $statusCon)
    {
        $roles = auth()->user()->getRoleNames()->toArray();
        $status = ['transfered','complete'];
        if($codeLoan=='03' && in_array($statusCon,$status) != true){
            $userArr = ['administrator','superadmin','audit','manager','assistant manager','supervisor','finances'];
        }else{
            $userArr = ['administrator','superadmin','audit','manager','assistant manager','supervisor'];
        }

        $chkRole = count(array_intersect($userArr, $roles)) > 0;
        if ($chkRole) {
            return 1;
        } else {
            return 0;
        }
    }

    public function checkRoleAuthorizes($auth)
    {
        $userArr = ['superadmin'];
        $chkRole = count(array_intersect($userArr, $auth)) > 0;

        if ($chkRole) {
            return $roles = Role::all();
        } else {
            return $roles = Role::where('name', '!=', 'superadmin')->get();
        }
    }

    public function checkRoleEditroles()
    {
        $roles = auth()->user()->getRoleNames()->toArray();
        $userArr = ['superadmin'];

        $chkRole = count(array_intersect($userArr, $roles)) > 0;
        if ($chkRole) {
            return true;
        } else {
            return false;
        }
    }
    public function checkRolePayment()
    {
        $roles = auth()->user()->getRoleNames()->toArray();
        $userArr = ['administrator', 'financial'];

        $chkRole = count(array_intersect($userArr, $roles)) > 0;
        if ($chkRole) {
            return true;
        } else {
            return false;
        }
    }

    public function roleApprove($typloan = null) {
        if ($typloan == '03') {
            $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager', 'finances','assistant manager'];
        } else {
            $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager','assistant manager'];
        }

        return $arrRole;
    }

    public function checkRoleEditLoansList($statusCon)
    {

        $status = ['transfered','complete'];
        if(in_array($statusCon,$status) != true){
            $userArr = ['administrator','superadmin','audit','manager','assistant manager','supervisor','finances'];
        }else{
            $userArr = ['administrator','superadmin','audit','manager','assistant manager','supervisor'];
        }

        return $userArr ;

    }
}
