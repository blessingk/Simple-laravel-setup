<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\Birthday;

class BirthdayTest extends TestCase
{
    /**
     * @var string
     */
    private $birthday;

    public function setUp() : void
    {
        parent::setUp();
        $this->birthday = $this->app->make(Birthday::class);
    }

    /**
     * Test get all employees.
     *
     * @return void
     */
    public function testGetEmployees()
    {
        $response = $this->birthday->getEmployees();
        $this->assertIsArray($response);
        $this->assertCount(131, $response);
    }

    /**
     * Test get excluded employees.
     *
     * @return void
     */
    public function testGetEmployeesNotToSendWishes()
    {
        $response = $this->birthday->getEmployeesNotToSendWishes();
        $this->assertIsArray($response);
        $this->assertCount(3, $response);
    }

    /**
     * Test send birthday wishes.
     *
     * @return void
     */
    public function testSendBirthdayWish()
    {
        $response = $this->birthday->sendBirthdayWish();
        $this->assertTrue($response);
    }

    /**
     * Test isEmployeeBirthday check.
     *
     * @return void
     */
    public function testIsEmployeeBirthday()
    {
        $excludedEmployeeIds = $this->birthday->getEmployeesNotToSendWishes();
        $allEmployees = $this->birthday->getEmployees();
        $firstEmployee = collect($allEmployees)->whereNull('employmentEndDate')->whereNotNull('dateOfBirth')->whereNotIn('id', $excludedEmployeeIds)->first();
        $response = $this->birthday->isEmployeeBirthday($firstEmployee);
        $this->assertIsBool($response);
    }

}
