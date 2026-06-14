@extends('layouts.admin')
@section('title', 'Inquiry from '.$contact->name)
@section('heading', 'Inquiry Detail')
@section('content')
<div class="admin-page-heading"><div><h1>{{ $contact->name }}</h1><p>Received {{ $contact->created_at->format('F d, Y h:i A') }}</p></div><a class="admin-secondary" href="{{ route('admin.contacts.index') }}">Back</a></div>
<section class="admin-card admin-message"><div class="admin-contact-meta"><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>@if($contact->email)<a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>@endif</div><p>{{ $contact->message }}</p><div class="admin-actions"><a class="admin-primary" href="https://wa.me/92{{ ltrim(preg_replace('/\D/','',$contact->phone),'0') }}" target="_blank" rel="noopener">Reply on WhatsApp</a><x-admin.delete-form :action="route('admin.contacts.destroy',$contact)" /></div></section>
@endsection
