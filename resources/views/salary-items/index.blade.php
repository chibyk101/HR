<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Salary Items') }}
      </h2>
      <div class="flex">
        <x-bladewind.button color="orange" onclick="showModal('import-modal-2')">Import Basic salaries</x-bladewind.button>
        <x-bladewind.button tag="a" href="{{route('salaryItems.create')}}">Add Item</x-bladewind.button>
      </div>
    </div>
  </x-slot>
  <x-bladewind.modal size="big" title="Import Basic salaries" name="import-modal-2" show_action_buttons="false">
    <form action="{{ route('payslips.basicSalary.import') }}" method="post" id="user-import-form" enctype="multipart/form-data">
      @csrf
      <div class="mb-5">
        <a href="{{ route('payslips.basicSalary.import.sample') }}">download sample</a>
      </div>
      <label for="payslips">Select file</label>
      <input type="file" name="excel_sheet" id="payslips">
      <x-bladewind::button name="btn-save" has_spinner="true" type="primary" can_submit="true" class="mt-3">
        Upload
      </x-bladewind::button>
    </form>
  </x-bladewind.modal>
  <x-bladewind.table>
    <x-slot name="header">
      <th>Name</th>
      <th>Actions</th>
    </x-slot>
    @forelse($salaryItems as $salaryItem)
    <tr>
      <td>{{ $salaryItem->name }}</td>
      <td class="flex justify-center">
        <x-bladewind.button size="tiny" color="green" tag="a" href="{{ route('salaryItems.show',$salaryItem) }}" title="Edit Item">
          <x-heroicon-o-eye class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-bladewind.button>
        <x-bladewind.button size="tiny" tag="a" href="{{ route('salaryItems.edit',$salaryItem) }}" title="Edit Item">
          <x-heroicon-o-pencil-alt class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-bladewind.button>
        <form action="{{ route('salaryItems.destroy',$salaryItem) }}" method="POST" class="mx-1" onsubmit="if(!confirm('Are you sure you want to proceed? This action can not be undone')) return false;">
          @method('DELETE')
          @csrf
          <x-bladewind.button color="red" size="tiny" can_submit="true" href="{{ route('salaryItems.edit',$salaryItem) }}" title="Edit Item">
            <x-heroicon-o-trash class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
          </x-bladewind.button>
        </form>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="4"></td>
    </tr>
    @endforelse
  </x-bladewind.table>
</x-app-layout>