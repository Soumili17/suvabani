<?php

namespace Tests\Feature;

use App\Models\Gallery;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RecentProjectsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->string('image')->nullable();
            $table->string('type')->default('image');
            $table->string('video_url')->nullable();
            $table->timestamps();
        });

        Schema::create('home_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('youtube_url');
            $table->timestamps();
        });

        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function test_homepage_recent_projects_use_the_latest_gallery_photo_per_category(): void
    {
        Gallery::create([
            'title' => 'Older food photo',
            'category' => 'Food Distribution',
            'image' => 'gallery/old-food.jpg',
            'type' => 'image',
        ]);
        Gallery::create([
            'title' => 'Latest food photo',
            'category' => 'Food Distribution',
            'image' => 'gallery/latest-food.jpg',
            'type' => 'image',
        ]);
        Gallery::create([
            'title' => 'Video entry',
            'category' => 'Education for All',
            'type' => 'youtube',
            'video_url' => 'https://youtu.be/example',
        ]);

        $response = $this->get('/');
        $response->assertOk();

        $content = $response->getContent();
        $projectsStart = strpos($content, '<section class="projects');
        $galleryStart = strpos($content, '<!-- GALLERY -->', $projectsStart);
        $projectsSection = substr($content, $projectsStart, $galleryStart - $projectsStart);

        $this->assertStringContainsString('Latest food photo', $projectsSection);
        $this->assertStringContainsString('Food Distribution', $projectsSection);
        $this->assertStringNotContainsString('Older food photo', $projectsSection);
    }

    public function test_gallery_photo_upload_saves_its_path_and_metadata_to_the_database(): void
    {
        Storage::fake('public');
        $this->withoutMiddleware();

        $response = $this->post(route('dashboard.gallery.store'), [
            'title' => 'Community meal',
            'category' => 'Food Distribution',
            'type' => 'image',
            'image' => UploadedFile::fake()->image('community-meal.jpg'),
        ]);

        $response->assertRedirect(route('dashboard.gallery'));

        $galleryItem = Gallery::where('title', 'Community meal')->firstOrFail();
        $this->assertSame('Food Distribution', $galleryItem->category);
        $this->assertSame('image', $galleryItem->type);
        $this->assertNotEmpty($galleryItem->image);
        Storage::disk('public')->assertExists($galleryItem->image);
    }
}
