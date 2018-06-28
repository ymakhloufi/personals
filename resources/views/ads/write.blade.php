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
                    <div class="row">
                        <div class="col-sm-12" style="font-size: 14pt; font-weight: bold; ">
                            <span>Contact Details</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="form-control form-required"
                                   type="email"
                                   name="author_email"
                                   placeholder="{{__('Your Email')}}"
                                   maxlength="64"/>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control"
                                   type="tel"
                                   name="author_phone"
                                   placeholder="{{__('Phone (e.g. +1...)')}}"
                                   pattern="[\+]\d{1,3}[\d\.\-\ ]{6,30}"
                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                   maxlength="32"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div style="height: 34px;">
                                <input type="checkbox"
                                       name="author_phone_whatsapp"
                                       id="author_phone_whatsapp"
                                       pattern="[\+]\d{6,32}"
                                       oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                       maxlength="32"/>
                                <label for="author_phone_whatsapp">Whatsapp</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <select name="country" class="form-control">
                                <option selected disabled value=""></option>
                                @foreach(config('countries') as $code => $set)
                                    <option value="{{$code}}">{{ucwords(strtolower($set['name']))}}</option>
                                @endforeach
                            </select>
                            <input class="form-control form-required"
                                   type="email"
                                   name="author_email"
                                   placeholder="Your Email"
                                   maxlength="64"/>
                        </div>
                        <div class="col-sm-4">
                            <input class="form-control"
                                   type="tel"
                                   name="author_phone"
                                   placeholder="Your Phone Number"
                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                   maxlength="32"/>
                        </div>
                        <div class="col-sm-4">
                            <input class="form-control"
                                   type="tel"
                                   name="author_phone"
                                   placeholder="Your Phone Number"
                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                   maxlength="2"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <textarea name="text" id="text" cols="30" rows="10" class="form-control"></textarea>
                </div>
            </div>
            <button>Submit</button>
        </form>
    </div>
@endsection
