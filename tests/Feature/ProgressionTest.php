<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use App\Progression;
use App\Events\UserEarnedExperience;
use Log;

class ProgressionTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_buy_a_box_with_xp(){
        Event::fake();
        $user = factory('App\User')->create();
        $user->progression()->save(new Progression);
        $user->load('progression');
        $user->progression->awardExperience(1000);
        $user->progression->buyBox(200, 1);
        $user->load('progression');
        print $user;
        $this->assertTrue($user->progression->lifetime_xp !== $user->progression->current_xp);
    }

    /** @test */ 
    public function a_user_can_open_a_box_and_receive_a_reward() {
        //create the world 
        $user = factory('App\User')->create();
        $user->progression()->save(new Progression); 
        $user->load('progression'); 
        $reward = factory('App\Reward')->create();

        $user->progression->awardExperience(1000);
        $user->progression->buyBox(200, 1); 
        $user->load('progression');
        $user->progression->openBox(98);
        print("Here are the associated rewards");
        $user->load('rewards');
        print($user->rewards->count());
        $this->assertTrue($user->rewards->count() > 0);


        //open it 

        //get random reward
    }

    
    public function a_new_user_levels_up_at_200_points(){
        //create a user
        Event::fake();
        $user = factory('App\User')->create();

        $user->progression()->save(new Progression);

        //attach a progression 
        $user->load('progression');

        $user->progression->awardExperience(201); 

        //print($user->progression);
        $user->load('progression');
        //print($user->progression);

        $this->assertTrue($user->progression->level === 2);

        //award 200 xp 

        //check and make sure that user leveled up
    }
    /** @test */
    public function a_user_has_a_progression(){
        $user = factory('App\User')->create();

        $user->progression()->save(new Progression);
        //attach a progression
        $user->load('progression');
        //print($user);
        $this->assertTrue($user->progression->id !== 0);
    }

    /** @test */
    public function a_user_can_receive_xp(){
        //create a user
        $user = factory('App\User')->create(); 

        $user->progression()->save(new Progression);

        $user->load('progression');

        $user->progression->awardExperience(200);

        //Here we should announce that has some experience has been awarded

        //print($user->progression);

        $this->assertTrue($user->progression->current_xp === 200 );

    }
    /** @test */
    public function an_announcement_is_made_when_experience_is_earned(){
        Event::fake();

        $user = factory('App\User')->create(); 

        $user->progression()->save(new Progression);

        $user->load('progression');

        $user->progression->awardExperience(200);

        //put things into motion 

        Event::assertDispatched(UserEarnedExperience::class);
    }



}
