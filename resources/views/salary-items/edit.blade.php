<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __($salaryItem->name) }}
      </h2>
    </div>
  </x-slot>
  <x-bladewind::notification />

  <x-bladewind::card>

    <form method="POST" class="signup-form" action="{{route('salaryItems.update',$salaryItem)}}" x-data="model" x-init="initModel">
      @csrf
      @method('PUT')
      <h1 class="my-2 text-2xl font-light text-blue-900/80">Edit Salary Item</h1>
      <!-- <p class="mt-3 mb-6 text-blue-900/80 text-sm">
        Employee Information
      </p> -->
      <div class="grid gap-2 grid-cols-1 md:grid-cols-2">

        <div class="flex flex-col">
          <x-bladewind::input name="name" required="true" label="Item Name" value="{{ old('name',$salaryItem->name) }}" />
          @error('name')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror

        </div>
      </div>
      <div class="text-center">

        <x-bladewind::button name="btn-save" has_spinner="true" type="primary" can_submit="true" class="mt-3">
          SUBMIT
        </x-bladewind::button>

      </div>

    </form>

  </x-bladewind::card>
</x-app-layout>