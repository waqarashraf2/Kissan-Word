@props(['action', 'label' => 'Delete'])
<form action="{{ $action }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone.')">@csrf @method('DELETE')<button type="submit" class="admin-danger">{{ $label }}</button></form>
