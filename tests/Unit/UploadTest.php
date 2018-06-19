<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UploadTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
//     public function testExample()
//     {
//         $this->assertTrue(true);
//     }

    public function testUpload()
    {
        Storage::fake('avatars');
        
        $response = $this->json('POST', '/upload', [
            'avatar' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        
        Storage::disk('avatars')->assertExists('avatar.jpg');
    }
}
