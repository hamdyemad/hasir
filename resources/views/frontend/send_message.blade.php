@extends('frontend.layout')

@section('content')
    <div class="send_message_page pt-5 pb-5">
        <div class="container">
            <div class="card">
                <div class="card-header animated fadeInDown">
                    @include('frontend.inc.heading', ['heading' => 'أرسل رسالتك عبر البريد الألكترونى'])
                </div>
                <div class="card-body animated fadeInUp">
                    <form action="{{ route('frontend.send_message') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="الأسم">
                                    @error('name')
                                    <div class="text-danger font-size-16">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="البريد الألكترونى">
                                    @error('email')
                                        <div class="text-danger font-size-16">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <select class="form-control select2" name="type">
                                        <option value="">أختر نوع الطلب</option>
                                        <option @if(request('type') == 'تعاون تجارى') selected @endif value="تعاون تجارى">تعاون تجارى</option>
                                        <option value="طالب عقار">طالب عقار</option>
                                        <option value="أخرى">أخرى</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger font-size-16">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" placeholder="الجوال">
                                    @error('phone')
                                        <div class="text-danger font-size-16">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" name="notes" placeholder="ملاحظات"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-block submit" placeholder="ارسال">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerScript')
<script>
    $("input[type=submit]").on('click', function() {
        $("form").submit();
        $(this).attr('disabled', '');
    });
</script>
@endsection
