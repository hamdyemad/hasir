@extends('layouts.master')

@section('title')
تعديل {{ $business->name }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $business->name }} @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') المعاملات المالية @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('business.index') }} @endslot
        @slot('li3') تعديل {{ $expense->name }} @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    تعديل {{ $business->name }}
                </div>
                <div class="card-body">
                    <form action="{{ route('expenses.update', $expense) }}" method="POST">
                        <input type="text" name="type" hidden value="{{ request('type') }}">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    @if ($business->type == 'income')
                                        <label for="name">أسم الأيراد</label>
                                    @else
                                        <label for="name">أسم المصروف</label>
                                    @endif
                                    <input type="text" class="form-control" name="name" value="{{ $expense->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    @if ($business->type == 'income')
                                        <label for="name">أسم صاحب الأيراد</label>
                                    @else
                                        <label for="name">أسم صاحب المصروف</label>
                                    @endif
                                    <input type="text" class="form-control" name="expense_for"
                                        value="{{ $expense->expense_for }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">الهاتف</label>
                                    <input type="number" class="form-control" name="phone"
                                        value="{{ $expense->phone }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">المبلغ</label>
                                    <input type="text" class="form-control" name="price" value="{{ $expense->price }}">
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">الملاظات</label>
                                    <textarea id="textarea" class="form-control" name="notes" maxlength="225"
                                        rows="3">{{ $expense->notes }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="تعديل" class="btn btn-success">
                                    <a href="{{ route('expenses.index', ['type' => request('type')]) }}"
                                        class="btn btn-info">
                                        رجوع الى {{ $business->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
