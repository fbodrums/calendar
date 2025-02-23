@php
    $currentRoute = Request::route()->getName();
@endphp
<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="#" class="sidebar-logo">
            <img src="{{ asset('assets/images/logo.png') }}" class="light-logo">
            <img src="{{ asset('assets/images/logo.png') }}" class="dark-logo">
            <img src="{{ asset('assets/images/logo.png') }}" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            @foreach (getSidebar() as $menu)
                @if (!isset($menu['submenu']))
                    @if (isset($menu['icon']))
                        <li>
                            <a href="{{ route($menu['route'], $menu['params'] ?? []) }}"
                                {{ isset($menu['target']) ? 'target=' . $menu['target'] : '' }}
                                class="{{ in_array($currentRoute, $menu['active_routes']) ? 'active-page' : '' }}">
                                <iconify-icon icon="{{ $menu['icon'] }}" class="menu-icon"></iconify-icon>
                                <span>{{ $menu['title'] }}</span>
                            </a>
                        </li>
                    @else
                        <li class="sidebar-menu-group-title">{{ $menu['title'] }}</li>
                    @endif
                @else
                    <li class="dropdown">
                        <a
                            href="{{ $menu['route'] ? route($menu['route'], $submenu['params'] ?? []) : 'javascript:void(0)' }}">
                            <iconify-icon icon="{{ $menu['icon'] }}" class="menu-icon"></iconify-icon>
                            <span>{{ $menu['title'] }}</span>
                        </a>
                        @if ($menu['submenu'])
                            <ul class="sidebar-submenu">
                                @foreach ($menu['submenu'] as $submenu)
                                    <li class="">
                                        <a href="{{ route($submenu['route'], $submenu['params'] ?? []) }}">
                                            <i
                                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>{{ $submenu['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
