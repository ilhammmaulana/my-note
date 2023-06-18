<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href={{ asset('assets/css/base.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/pages/auth.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/animate.css') }}>

</head>

<body>
    <div id="root">
        {{ $html }}
    </div>
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script>
    $(document).ready(function(){
    $('#alert').animate({ marginTop: -100 }, 200).removeClass('d-none').hide().slideDown(10, function() {
       $('#alert').animate({ marginTop: 10 }, 250);
    });
    setTimeout(() => {
        $('#alert').animate({ marginTop: '-200px'}, 250);
    }, 2500);

   $(document).on('click', function(event) {
       var $target = $(event.target);
       if (!$target.closest('#form-login').length) {
           $('#animation-login-logo, #animation-login').addClass('hidden');
       }
       });

       $('#email_or_phone, #password, #button-submit').on('focus', function() {
       $('#animation-login-logo, #animation-login').removeClass('hidden');
       }).on('blur', function() {
       $('#animation-login-logo, #animation-login').addClass('hidden');
   });
})
    </script>
</body>

</html>