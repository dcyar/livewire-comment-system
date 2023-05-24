<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Comments;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CommentsTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Comments::class);

        $component->assertStatus(200);
    }
}
