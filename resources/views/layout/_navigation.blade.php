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
        <img src="{{asset('/img/logo_white.png')}}" height="28">
        <span class="d-none d-sm-inline"> Personals</span>
    </a>
    <form action="/search" method="get" id="search-form" class="search form-inline">
        <i class="fa fa-search" onclick="
                            if(_('search-input').value !== ''){
                              _('search-form').submit();
                            } else {
                              _('search-input').focus();
                            }"></i>

        <input type="text"
               class="navbar-item"
               placeholder="{{__('search...')}}"
               name="q"
               id="search-input"
               autocomplete="off"
        />
        <i class="fa fa-times" onclick="_('search-form').reset();"></i>
    </form>
    <a class="btn btn-success" href="/write">
        <span class="icon"><i class="fa fa-pencil-alt"></i></span>
        <span class="d-none d-sm-inline"> {{_('Write Ad')}}</span>
    </a>
</nav>

<script language="JavaScript">
  function _ (id) {
    return document.getElementById(id)
  }

  document.addEventListener('DOMContentLoaded', function () {

    // Get all "navbar-burger" elements
    let $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0)

    // Check if there are any navbar burgers
    if ($navbarBurgers.length > 0) {

      // Add a click event on each of them
      $navbarBurgers.forEach(function ($el) {
        $el.addEventListener('click', function () {

          // Get the target from the "data-target" attribute
          let target = $el.dataset.target
          let $target = document.getElementById(target)

          // Toggle the class on both the "navbar-burger" and the "navbar-menu"
          $el.classList.toggle('is-active')
          $target.classList.toggle('is-active')

        })
      })
    }

  })
</script>
