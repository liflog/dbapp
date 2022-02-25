@php
$role_id = Auth::user()->roles->first()->id;
if ($role_id) {
    $menus = DB::table('menus')
        ->where('role_id', $role_id)
        ->get();
} else {
    $role_id = 4;
}
@endphp
<div class="menus">
    @foreach ($menus as $menu)
        <a href="{{ $menu->url }}" class="menuitem">
            <i class="{{ $menu->icon }}"></i>
            <span class="title titlealt"> {{ $menu->name }}</span>
        </a>
    @endforeach
</div>
