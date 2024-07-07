@extends('layouts.admin')

@section('title', 'Chỉnh sửa quyền')

@section('content')
<div class="px-20 py-10">
    <div class="flex justify-center">
        <h1 class="p-2 bg-blue-800 mb-4 text-white font-semibold">Chỉnh sửa quyền</h1>
    </div>

    <form action="{{ route('roles.update', $role) }}" method="POST" class="px-40 py-10 border-blue-900 border-dashed border-2">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-[14px] font-medium text-blue-900">Tên quyền <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900 placeholder:text-sm" placeholder="Nhập tên quyền mới" required value="{{ old('name', $role->name) }}">
        </div>

        <div class="mb-4">
            <label for="permission-select" class="block text-[14px] font-medium text-blue-900">Danh sách Permissions</label>
            <select id="permission-select" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900">
                @foreach($permissions as $permission)
                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                @endforeach
            </select>
            <button type="button" id="add-permission" class="mt-2 p-2 bg-blue-800 text-white font-semibold">Thêm</button>
        </div>

        <div class="mb-4">
            <label for="permission-input" class="block text-[14px] font-medium text-blue-900">Permissions khác (nếu có)</label>
            <input type="text" id="permission-input" class="mt-1 p-2 outline outline-gray-300 outline-2 rounded-sm block w-full text-blue-900 placeholder:text-sm" placeholder="Nhập tên permission mới và nhấn thêm">
            <button type="button" id="add-other-permission" class="mt-2 p-2 bg-blue-800 text-white font-semibold">Thêm</button>
        </div>

        <ul id="permissions-list" class="mb-4 list-disc pl-5 text-blue-900">
            @foreach($role->permissions as $permission)
            <li>
                {{ $permission->name }}
                <button type="button" class="ml-2 text-red-500 hover:text-red-700 font-medium remove-permission">Xóa</button>
            </li>
            @endforeach
        </ul>

        <input type="hidden" name="permissions" id="permissions-hidden-input" value="{{ implode(',', $role->permissions->pluck('name')->toArray()) }}">

        <div class="flex justify-between">
            <a class="py-2 px-5 bg-green-600 text-white font-semibold opacity-90 hover:opacity-100" href="{{ route('accounts.index') }}">Trở lại</a>
            <button type="submit" class="py-2 px-5 bg-blue-800 text-white font-semibold opacity-90 hover:opacity-100">Cập nhật</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addPermissionButton = document.getElementById('add-permission');
        const addOtherPermissionButton = document.getElementById('add-other-permission');

        const permissionSelect = document.getElementById('permission-select');
        const permissionsList = document.getElementById('permissions-list');
        const permissionInput = document.getElementById('permission-input');
        const permissionsHiddenInput = document.getElementById('permissions-hidden-input');

        function addPermission(permission) {
            if (permission && !permissionsHiddenInput.value.includes(permission)) {
                const li = document.createElement('li');
                li.textContent = permission;
                const removeButton = document.createElement('button');
                removeButton.textContent = 'Xóa';
                removeButton.className = 'ml-2 text-red-500 hover:text-red-700 font-medium remove-permission';
                li.appendChild(removeButton);
                permissionsList.appendChild(li);

                permissionsHiddenInput.value += (permissionsHiddenInput.value ? ',' : '') + permission;

                return true;
            }
            return false;
        }

        addPermissionButton.addEventListener('click', function() {
            const permission = permissionSelect.value.trim();
            if (addPermission(permission)) {
                permissionSelect.value = '';
            }
        });

        addOtherPermissionButton.addEventListener('click', function() {
            const permission = permissionInput.value.trim();
            if (addPermission(permission)) {
                permissionInput.value = '';
            }
        });

        permissionsList.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-permission')) {
                const listItem = event.target.parentElement;
                const permissionToRemove = Array.from(listItem.childNodes)
                    .filter(node => node.nodeType === Node.TEXT_NODE)
                    .map(node => node.textContent.trim())
                    .join('');

                const currentPermissions = permissionsHiddenInput.value.split(',').filter(Boolean);
                const index = currentPermissions.indexOf(permissionToRemove);

                if (index !== -1) {
                    currentPermissions.splice(index, 1);
                    permissionsHiddenInput.value = currentPermissions.join(',');
                    listItem.remove();
                }
            }
        });

    });
</script>
@endsection