<?php

namespace App\Traits;

trait TagOwners
{
    /**
     * Get users by roles
     *
     * @param int $user_successor
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function ChecktagUserOwner($successor_status, $user_successor = null)
    {
        if ($successor_status == 'active') {
            $user = auth()->user();
            if ($user->id == $user_successor) {
                return true;
            } else {
                return false;
            }
        }else{
            return true;
        }
    }

    public function checkfilterTag($data)
    {
        $filter_tag = null;
        if (isset($data)) {
            $tagStatus = $data->filter(function ($item) {
                return $item['Status_Tag'] == 'active';
            });
            $contStatus = $data->filter(function ($item) {
                return @$item->TagToContracts->Status_Con == 'active' || @$item->TagToContracts->Status_Con == 'pending';
            });
        }
        if (count(@$tagStatus) > 0 || count(@$contStatus) > 0) {
            $filter_tag = "btn_tagdisabled";
        }
        return $filter_tag;
    }
}