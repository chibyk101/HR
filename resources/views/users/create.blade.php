<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Users') }}
      </h2>

      <x-bladewind.button onclick="showModal('import-modal')">Import Staff</x-bladewind.button>
    </div>
  </x-slot>
  <x-bladewind::notification />

  <x-bladewind.modal size="big" title="Import Staff" name="import-modal" show_action_buttons="false">
    <form action="{{ route('users.import') }}" method="post" id="user-import-form" enctype="multipart/form-data">
      @csrf
      <div class="mb-5">
        <a href="{{ route('users.import.sample') }}">download sample</a>
      </div>
      <label for="users">Select file</label>
      <input type="file" name="excel_sheet" id="users">
      <x-bladewind::button name="btn-save" has_spinner="true" type="primary" can_submit="true" class="mt-3">
        Upload
      </x-bladewind::button>
    </form>
  </x-bladewind.modal>

  <x-bladewind::card>

    <form method="POST" class="signup-form" action="{{route('users.store')}}" x-data="model" x-init="initModel" enctype="multipart/form-data">
      @csrf

      <h1 class="my-2 text-2xl font-light text-blue-900/80">Create Account</h1>
      <p class="mt-3 mb-6 text-blue-900/80 text-sm">
        Employee Information
      </p>
      <div class="flex justify-center">
        <div class="mb-3 w-96">
          <label for="formFileLg" class="inline-block mb-2 text-gray-700">Photo</label>
          <input name="photo" class="form-control block w-full px-2 py-1.5 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="formFileLg" type="file">
          @error('photo')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="grid gap-2 grid-cols-1 md:grid-cols-2">
        <div class="flex flex-col">
          <x-bladewind::input name="first_name" required="true" label="First Name" value="{{ old('first_name') }}" />
          @error('first_name')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::input name="last_name" required="true" label="Last Name" value="{{ old('last_name') }}" />
          @error('last_name')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::input name="middle_name" label="Other Names" value="{{ old('middle_name') }}" />
          @error('middle_name')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror

          @error('photo')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>

        <div class="flex flex-col">
          <x-bladewind::input name="email" required="true" label="Email" value="{{ old('email') }}" />
          @error('email')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::input name="phone" label="Mobile" numeric="true" value="{{ old('phone') }}" />
          @error('phone')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>
        <div>
          <x-bladewind.radio-button label="Male" name="gender" value="male" />
          <x-bladewind.radio-button label="female" name="gender" value="female" />
          @error('gender')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>
        <div class="flex flex-col">
          <label for="dob">Date of birth</label>
          <input type="date" name="dob" id="dob" placeholder="Date of birth" value="{{ old('dob') }}" />
          @error('dob')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::input name="lga" label="Local Government Area" value="{{ old('lga') }}" />
          @error('lga')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::input name="password" label="Initial Password" type="password" required="true" value="{{ old('password') }}" />
          @error('password')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>

        <div class="flex flex-col">
          <x-bladewind::input name="state_of_origin" label="State of origin" value="{{ old('state_of_origin') }}" />
          @error('state_of_origin')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::textarea name="address" label="Address" value="{{ old('address') }}"></x-bladewind::textarea>
          @error('address')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>

        <div class="flex flex-col">
          @php
          $marital_status = [
          [ 'label' => 'Single', 'value' => 'single' ],
          [ 'label' => 'Married', 'value' => 'married' ]
          ];
          @endphp
          <x-bladewind.dropdown name="marital_status" placeholder="Marital Status" data="{{ json_encode($marital_status) }}" />
          @error('marital_status')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::input name="religion" label="Religion" value="{{ old('religion') }}" />
          @error('religion')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>
        <div class="flex flex-col">
          <h4 class="my-2">Next Of Kin</h4>
          <x-bladewind::input name="next_of_kin" label="Next of kin name" value="{{ old('next_of_kin') }}" />
          @error('next_of_kin')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::input name="next_of_kin_phone" label="Next of kin phone" value="{{ old('next_of_kin_phone') }}" />
          @error('next_of_kin_phone')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::textarea name="next_of_kin_address" label="Next of kin address" selected_value="{{ old('next_of_kin_address') }}"></x-bladewind::textarea>
          @error('next_of_kin_address')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>
        <div class="flex flex-col">
          <h4 class="my-2">Guarantor one</h4>
          <x-bladewind::input name="guarantor_1" label="Guarantor 1 name" value="{{ old('guarantor_1') }}" />
          @error('guarantor_1')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::input name="guarantor_1_phone" label="Guarantor 1 phone" value="{{ old('guarantor_1_phone') }}" />
          @error('guarantor_1_phone')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::textarea name="guarantor_1_address" label="Guarantor 1 address" selected_value="{{ old('guarantor_1_address') }}"></x-bladewind::textarea>
          @error('guarantor_1_address')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>
        <div class="flex flex-col">
          <h4 class="my-2">Guarantor two</h4>
          <x-bladewind::input name="guarantor_2" label="Guarantor 2 name" value="{{ old('guarantor_2') }}" />
          @error('guarantor_2')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::input name="guarantor_2_phone" label="Guarantor 2 phone" value="{{ old('guarantor_2_phone') }}" />
          @error('guarantor_2_phone')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::textarea name="guarantor_2_address" label="Guarantor 2 address" selected_value="{{ old('guarantor_1') }}"></x-bladewind::textarea>
          @error('guarantor_2_address')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>
        <div class="flex flex-col">
          <h4 class="my-2">Guarantor three</h4>
          <x-bladewind::input name="guarantor_3" label="Guarantor 3 name" value="{{ old('guarantor_3') }}" />
          @error('guarantor_3')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::input name="guarantor_3_phone" label="Guarantor 3 phone" value="{{ old('guarantor_3_phone') }}" />
          @error('guarantor_3_phone')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <x-bladewind::textarea name="guarantor_3_address" label="Guarantor 3 address" selected_value="{{ old('guarantor_3_address') }}"></x-bladewind::textarea>
          @error('guarantor_3_address')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <p class="mt-3 mb-6 text-blue-900/80 text-sm">
        Company Information
      </p>
      <div class="grid gap-2 grid-cols-1 md:grid-cols-2">
        <div class="flex flex-col">
          @php
          $levels = [
          [ 'label' => 'Level 1', 'value' => 1 ],
          [ 'label' => 'Level 2', 'value' => 2 ],
          [ 'label' => 'Level 3', 'value' => 3 ],
          [ 'label' => 'Level 4', 'value' => 4 ],
          ];
          @endphp
          <x-bladewind.dropdown name="level" placeholder="Employee Level" data="{{ json_encode($levels) }}" />
          <label for="doj">Company date of joining</label>
          <input type="date" name="company_doj" placeholder="Date of joining" value="{{ old('company_doj') }}" />
          @error('company_doj')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
        </div>
        <div class="flex flex-col">
          <select name="subsidiary_id" class="px-4 py-2 my-1 bw-dropdown bg-white cursor-pointer text-left w-full text-gray-400 flex justify-between dark:text-white dark:border-slate-700 dark:bg-slate-600 dark:text-gray-300" x-on:change="setDepartments">
            <option value="">SELECT SUBSIDIARY</option>
            <template x-for="sub in subsidiaries">
              <option x-bind:value="sub.id" x-text="sub.name"></option>
            </template>
          </select>
          <select multiple x-ref="select" data-placeholder="Select a departments" name="departments[]" id="departments" class="px-4 py-2 my-1 bw-dropdown bg-white cursor-pointer text-left w-full text-gray-400 flex justify-between dark:text-white dark:border-slate-700 dark:bg-slate-600 dark:text-gray-300" x-on:change="setBranches">
            <option value="">SELECT DEPARTMENTS</option>
            <template x-for="dept in departments">
              <option x-bind:value="dept.id" x-text="dept.name"></option>
            </template>
          </select>
          @error('departments')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          <select name="branch_id" class="px-4 py-2 my-1 bw-dropdown bg-white cursor-pointer text-left w-full text-gray-400 flex justify-between dark:text-white dark:border-slate-700 dark:bg-slate-600 dark:text-gray-300">
            <option value="">SELECT BRANCH</option>
            <template x-for="branch in branches">
              <option x-bind:value="branch.id" x-text="branch.name"></option>
            </template>
          </select>
          @error('branch_id')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          @if($designations->count())
          <x-bladewind.dropdown onselect="getDepartments" name="designation_id" placeholder="Designation" data="{{ $designations->toJson() }}" label_key="name" value_key="id" />
          @error('designation_id')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          @endif
          @if($officeTypes->count())
          <select name="officeType_id" class="px-4 py-2 my-1 bw-dropdown bg-white cursor-pointer text-left w-full text-gray-400 flex justify-between dark:text-white dark:border-slate-700 dark:bg-slate-600 dark:text-gray-300">
            <option value="">SELECT OFFICE TYPE</option>

            <template x-for="officeType in officeTypes">
              <option x-bind:value="officeType.id" x-text="officeType.name"></option>
            </template>
          </select>
          @error('officeType_id')
          <span class="text-red-600 my-1">{{ $message }}</span>
          @enderror
          @endif
        </div>
      </div>


      <div class="text-center">

        <x-bladewind::button name="btn-save" has_spinner="true" type="primary" can_submit="true" class="mt-3">
          SUBMIT
        </x-bladewind::button>

      </div>

    </form>

  </x-bladewind::card>
  @section('script')
  <script>
    function model() {
      return {
        dataBank: {
          departments: <?php echo json_encode($departments) ?>,
          subsidiaries: <?php echo json_encode($subsidiaries) ?>,
          branches: <?php echo json_encode($branches) ?>,
        },
        departments: [],
        subsidiaries: [],
        branches: [],
        officeTypes: <?php echo json_encode($officeTypes) ?>,

        selected_departments: [],
        setDepartments(evt) {
          this.branches = []
          document.getElementById('department_id').value = ''

          this.departments = this.dataBank.departments.filter((dept) => {
            return dept.subsidiary_id == evt.target.value
          });
        },
        setBranches(evt) {
          this.branches = this.dataBank.branches.filter((branch) => {
            return branch.department_id == evt.target.value
          });
        },
        initModel() {
          this.departments = this.dataBank.departments
          this.subsidiaries = this.dataBank.subsidiaries
          this.branches = this.dataBank.branches
          this.select2 = $(this.$refs.select).select2();
          this.select2.on("select2:select", (event) => {
            var selected = [];
            for (var option of event.target.options) {
              if (option.selected) {
                selected.push(option.value);
              }
            }
            this.selected_departments = selected
          });
          this.select2.on("select2:unselect", (event) => {
            var selected = [];
            for (var option of event.target.options) {
              if (option.selected) {
                selected.push(option.value);
              }
            }
            this.selected_departments = selected
          });
          this.$watch("selected_departments", (value) => {
            this.branches = this.dataBank.branches.filter((branch) => {
              return this.selected_departments.some(function(val) {
                return val == branch.department_id
              })
            })
          });
        },
      }
    }
  </script>
  @endsection
</x-app-layout>