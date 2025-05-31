@extends('layout.master')
@push('styles')
    @livewireStyles
@endpush

@section('content')
    @livewire('detail-order')
@endsection

@push('script')
    @livewireScripts
    <script src="https://kit.fontawesome.com/d074033519.js" crossorigin="anonymous"></script>
@endpush
