
@extends('layouts.admin_layout')

@section('content')
  @include('includes.user_sidebar', ['requestStatus' => $requestStatus])
    <x-page-heading>Update Account</x-page-heading>

    <x-forms.form method="POST" action="{{ route('profile.update', auth()->user()->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH') <!-- Use PATCH for updating -->
        
        <x-forms.input label="Email" name="email" placeholder="Enter Email" value="{{ auth()->user()->email }}" required />
        <x-forms.input label="phone" name="phone" value="{{ auth()->user()->phone }}" />

        <x-forms.input label="Country" name="country" value="{{ auth()->user()->country }}" required />
        <x-forms.input label="city" name="city" value="{{ auth()->user()->city }}" />


        <x-forms.divider />

        <x-forms.input label="Display Image" name="image" type="file" />

        @if($user->image)
            <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="{{ auth()->user()->name }}" style="width: 50px; height: auto;">
        @else
            No Image
        @endif

        <x-forms.divider />

        <x-forms.button>Update</x-forms.button>
    </x-forms.form>
@endsection
