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
                        <div class="col-sm-12 mt-4" style="font-size: 14pt; font-weight: bold; ">
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
                                   type="text"
                                   id="phone_number"
                                   placeholder="{{__('Your Phone Number')}}"
                                   oninput="set_phone();"
                                   maxlength="32"/>
                            <input type="hidden" name="author_phone" id="author_phone">
                        </div>
                        <div class="col-sm-5" style="margin-left: 0; padding-left: 0;">
                            <div class="form-control" style="border: 0;">
                                <div class=" checkbox checbox-switch switch-warning">
                                    <label style="cursor:pointer; white-space: nowrap;">
                                        <input type="checkbox" name="author_phone_whatsapp">
                                        <span></span>
                                        <i class="fab fa-whatsapp fa-1x"></i> Whatsapp
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mt-4" style="font-size: 14pt; font-weight: bold; ">
                            <span>Location</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="author_zip" placeholder="{{__("ZIP Code")}}"/>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="author_town"
                                   placeholder="{{__("Your Town")}}"/>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <select class="form-control" name="author_country" id="author_country">
                                @foreach(config('countries.all') as $code => $set)
                                    <option value="{{$code}}"
                                            @if(config('countries.default') === $code) selected @endif>
                                        {{ucwords(strtolower($set['name']))}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-12" style="font-size: 14pt; font-weight: bold; ">
                            <span>{{__("Your Ad")}}</span>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <input type="text" name="title" class="form-control"
                                   placeholder="{{__("Title of Your Ad")}}"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                    <textarea name="text" id="text" rows="11" class="form-control"
                              placeholder="{{__("Your Ad")}}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4" align="center">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-warning">{{__('Submit the Ad')}}</button>
                </div>
            </div>
        </form>
    </div>

    <style>
        .fa-whatsapp {
            color: #fff;
            background: linear-gradient(#25d366, #25d366) 1px 84%/4px 4px no-repeat,
            radial-gradient(circle at center, #25d366 63%, transparent 0);
            stroke: #1b1e21;
            stroke-width: 2px;
        }
    </style>
@endsection
