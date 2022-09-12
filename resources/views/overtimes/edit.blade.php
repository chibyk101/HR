<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Deduction') }}
      </h2>

      <!-- <x-bladewind.button>Import Staff</x-bladewind.button> -->
    </div>
  </x-slot>
  <x-bladewind::notification />

  <x-bladewind::card>

    <form method="POST" class="signup-form" action="{{route('overtimes.update',$overtime)}}">
      @csrf
      @method('PUT')

      <h1 class="my-2 text-2xl font-light text-blue-900/80">{{ $overtime->name }}</h1>
      <p class="mt-3 mb-6 text-blue-900/80 text-sm">
        Edit
      </p>
      <div class="grid gap-2 grid-cols-1 md:grid-cols-2">

        <div class="flex flex-col">
          <label for="name">Overtime title</label>
          <input type="text" id="name" name="name" required placeholder="Overtime title" value="{{ old('name',$overtime->name) }}" />
          @error('name')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <label for="hours">Hours</label>
          <input type="number" name="hours" id="hours" value="{{ old('hours',$overtime->hours) }}">
          @error('hours')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>
        <div class="flex flex-col">
          <label for="rate">Rate (%)</label>
          <input type="text" name="rate" id="rate" required placeholder="Rate (%)" value="{{ old('rate',$overtime->rate) }}" />
          @error('rate')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <label for="pay_month">Number of days</label>
          <input type="number" name="number_of_days" id="pay_month" value="{{ old('number_of_days',$overtime->number_of_days) }}">
          @error('number_of_days')
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

  @endsection
</x-app-layout>