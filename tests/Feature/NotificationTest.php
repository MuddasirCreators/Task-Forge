<?php

namespace Tests\Feature;


use Tests\TestCase;

use App\Models\User;
use App\Models\Project;

use App\Notifications\ProjectAssignedNotification;

use Illuminate\Support\Facades\Notification;

use Illuminate\Foundation\Testing\RefreshDatabase;



class NotificationTest extends TestCase
{

use RefreshDatabase;



public function test_project_assignment_notification_is_sent()
{


Notification::fake();



$user=User::factory()->create();


$project=Project::factory()->create();



$user->notify(

new ProjectAssignedNotification($project)

);



Notification::assertSentTo(

$user,

ProjectAssignedNotification::class

);


}



}