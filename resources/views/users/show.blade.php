<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Employee Profile') }}
      </h2>
      <div class="flex justify-center">
        <div>
        <div class="dropdown relative">
        <button class="
              dropdown-toggle
              px-6
              py-2.5
              bg-blue-600
              text-white
              font-medium
              text-xs
              leading-tight
              uppercase
              rounded
              shadow-md
              hover:bg-blue-700 hover:shadow-lg
              focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
              active:bg-blue-800 active:shadow-lg active:text-white
              transition
              duration-150
              ease-in-out
              flex
              items-center
              whitespace-nowrap
              " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          Actions
          <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-down" class="w-2 ml-2" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
            <path fill="currentColor" d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"></path>
          </svg>
        </button>
        <ul class="
            dropdown-menu
            min-w-max
            absolute
            hidden
            bg-white
            text-base
            z-50
            float-left
            py-2
            list-none
            text-left
            rounded-lg
            shadow-lg
            mt-1
            hidden
            m-0
            bg-clip-padding
            border-none" aria-labelledby="dropdownMenuButton1">
          
          <li>
            <a class="
                  dropdown-item
                  text-sm
                  py-2
                  px-4
                  font-normal
                  block
                  w-full
                  whitespace-nowrap
                  bg-transparent
                  text-gray-700
                  hover:bg-gray-100
                " href="{{route('users.edit',$user)}}">Edit Employee</a>
          </li>
        </ul>
      </div>
        </div>
      </div>
    </div>
  </x-slot>
  <x-bladewind::notification />

  <div class="text-center">
    <img src="{{ asset(Storage::url($user->photo)) }}" class="rounded-full w-32 mb-4 mx-auto" alt="Avatar" />
    <h5 class="text-xl font-medium leading-tight mb-2">{{$user->name}}</h5>
    <h6 class="text-xl font-medium leading-tight mb-2">#{{ $user->staff_id }}</h6>
    <p class="text-gray-500">{{$user->designation?->name}}</p>
  </div>
  <!-- basic info -->
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <h5 class="font-medium leading-tight text-xl mt-0 mb-2 text-gray-600">Basic Information</h5>
          <table class="min-w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  ID
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  First name
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Last name
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Gender
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Date of birth
                </th>
              </tr>
            </thead class="border-b">
            <tbody>
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ $user->staff_id }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->first_name }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->last_name }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->gender }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->dob }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- contact info -->
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <h5 class="font-medium leading-tight text-xl mt-0 mb-2 text-gray-600">Contact Information</h5>
          <table class="min-w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Email address
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Phone number
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Address
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  State of origin
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Local government area
                </th>
              </tr>
            </thead class="border-b">
            <tbody>
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ $user->email }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->phone }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->address }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->state_of_origin }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->lga }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- reference -->
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <h5 class="font-medium leading-tight text-xl mt-0 mb-2 text-gray-600">Reference Information</h5>
          <table class="min-w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  #
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Guarantor
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Phone number
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Address
                </th>
              </tr>
            </thead class="border-b">
            <tbody>
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  1
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ $user->guarantor_1 }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->guarantor_1_phone }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->guarantor_1_address }}
                </td>
              </tr>
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  2
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ $user->guarantor_2 }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->guarantor_2_phone }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->guarantor_2_address }}
                </td>
              </tr>
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  3
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ $user->guarantor_3 }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->guarantor_3_phone }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->guarantor_3_address }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- employment info -->
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <h5 class="font-medium leading-tight text-xl mt-0 mb-2 text-gray-600">Employment Information</h5>
          <table class="min-w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Designation
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Branch
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Departments
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Office type
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Date of joining
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Employee Level
                </th>
              </tr>

            </thead class="border-b">
            <tbody>
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ $user->designation?->name }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->branch?->name }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->departments->pluck('name')->implode(', ') }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->officeType?->name }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->company_doj }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->level }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- salary info -->
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <h5 class="font-medium leading-tight text-xl mt-0 mb-2 text-gray-600">Salary Information</h5>
          <table class="min-w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Basic Salary
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Gross pay
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Account number
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Bank name
                </th>
              </tr>

            </thead class="border-b">
            <tbody>
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ $user->basic_salary }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->grossPay() }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->account_number }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ $user->bank_name }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- documents -->
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <h5 class="font-medium leading-tight text-xl mt-0 mb-2 text-gray-600">Documents</h5>
          <table class="min-w-full text-center">
            <thead class="border-b bg-gray-800">
              <tr>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Document
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  File
                </th>
                <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                  Upload/Change
                </th>
              </tr>

            </thead class="border-b">
            <tbody>
              @forelse($documents as $document)
              <tr class="bg-white border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ $document->name }}
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  @php
                  $employeeDocument = $user->employeeDocuments->where('document_id',$document->id)->first();
                  @endphp
                  @if($employeeDocument)
                  <a href="{{ asset(Storage::url($employeeDocument->document_file)) }}">open</a>
                  @else
                  not found
                  @endif
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                 <a href="{{ route('documents.employeeDocuments.create',[$document,$user]) }}">
                  <span class="mdi mdi-cloud-upload text-xl"></span>
                 </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="3"></td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</x-app-layout>