<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Log;

class ChallengeTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * 
     */
    public function a_user_can_create_a_challenge()
    {
        $this->withoutExceptionHandling();

        $attributes = factory('App\Challenge')->raw();

        $this->post('/challenges', $attributes);
        $this->assertDatabaseHas('challenges', $attributes);
        $this->get('/challenges')->assertSee($attributes['title']);
    }

    /** @test */
    public function missing_title_thorws_an_error(){
        $attributes = factory('App\Challenge')->raw(['title' => '']);
        $this->post('/challenges', [])->assertSessionHasErrors('title');
    }

    /** @test */ 
    public function challenge_details_can_be_viewed(){
        //create a challenge 
        $challenge = factory('App\Challenge')->create();
        //see it on the main page
        $this->get('/challenges/' . $challenge->id)->assertSee($challenge->title);
        //go to a details page and view the challenge details 
    }
}
