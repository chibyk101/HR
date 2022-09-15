<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Branch') }}
      </h2>

      <!-- <x-bladewind.button>Import Staff</x-bladewind.button> -->
    </div>
  </x-slot>
  <x-bladewind::notification />

  <x-bladewind::card>

    <form method="POST" class="signup-form" action="{{route('branches.update',$branch)}}">
      @csrf
      @method('PUT')

      <h1 class="my-2 text-2xl font-light text-blue-900/80">{{ $branch->name }}</h1>
      <div class="grid gap-2 grid-cols-1 md:grid-cols-2">

        <div class="flex flex-col">
          <input type="text" name="name" required placeholder="Stream Name" value="{{ old('name',$branch->name) }}" />
          @error('name')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>
        <div class="flex flex-col">
        <select name="department_id" id="departments-select" style="width: 400px !important;" data-placeholder="Select Subsidiary" class="mb-5">
    
          @if($branch->department)
          <option value="{{ $branch->department->id }}" selected>{{ $branch->department->name }}</option>
          @endif
      </select>
        @error('department_id')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
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
  <script>
    $(function(){
      $("#departments-select").select2({
          ajax: {
            url: "{{route('ajax.departments.search')}}",
            processResults: function(data) {
              return {
                results: data
              };
            },
            delay: 250,
          }
        })
    })
  </script>
  @endsection
</x-app-layout>