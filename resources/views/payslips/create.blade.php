<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Payslips') }}
      </h2>

      <x-bladewind.button tag="a" href="{{route('paymentStreams.payslips.index',$paymentStream)}}">Back to {{ $paymentStream->name }}</x-bladewind.button>

    </div>
  </x-slot>
  <x-bladewind::notification />

  <x-bladewind::card>

    <form method="POST" class="signup-form" action="{{route('paymentStreams.payslips.store',$paymentStream)}}" x-data="model">
      @csrf

      <h1 class="my-2 text-2xl font-light text-blue-900/80">Create Payslips for {{ $paymentStream->name }} </h1>
      <p class="mt-3 mb-6 text-blue-900/80 text-sm">
        Payslips can be created by department, branch, designation or office type.
      </p>
      <div class="grid gap-2 grid-cols-1 md:grid-cols-2">
        <div class="flex flex-col">
          <label for="paying_by">Pay by</label>
          <select x-model="payBy" name="paying_by">
           <option value="department">Department</option>
           <option value="branch">Branch</option>
           <option value="designation">Designation</option>
           <option value="officeType">Office Type</option>
          </select>
          @error('paying_by')
            <span class="text-red-600 my-1">{{ $message }}</span>
            @enderror
        </div>

        
        <!-- pay by -->
        <template x-if="payBy == `department`">
          <div class="flex flex-col">
            <label for="stream">Select Department</label>
            <select name="paying_id" id="stream">
              @foreach($departments as $dept)
              <option value="{{$dept->id}}">{{$dept->name}}</option>
              @endforeach
            </select>
            @error('paying_id')
            <span class="text-red-600 my-1">{{ $message }}</span>
            @enderror
          </div>
        </template>
        <!-- branch -->
        <template x-if="payBy == `branch`">
          <div class="flex flex-col">
            <label for="paying_id">Select Branch</label>
            <select name="paying_id" id="paying_id">
              @foreach($branches as $branch)
              <option value="{{$branch->id}}">{{$branch->name}}</option>
              @endforeach
            </select>
            @error('paying_id')
            <span class="text-red-600 my-1">{{ $message }}</span>
            @enderror
          </div>
        </template>
        <!-- designation -->
        <template x-if="payBy == `designation`">
          <div class="flex flex-col">
            <label for="paying_id">Select Designation</label>
            <select name="paying_id" id="paying_id">
              @foreach($designations as $designation)
              <option value="{{$designation->id}}">{{$designation->name}}</option>
              @endforeach
            </select>
            @error('paying_id')
            <span class="text-red-600 my-1">{{ $message }}</span>
            @enderror
          </div>
        </template>
        <template x-if="payBy == `officeType`">
          <div class="flex flex-col">
            <label for="paying_id">Select Office type</label>
            <select name="paying_id" id="paying_id">
              @foreach($office_types as $office)
              <option value="{{$office->id}}">{{$office->name}}</option>
              @endforeach
            </select>
            @error('paying_id')
            <span class="text-red-600 my-1">{{ $message }}</span>
            @enderror
          </div>
          
        </template>

        <div>

          <x-bladewind::button name="btn-save" has_spinner="true" type="primary" can_submit="true" class="mt-3">
            SUBMIT
          </x-bladewind::button>

        </div>
      </div>

    </form>

  </x-bladewind::card>
  @section('script')
  <script>
    let model = function() {
      return {
        payBy : 'department'
      }
    }
  </script>
  @endsection
</x-app-layout>