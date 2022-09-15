<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

  <x-sidebar.link title="Dashboard" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
    <x-slot name="icon">
      <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>
  </x-sidebar.link>


  <!-- users -->
  <x-sidebar.dropdown title="Employees" :active="Str::startsWith(request()->route()->uri(), ['users','documents'])">
    <x-slot name="icon">
      <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>

    <x-sidebar.sublink title="Employees" href="{{ route('users.index') }}" :active="request()->routeIs('users.index')" />
    <x-sidebar.sublink title="Add Employee" href="{{ route('users.create') }}" :active="request()->routeIs('users.create')" />
    <x-sidebar.sublink title="Employee Documents" href="{{ route('documents.index') }}" :active="request()->routeIs('documents.index')" />
  </x-sidebar.dropdown>
  <!-- end users -->

  <!-- subsidiaries -->
  <x-sidebar.dropdown title="Subsidiaries" :active="Str::startsWith(request()->route()->uri(), 'subsidiaries')">
    <x-slot name="icon">
      <x-heroicon-o-puzzle class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>

    <x-sidebar.sublink title="All subsidiaries" href="{{ route('subsidiaries.index') }}" :active="request()->routeIs('subsidiaries.index')" />
    <x-sidebar.sublink title="Add Subsidiary" href="{{ route('subsidiaries.create') }}" :active="request()->routeIs('subsidiaries.create')" />
    <!-- <x-sidebar.sublink title="Text with icon" href="{{ route('documents.index') }}"
            :active="request()->routeIs('buttons.text-icon')" /> -->
  </x-sidebar.dropdown>
  <!-- end subsidiaries -->
  
  
    <!-- departments -->
    <x-sidebar.dropdown title="Departments" :active="Str::startsWith(request()->route()->uri(), 'departments')">
      <x-slot name="icon">
        <x-heroicon-o-office-building class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
      </x-slot>
  
      <x-sidebar.sublink title="All department" href="{{ route('departments.index') }}" :active="request()->routeIs('departments.index')" />
      <x-sidebar.sublink title="Add department" href="{{ route('departments.create') }}" :active="request()->routeIs('departments.create')" />
      <!-- <x-sidebar.sublink title="Text with icon" href="{{ route('buttons.text-icon') }}"
              :active="request()->routeIs('buttons.text-icon')" /> -->
    </x-sidebar.dropdown>
    <!-- end departments -->
    
    <!-- branches -->
    <x-sidebar.dropdown title="Branches" :active="Str::startsWith(request()->route()->uri(), 'branches')">
      <x-slot name="icon">
        <x-heroicon-o-location-marker class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
      </x-slot>
  
      <x-sidebar.sublink title="All branches" href="{{ route('branches.index') }}" :active="request()->routeIs('branches.index')" />
      <x-sidebar.sublink title="Add branches" href="{{ route('branches.create') }}" :active="request()->routeIs('branches.create')" />
      <!-- <x-sidebar.sublink title="Text with icon" href="{{ route('buttons.text-icon') }}"
              :active="request()->routeIs('buttons.text-icon')" /> -->
    </x-sidebar.dropdown>
    <!-- designations -->
    <x-sidebar.dropdown title="Designations" :active="Str::startsWith(request()->route()->uri(), 'designations')">
      <x-slot name="icon">
        <span class="mdi-facebook-workplace mdi font-extrabold text-2xl"></span>
      </x-slot>
  
      <x-sidebar.sublink title="All designations" href="{{ route('designations.index') }}" :active="request()->routeIs('designations.index')" />
      <x-sidebar.sublink title="Add designations" href="{{ route('designations.create') }}" :active="request()->routeIs('designations.create')" />
      <!-- <x-sidebar.sublink title="Text with icon" href="{{ route('buttons.text-icon') }}"
              :active="request()->routeIs('buttons.text-icon')" /> -->
    </x-sidebar.dropdown>
    <!-- office types -->
    <x-sidebar.dropdown title="Office Types" :active="Str::startsWith(request()->route()->uri(), 'officeTypes')">
      <x-slot name="icon">
        <span class="mdi-office-building mdi font-extrabold text-2xl"></span>
      </x-slot>
  
      <x-sidebar.sublink title="All officeTypes" href="{{ route('officeTypes.index') }}" :active="request()->routeIs('officeTypes.index')" />
      <x-sidebar.sublink title="Add officeTypes" href="{{ route('officeTypes.create') }}" :active="request()->routeIs('officeTypes.create')" />
      <!-- <x-sidebar.sublink title="Text with icon" href="{{ route('buttons.text-icon') }}"
              :active="request()->routeIs('buttons.text-icon')" /> -->
    </x-sidebar.dropdown>
    <!-- end branches -->
    <!-- payroll -->
    <x-sidebar.dropdown title="Payroll" :active="Str::startsWith(request()->route()->uri(), ['paymentStreams','salaryItems','deductions','overtimes'])">
      <x-slot name="icon">
        <x-heroicon-o-credit-card class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
      </x-slot>
  
      <x-sidebar.sublink title="Payment Streams" href="{{ route('paymentStreams.index') }}" :active="request()->routeIs('paymentStreams.index')" />
      <x-sidebar.sublink title="Salary Items" href="{{ route('salaryItems.index') }}" :active="request()->routeIs('salaryItems.index')" />
      <x-sidebar.sublink title="Deductions" href="{{ route('deductions.index') }}" :active="request()->routeIs('deductions.index')" />
      <x-sidebar.sublink title="Overtimes" href="{{ route('overtimes.index') }}" :active="request()->routeIs('overtimes.index')" />
    </x-sidebar.dropdown>
    <!-- end payroll -->

  <!-- <div x-transition x-show="isSidebarOpen || isSidebarHovered" class="text-sm text-gray-500">Dummy Links</div> -->

</x-perfect-scrollbar>