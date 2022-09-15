<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        Documents
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
              " id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
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
                " href="#" onclick="showModal('create-modal')">Create document</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </x-slot>


  <div x-data="Model">
    <x-bladewind.modal size="big" title="Create document" name="create-modal" show_action_buttons="false">
      <form @submit.prevent="handleCreate" action="{{ route('ajax.documents.store') }}" method="post" id="document-create-form">
        @csrf
        <div class="block p-6 rounded-lg shadow-lg bg-white max-w-md">
          <div x-show="formErrorMessage" class="bg-red-100 rounded-lg py-5 px-6 mb-3 text-base text-red-700 inline-flex items-center w-full" role="alert">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="w-4 h-4 mr-2 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path>
            </svg>
            <span x-text="formErrorMessage"></span>
          </div>
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
                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleInput7" placeholder="document title">
          </div>
          <div class="form-group form-check text-center mb-6">
            <input name="is_required" value="1" type="checkbox" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer" id="exampleCheck87">
            <label class="form-check-label inline-block text-gray-800" for="exampleCheck87">is compulsory?</label>
          </div>

          <button  class="
              w-full
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
              active:bg-blue-800 active:shadow-lg
              transition
              duration-150
              ease-in-out">
            Send
          </button>
        </div>
      </form>
    </x-bladewind.modal>
    <div x-show="!loading && documents.length && paginator.hasPages" class="flex justify-between mb-5">
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
      <div x-show="!loading && documents.length"> showing
        <b x-text="paginator.from"></b> -
        <b x-text="paginator.to"></b>
        of
        <b x-text="paginator.total"></b>
      </div>
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
          <th>Document</th>
          <th>Compulsory</th>
          <th>Actions</th>
        </x-slot>

        <template x-for="document in documents">
          <tr>
            <td x-text="document.name"></td>
            <td x-text="document.is_required ? 'yes' : 'no' "></td>
            <td>
              <div class="flex">
                <form @submit.prevent="handleDelete($event,document.id)" class="mx-1">
                  @method('DELETE')
                  @csrf
                  <x-bladewind.button color="red" size="tiny" can_submit="true">
                    <x-heroicon-o-trash class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                  </x-bladewind.button>
                </form>
                <x-bladewind.button color="blue" size="tiny" @click="openEdit(document)">
                  <i class="mdi mdi-pencil text-xl"></i>
                </x-bladewind.button>
              </div>
            </td>
          </tr>
        </template>
        <template x-if="!documents.length">
          <tr>
            <td colspan="6">
              <h4 class="text-center">no records found</h4>
            </td>
          </tr>
        </template>
      </x-bladewind.table>
    </template>
    <div x-show="!loading && documents.length && paginator.hasPages" class="flex justify-center">
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
      documents: [],
      paginator: {
        next: null,
        prev: null,
        links: [],
        from: null,
        to: null,
        total: null,
        hasPages: false
      },
      loading: true,
      formErrorMessage: null,
      handleDelete: function($evt, id) {
        let model = this
        if (confirm('Are you sure you want to proceed? This action can not be undone'))
          $.ajax({
            method: "post",
            url: "{{ url('ajax/documents') }}/" + id,
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
      fetchData: function(url = "{{ route('ajax.documents.index') }}") {
        let model = this
        $.ajax({
          method: "GET",
          url: url,
          success: function(response) {
            model.paginator.next = response.documents.next_page_url
            model.paginator.prev = response.documents.prev_page_url
            model.paginator.links = response.documents.links
            model.paginator.from = response.documents.from
            model.paginator.to = response.documents.to
            model.paginator.total = response.documents.total
            model.paginator.hasPages = response.documents.links.length > 3
            model.documents = response.documents.data
            model.loading = false
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
        let url = '{{ route("documents.edit", ":id") }}';
        window.location.href = url.replace(':id', item.id)
      }
    })
  </script>
  @endsection
</x-app-layout>