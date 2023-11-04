@extends('layouts.app')
@section('content')
    <section id="list_user_section">
        <div class="message">
        </div>
        <div class="list_user_header">
            <div class="row align-items-center">
                <h4 class="col-6">
                    Danh sách phòng ban
                </h4>
                <div class="col-6 d-flex justify-content-end">
                    <div class="input-group " style="width:fit-content">
                        <form action="" class="d-flex ms-0">
                            <input class="form-control search-input " type="text" placeholder="Nhập tên phòng ban"
                                name="search">
                            <button type="submit" class="btn btn-primary search-btn" type="button" id="button-addon1">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="list_user_body mt-5">
            <table class="table ">
                <thead>
                    <th style="border-top-left-radius: 10px;">
                        Tên phòng ban
                    </th>
                    <th>
                        Tên trưởng phòng
                    </th>
                    <th>
                        Mô tả
                    </th>

                    <th>
                        Số lượng
                    </th>
                    <th>

                    </th>

                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr id="department-{{ $department->id }}">
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->getLeaderName($department->leader_id) }}</td>
                            <td>{{ $department->description }}</td>
                            <td>{{ $department->countUsers() }}</td>
                            <td class="">
                                @if (Auth::user()->position_id == 4)
                                    <a href="{{ url('ceo/department/upsert', $department->id) }}" class="me-4">
                                        <i class="fa-solid fa-user-pen"></i>
                                    </a>
                                @else
                                    <a href="{{ url('admin/department/upsert', $department->id) }}" class="me-4">
                                        <i class="fa-solid fa-user-pen"></i>
                                    </a>
                                @endif

                                <a href="#" class="btn-delete"
                                    data-url="{{ url('admin/department/destroy', $department->id) }}">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <div class="pagination-wrap">
                {{ $departments->appends(['search' => $search])->links('layouts.pagination') }}

            </div>
        </div>
    </section>
    @vite(['resources/js/admin/department.js'])
@endsection
