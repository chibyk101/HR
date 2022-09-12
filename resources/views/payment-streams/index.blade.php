<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Payment Streams for ' . now()->monthName) }}
      </h2>
      <x-bladewind.button tag="a" href="{{route('paymentStreams.create')}}">Add Stream</x-bladewind.button>
    </div>
  </x-slot>

  <x-bladewind.table>
    <x-slot name="header">
      <th>Name</th>
      <th>Month</th>
      <th>Process deductions</th>
      <th>Pay overtimes</th>
      <th>Pay basic salaries</th>
      <th>Processed at</th>
      <th>Actions</th>
    </x-slot>
    @forelse($paymentStreams as $paymentStream)
    <tr>
      <td>{{ $paymentStream->name }}</td>
      <td>{{ Date::parse($paymentStream->payment_month)->monthName }}</td>
      <td>{{ $paymentStream->process_deductions ? 'Yes' : 'No' }}</td>
      <td>{{ $paymentStream->include_overtime ? 'Yes' : 'No' }}</td>
      <td>{{ $paymentStream->include_basic_salary ? 'Yes' : 'No' }}</td>
      <td>{{ $paymentStream->processed_at?->toDateString() ?? 'not processed' }}</td>
      <td class="flex justify-center">
        @if($paymentStream->processed_at?->isPast() == false)
        <x-bladewind.button size="tiny" color="green" tag="a" href="{{ route('paymentStreams.payslips.index',$paymentStream) }}" title="Payslips">
          <x-heroicon-o-book-open class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-bladewind.button>
        @else
        <x-bladewind.button size="tiny" tag="a" href="{{ route('paymentStreams.show',$paymentStream) }}" >
          <x-heroicon-o-arrow-left class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-bladewind.button>
        @endif
        <x-bladewind.button size="tiny" tag="a" href="{{ route('paymentStreams.edit',$paymentStream) }}" title="Edit Staff">
          <x-heroicon-o-pencil-alt class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-bladewind.button>
        <form action="{{ route('paymentStreams.destroy',$paymentStream) }}" method="POST" class="mx-1" onsubmit="if(!confirm('Are you sure you want to proceed? This action can not be undone')) return false;">
          @method('DELETE')
          @csrf
          <x-bladewind.button color="red" size="tiny" can_submit="true" href="{{ route('paymentStreams.edit',$paymentStream) }}" title="Edit Staff">
            <x-heroicon-o-trash class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
          </x-bladewind.button>
        </form>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="5"></td>
    </tr>
    @endforelse
  </x-bladewind.table>
</x-app-layout>