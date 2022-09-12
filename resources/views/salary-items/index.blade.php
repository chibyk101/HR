<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Salary Items') }}
      </h2>
      <x-bladewind.button tag="a" href="{{route('salaryItems.create')}}">Add Item</x-bladewind.button>
    </div>
  </x-slot>

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