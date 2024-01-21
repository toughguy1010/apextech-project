@extends('layouts.app')
@section('content')
    <?php
    use App\Models\Department;
    
    ?>
    <section>
        <div class="container-fluid">
            <ul class="nav nav-tabs">
                @foreach ($roles as $i => $role)
                    <?php
                    $department = Department::getDepartmentbyRoleId($role->id);
                    
                    if (!$department) {
                        continue;
                    }
                    $isActive = $i == 0 ? 'active' : '';
                    ?>
                    <li class="nav-item">
                        <a class="nav-link role-tab {{ $isActive }}" aria-current="page" href="#"
                            data-url="{{ url('admin/user/filter-role-user', $department->id) }}"> {{ $role->name }} </a>
                    </li>
                @endforeach
            </ul>
            <div class="list_user_body mt-5">
            </div>
            {{-- @include('admin.role-user') --}}
        </div>
        @vite(['resources/js/role.js'])
    </section>
@endsection
