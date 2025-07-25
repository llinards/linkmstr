@if (session('message'))
    <x-success-alert class="mb-6">
        {{ session('message') }}
    </x-success-alert>
@endif

@if (session('error'))
    <x-error-alert class="mb-6">
        {{ session('error') }}
    </x-error-alert>
@endif
