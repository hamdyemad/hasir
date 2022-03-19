@extends('layouts.master')


@section('title')
شركاء النجاح
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') شركاء النجاح @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') كل شركاء النجاح @endslot
    @endcomponent
    <div class="all_projects">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>شركاء النجاح</h2>
                    @can('clients.create')
                        <div>
                            <a href="{{ route('clients.create') }}" class="btn btn-primary mb-2">أنشاء عميل جديد</a>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>وقت أخر تعديل</th>
                                <th>الأعدادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <th scope="row">{{ $client->id }}</th>
                                    <td>
                                        <div>
                                            @if ($client->photo !== null)
                                                <img src="{{ asset($client->photo) }}" alt="">
                                            @else
                                                <img src="{{ asset('/images/product_avatar.png') }}" alt="">
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $client->created_at->diffForHumans() }}</td>
                                    <td>{{ $client->updated_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="options d-flex">
                                            @can('clients.edit')
                                                <a class="btn btn-info mr-1"
                                                    href="{{ route('clients.edit', $client) }}">
                                                    <span>تعديل</span>
                                                    <span class="mdi mdi-circle-edit-outline"></span>
                                                </a>
                                            @endcan
                                            @can('clients.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $client->id }}">
                                                    <span>ازالة</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $client->id,
                                                'route' => route('clients.destroy', $client->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
