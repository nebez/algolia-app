<?php

namespace Tests\Application;

use Tests\Helpers\ApplicationTestCase;

class InfoControllerTest extends ApplicationTestCase {

    public function testThatApplicationInfoIsReturned()
    {
        $this->visit('/api/1/info')
            ->status(200)
            ->seeJson(['appId' => 'fake_app_id', 'apiKey' => 'fake_api_key']);
    }
}
