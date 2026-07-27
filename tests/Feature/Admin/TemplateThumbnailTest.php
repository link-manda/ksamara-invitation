<?php

use App\Models\Template;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    $this->admin = User::factory()->create(['role' => 'admin']);
});

test('admin can upload a thumbnail image when creating a template', function () {
    $file = UploadedFile::fake()->image('template-preview.jpg');

    $response = $this->actingAs($this->admin)->post(route('admin.templates.store'), [
        'name' => 'Template With Thumbnail',
        'view_path' => 'themes.with_thumbnail',
        'thumbnail' => $file,
        'is_active' => 1,
    ]);

    $response->assertRedirect(route('admin.templates.index'));

    $template = Template::where('name', 'Template With Thumbnail')->first();
    expect($template)->not->toBeNull();
    expect($template->thumbnail_path)->not->toBeNull();

    Storage::disk('public')->assertExists($template->thumbnail_path);
});

test('admin can replace a thumbnail and old thumbnail file is deleted from storage', function () {
    $oldFile = UploadedFile::fake()->image('old-preview.jpg');

    $template = Template::factory()->create([
        'name' => 'Template Old Preview',
        'view_path' => 'themes.old_preview',
        'thumbnail_path' => $oldFile->store('templates/thumbnails', 'public'),
    ]);

    Storage::disk('public')->assertExists($template->thumbnail_path);
    $oldPath = $template->thumbnail_path;

    $newFile = UploadedFile::fake()->image('new-preview.jpg');

    $response = $this->actingAs($this->admin)->put(route('admin.templates.update', $template->id), [
        'name' => 'Template Old Preview Updated',
        'view_path' => 'themes.old_preview',
        'thumbnail' => $newFile,
        'is_active' => 1,
    ]);

    $response->assertRedirect(route('admin.templates.index'));

    $template->refresh();
    expect($template->thumbnail_path)->not->toBe($oldPath);
    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($template->thumbnail_path);
});

test('deleting a template removes its thumbnail image from storage', function () {
    $file = UploadedFile::fake()->image('template-to-delete.png');

    $template = Template::factory()->create([
        'name' => 'Template Delete Me',
        'view_path' => 'themes.delete_me',
        'thumbnail_path' => $file->store('templates/thumbnails', 'public'),
    ]);

    Storage::disk('public')->assertExists($template->thumbnail_path);
    $path = $template->thumbnail_path;

    $response = $this->actingAs($this->admin)->delete(route('admin.templates.destroy', $template->id));

    $response->assertRedirect(route('admin.templates.index'));
    $this->assertDatabaseMissing('templates', ['id' => $template->id]);
    Storage::disk('public')->assertMissing($path);
});
