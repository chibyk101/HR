<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Document upload') }}
      </h2>

      <x-bladewind.button tag="a" href="{{ route('users.show',$user) }}">Back to employee profile</x-bladewind.button>
    </div>
  </x-slot>
  <x-bladewind::notification />

  <x-bladewind::card>
    <form method="POST" class="signup-form" action="{{route('documents.employeeDocuments.store',[$document,$user])}}" enctype="multipart/form-data">
      @csrf
      <h1 class="my-2 text-2xl font-light text-blue-900/80">{{ $document->name }}</h1>
      <p class="mt-3 mb-6 text-blue-900/80 text-sm">
        upload {{ $document->name }} for {{ $user->name }}
      </p>
      <div class="grid gap-2 grid-cols-1 md:grid-cols-2">

        <div class="flex flex-col">
          <input type="file" name="document_file" required placeholder=" document file" />
        </div>
        
        @error('document_file')
        <span class="text-red-600 my-1">{{ $message }}</span>
        @enderror
        <div class="text-center">

          <x-bladewind::button name="btn-save" has_spinner="true" type="primary" can_submit="true" class="mt-3">
            UPLOAD
          </x-bladewind::button>

        </div>
      </div>

    </form>

  </x-bladewind::card>
  @section('script')

  @endsection
</x-app-layout>