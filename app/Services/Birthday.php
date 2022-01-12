<?php

namespace App\Services;

use Carbon\Carbon;
use App\Mail\BirthdayWish;
use Illuminate\Support\Facades\Mail;

class Birthday
{
    private $endpoint = 'https://interview-assessment-1.realmdigital.co.za/';
    private $birthdayMail  = 'birthdays@realmdigital.co.za';

    /**
     * Get all employees
     * @return mixed
     */
    public function getEmployees()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL =>  $this->endpoint . 'employees',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    /**
     * Get all employeeIds not send birthday wishes
     * @return mixed
     */
    public function getEmployeesNotToSendWishes()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL =>  $this->endpoint . 'do-not-send-birthday-wishes',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    /**
     * Send all today's birthday wishes
     */
    public function sendBirthdayWish()
    {
        $allEmployees = $this->getEmployees();
        $excludedEmployeeIds = $this->getEmployeesNotToSendWishes();
        $employees = collect($allEmployees)->whereNull('employmentEndDate')->whereNotNull('dateOfBirth')->whereNotIn('id', $excludedEmployeeIds);

        foreach ($employees as $employee) {
            if ($this->isEmployeeBirthday($employee)) {
                Mail::to($this->birthdayMail)->send(new BirthdayWish($employee));
            }
        }
        return true;
    }

    /**
     * Check if its employee birthday
     * @param $employee
     * @return bool
     */
    public function isEmployeeBirthday($employee): bool
    {
        $today = Carbon::now();
        $employeeDateOfBirth = Carbon::parse($employee->dateOfBirth);
        $employmentStartDate = Carbon::parse($employee->employmentStartDate);
        if(
            $today->format('m') == $employeeDateOfBirth->format('m') &&
            $today->format('d') == $employeeDateOfBirth->format('d') &&
            $employmentStartDate->format('Y-m-d') < $today->format('Y-m-d')
        ) {
            return true;
        }
        return false;
    }

    /**
     * Check if its employee work anniversary
     * @param $employee
     */
    public function isEmployeeWorkAnniversary($employee)
    {
        //TODO - Check if employee work anniversary
    }

}
