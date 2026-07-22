@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <flux:heading size="xl">{{ isset($template) ? 'Edit Template' : 'Tambah Template' }}</flux:heading>
    <flux:subheading>Lengkapi form di bawah ini untuk menyimpan data template.</flux:subheading>
</div>

<flux:card class="max-w-2xl">
    <form action="{{ isset($template) ? route('admin.templates.update', $template->id) : route('admin.templates.store') }}" method="POST" class="flex flex-col gap-6">
        @csrf
        @if(isset($template))
            @method('PUT')
        @endif

        <flux:input 
            name="name" 
            label="Nama Template" 
            placeholder="Contoh: Elegan Gold" 
            value="{{ old('name', $template->name ?? '') }}" 
            required 
        />

        <flux:input 
            name="view_path" 
            label="View Path" 
            placeholder="Contoh: themes.elegan_gold" 
            description="Tentukan letak file blade untuk template ini (gunakan format dot)."
            value="{{ old('view_path', $template->view_path ?? '') }}" 
            required 
        />

        <flux:checkbox 
            name="is_active" 
            label="Aktifkan Template Ini" 
            description="Template yang aktif dapat dipilih oleh kustomer saat membuat undangan."
            value="1"
            :checked="old('is_active', $template->is_active ?? true)"
        />

        <div class="flex gap-2">
            <flux:button type="submit" variant="primary">Simpan</flux:button>
            <flux:button href="{{ route('admin.templates.index') }}">Batal</flux:button>
        </div>
    </form>
</flux:card>
@endsection
