<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Comment::class);

        $component->assertStatus(200);
    }
}
