<?php
function roleCancelTagparts()
{
    $role = auth()->user()->getRoleNames()->toArray();
    $roleEnable = ['administrator', 'superadmin', 'manager', 'supervisor'];

    $checkrole = count(array_intersect($role, $roleEnable)) > 0;

    if ($checkrole) {
        return 'enabled';
    } else {
        return 'disabled';
    }
}

function roleDocumentloans($typloan = null)
{
    if ($typloan == '03') {
        $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager', 'assistant manager', 'finances'];
    } else {
        $arrRole = ['administrator', 'superadmin', 'supervisor', 'assistant manager', 'manager'];
    }

    return $arrRole;
}

function roleCancelCheckApprove()
{
    $arrRole = ['administrator', 'superadmin'];
    return $arrRole;
}

function roleAuditcheckLists()
{
    $role = auth()->user()->getRoleNames()->toArray();
    $roleEnable = ['administrator', 'superadmin', 'audit'];
    $checkrole = count(array_intersect($role, $roleEnable)) > 0;

    if ($checkrole) {
        return 'enabled';
    } else {
        return 'disabled';
    }
}

function roleAuditothercheckLists()
{
    $role = auth()->user()->getRoleNames()->toArray();
    $roleEnable = ['administrator', 'superadmin', 'finances', 'staff', 'supervisor'];
    $checkrole = count(array_intersect($role, $roleEnable)) > 0;

    if ($checkrole) {
        return 'enabled';
    } else {
        return 'disabled';
    }
}

function roleEditAssetOwner()
{
    $role = auth()->user()->getRoleNames()->toArray();
    $roleEnable = ['administrator', 'superadmin', 'audit', 'manager', 'supervisor'];
    $checkrole = count(array_intersect($role, $roleEnable)) > 0;

    if ($checkrole) {
        return 'enabled';
    } else {
        return 'disabled';
    }
}

function roleCancelAssetOwner()
{
    $role = auth()->user()->getRoleNames()->toArray();
    $roleEnable = ['administrator', 'superadmin', 'audit', 'manager', 'supervisor'];
    $checkrole = count(array_intersect($role, $roleEnable)) > 0;

    if ($checkrole) {
        return 'enabled';
    } else {
        return 'disabled';
    }
}

function roleUpdateStateAsset()
{
    $role = auth()->user()->getRoleNames()->toArray();
    $roleEnable = ['administrator', 'superadmin', 'audit', 'manager', 'supervisor'];
    $checkrole = count(array_intersect($role, $roleEnable)) > 0;

    if ($checkrole) {
        return 'enabled';
    } else {
        return 'disabled';
    }
}


function rolebetterSup($zone)
{
    $arrRole = [];

    switch ($zone) {
        case 10:
            $arrRole = ['administrator', 'superadmin', 'manager', 'assistant manager'];
            break;
        case 20:
            $arrRole = ['administrator', 'superadmin', 'manager'];
            break;
        case 30:
            $arrRole = ['administrator', 'superadmin', 'manager'];
            break;
        case 50:
            $arrRole = ['administrator', 'superadmin', 'manager', 'supervisor', 'assistant manager'];
            break;
        case 40:
            $arrRole = ['administrator', 'superadmin', 'manager', 'supervisor', 'assistant manager'];
            break;
    }

    // $arrRole = ['administrator', 'superadmin', 'manager', 'supervisor','assistant manager'];
    $role = auth()->user()->getRoleNames();
    $Approve = $role->filter(function ($item) use ($arrRole) {
        return in_array($item, $arrRole);
    });

    return count($Approve) > 0 ? true : false;
}
