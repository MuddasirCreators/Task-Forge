{{-- TaskForge Sidebar --}}

<aside class="tf-sidebar" id="tf-sidebar">


{{-- Spacer to align with navbar height --}}
<div class="tf-sidebar__top"></div>



{{-- Navigation --}}
<nav class="tf-sidebar__nav" aria-label="Main navigation">

<ul class="tf-nav-list">



{{-- Dashboard --}}
<li class="tf-nav-item">


<a href="{{ route('dashboard') }}"
class="tf-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
aria-label="Dashboard">


<span class="tf-nav-link__icon">

<svg viewBox="0 0 24 24"
fill="none"
stroke="currentColor"
stroke-width="2"
stroke-linecap="round"
stroke-linejoin="round">

<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>

<polyline points="9 22 9 12 15 12 15 22"/>

</svg>

</span>


<span class="tf-nav-link__label">
Dashboard
</span>


<span class="tf-nav-link__dot"></span>


</a>


</li>







{{-- Projects --}}
@if(
auth()->user()->role == 'Admin' ||
auth()->user()->role == 'Manager'
)


<li class="tf-nav-item">


<a href="{{ route('projects.index') }}"
class="tf-nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}"
aria-label="Projects">


<span class="tf-nav-link__icon">


<svg viewBox="0 0 24 24"
fill="none"
stroke="currentColor"
stroke-width="2"
stroke-linecap="round"
stroke-linejoin="round">


<path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>


</svg>


</span>


<span class="tf-nav-link__label">
Projects
</span>


<span class="tf-nav-link__dot"></span>


</a>


</li>


@endif







{{-- Tasks --}}
@if(
auth()->user()->role == 'Admin' ||
auth()->user()->role == 'Manager' ||
auth()->user()->role == 'Member'
)


<li class="tf-nav-item">


<a href="{{ route('tasks.index') }}"
class="tf-nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}"
aria-label="Tasks">


<span class="tf-nav-link__icon">


<svg viewBox="0 0 24 24"
fill="none"
stroke="currentColor"
stroke-width="2"
stroke-linecap="round"
stroke-linejoin="round">


<polyline points="9 11 12 14 22 4"/>

<path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>


</svg>


</span>


<span class="tf-nav-link__label">
Tasks
</span>


<span class="tf-nav-link__dot"></span>


</a>


</li>


@endif
{{-- Clients --}}
@if(
auth()->user()->role == 'Admin' ||
auth()->user()->role == 'Manager'
)

<li class="tf-nav-item">


<a href="{{ route('clients.index') }}"
class="tf-nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}"
aria-label="Clients">


<span class="tf-nav-link__icon">


<svg viewBox="0 0 24 24"
fill="none"
stroke="currentColor"
stroke-width="2"
stroke-linecap="round"
stroke-linejoin="round">


<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>

<circle cx="9" cy="7" r="4"/>

<path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>


</svg>


</span>


<span class="tf-nav-link__label">
Clients
</span>


<span class="tf-nav-link__dot"></span>


</a>


</li>

@endif






{{-- Audit Logs --}}
@if(
auth()->user()->role == 'Admin' ||
auth()->user()->role == 'Manager' ||
auth()->user()->role == 'Member'
)


<li class="tf-nav-item">


<a href="{{ route('audit-logs.index') }}"
class="tf-nav-link {{ request()->routeIs('audit-logs.*') ? 'active' : '' }}"
aria-label="Audit Logs">


<span class="tf-nav-link__icon">


<svg viewBox="0 0 24 24"
fill="none"
stroke="currentColor"
stroke-width="2"
stroke-linecap="round"
stroke-linejoin="round">


<circle cx="12" cy="12" r="10"/>

<polyline points="12 6 12 12 16 14"/>


</svg>


</span>



<span class="tf-nav-link__label">

Audit Logs

</span>



<span class="tf-nav-link__dot"></span>


</a>


</li>


@endif


{{-- Team --}}
@if(auth()->user()->role == 'Admin')


<li class="tf-nav-item">


<a href="{{ route('team.index') }}"
class="tf-nav-link {{ request()->routeIs('team.*') ? 'active' : '' }}"
aria-label="Team">


<span class="tf-nav-link__icon">


<svg viewBox="0 0 24 24"
fill="none"
stroke="currentColor"
stroke-width="2"
stroke-linecap="round"
stroke-linejoin="round">


<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>

<circle cx="9" cy="7" r="4"/>

<path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>


</svg>


</span>


<span class="tf-nav-link__label">
Team
</span>


<span class="tf-nav-link__dot"></span>


</a>


</li>


@endif
{{-- Settings --}}

<li class="tf-nav-item">


<a href="{{ route('profile.index') }}"
class="tf-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
aria-label="Settings">


<span class="tf-nav-link__icon">


<svg viewBox="0 0 24 24"
fill="none"
stroke="currentColor"
stroke-width="2"
stroke-linecap="round"
stroke-linejoin="round">


<circle cx="12" cy="12" r="3"/>


<path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>


</svg>


</span>


<span class="tf-nav-link__label">
Settings
</span>


<span class="tf-nav-link__dot"></span>


</a>


</li>








{{-- Logout --}}

<li class="tf-nav-item">


<form method="POST"
action="{{ route('logout') }}"
class="logout-form">


@csrf



<button type="submit"
class="tf-nav-link tf-nav-button"
aria-label="Logout">


<span class="tf-nav-link__icon">


<svg viewBox="0 0 24 24"
fill="none"
stroke="currentColor"
stroke-width="2"
stroke-linecap="round"
stroke-linejoin="round">


<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>

<polyline points="16 17 21 12 16 7"/>

<line x1="21" y1="12" x2="9" y2="12"/>


</svg>


</span>


<span class="tf-nav-link__label">
Logout
</span>


<span class="tf-nav-link__dot"></span>


</button>


</form>


</li>


</ul>


</nav>







{{-- Collapse toggle --}}

<div class="tf-sidebar__bottom">


<div class="tf-sidebar__collapse-wrap">


<button 
class="tf-sidebar__collapse"
id="tf-sidebar-toggle"
aria-label="Collapse sidebar">

«

</button>


</div>


</div>



</aside>









{{-- Sidebar collapse script --}}

<script>

(function () {


var sidebar = document.getElementById('tf-sidebar');

var toggle = document.getElementById('tf-sidebar-toggle');

var layout = document.querySelector('.tf-layout');


var collapsed =
localStorage.getItem('tf_sidebar_collapsed') === '1';



function applyState() {


if(collapsed){


sidebar.classList.add('collapsed');


if(layout){

layout.classList.add('sidebar-collapsed');

}


toggle.textContent='»';



}else{


sidebar.classList.remove('collapsed');


if(layout){

layout.classList.remove('sidebar-collapsed');

}


toggle.textContent='«';


}


}



applyState();





toggle.addEventListener(
'click',
function(){


collapsed = !collapsed;


localStorage.setItem(
'tf_sidebar_collapsed',
collapsed ? '1' : '0'
);


applyState();


});


})();


</script>