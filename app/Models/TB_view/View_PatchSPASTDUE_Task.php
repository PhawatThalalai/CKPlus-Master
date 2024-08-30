<?php

namespace App\Models\TB_view;

use Illuminate\Database\Eloquent\Model;

class View_PatchSPASTDUE_Task extends Model
{
    // กำหนดชื่อ View ในฐานข้อมูล
    protected $table = 'View_PatchSPASTDUE_Task';

    // ถ้า View ไม่มี primary key หรือไม่มีการเพิ่มข้อมูลใน View นั้น
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    // กรณี View มีข้อมูล read-only
    public function getKeyName()
    {
        return null;
    }
    
    /**
     * ค้นหากลุ่มงานโทรตาม zone ที่กำหนด
     *
     * @param string $userZone Zone ของผู้ใช้
     */
    public static function getGroupPhone($userZone)
    {
        return self::where('UserZone', $userZone)
                    ->where('GroupingType', 'P')
                    ->orderBy('GroupingTemp')
                    ->orderBy('HLDNO')
                    ->get();
    }

    public static function getPhoneData($userZone) {
        $groupPhone = self::getGroupPhone( $userZone );
        //----------------------------------------------------------------------------------------------------------
        // phone_unassigned
        $phone_unassigned = 0;
        $phone_unassigned += $groupPhone->where('CODLOAN', '1')->whereNull('FOLCODE')->groupBy('GroupingTemp')->count();
        $phone_unassigned += $groupPhone->where('CODLOAN', '2')->whereNull('FOLCODE')->groupBy('GroupingTemp')->count();
        //----------------------------------------------------------------------------------------------------------
        //$phone_unconfirmed
        $unconfirm = 0;
        if ($groupPhone->where('CODLOAN', '1')->whereNotNull('GroupingTemp')->whereNull('FOLCODE')->count() == 0) {
            $unconfirm += $groupPhone->where('CODLOAN', '1')
                ->whereNotNull('FOLCODE')
                ->where('GroupingState', '!=', 'Y')
                ->groupBy('FOLCODE')
                ->count();
        }
        if ($groupPhone->where('CODLOAN', '2')->whereNotNull('GroupingTemp')->whereNull('FOLCODE')->count() == 0) {
            $unconfirm += $groupPhone->where('CODLOAN', '2')
                ->whereNotNull('FOLCODE')
                ->where('GroupingState', '!=', 'Y')
                ->groupBy('FOLCODE')
                ->count();
        }
        $phone_unconfirmed = $unconfirm;
        //----------------------------------------------------------------------------------------------------------
        return array($groupPhone, $phone_unassigned, $phone_unconfirmed);
    }

    /**
     * ค้นหากลุ่มงานติดตาม zone ที่กำหนด (งานตาม = งานสินเชื่อ ทีมตามนอก)
     *
     * @param string $userZone Zone ของผู้ใช้
     */
    public static function getGroupTrack($userZone)
    {
        return self::where('UserZone', $userZone)
                    ->where('GroupingType', 'T')
                    ->orderBy('GroupingTemp')
                    ->orderBy('HLDNO')
                    ->get();
    }

    public static function getTrackData($userZone) {
        $groupTrack = self::getGroupTrack( $userZone );
        //----------------------------------------------------------------------------------------------------------
        // phone_unassigned
        $track_unassigned = 0;
        $track_unassigned += $groupTrack->where('CODLOAN', '1')->whereNull('FOLCODE')->groupBy('GroupingTemp')->count();
        $track_unassigned += $groupTrack->where('CODLOAN', '2')->whereNull('FOLCODE')->groupBy('GroupingTemp')->count();
        //----------------------------------------------------------------------------------------------------------
        //$phone_unconfirmed
        $unconfirm = 0;
        if ($groupTrack->where('CODLOAN', '1')->whereNotNull('GroupingTemp')->whereNull('FOLCODE')->count() == 0) {
            $unconfirm += $groupTrack->where('CODLOAN', '1')
                ->whereNotNull('FOLCODE')
                ->where('GroupingState', '!=', 'Y')
                ->groupBy('FOLCODE')
                ->count();
        }
        if ($groupTrack->where('CODLOAN', '2')->whereNotNull('GroupingTemp')->whereNull('FOLCODE')->count() == 0) {
            $unconfirm += $groupTrack->where('CODLOAN', '2')
                ->whereNotNull('FOLCODE')
                ->where('GroupingState', '!=', 'Y')
                ->groupBy('FOLCODE')
                ->count();
        }
        $track_unconfirmed = $unconfirm;
        //----------------------------------------------------------------------------------------------------------
        return array($groupTrack, $track_unassigned, $track_unconfirmed);
    }

    /**
     * ค้นหากลุ่มงานที่ดินตาม zone ที่กำหนด
     *
     * @param string $userZone Zone ของผู้ใช้
     */
    public static function getGroupLand($userZone)
    {
        return self::where('UserZone', $userZone)
                    ->where('GroupingType', 'L')
                    ->orderBy('GroupingTemp')
                    ->orderBy('HLDNO')
                    ->get();
    }

    public static function getLandData($userZone) {
        $groupLand = self::getGroupLand( $userZone );
        //----------------------------------------------------------------------------------------------------------
        // phone_unassigned
        $land_unassigned = $groupLand->whereNull('FOLCODE')->groupBy('GroupingTemp')->count();
        //----------------------------------------------------------------------------------------------------------
        //$phone_unconfirmed
        $unconfirm = 0;
        if ($groupLand->whereNotNull('GroupingTemp')->whereNull('FOLCODE')->count() == 0) {
            $unconfirm += $groupLand->whereNotNull('FOLCODE')
                ->where('GroupingState', '!=', 'Y')
                ->groupBy('FOLCODE')
                ->count();
        }
        $land_unconfirmed = $unconfirm;
        //----------------------------------------------------------------------------------------------------------
        return array($groupLand, $land_unassigned, $land_unconfirmed);
    }

}
