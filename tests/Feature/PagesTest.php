<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function test_home_page_returns_200(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_deploy_page_returns_200(): void
    {
        $this->get('/deploy')->assertStatus(200);
    }

    public function test_launch_page_returns_200(): void
    {
        $this->get('/launch')->assertStatus(200);
    }

    public function test_confirmation_page_returns_200(): void
    {
        $this->get('/confirmation')->assertStatus(200);
    }
}
