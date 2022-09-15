<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Edit payslip') }}
      </h2>
      <x-bladewind.button tag="a" href="{{route('paymentStreams.payslips.index',$payslip->paymentStream)}}"> back to payslips </x-bladewind.button>
    </div>
  </x-slot>
  <x-bladewind::notification />
  @php
  $user = $payslip->user;
  @endphp
  <!-- salary items-->
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <div class="flex justify-between mb-3">
            <h5 class="font-medium leading-tight text-xl mt-0 mb-2 text-gray-600">Salary items</h5>
            <button onclick="showModal('add-salary-item')"  class="mb-2 inline-block px-6 py-2 border-2 border-green-600 text-green-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">add salary item</button>
          </div>
          <table class="min-w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Salary item
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Amount
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">

                </th>
              </tr>
            </thead class="border-b">
            <tbody>
              <form action="{{ route('update-basic-salary',$user) }}" method="post">
                <tr class="bg-white border-b">
                  @csrf
                  @method('PUT')
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    Basic Salary
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    <input type="number" value="{{ old('basic_salary',$user->basic_salary) }}" name="basic_salary">
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    <button  class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">update</button>
                  </td>
                </tr>
              </form>
              @foreach($user->salaryItems as $item)

              <form action="{{route('salaryItems.users.update',$user)}}" method="post">
                @csrf
                @method('PUT')
                <tr class="bg-white border-b">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ $item->name }}
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    <input type="hidden" name="salary_item_id" value="{{$item->id}}">
                    <input type="number" name="amount" value="{{ old('amount',$item->pivot->amount) }}">
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    <button  class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">update</button>
                    <button onclick="if(confirm('are you sure?'))document.getElementById(`detach-form-{{ $item->id }}`).submit();"  class="inline-block px-6 py-2 border-2 border-red-600 text-red-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">remove</button>

                  </td>
                </tr>
              </form>
              <form action="{{route('salaryItems.users.detach',$user)}}" method="post" id="detach-form-{{ $item->id }}" onsubmit="return false;">
                @csrf
                @method('DELETE')
                <input type="hidden" name="salary_item_id" value="{{$item->id}}">
              </form>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- deductions-->
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <div class="flex justify-between mb-3">
            <h5 class="font-medium leading-tight text-xl mt-0 mb-2 text-gray-600">Deductions</h5>
            <button onclick="showModal('add-deduction-item')"  class="mb-2 inline-block px-6 py-2 border-2 border-green-600 text-green-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">add deduction item</button>
          </div>
          <table class="min-w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Deduction
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Amount
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Apply deduction?
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">

                </th>
              </tr>
            </thead class="border-b">
            <tbody>
              @foreach($user->deductions as $deduction)

              <form action="{{route('deductions.update',$deduction)}}" method="post">
                @csrf
                @method('PUT')
                <tr class="bg-white border-b">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <input type="text" name="name" id="name" value="{{ old('name',$deduction->name) }}">
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    <input type="hidden" name="deduction_id" value="{{$deduction->id}}">
                    <input type="number" name="amount" value="{{ old('amount',$deduction->amount) }}">
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    <div class="flex flex-col">
                      <x-bladewind.checkbox label="yes" name="is_active" checked="{{ $deduction->is_active?'true':'false' }}" value="1" />
                    </div>
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    <button  class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">update</button>
                    <button onclick="if(confirm('are you sure?'))document.getElementById(`delete-deduction-{{ $deduction->id }}`).submit();"  class="inline-block px-6 py-2 border-2 border-red-600 text-red-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">remove</button>

                  </td>
                </tr>
              </form>
              <form action="{{route('deductions.destroy',$deduction)}}" method="post" id="delete-deduction-{{ $deduction->id }}" onsubmit="return false;">
                @csrf
                @method('DELETE')
              </form>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- overtimes-->
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <div class="flex justify-between mb-3">
            <h5 class="font-medium leading-tight text-xl mt-0 mb-2 text-gray-600">Overtimes</h5>
            <button onclick="showModal('add-overtime-item')"  class="mb-2 inline-block px-6 py-2 border-2 border-green-600 text-green-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">add overtime item</button>
          </div>
          <table class="min-w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Title
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Rate
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                 Hours
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Number of days
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">

                </th>
              </tr>
            </thead class="border-b">
            <tbody>
              @foreach($user->overtimes as $overtime)

              <form action="{{route('overtimes.update',$overtime)}}" method="post">
                @csrf
                @method('PUT')
                <tr class="bg-white border-b">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <input type="hidden" name="overtime_id" value="{{$overtime->id}}">
                    <input type="text" name="name" id="name" value="{{ old('name',$overtime->name) }}">
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    <input type="text" name="rate" value="{{ old('rate',$overtime->rate) }}">
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    <input type="number" name="hours" value="{{ old('hours',$overtime->hours) }}">
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    <input type="number" name="number_of_days" value="{{ old('number_of_days',$overtime->number_of_days) }}">
                  </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                    <button  class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">update</button>
                    <button onclick="if(confirm('are you sure?'))document.getElementById(`delete-overtime-{{ $overtime->id }}`).submit();"  class="inline-block px-6 py-2 border-2 border-red-600 text-red-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">remove</button>

                  </td>
                </tr>
              </form>
              <form action="{{route('overtimes.destroy',$overtime)}}" method="post" id="delete-overtime-{{ $overtime->id }}" onsubmit="return false;">
                @csrf
                @method('DELETE')
              </form>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- create salary item -->
  <x-bladewind.modal size="big" title="Add salary item" name="add-salary-item" show_action_buttons="false">
    <form action="{{ route('salaryItems.users.attach',$user) }}" method="post" id="user-add-form">
      @csrf
      <select name="salary_item_id" id="item-select" style="width: 400px !important;" data-placeholder="Select Salary Item"></select>
      <input type="number" name="amount" id="amount" placeholder="Amount">
      <x-bladewind::button name="btn-save" has_spinner="true" type="primary" can_submit="true" class="mt-3">
        Add
      </x-bladewind::button>
    </form>
  </x-bladewind.modal>
  <!-- create deduction -->
  <x-bladewind.modal size="big" title="Add Deduction" name="add-deduction-item" show_action_buttons="false">
    <form action="{{ route('deductions.store') }}" method="post" id="user-add-form">
      @csrf
      <div class="form-group">
        <div class="mb-3 xl:w-96">
          <input type="text" class="
              form-control
              block
              w-full
              px-3
              py-1.5
              text-base
              font-normal
              text-gray-700
              bg-white bg-clip-padding
              border border-solid border-gray-300
              rounded
              transition
              ease-in-out
              m-0
              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
            " id="exampleFormControlInput1" placeholder="Deduction title" name="name" />
        </div>
      </div>
      <div class="form-group">
        <div class="mb-3 xl:w-96">
          <input type="text" class="
              form-control
              block
              w-full
              px-3
              py-1.5
              text-base
              font-normal
              text-gray-700
              bg-white bg-clip-padding
              border border-solid border-gray-300
              rounded
              transition
              ease-in-out
              m-0
              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
            " id="d-amount" placeholder="Deduction amount" name="amount" />
        </div>
      </div>
      <input type="hidden" name="user_id" value="{{$user->id}}">
      <div class="form-group">
        <x-bladewind.checkbox label="Apply Deduction?" name="is_active" checked="false" value="1" />
      </div>

      <x-bladewind::button name="btn-save" has_spinner="true" type="primary" can_submit="true" class="mt-3">
        Add
      </x-bladewind::button>
    </form>
  </x-bladewind.modal>
  <!-- create overtime -->
  <x-bladewind.modal size="big" title="Add overtime" name="add-overtime-item" show_action_buttons="false">
    <form action="{{ route('overtimes.store') }}" method="post" id="user-add-form">
      @csrf
      <div class="form-group mb-6">
            <input type="text" name="name" class="form-control block
                w-full
                px-3
                py-1.5
                text-base
                font-normal
                text-gray-700
                bg-white bg-clip-padding
                border border-solid border-gray-300
                rounded
                transition
                ease-in-out
                m-0
                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="overtime title">
          </div>
          <div class="form-group mb-6">
            <input type="text" name="rate" class="form-control block
                w-full
                px-3
                py-1.5
                text-base
                font-normal
                text-gray-700
                bg-white bg-clip-padding
                border border-solid border-gray-300
                rounded
                transition
                ease-in-out
                m-0
                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="overtime Rate">
          </div>
          <div class="form-group mb-6">
            <input type="number" name="hours" class="form-control block
                w-full
                px-3
                py-1.5
                text-base
                font-normal
                text-gray-700
                bg-white bg-clip-padding
                border border-solid border-gray-300
                rounded
                transition
                ease-in-out
                m-0
                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="overtime Hours">
          </div>
          <div class="form-group mb-6">
            <input type="number" name="number_of_days" class="form-control block
                w-full
                px-3
                py-1.5
                text-base
                font-normal
                text-gray-700
                bg-white bg-clip-padding
                border border-solid border-gray-300
                rounded
                transition
                ease-in-out
                m-0
                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="Number of days">
          </div>
      <input type="hidden" name="user_id" value="{{$user->id}}">
      <x-bladewind::button name="btn-save" has_spinner="true" type="primary" can_submit="true" class="mt-3">
        Add
      </x-bladewind::button>
    </form>
  </x-bladewind.modal>
  @section('script')
  <script>
    $(function() {
      $("#item-select").select2({
        ajax: {
          url: "{{route('ajax.salaryItems.search')}}",
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