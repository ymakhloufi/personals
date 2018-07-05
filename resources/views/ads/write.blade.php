@extends('layout.main')

@section('title', "Place an Ad - ".config('app.name'))

@section('content')
    <div class="container mt-4 p-4" style="border: 1px solid #ddd; border-radius: 10px;">
        <h1>{{__('Place an Ad')}}</h1>
        <form class="form" method="post">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-12" style="font-size: 14pt; font-weight: bold; ">
                            <span>About You</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <input class="form-control form-required"
                                   type="text"
                                   name="author_name"
                                   placeholder="{{__('Your Name')}}"
                                   maxlength="16"/>
                        </div>
                        <div class="col-sm-4">
                            <input class="form-control"
                                   type="number"
                                   name="author_age"
                                   placeholder="{{__('Age')}}"
                                   min="0"
                                   max="99"
                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                   maxlength="2"/>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12" style="font-size: 14pt; font-weight: bold; ">
                            <span>Contact Details</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input class="form-control form-required"
                                   type="email"
                                   name="author_email"
                                   placeholder="{{__('Your Email')}}"
                                   maxlength="64"/>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-7">
                            <input class="form-control"
                                   type="tel"
                                   name="author_phone"
                                   placeholder="{{__('Phone (e.g. +1...)')}}"
                                   pattern="[\+]\d{1,3}[\d\.\-\ ]{6,30}"
                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                   maxlength="32"/>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-control" style="height: 34px; white-space: nowrap;">
                                <input type="checkbox"
                                       name="author_phone_whatsapp"
                                       id="author_phone_whatsapp"
                                       pattern="[\+]\d{6,32}"
                                       oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                       maxlength="32"/>
                                <label class="ml-2" for="author_phone_whatsapp">
                                    <i class="text-success fab fa-whatsapp" aria-hidden="true"></i>
                                    Whatsapp
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12" style="font-size: 14pt; font-weight: bold; ">
                            <span>Location</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" name="author_zip" placeholder="{{__('Your Zip Code')}}"
                                   class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="author_town" placeholder="{{__('Your Town')}}"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="row mt-2 mb-4">
                        <div class="col-sm-12">
                            <select name="country" class="form-control">
                                <option selected disabled value=""></option>
                                @foreach(config('countries.all') as $code => $set)
                                    <option value="{{$code}}" {{config('countries.default') === $code ? 'selected' : ''}}>{{ucwords(strtolower($set['name']))}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-12" style="font-size: 14pt; font-weight: bold; ">
                            <span>Your Ad</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm 12">
                            <input required type="text" class="form-control" name="title"
                                   placeholder="{{__('Title of Your Ad')}}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm 12">
                            <textarea required name="text" id="text" rows="11" class="form-control"
                                      placeholder="Text of Your Ad"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12" style="font-size: 14pt; font-weight: bold; ">
                    <span>{{__('Pictures')}}</span>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-3 d-none d-sm-inline"><img src="" style="width:100%" id="preview1"/></div>
                <div class="col-sm-9">
                    <input type="file" name="image[]" onchange="preview(this, 'preview1'); unhide('picture2');"/>
                </div>
            </div>
            <div class="row mb-4" id="picture2" style="display:none;">
                <div class="col-sm-3"><img src="" style="width:100%" id="preview2"/></div>
                <div class="col-sm-9">
                    <input type="file" name="image[]" onchange="preview(this, 'preview2'); unhide('picture3');"/>
                </div>
            </div>
            <div class="row mb-4" id="picture3" style="display:none;">
                <div class="col-sm-3"><img src="" style="width:100%" id="preview3"/></div>
                <div class="col-sm-9">
                    <input type="file" name="image[]" onchange="preview(this, 'preview3'); unhide('picture4');"/>
                </div>
            </div>
            <div class="row mb-4" id="picture4" style="display:none;">
                <div class="col-sm-3"><img src="" style="width:100%" id="preview4"/></div>
                <div class="col-sm-9">
                    <input type="file" name="image[]" onchange="preview(this, 'preview4'); unhide('picture5');"/>
                </div>
            </div>
            <div class="row mb-4" id="picture5" style="display:none;">
                <div class="col-sm-3"><img src="" style="width:100%" id="preview5"/></div>
                <div class="col-sm-9">
                    <input type="file" name="image[]" onchange="preview(this, 'preview5');"/>
                </div>
            </div>
            <div class="row">
                <div align="center" class="mt-3 col-sm-12">
                    <button type="submit" class="btn btn-warning btn-lg">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <script language="JavaScript">
        function unhide (id) {
            _(id).style.display = '';
        }

        function preview (input, previewId) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    $('#' + previewId).attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
