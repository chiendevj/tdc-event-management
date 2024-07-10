@extends('layouts.admin')

@section('title', 'Tạo quyền mới')

@section('content')
<div class="px-20 py-10">
    <div class="flex justify-center">
        <h1 class="p-2 bg-blue-800 mb-4 text-white font-semibold">Tạo quyền mới</h1>
    </div>

    <form action="{{ route('roles.store') }}" method="POST" class="px-40 py-10 border-blue-900 border-dashed border-2">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-[14px] font-medium text-blue-900">Tên quyền <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900 placeholder:text-sm" placeholder="Nhập tên quyền mới" required>
        </div>

        <div class="mb-4">
            <label for="permission" class="block text-[14px] font-medium text-blue-900">Danh sách Permissions</label>
            <select id="permission-select" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900">
                @foreach($permissions as $permission)
                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                @endforeach
            </select>
            <button type="button" id="add-permission" class="mt-2 p-2 bg-blue-800 text-white font-semibold">Thêm</button>
        </div>

        <div class="mb-4">
            <label for="permission" class="block text-[14px] font-medium text-blue-900">Permissions khác (nếu có)</label>
            <input type="text" id="permission-input" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900 placeholder:text-sm" placeholder="Nhập tên permission mới và nhấn thêm">
            <button type="button" id="add-other-permission" class="mt-2 p-2 bg-blue-800 text-white font-semibold">Thêm</button>
        </div>

        <ul id="permissions-list" class="mb-4 list-disc pl-5 text-blue-900"></ul>

        <input type="hidden" name="permissions" id="permissions-hidden-input">

        <div class="flex justify-between">
            <a class="py-2 px-5 bg-green-600 text-white font-semibold opacity-90 hover:opacity-100" href="{{ route('accounts.index') }}">Trở lại</a>
            <button type="submit" class="py-2 px-5 bg-blue-800 text-white font-semibold opacity-90 hover:opacity-100">Tạo</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addPermissionButton = document.getElementById('add-permission');
        const addOtherPermissionButton = document.getElementById('add-other-permission');

        const permissionSelect = document.getElementById('permission-select');
        const permissionsList = document.getElementById('permissions-list');
        const permissionInput = document.getElementById('permission-input');
        const permissionsHiddenInput = document.getElementById('permissions-hidden-input');

        
        addOtherPermissionButton.addEventListener('click', function() {
            const permission = permissionInput.value.trim();
            if (permission) {
                const li = document.createElement('li');
                li.textContent = permission;
                permissionsList.appendChild(li);

                const currentPermissions = permissionsHiddenInput.value.split(',').filter(Boolean);
                if (!currentPermissions.includes(permission)) {
                    currentPermissions.push(permission);
                    permissionsHiddenInput.value = currentPermissions.join(',');
                }

                permissionInput.value = '';
            }
        })

        addPermissionButton.addEventListener('click', function () {
            const permission = permissionSelect.value.trim();
            if (permission) {
                const li = document.createElement('li');
                li.textContent = permission;
                permissionsList.appendChild(li);

                const currentPermissions = permissionsHiddenInput.value.split(',').filter(Boolean);
                if (!currentPermissions.includes(permission)) {
                    currentPermissions.push(permission);
                    permissionsHiddenInput.value = currentPermissions.join(',');
                }

                permissionSelect.value = '';
            }
        });

        // Optional: Add event listener to remove selected permission from list
        permissionsList.addEventListener('click', function (event) {
            if (event.target.tagName === 'LI') {
                const permissionToRemove = event.target.textContent.trim();
                const currentPermissions = permissionsHiddenInput.value.split(',').filter(Boolean);
                const index = currentPermissions.indexOf(permissionToRemove);
                if (index !== -1) {
                    currentPermissions.splice(index, 1);
                    permissionsHiddenInput.value = currentPermissions.join(',');
                    event.target.remove();
                }
            }
        });
    });
</script>
@endsection
