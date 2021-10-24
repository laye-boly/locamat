<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Equipment;

use Illuminate\Support\Facades\DB;

class DateFormatService {

    public function formatDate(string $timestamp){
        $date = date('D j M Y', $timestamp);
        $dateArray  = explode(' ', $date);
        $day = 'lundi';
        switch ($dateArray[0]) {
            case 'Mon':
                $day = 'lundi';
                break;
            case 'Tue':
                $day = 'mardi';
                break;
            case 'Wes':
                $day = 'mercredi';
                break;
            case 'Thu':
                $day = 'jeudi';
                break;
            case 'Fri':
                $day = 'vendredi';
                break;
            case 'Sat':
                $day = 'samedi';
                break;
            case 'Sun':
                $day = 'dimanche';
                break;
            
            default:
                # code...
                break;
        }

        $month = 'janvier';
        switch ($dateArray[2]) {
            case 'Jan':
                $month = 'janvier';
                break;
            case 'Feb':
                $month = 'février';
                break;
            case 'Mar':
                $month = 'mars';
                break;
            case 'Apr':
                $month = 'avril';
                break;
            case 'May':
                $month = 'mai';
                break;
            case 'Jun':
                $month = 'juin';
                break;
            case 'Jul':
                $month = 'juilliet';
                break;
            case 'Aug':
                $month = 'août';
                break;
            case 'Sep':
                $month = 'septembre';
                break;
            case 'Oct':
                $month = 'octobre';
                break;
            case 'Nov':
                $month = 'novembre';
                break;
            case 'Dec':
                $month = 'décembre';
                break;
            
            
            default:
                # code...
                break;
        }
    
        return "$day $dateArray[1] $month $dateArray[3]";

    }
}
