@extends('Admin.layout')
@section('main')
<div class="container text-end">
    <h2>جميع مندوبي التوصيل </h2>

    <!-- Success Message -->
    @if (Session::has('success'))
        <div class="alert alert-success" style="background:#28272f; color: white;">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <!-- delegates Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>الإجراءات</th>
                <th>الهاتف</th>
                <th>الاسم</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($delegates as $delegate)
            <tr>
                <td>


                    <!-- Show Button -->
                    <button class="btn btn-info btn-rounded btn-sm" data-bs-toggle="modal" data-bs-target="#showDelegateModal{{ $delegate->id }}">
                        <i class="fa fa-eye"></i>
                    </button>
                    @if($delegate->phone)
                                    <a href="https://wa.me/{{ $delegate->phone }}" target="_blank" class="btn btn-action"
                                        style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); color: #fff; border: none;">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                @endif
                </td>
                <td>{{ $delegate->phone }}</td>
                <td>{{ $delegate->name }}</td>
                <td>{{ $delegate->id }}</td>
            </tr>

            <!-- Show delegate Modal -->
            <div class="modal fade text-end" id="showDelegateModal{{ $delegate->id }}" tabindex="-1" aria-labelledby="showDelegateModalLabel{{ $delegate->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="showDelegateModalLabel{{ $delegate->id }}">
                                <i class="fa fa-user me-2"></i>تفاصيل المندوب
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card mb-3 border-0 shadow-none" style="background: #f8fafc;">
                                <div class="card-body text-center">
                                    <img src="{{ $delegate->image }}" alt="صورة المندوب" class="rounded-circle mb-3" style="width: 90px; height: 90px; object-fit: cover; border: 3px solid #e5e7eb;">
                                    <h5 class="card-title mb-2" style="color: #0F172A;">{{ $delegate->name }}</h5>
                                    <span class="badge {{ $delegate->is_blocked ? 'bg-danger' : 'bg-success' }} mb-2">{{ $delegate->is_blocked ? 'محظور' : 'نشط' }}</span>
                                </div>
                                <ul class="list-group list-group-flush text-end">
                                    <li class="list-group-item"><strong>رقم المعرف:</strong> {{ $delegate->id }}</li>
                                    <li class="list-group-item"><strong>الهاتف:</strong> {{ $delegate->phone }}</li>
                                    <li class="list-group-item"><strong>الإيميل:</strong> {{ $delegate->email }}</li>
                                    <li class="list-group-item"><strong>المنطقة:</strong> {{ $delegate->area }}</li>
                                    <li class="list-group-item"><strong>المسؤول:</strong> {{ $delegate->admin ? $delegate->admin->name : '-' }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </div>
>
            @empty
            <tr>
                <td colspan="12" class="text-center">لا يوجد مندوبين متاحين.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection