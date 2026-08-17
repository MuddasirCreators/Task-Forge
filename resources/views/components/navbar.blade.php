{{-- TaskForge Navbar --}}
<nav class="tf-navbar">

  {{-- Logo --}}
  <a href="{{ route('dashboard') }}" class="tf-logo">
    <div class="tf-logo__icon">
      <img src="{{ asset('images/logo.png') }}"
           alt="TaskForge Logo"
           class="tf-logo__image">
    </div>
    <div class="tf-logo__text">
      <span class="tf-logo__name">TaskForge</span>
      <span class="tf-logo__tagline">Work. Track. Deliver.</span>
    </div>
  </a>

  {{-- Search --}}
  <div class="tf-search">
    <span class="tf-search__icon">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
      </svg>
    </span>
    <input
      type="text"
      class="tf-search__input"
      placeholder="Search projects, tasks, clients..."
      id="tf-global-search"
    />
    <span class="tf-search__shortcut">⌘K</span>
  </div>

  {{-- Right actions --}}
  <div class="tf-navbar__right">

    {{-- New button --}}
    <button class="tf-btn-new">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
        <path d="M12 5v14M5 12h14"/>
      </svg>
      New
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <path d="m6 9 6 6 6-6"/>
      </svg>
    </button>

    {{-- Date range --}}
    <div class="tf-date-range">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
        <rect x="3" y="4" width="18" height="18" rx="2"/>
        <path d="M16 2v4M8 2v4M3 10h18"/>
      </svg>
      {{ now()->format('M j, Y') }}
    </div>

  {{-- Notifications --}}
<div class="dropdown">
    <button class="tf-icon-btn" 
            type="button" 
            data-bs-toggle="dropdown" 
            aria-expanded="false"
            aria-label="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>

        @php
            $unreadCount = auth()->user()->unreadNotifications->count();
        @endphp

        @if($unreadCount > 0)
            <span class="tf-badge-dot">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
        @endif
    </button>

    <div class="dropdown-menu dropdown-menu-end shadow-sm notification-dropdown">
        <div class="notification-header">
            <strong>Notifications</strong>
            @if($unreadCount > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-mark-all">Mark all as read</button>
                </form>
            @endif
        </div>

        <div class="notification-list">
            @forelse(auth()->user()->notifications()->take(8)->get() as $notification)
                <a href="{{ $notification->data['url'] ?? '#' }}" 
                   class="notification-item {{ $notification->read_at ? '' : 'unread' }}"
                   onclick="markAsRead('{{ $notification->id }}')">
                    <div class="notification-icon 
                        {{ ($notification->data['type'] ?? '') === 'task_overdue' ? 'bg-red-soft' : 'bg-green-soft' }}">
                        <i class="bi {{ $notification->data['icon'] ?? 'bi-bell' }}"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">{{ $notification->data['title'] ?? 'Notification' }}</div>
                        <div class="notification-message">{{ $notification->data['message'] ?? '' }}</div>
                        <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                    </div>
                </a>
            @empty
                <div class="notification-empty">
                    No notifications yet
                </div>
            @endforelse
        </div>
    </div>
</div>

    {{-- Dark mode toggle --}}
    <!-- <button class="tf-icon-btn" aria-label="Toggle dark mode" id="tf-dark-toggle">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
      </svg>
    </button> -->

    {{-- User profile (clickable → opens profile page) --}}
    <a href="{{ route('profile.index') }}" class="tf-user" title="Go to Profile">
      @if(auth()->user()->avatar ?? false)
        <img src="{{ auth()->user()->avatar }}" 
             alt="{{ auth()->user()->name }}" 
             class="tf-user__avatar">
      @else
        <div class="tf-user__avatar-placeholder">
          {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
      @endif

      <div class="tf-user__info">
        <span class="tf-user__name">{{ auth()->user()->name }}</span>
        <span class="tf-user__role">
          {{ auth()->user()->role ?? 'Member' }}
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="m6 9 6 6 6-6"/>
          </svg>
        </span>
      </div>
    </a>

  </div>
</nav>

{{-- Keyboard shortcut handler --}}
<script>
  document.addEventListener('keydown', function(e) {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
      e.preventDefault();
      document.getElementById('tf-global-search').focus();
    }
  });
</script>
<script>
function markAsRead(id) {
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    });
}
</script>