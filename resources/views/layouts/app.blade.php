<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'K UI') }}</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <!-- Styles -->
 
  <link href="{{ asset('bladewind/css/animate.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/materialdesignicons.min.css') }}" rel="stylesheet" />

  <link href="{{ asset('bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
  <style>
    [x-cloak] {
      display: none;
    }
  </style>

  <!-- Scripts -->
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ mix('js/app.js') }}" defer></script>
  <script src="{{ asset('bladewind/js/helpers.js') }}"></script>
</head>

<body class="font-sans antialiased">
  <div x-data="mainState" :class="{ dark: isDarkMode }" @resize.window="handleWindowResize" x-cloak>
    <div class="min-h-screen text-gray-900 bg-gray-100 dark:bg-dark-bg dark:text-gray-200">
      <!-- Sidebar -->
      <x-sidebar.sidebar />
      <!-- Page Wrapper -->
      <div class="flex flex-col min-h-screen" :class="{ 
                    'lg:ml-64': isSidebarOpen,
                    'md:ml-16': !isSidebarOpen
                }" style="transition-property: margin; transition-duration: 150ms;">

        <!-- Navbar -->
        <x-navbar />

        <!-- Page Heading -->
        <header>
          <div class="p-4 sm:p-6">
            {{ $header }}
          </div>
        </header>

        <!-- Page Content -->
        <main class="px-4 sm:px-6 flex-1">
          <div class="my-5">
            <!-- success alert -->
            @if($msg = Session::get('success'))
            <x-bladewind.alert type="success">
              {{ $msg}}
            </x-bladewind.alert>
            @endif
            <!-- end success alert -->
  
            <!-- error alert -->
            @if($msg = Session::get('error'))
            <x-bladewind.alert type="error">
              {{ $msg}}
            </x-bladewind.alert>
            @endif
            <!-- end error alert -->
            <!-- warning alert -->
            @if($msg = Session::get('warning'))
            <x-bladewind.alert type="warning">
              {{ $msg}}
            </x-bladewind.alert>
            @endif
            <!-- end warning alert -->
            <!-- info alert -->
            @if($msg = Session::get('info'))
            <x-bladewind.alert>
              {{ $msg}}
            </x-bladewind.alert>
            @endif

          </div>
          <!-- end info alert -->

          {{ $slot }}
        </main>

        <!-- Page Footer -->
        <x-footer />
      </div>
    </div>
  </div>
  @yield('script')
  <script src="{{ asset('js/select2.min.js') }}"></script>

</body>

</html>