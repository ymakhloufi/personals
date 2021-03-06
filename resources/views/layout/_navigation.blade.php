<style>
    .search {
        color: #ccc;
        padding: 0 15px;
        background-color: white;
        border-radius: 20px;
        height: 30px;
        border: 1px solid #ddd;
        min-width: 100px;
    }

    .search > i {
        max-height: 30px;
        min-height: 30px;
        cursor: pointer;
    }

    .search > input {
        margin: 0 5px;
        border-style: none;
        max-height: 26px;
        display: inline-block;
        top: -9px;
        color: #444;
    }

    .search > input::placeholder {
        color: #ccc;
    }

    .search > input:focus {
        outline: none;
    }

    @media (max-width: 460px) {
        .search {
            width: 150px;
        }

        .search > input {
            width: 66%;
        }
    }
</style>
<nav class="navbar navbar-dark bg-dark justify-content-between">
    <a class="navbar-brand" href="/">
        <img src="{{env('LOGO_URL', asset('/img/logo_white.png'))}}" height="28" alt="logo">
        <span class="d-none d-sm-inline"> {{config('app.name')}}</span>
    </a>
    <form action="{{route('ad.search')}}" method="get" id="search-form" class="search form-inline">
        <label for="search-input">
            <button type="submit" class="btn btn-link" style="color: inherit; padding: 0;">
                <i class="fa fa-search" onclick="
                    if(document.getElementById('search-input').value !== ''){
                      document.getElementById('search-form').submit();
                    } else {
                      document.getElementById('search-input').focus();
                    }">

                </i>
            </button>
        </label>


        <input type="text"
               class="navbar-item"
               placeholder="{{__('search...')}}"
               name="q"
               id="search-input"
               autocomplete="off"
        />
        <i class="fa fa-times" onclick="document.getElementById('search-form').reset();"></i>
    </form>
    <a class="btn btn-warning" href="/ads/write">
        <span class="icon"><i class="fa fa-pencil-alt"></i></span>
        <span class="d-none d-sm-inline"> {{_('Write Ad')}}</span>
    </a>
</nav>

<nav>
    <div class="jumbotron jumbotron-fluid p-4"
         style="text-align: center; color: #444; background: #fceabb; background: linear-gradient(10deg, #f7d785 0%,#fccd4d 100%);">
        <h1 class="text-lg-center">{{config('app.name')}}</h1>
        <span class="lead">{{config('app.description')}}</span>
    </div>
</nav>

@if(session()->has('success'))
    <div class="alert alert-success m-5 text-center">{!! session()->get('success') !!}</div>
@endif

@if(session()->has('warning'))
    <div class="alert alert-warning m-5 text-center">{{session()->get('warning')}}</div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger m-5 text-center">{{session()->get('error')}}</div>
@endif

@if(count($errors->getMessages()))
    <div class="alert alert-danger m-5 text-center">
        <ul>
            @foreach($errors->getMessages() as $messages)
                @foreach($messages as $message)
                    <li style="list-style: none;">{{$message}}</li>
                @endforeach
            @endforeach
        </ul>
    </div>
@endif
