<nav class="navbar-custom" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                        💬
                    </div>
                    <span class="text-xl font-bold gradient-text hidden sm:block">ITCP</span>
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center ml-8 space-x-1">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg hover:bg-gray-100 transition {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-indigo-600' : 'text-gray-700' }}">
                        <i class="bi bi-grid-3x3-gap-fill mr-2"></i> Dashboard
                    </a>

                    @auth
                        @if(Auth::user()->user_type == 'Admin')
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg hover:bg-gray-100 transition {{ request()->routeIs('admin.*') ? 'bg-gray-100 text-indigo-600' : 'text-gray-700' }}">
                                <i class="bi bi-shield-lock-fill mr-2"></i> Admin
                            </a>
                        @endif
                    @endauth

                    <a href="{{ route('tasks.index') }}" class="px-4 py-2 rounded-lg hover:bg-gray-100 transition {{ request()->routeIs('tasks.*') ? 'bg-gray-100 text-indigo-600' : 'text-gray-700' }}">
                        <i class="bi bi-check2-square mr-2"></i> Tasks
                    </a>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="flex items-center space-x-3">
                <div class="hidden sm:flex items-center space-x-2 text-sm text-gray-500">
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-semibold">
                        {{ Auth::user()->user_type }}
                    </span>
                </div>

                <!-- 🔥 DROPDOWN TOGGLE -->
                <div class="relative">
                    <button @click="open = !open" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-100 transition">
                        <div class="avatar avatar-sm">
                            {{ substr(Auth::user()->username, 0, 1) }}
                        </div>
                        <span class="font-medium text-gray-700 hidden sm:block">
                            {{ Auth::user()->username }}
                        </span>
                        <i class="bi bi-chevron-down text-gray-400 text-sm transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <!-- 🔥 DROPDOWN MENU -->
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50"
                         style="display: none;"
                         :style="open ? 'display: block;' : 'display: none;'">
                        
                        <!-- User Info -->
                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                            <p class="font-semibold text-gray-800">{{ Auth::user()->username }}</p>
                            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-1">
                            <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                                <i class="bi bi-person-circle text-gray-400 text-lg"></i>
                                My Profile
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                                <i class="bi bi-pencil-square text-gray-400 text-lg"></i>
                                Edit Profile
                            </a>
                            <a href="{{ route('profile.change-password') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                                <i class="bi bi-key text-gray-400 text-lg"></i>
                                Change Password
                            </a>
                        </div>

                        <!-- Logout -->
                        <div class="border-t border-gray-100 py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-4 py-2.5 w-full text-left text-sm text-red-600 hover:bg-red-50 transition">
                                    <i class="bi bi-box-arrow-right text-red-400 text-lg"></i>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>