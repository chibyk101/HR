<div class="flex items-center justify-between flex-shrink-0 px-3">
    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2">
        <x-application-logo aria-hidden="true" class="w-10 h-auto" />
        <span class="sr-only">K UI Logo</span>
    </a>

    <!-- Toggle button -->
    <x-button type="button" iconOnly srText="Toggle sidebar" variant="secondary"
        x-show="isSidebarOpen || isSidebarHovered" @click="isSidebarOpen = !isSidebarOpen">
        <x-icons.menu-fold-right x-show="!isSidebarOpen" aria-hidden="true" class="hidden w-6 h-6 lg:block" />
        <x-icons.menu-fold-left x-show="isSidebarOpen" aria-hidden="true" class="hidden w-6 h-6 lg:block" />
        <i class="mdi mdi-format-align-justify text-xl"></i>
    </x-button>
</div>