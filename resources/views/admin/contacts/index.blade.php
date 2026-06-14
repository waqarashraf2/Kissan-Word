@extends('layouts.admin')
@section('title', 'Inquiries')
@section('heading', 'Inquiries')
@section('content')
<div class="admin-page-heading"><div><h1>Contact inquiries</h1><p>Messages submitted from the public contact form.</p></div></div>
<section class="admin-card"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Name</th><th>Phone</th><th>Email</th><th>Status</th><th>Received</th><th></th></tr></thead><tbody>@forelse($contacts as $contact)<tr><td><strong>{{ $contact->name }}</strong></td><td>{{ $contact->phone }}</td><td>{{ $contact->email }}</td><td><span class="admin-status {{ $contact->status === 'new' ? 'pending' : 'completed' }}">{{ ucfirst($contact->status) }}</span></td><td>{{ $contact->created_at->format('M d, Y h:i A') }}</td><td class="admin-actions"><a href="{{ route('admin.contacts.show',$contact) }}">Read</a><x-admin.delete-form :action="route('admin.contacts.destroy',$contact)" /></td></tr>@empty<tr><td colspan="6" class="admin-empty">No inquiries found.</td></tr>@endforelse</tbody></table></div><div class="admin-pagination">{{ $contacts->links() }}</div></section>
@endsection
