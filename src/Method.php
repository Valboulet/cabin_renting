<?php

namespace App;

class Method {

    private static function formatDate(string $bookingWeek): array
    {
        $date = [
            'year' => substr($bookingWeek, 0, 4),
            'week' => substr($bookingWeek, -2, 2)
        ]; 
        $firstDay = date('d/m/Y', strtotime($date['year'] . 'W' . $date['week'] . '1'));
        $lasttDay = date('d/m/Y', strtotime($date['year'] . 'W' . $date['week'] . '7'));

        $dataDate = [$date, $firstDay, $lasttDay];
        return $dataDate;
    }

    // Returns the date format "202405" in format "Semaine 05-2024 (02/03/2024 - 09/03/2024)"
    public static function displayDate(string $bookingWeek): string
    {
        $dataDate = self::formatDate($bookingWeek);
        $displayDate = 'Semaine ' . $dataDate[0]['week']. '-' . $dataDate[0]['year'];
        
        $displayDate .= ' ('. $dataDate[1] . ' - ' . $dataDate[2] . ')';
        return $displayDate;  
    }

    // Returns the date in format "Du 29/01/2024 au 04/02/2024"
    public static function displayDateClient(string $bookingWeek): string
    {
        $dataDate = self::formatDate($bookingWeek);
        return "Du {$dataDate[1]} au {$dataDate[2]}";
    }


    // Returns the date format "Semaine 05-2024 (02/03/2024 - 09/03/2024)" in format "202405"
    public static function reverseDisplayDate(string $displayDate): string
    {
        $week = substr($displayDate, 8, 2);
        $year = substr($displayDate, 11, 4);

        return $year . $week;
    }

    // // Returns date for week picker in format "2024-W05"
    public static function displayDateWeekPicker(string $week): string
    {
        $year = substr($week, 0, 4);
        $selectedWeek = substr($week, 4);

        return $year . '-W' . $selectedWeek;
    }

    // Returns bedrooms number
    public static function roomNumbers(string $cabinName): string
    {
        $numberRoom = substr($cabinName, 7, 1);
        if ($numberRoom > 1 && $numberRoom <= 5) {
            $bedrooms = $numberRoom . ' chambres';
        } elseif ($numberRoom == 1){
            $bedrooms = $numberRoom . ' chambre';
        } else {
            $bedrooms = '';
        }
        return $bedrooms;
    }


    // Generate randow Password
    public static function generatePassword(): string
    {
        $lowercase = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 5, 2);
        $uppercase = substr(str_shuffle(strtoupper($lowercase)), 12, 2);;
        $numbers = substr(str_shuffle('0123456789'), 3, 2);
        $specialChars = substr(str_shuffle('#$&@*+-=_'), -1, 2);;

        return str_shuffle($lowercase . $uppercase . $numbers . $specialChars);
    }
}