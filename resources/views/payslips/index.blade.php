<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Payslips for ' . Date::parse($paymentStream->payment_month)->monthName . ' (' . $paymentStream->name. ')') }}
      </h2>
      <x-bladewind.button tag="a" href="{{route('paymentStreams.payslips.create',$paymentStream)}}">Create Payslips</x-bladewind.button>
    </div>
  </x-slot>
  <form action="{{ route('paymentStreams.processed',$paymentStream) }}" id="close-form" method="post">
    @csrf
    @method('PUT')
  </form>
  <div x-data="Model">

    <div class="flex justify-between mb-5">
      <form action="{{ route('payslips.pay',$paymentStream) }}" method="post">
        @csrf
        <!-- pay by -->
        <div class="flex flex-col">
          <label for="stream">How do you wish to pay</label>
          <select x-model="payBy" name="paying_by" @change="resetSelected">
            <option value="">Pay by...</option>
            <option value="department">Department</option>
            <option value="branch">Branch</option>
            <option value="designation">Designation</option>
            <option value="officeType">Office Type</option>
          </select>
        </div>
        <!-- department -->
        <template x-if="payBy == `department`">
          <div class="flex flex-col">
            <label for="stream">Select Department</label>
            <select name="paying_id" x-model="payId" @change="setBy" id="stream">
              <option value="">Select department</option>
              @foreach($departments as $dept)
              <option value="{{$dept->id}}">{{$dept->name}}</option>
              @endforeach
            </select>
            @error('paying_id')
            <span class="text-red-600 my-1">{{ $message }}</span>
            @enderror
          </div>
        </template>
        <!-- branch -->
        <template x-if="payBy == `branch`">
          <div class="flex flex-col">
            <label for="stream">Select Branch</label>
            <select name="paying_id" x-model="payId" @change="setBy" id="stream">
              <option value="">Select branch</option>
              @foreach($branches as $branch)
              <option value="{{$branch->id}}">{{$branch->name}}</option>
              @endforeach
            </select>
            @error('paying_id')
            <span class="text-red-600 my-1">{{ $message }}</span>
            @enderror
          </div>
        </template>
        <!-- designation -->
        <template x-if="payBy == `designation`">
          <div class="flex flex-col">
            <label for="stream">Select Designation</label>
            <select name="paying_id" x-model="payId" @change="setBy" id="stream">
              <option value="">Select designation</option>
              @foreach($designations as $designation)
              <option value="{{$designation->id}}">{{$designation->name}}</option>
              @endforeach
            </select>
            @error('paying_id')
            <span class="text-red-600 my-1">{{ $message }}</span>
            @enderror
          </div>
        </template>
        <template x-if="payBy == `officeType`">
          <div class="flex flex-col">
            <label for="stream">Select Office type</label>
            <select name="paying_id" x-model="payId" @change="setBy" id="stream">
              <option value="">Select office type</option>
              @foreach($office_types as $office)
              <option value="{{$office->id}}">{{$office->name}}</option>
              @endforeach
            </select>
            @error('paying_id')
            <span class="text-red-600 my-1">{{ $message }}</span>
            @enderror
          </div>

        </template>
        <x-bladewind::button name="btn-save" has_spinner="true" type="primary" color="orange" can_submit="true" class="mt-3">
          process {{$paymentStream->name}} payments
        </x-bladewind::button>
      </form>

      <div class="d-flex flex-col">
        <x-bladewind.button color="red" onclick="if(confirm(`Are you sure you want to close current stream`)) document.getElementById(`close-form`).submit() ;">
          Mark as processed
        </x-bladewind.button>
      </div>

    </div>
    <div x-show="!loading && payslips.length" class="flex justify-between mb-5">
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
      <div x-show="!loading && payslips.length"> showing
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
          <th>Basic Salary</th>
          <!-- <th>Month</th> -->
          <th>Net Payable</th>
          <th>Paid at</th>
          <th>Actions</th>
        </x-slot>

        <template x-for="payslip in payslips">
          <tr>
            <td x-text="payslip.user.name"></td>
            <td x-text="payslip.user.basic_salary"></td>
            <!-- <td x-text="payslip.salary_month"></td> -->
            <td x-text="payslip.net_payable"></td>
            <td x-text="payslip.paid_at || 'unpaid' "></td>
            <td>
              <div class="flex">
                <form @submit.prevent="handleDelete($event,payslip.id)" class="mx-1">
                  @method('DELETE')
                  @csrf
                  <x-bladewind.button color="red" size="tiny" can_submit="true">
                    <x-heroicon-o-trash class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                  </x-bladewind.button>
                </form>
                <x-bladewind.button color="blue" size="tiny" @click="openEdit(payslip)">
                  <i class="mdi mdi-pencil text-xl"></i>
                </x-bladewind.button>
              </div>
            </td>
          </tr>
        </template>
        <template x-if="!payslips.length">
          <tr>
            <td colspan="6">
              <h4 class="text-center" x-text="payId ? 'no records found' : 'Select payment options to load payslips' "></h4>
            </td>
          </tr>
        </template>
      </x-bladewind.table>
    </template>
    <div x-show="!loading && payslips.length" class="flex justify-center">
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
    let Model = function() {
      return {
        payBy: '',
        payId: null,
        setBy() {
          this.loading = true
          this.fetchData()
        },
        payslips: [],
        paginator: {
          next: null,
          prev: null,
          links: [],
          from: null,
          to: null,
          total: null
        },
        loading: false,
        formErrorMessage: null,
        handleDelete: function($evt, id) {
          let model = this
          if (confirm('Are you sure you want to proceed? This action can not be undone'))
            $.ajax({
              method: "post",
              url: "{{ url('ajax/payslips') }}/" + id,
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
        fetchData: function(url = "{{ route('ajax.paymentStreams.payslips.index',$paymentStream) }}") {
          let model = this
          $.ajax({
            method: "GET",
            url: url,
            data: {
              paying_by: model.payBy,
              paying_id: model.payId
            },
            success: function(response) {
              model.paginator.next = response.payslips.next_page_url
              model.paginator.prev = response.payslips.prev_page_url
              model.paginator.links = response.payslips.links
              model.paginator.from = response.payslips.from
              model.paginator.to = response.payslips.to
              model.paginator.total = response.payslips.total
              model.payslips = response.payslips.data
              model.loading = false
              console.log(response.payslips)
            },
            error: function(xhr, status, message) {
              model.loading = false
            }
          })
        },
        init: function() {
          // this.fetchData()
          // $("#users-select").select2({
          //   ajax: {
          //     url: "{{route('ajax.users.search')}}",
          //     processResults: function(data) {
          //       return {
          //         results: data
          //       };
          //     },
          //     delay: 250,
          //   }
          // })
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
          let url = '{{ route("payslips.edit", ":slug") }}';
          window.location.href = url.replace(':slug', item.id)
        },
        resetSelected() {
          this.payId = null
        }
      }
    }
  </script>
  @endsection
</x-app-layout>