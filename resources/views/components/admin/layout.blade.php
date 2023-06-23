
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    {{-- BOOTST --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/icon.ico') }}" /> --}}

    {{-- CSS --}}
  <link rel="stylesheet" href={{ asset('assets/css/app.css') }}>
  <link rel="stylesheet" href={{ asset('assets/css/base.css') }}>
  @isset($css)
  {{ $css }}
  @endisset 

</head>

<body>
  <div class="root d-md-flex">
    
    <x-alerts.alert />
    <x-admin.sidebar />
    <div id="content">
      <x-admin.header page="{{ $title }}"></x-admin.header>
      <div id="content-html">
        {{ $html }}
      </div>
    </div>
  </div>



  
  <script src="{{ asset('assets/js/jquery.js') }}"></script>
  <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/index.js') }}"></script>
  <script>
    const userLink = document.querySelector('#user-link');
    const userMenu = document.querySelector('#user-menu');

    document.addEventListener("click", (e) => {
      if (e.target.classList.contains('header-dropdown')) {
          userMenu.classList.add('active')
          console.log('oke')
      } else {
          if (!e.target.classList.contains('header-dropdown')) {
              userMenu.classList.remove('active')
          }
      }
    })
  </script>
  <script >
        $(document).ready(function(){
        $('#alert').animate({ marginTop: -100 }, 200).removeClass('d-none').hide().slideDown(10, function() {
            $('#alert').animate({ marginTop: 10 }, 250);
        });
        setTimeout(() => {
            $('#alert').animate({ marginTop: -400 }, 500);

        }, 2500);
      })
  </script>
      @isset($js)
      {{ $js }}
      @endisset 
</body>
</html>