<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __($salaryItem->name) }}
      </h2>
      <x-bladewind.button onclick="showModal('import-modal')">Import {{$salaryItem->name}}</x-bladewind.button>
    </div>
  </x-slot>
  <x-bladewind.modal size="big" title="Import {{$salaryItem->name}}" name="import-modal" show_action_buttons="false">
    <form action="{{ route('salaryItems.import',$salaryItem) }}" method="post" id="user-import-form" enctype="multipart/form-data">
      @csrf
      <div class="mb-5">
        <a href="{{ route('salaryItems.import.sample') }}">download sample</a>
      </div>
      <label for="salaryItems">Select file</label>
      <input type="file" name="excel_sheet" id="salaryItems">
      <x-bladewind::button name="btn-save" has_spinner="true" type="primary" can_submit="true" class="mt-3">
        Upload
      </x-bladewind::button>
    </form>
  </x-bladewind.modal>

  <div x-data="Model">
    <div x-show="!loading" class="flex justify-between mb-5">
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
      <div x-show="!loading"> showing
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
          <th>Beneficiary</th>
          <th>Amount</th>
          <th>Actions</th>
        </x-slot>

        <template x-for="user in users">
          <tr>
            <td x-text="user.name"></td>
            <td>
              <form @submit.prevent="handleUpdate($event,user.id)" class="flex">
                @csrf
                @method('PUT')
                <input type="number" name="amount" id="amount" x-bind:value="user.pivot.amount">
                <button type="submit" class="inline-block px-4 py-1.5 ml-5 bg-blue-600 text-white font-medium leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"><span class="mdi mdi-content-save"></span></button>
              </form>
            </td>
            <td>
              <form @submit.prevent="handleDelete($event,user.id)" class="mx-1">
                @method('DELETE')
                @csrf
                <x-bladewind.button color="red" size="tiny" can_submit="true">
                  <x-heroicon-o-trash class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                </x-bladewind.button>
              </form>
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
    <div x-show="!loading" class="flex justify-center">
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
      salaryItem: {},
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
      handleUpdate: function($evt, id) {
        let model = this
        $.ajax({
          method: "post",
          url: "{{ url('ajax/salaryItems/'.$salaryItem->id.'/users') }}/" + id,
          data: $($evt.target).serialize(),
          success: function(response, status, xhr) {
            model.fetchData()

            alert('Saved!')
          },
          error: function(xhr, status, errorMsg) {
            alert('Error:' + errorMsg)
          }
        })
      },
      handleDelete: function($evt, id) {
        let model = this
        if (confirm('Are you sure you want to proceed? This action can not be undone'))
          $.ajax({
            method: "post",
            url: "{{ url('ajax/salaryItems/'.$salaryItem->id.'/users') }}/" + id,
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
      fetchData: function(url = "{{ route('ajax.salaryItems.show',$salaryItem) }}") {
        let model = this
        $.ajax({
          method: "GET",
          url: url,
          success: function(response) {
            console.log(response.users)
            model.paginator.next = response.users.next_page_url
            model.paginator.prev = response.users.prev_page_url
            model.paginator.links = response.users.links
            model.paginator.from = response.users.from
            model.paginator.to = response.users.to
            model.paginator.total = response.users.total
            model.users = response.users.data
            model.salaryItem = response.salaryItem
            model.loading = false
          },
          error: function(xhr, status, message) {
            model.loading = false
          }
        })
      },
      init: function() {
        this.fetchData()
      }
    })
  </script>
  @endsection
</x-app-layout>