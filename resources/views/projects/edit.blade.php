@extends('layouts.master')

@section('title')
تعديل المشروع
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $project->name }} @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') المشاريع @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('projects.index') }} @endslot
        @slot('li3') {{ $project->name }} @endslot
    @endcomponent
    <div class="edit_project">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    تعديل المشروع
                </div>
                <div class="card-body">
                    <form action="{{ route('projects.update', $project) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">أسم المشروع</label>
                                    <input type="text" class="form-control" name="name" value="{{ $project->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">وصف المشروع</label>
                                    <textarea class="form-control" name="description" maxlength="225"
                                    rows="3">{{ $project->description }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">عدد الوحدات</label>
                                    <input type="integer" class="form-control" name="units" value="{{ $project->units }}">
                                    @error('units')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">الوحدات المتاحة</label>
                                    <input type="number" class="form-control" name="available_units" value="{{ $project->available_units }}">
                                    @error('available_units')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">عدد المبانى</label>
                                    <input type="integer" class="form-control" name="buildings" value="{{ $project->buildings }}">
                                    @error('buildings')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">ملف المشروع</label>
                                    <input type="file" class="form-control" accept="application/pdf" value="{{ $project->file }}" name="file"
                                        value="{{ old('file') }}">
                                    @error('file')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">موقع المشروع</label>
                                    <input type="text" class="form-control" name="location" value="{{ $project->location }}">
                                    @error('location')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">مميزات الموقع</label>
                                    <textarea class="form-control" name="location_features" maxlength="225"
                                    rows="3">{{ $project->location_features }}</textarea>
                                    @error('location_features')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">صور المشروع</label>
                                    <input type="file" class="form-control input_files" accept="image/*" multiple hidden name="photos[]"
                                        value="{{ old('photo') }}">
                                    <button type="button" class="btn btn-primary form-control files">
                                        @if ($project->photos)
                                            {{ count(json_decode($project->photos)) }}
                                        @else
                                            <span class="mdi mdi-plus btn-lg"></span>
                                        @endif
                                    </button>
                                    <div class="imgs mt-2 d-flex">
                                        @if ($project->photos)
                                        @foreach (json_decode($project->photos) as $photo)
                                            <img class="input_img mt-2" src="{{ asset($photo) }}">
                                        @endforeach
                                        @else
                                            <img class="input_img mt-2" src="{{ asset('images/product_avatar.png') }}">
                                        @endif
                                    </div>
                                    @error('photos')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">رقم الظهور</label>
                                    <input type="integer" class="form-control" name="viewed_number" value="{{ $project->viewed_number }}">
                                    @error('viewed_number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-success mb-2 add_infos" type="button">أضف الوحدات السكنية</button>
                                <div class="infos">
                                    @if(old('infos'))
                                        @foreach (old('infos') as $index => $obj)
                                            <table class="table table-responsive table-{{ $index }}">
                                                <thead>
                                                    <th>الدور</th>
                                                    <th>رقم الشقة</th>
                                                    <th>مواصفات الشقة</th>
                                                    <th>المساحة</th>
                                                    <th>مميزات الشقة</th>
                                                    <th></th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input class="form-control" name="infos[{{ $index }}][round]" placeholder="الدور" type="text" value="{{ $obj['round'] }}">
                                                            @error("infos.$index.round")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <input class="form-control" name="infos[{{ $index }}][rooms]" placeholder="رقم الشقة" type="text" value="{{ $obj['rooms'] }}">
                                                            @error("infos.$index.rooms")
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" name="infos[{{ $index }}][description]" placeholder="مواصفات الشقة">{{ $obj['description'] }}</textarea>
                                                            @error("infos.$index.description")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <textarea  class="form-control" name="infos[{{ $index }}][space]"  placeholder="المساحة">{{ $obj['space'] }}</textarea>
                                                            @error("infos.$index.space")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" name="infos[{{ $index }}][features]" placeholder="مميزات الشقة">{{ $obj['features'] }}</textarea>
                                                            @error("infos.$index.features")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger removeRow" type="button">ازالة</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>الصور</th>
                                                        <th>السعر</th>
                                                        <th>الحالة</th>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="file" class="form-control input_files" data-img="2" accept="image/*" multiple hidden  name="infos[{{ $index }}][photos][]">
                                                            <div class="text-danger file_error" hidden>يجب اختيار 2 صور كحد اقصى</div>
                                                            <button type="button" class="btn btn-primary form-control files">
                                                                <span class="mdi mdi-plus btn-lg"></span>
                                                            </button>
                                                            <div class="imgs mt-2 d-flex"></div>
                                                            @error("infos.$index.photos")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <input class="form-control" name="infos[{{ $index }}][price]" placeholder="السعر" type="number" value="{{ $obj['price'] }}">
                                                            @error("infos.$index.price")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <select class="form-control" name="infos[{{ $index }}][status]">
                                                                    <option @if($obj['status'] == 'غير مباع') selected @endif value="غير مباع">غير مباع</option>
                                                                    <option @if($obj['status'] == 'مباع') selected @endif  value="مباع">مباع</option>
                                                                    <option @if($obj['status'] == 'محجوز') selected @endif  value="محجوز">محجوز</option>
                                                                </select>
                                                                @error("infos.$index.status")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endforeach
                                    @else
                                        @if($project->infos->count() > 0)
                                            @foreach ($project->infos as $index => $obj)
                                                <input class="form-control" name="infos[{{ $index }}][id]" placeholder="الدور" type="hidden" value="{{ $obj['id'] }}">
                                                <table class="table table-responsive table-{{ $index }}">
                                                    <thead>
                                                        <th>الدور</th>
                                                        <th>رقم الشقة</th>
                                                        <th>مواصفات الشقة</th>
                                                        <th>المساحة</th>
                                                        <th>مميزات الشقة</th>
                                                        <th></th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input class="form-control" name="infos[{{ $index }}][round]" placeholder="الدور" type="text" value="{{ $obj['round'] }}">
                                                                @error("infos.$index.round")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input class="form-control" name="infos[{{ $index }}][rooms]" placeholder="رقم الشقة" type="text" value="{{ $obj['rooms'] }}">
                                                                @error("infos.$index.rooms")
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" name="infos[{{ $index }}][description]" placeholder="مواصفات الشقة">{{ $obj['description'] }}</textarea>
                                                                @error("infos.$index.description")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <textarea  class="form-control" name="infos[{{ $index }}][space]"  placeholder="المساحة">{{ $obj['space'] }}</textarea>
                                                                @error("infos.$index.space")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" name="infos[{{ $index }}][features]" placeholder="مميزات الشقة">{{ $obj['features'] }}</textarea>
                                                                @error("infos.$index.features")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger removeRow" data-project="{{ $project->id }}" data-info="{{ $obj->id }}" type="button">ازالة</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>الصور</th>
                                                            <th>السعر</th>
                                                            <th>الحالة</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="file" class="form-control input_files" data-img="2" accept="image/*" multiple hidden  name="infos[{{ $index }}][photos][]">
                                                                <div class="text-danger file_error" hidden>يجب اختيار 2 صور كحد اقصى</div>
                                                                <button type="button" class="btn btn-primary form-control files">
                                                                    @if ($obj->photos)
                                                                        {{ count(json_decode($obj->photos)) }}
                                                                    @else
                                                                        <span class="mdi mdi-plus btn-lg"></span>
                                                                    @endif
                                                                </button>
                                                                <div class="imgs mt-2 d-flex">
                                                                    @if ($obj->photos)
                                                                        @foreach (json_decode($obj->photos) as $photo)
                                                                            <img class="input_img mt-2" src="{{ asset($photo) }}">
                                                                        @endforeach
                                                                    @else
                                                                        <img class="input_img mt-2" src="{{ asset('images/product_avatar.png') }}">
                                                                    @endif
                                                                </div>
                                                                @error("infos.$index.photos")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input class="form-control" name="infos[{{ $index }}][price]" placeholder="السعر" type="number" value="{{ $obj['price'] }}">
                                                                @error("infos.$index.price")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <select class="form-control" name="infos[{{ $index }}][status]">
                                                                        <option @if($obj['status'] == 'غير مباع') selected @endif value="غير مباع">غير مباع</option>
                                                                        <option @if($obj['status'] == 'مباع') selected @endif  value="مباع">مباع</option>
                                                                        <option @if($obj['status'] == 'محجوز') selected @endif  value="محجوز">محجوز</option>
                                                                    </select>
                                                                    @error("infos.$index.status")
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endforeach
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="مرئى">مرئى</label>
                                <div class="form-group">
                                    <input type="checkbox" name="active" id="projectSwitch" switch="bool"
                                    @if($project->active)
                                        checked
                                    @endif />
                                    <label for="projectSwitch" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="تعديل" class="btn btn-success">
                                    <a href="{{ route('projects.index') }}" class="btn btn-info">رجوع الى المشاريع</a>
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
        let increament = 0 + parseInt("{{ $project->infos->count() }}");
        function table(index) {
            return `
            <table class="table table-responsive table-${index} added_table">
                <thead>
                    <th>الدور</th>
                    <th>رقم الشقة</th>
                    <th>مواصفات الشقة</th>
                    <th>المساحة</th>
                    <th>مميزات الشقة</th>
                    <th></th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input class="form-control" name="infos[${index}][round]" placeholder="الدور" type="text">
                            @error('infos.*.round')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <input class="form-control" name="infos[${index}][rooms]" placeholder="رقم الشقة" type="text">
                            @error('infos.*.rooms')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <textarea class="form-control" name="infos[${index}][description]" placeholder="مواصفات الشقة"></textarea>
                            @error('infos.*.description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <textarea class="form-control" name="infos[${index}][space]"  placeholder="المساحة"></textarea>
                            @error('infos.*.space')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <textarea class="form-control" name="infos[${index}][features]" placeholder="مميزات الشقة"></textarea>
                            @error('infos.*.features')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <button class="btn btn-danger removeRow" type="button">ازالة</button>
                        </td>
                    </tr>
                    <tr>
                        <th>الصور</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="file" class="form-control input_files" data-img="2" accept="image/*" multiple hidden  name="infos[${index}][photos][]">
                            <div class="text-danger file_error" hidden>يجب اختيار 2 صور كحد اقصى</div>
                            <button type="button" class="btn btn-primary form-control files">
                                <span class="mdi mdi-plus btn-lg"></span>
                            </button>
                            <div class="imgs mt-2 d-flex"></div>
                            @error('infos.*.photos')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <input class="form-control" name="infos[${index}][price]" placeholder="السعر" type="number">
                            @error('infos.*.price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <div class="form-group">
                                <select class="form-control" name="infos[${index}][status]">
                                    <option value="غير مباع">غير مباع</option>
                                    <option value="مباع">مباع</option>
                                    <option value="محجوز">محجوز</option>
                                </select>
                                @error('infos.*.status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            `;
        }
        $(".add_infos").on('click', function() {
            $(".infos").prepend(table(increament));
            increament++
            $(".added_table .files").on("click", function() {
                $(this)
                .parent()
                .find(".input_files")
                .click();
            });
            $(".added_table .input_files").on("change", function() {
                let filesBtn = $(this)
                    .parent()
                    .find(".files");
                let imgs = $(this)
                    .parent()
                    .find(".imgs");

                imgs.empty();
                let files = this.files;
                if (files.length > $(this).data("img")) {
                    $(this)[0].value = '';
                    $(this)
                        .parent()
                        .find(".file_error")
                        .removeAttr("hidden");
                } else {
                    $(this)
                        .parent()
                        .find(".file_error")
                        .attr("hidden", "");
                    files.forEach(file => {
                        let fileReader = new FileReader();
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function(event) {
                            let img = document.createElement("img");
                            img.setAttribute("class", "rounded");
                            img.src = event.target.result;
                            imgs.append(img);
                        };
                        if (files.length > 2) {
                            imgs.css({ overflowX: "scroll" });
                            filesBtn.text(files.length);
                        } else {
                            imgs.css({ overflowX: "auto" });
                            if (files[0].name.length > 15) {
                                filesBtn.text(
                                    files[0].name.substring(0, 15) + "..."
                                );
                            } else {
                                filesBtn.text(files[0].name);
                            }
                        }
                    });
                }
            });
            removeRow();
        });

        function removeRow() {
            $(".removeRow").on('click', function() {
                $(this).parent().parent().parent().parent().remove();
                if($(this).data('info')) {
                    $.ajax({
                        "method": "POST",
                        "url": "{{ route('projects.remove_info') }}",
                        "data": {
                            _token: token,
                            info_id: $(this).data('info'),
                            project_id: $(this).data('project')
                        },
                        "success": function(res) {
                            if(res.status) {
                                toastr.success(res.message);
                            }
                        },
                        "error": function(err) {

                        }
                    })
                }
            });
        }
        removeRow();

    </script>
@endsection
