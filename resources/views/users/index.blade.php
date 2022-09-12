<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        Employees
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
                  hover:bg-gray-100" href="#" onclick="showModal('import-modal')">Import Employees</a>
              </li>
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
                " href="{{route('users.create')}}">Add Employee</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </x-slot>
  <x-bladewind.modal size="big" title="Import Employee" name="import-modal" show_action_buttons="false">
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


  <div x-data="Model">
    <div x-show="!loading && users.length" class="flex justify-between mb-5">
      <nav aria-label="Page navigation example">
        <ul class="flex list-style-none">
          <template x-for="link in paginator.links">
            <li :class="link.active ? 'active' : '' " :class="link.url ? '' : 'disabled'">
              <a @click.prevent="navigate" :class="link.active ? 'bg-blue-600 text-white hover:text-white hover:bg-blue-600 shadow-md' : 'text-gray-800 hover:text-gray-800 hover:bg-gray-200'" class="page-link relative block py-1.5 px-3 rounded border-0 outline-none transition-all duration-300 rounded focus:shadow-md" x-bind:href="link.url" x-html="link.label">
                <!-- <span class="visually-hidden">(current)</span> -->
              </a>
            </li>
          </template>
        </ul>
      </nav>
      <div x-show="!loading && users.length"> showing
        <b x-text="paginator.from"></b> -
        <b x-text="paginator.to"></b>
        of
        <b x-text="paginator.total"></b>
      </div>
    </div>

    <div class="flex justify-center mb-5">
      <input type="text" @keyup.debounce.500ms="searchData" class="w-1/2" placeholder="Search data">
    </div>
    <template x-if="loading">
      <div class="flex justify-center items-center">
        <div class="spinner-border animate-spin inline-block w-8 h-8 border-4 rounded-full" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </template>

    <template x-if="!loading">
      <x-bladewind.table>
        <x-slot name="header">
          <th>Name</th>
          <th>Email</th>
          <th>Phone number</th>
          <th>Branch</th>
          <th>Designation</th>
          <th>Actions</th>
        </x-slot>

        <template x-for="user in users">
          <tr>
            <td x-text="user.name"></td>
            <td x-text="user.email"></td>
            <td x-text="user.phone"></td>
            <td x-text="user.branch ? user.branch.name : ''"></td>
            <td x-text="user.designation ?user.designation.name : ''"></td>
            <td>
              <div class="flex">
                <button @click="openEdit(user)" type="button" class="inline-block px-2.5 py-1 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                  <i class="mdi mdi-pencil text-xl w-6 h-6"></i>
                </button>
                <span class="mx-1"></span>
                <button @click="openView(user)" type="button" class="inline-block px-2.5 py-1 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out">
                  <i class="mdi mdi-eye text-xl w-6 h-6"></i>
                </button>
                <form @submit.prevent="handleDelete($event,user.id)" class="mx-1">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="inline-block px-2.5 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">
                    <x-heroicon-o-trash class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                  </button>

                </form>
              </div>
            </td>
          </tr>
        </template>
        <template x-if="!users.length">
          <tr>
            <td colspan="4">
              <h4 class="text-center">no records found</h4>
            </td>
          </tr>
        </template>
      </x-bladewind.table>
    </template>
    <div x-show="!loading && users.length" class="flex justify-center">
      <nav aria-label="Page navigation example">
        <ul class="flex list-style-none">
          <template x-for="link in paginator.links">
            <li :class="link.active ? 'active' : '' " :class="link.url ? '' : 'disabled'">
              <a @click.prevent="navigate" :class="link.active ? 'bg-blue-600 text-white hover:text-white hover:bg-blue-600 shadow-md' : 'text-gray-800 hover:text-gray-800 hover:bg-gray-200'" class="page-link relative block py-1.5 px-3 rounded border-0 outline-none transition-all duration-300 rounded focus:shadow-md" x-bind:href="link.url" x-html="link.label">
                <!-- <span class="visually-hidden">(current)</span> -->
              </a>
            </li>
          </template>
        </ul>
      </nav>
    </div>
  </div>
  @section('script')
  <script>
    let Model = () => ({
      users: [],
      paginator: {
        next: null,
        prev: null,
        links: [],
        from: null,
        to: null,
        total: null
      },
      loading: true,
      formErrorMessage: null,
      handleDelete: function($evt, id) {
        let model = this
        if (confirm('Are you sure you want to proceed? This action can not be undone'))
          $.ajax({
            method: "post",
            url: "{{ url('ajax/users') }}/" + id,
            data: $($evt.target).serialize(),
            success: function(response, status, xhr) {
              model.fetchData()
            },
            error: function(xhr, status, errorMsg) {
              alert('Error:' + errorMsg)
            }
          });
      },
      navigate: function($evt) {
        let url = $($evt.target).attr('href');
        if (url) {
          window.scrollTo(0, 0)
          this.loading = true
          this.fetchData(url)
        }
      },
      fetchData: function(url = "{{ route('ajax.users.index') }}", query = null) {

        if (query) {
          query = {
            q: query
          }
        }
        let model = this
        $.ajax({
          method: "GET",
          url: url,
          data: query,
          success: function(response) {
            model.paginator.next = response.users.next_page_url
            model.paginator.prev = response.users.prev_page_url
            model.paginator.links = response.users.links
            model.paginator.from = response.users.from
            model.paginator.to = response.users.to
            model.paginator.total = response.users.total
            model.users = response.users.data
            model.loading = false
            console.log(response.users)
          },
          error: function(xhr, status, message) {
            model.loading = false
          }
        })
      },
      init: function() {
        this.fetchData()
        $("#users-select").select2({
          ajax: {
            url: "{{route('ajax.users.search')}}",
            processResults: function(data) {
              return {
                results: data
              };
            },
            delay: 250,
          }
        })
      },
      handleCreate: function($event) {
        let model = this
        model.formErrorMessage = null
        $.ajax({
          method: "POST",
          url: $($event.target).attr('action'),
          data: $($event.target).serialize(),
          success: function(response) {
            model.fetchData()
            hideModal('create-modal')
          },
          error: function(xhr, status, message) {
            model.formErrorMessage = xhr.responseJSON.message
          }
        })
      },
      openEdit(item) {
        let url = '{{ route("users.edit", ":id") }}';
        window.location.href = url.replace(':id', item.id)
      },
      openView(item) {
        let url = '{{ route("users.show", ":id") }}';
        window.location.href = url.replace(':id', item.id)
      },
      searchData(event) {
        this.fetchData("{{ route('ajax.users.index') }}", $(event.target).val())
      }
    })
  </script>
  @endsection
</x-app-layout>