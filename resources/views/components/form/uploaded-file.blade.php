@props([
    'file' => '',
    'file_original_name' => '',
    'type' => 'image', // image | kml | pdf
    'is_preview' => false
])
<div class="card">
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->

    @php
        $file_path = '/storage/'.$file;
        $fullPath = public_path($file_path);
        $fileExists = file_exists($fullPath);
    @endphp

    @if($fileExists)
        <img
            class="card-img-top img-fluid"
            alt="{{ $file_original_name }}"
            src="{{ $type == 'image' ? Storage::url($file) :
                    ($type == 'pdf' ? asset('assets/images/icon/document.png') :
                    asset('assets/images/icon/setting.png')) }}"
            data-holder-rendered="true"
        >
        <div class="card-body">
            <h5 class="card-title">{{ $file_original_name }}</h5>
            <a
                href="{{ Storage::url($file) }}"
                class="btn btn-info btn-sm waves-effect btn-label waves-light m-1"
                target="_blank"
            ><i class="bx bxs-file-pdf label-icon"></i>
                Lihat
            </a>
            @if(!$is_preview)
                <button type="button" {{ $attributes->whereStartsWith('wire:') }}
                class="btn btn-danger btn-sm waves-effect btn-label waves-light m-1">
                    <i class="bx bx-trash label-icon"></i>Hapus
                </button>
            @endif
        </div>
    @else
        <img
            class="card-img-top img-fluid"
            alt="{{ $file_original_name }}"
            src="{{ asset('assets/images/icon/damages.png') }}"
            data-holder-rendered="true"
        >
        <div class="card-body">
            <h5 class="card-title">Silahkan upload {{ $file_original_name }} lagi!</h5>
            <a
                href="{{ Storage::url($file) }}"
                class="btn btn-warning btn-sm waves-effect btn-label waves-light m-1"
                target="_blank"
            ><i class="bx bxs-file-pdf label-icon"></i>
                Berkas rusak!
            </a>
            @if(!$is_preview)
                <button type="button" {{ $attributes->whereStartsWith('wire:') }}
                class="btn btn-danger btn-sm waves-effect btn-label waves-light m-1">
                    <i class="bx bx-trash label-icon"></i>Hapus
                </button>
            @endif
        </div>
    @endif
</div>
