<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Payment Stream') }}
      </h2>

      <!-- <x-bladewind.button>Import Staff</x-bladewind.button> -->
    </div>
  </x-slot>
  <x-bladewind::notification />

  <x-bladewind::card>

    <form method="POST" class="signup-form" action="{{route('paymentStreams.update',$paymentStream)}}">
      @csrf
      @method('PUT')

      <h1 class="my-2 text-2xl font-light text-blue-900/80">{{ $paymentStream->name }}</h1>
      <p class="mt-3 mb-6 text-red-500/80 text-sm">
        NB: updating stream settings will clear all payslips in stream, this is to make sure new settings reflect on all payslips
      </p>
      <div class="grid gap-2 grid-cols-1 md:grid-cols-2">

        <div class="flex flex-col">
          <input type="text" name="name" required placeholder="Stream Name" value="{{ old('name',$paymentStream->name) }}" />
          @error('name')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <label for="pay_month">Payment Month</label>
          <input type="month" name="payment_month" id="pay_month" value="{{ old('payment_month',$paymentStream->payment_month) }}">
          @error('payment_month')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror

          <label for="items">Salary items to pay</label>
          <select name="salary_items[]" id="items" multiple data-placeholder="Select salary items">
            
            @foreach($salaryItems as $item)
            <option value="{{ $item->id }}" {{ in_array($item->id,$paymentStream->salaryItems()->allRelatedIds()->toArray()) ? 'selected' : '' }} >{{ $item->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="flex flex-col">
          <x-bladewind.checkbox label="Process Deductions?" name="process_deductions" checked="{{ $paymentStream->process_deductions?'true':'false' }}" value="1" />
          <x-bladewind.checkbox label="Pay basic salaries?" name="include_basic_salary" checked="{{ $paymentStream->include_basic_salary?'true':'false' }}" value="1" />
          <x-bladewind.checkbox label="Pay overtimes?" name="include_overtime" checked="{{ $paymentStream->include_overtime?'true':'false' }}" value="1" />
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
    $(function() {
      $("#items").select2()
    })
  </script>
  @endsection
</x-app-layout>