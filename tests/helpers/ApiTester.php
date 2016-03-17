<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class ApiTester extends TestCase
{
    use WithoutMiddleware;
    use DatabaseMigrations;

    protected $fake;

    function __construct()
    {
        $this->fake = Faker::create();
    }

    /**
     * [setUp description]
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * [getJson description]
     * @param  [type] $uri [description]
     * @return [type]      [description]
     */
    protected function getJson($uri, $method = 'GET', $parameters = [])
    {
        return json_decode(
            $this->call($method, $uri, $parameters)
                 ->getContent()
        );
    }

    /**
     * [assertObjectHasAttributes description]
     * @return [type] [description]
     */
    protected function assertObjectHasAttributes()
    {
        $args = func_get_args();
        $object = array_shift($args);

        foreach ($args as $attribute)
        {
            $this->assertObjectHasAttribute($attribute, $object);
        }
    }


}