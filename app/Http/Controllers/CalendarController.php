<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DateFormatService;
use App\Services\DateScheduleService;
use App\Events\ItemToDeleteEvent;

class CalendarController extends Controller
{
    public function index(DateFormatService $dateFormatService, DateScheduleService $dateScheduleService){
        $actualWeekTimestamp  = [];
        $actualDayTimestamp = time();
        for($i = 0; $i < 7; $i++){
            $dayITimestamp = $actualDayTimestamp + $i * 24 * 3600;
            $actualWeekTimestamp[] = $dayITimestamp;
        }
        $weekSchedule = [];
        
        foreach ($actualWeekTimestamp as $dayTimestamp) {
            $date = new \DateTime();
            $date = $date->setTimestamp($dayTimestamp);
            $availbleEquipments = $dateScheduleService->getDateAvailableEquipment($date);
            $weekSchedule[$dateFormatService->formatDate($dayTimestamp)] = $availbleEquipments;
          
        }
       
        return view('calendars.index', ['weekSchedule' => $weekSchedule]);
    }
}
