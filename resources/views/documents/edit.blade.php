<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Document') }}
      </h2>

      <!-- <x-bladewind.button>Import Staff</x-bladewind.button> -->
    </div>
  </x-slot>
  <x-bladewind::notification />

  <x-bladewind::card>

    <form method="POST" class="signup-form" action="{{route('documents.update',$document)}}">
      @csrf
      @method('PUT')

      <h1 class="my-2 text-2xl font-light text-blue-900/80">{{ $document->name }}</h1>
      <p class="mt-3 mb-6 text-blue-900/80 text-sm">
        Edit
      </p>
      <div class="grid gap-2 grid-cols-1 md:grid-cols-2">

        <div class="flex flex-col">
          <input type="text" name="name" required placeholder="Stream Name" value="{{ old('name',$document->name) }}" />
          @error('name')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>
        <div class="flex flex-col">
          <x-bladewind.checkbox label="Is compulsory ?" name="is_required" checked="{{ $document->is_required?'true':'false' }}" value="1" />
        </div>

        <div class="text-center">

          <x-bladewind::button name="btn-save" has_spinner="true" type="primary" can_submit="true" class="mt-3">
            SUBMIT
          </x-bladewind::button>

        </div>
      </div>

    </form>

  </x-bladewind::card>
  @section('script')

  @endsection
</x-app-layout>