<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Login</title>

    <meta name="description" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://www.ubtuit.uz/img/tuit_logo.png"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        .position-relative {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .position-absolute {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
        }
    </style>

</head>

<body style="height: 100%">

<div class="position-relative">
    <form action="" method="post"
          class="card p-2  col-sm-10 col-md-5 col-lg-3 position-absolute "
          style="height: 51%;top: 0; left: 0; right: 0; bottom: 0; margin: auto; border-top: 4px solid #00a65a; padding-top: 5px;">
        @csrf
        <div class="mb-3 d-flex justify-content-center ">
            <img class="w-25 text-center" src="{{asset('logo.png')}}" alt="logo">
        </div>
        <h5 class="text text-center">Toshkent axborot texnologiyalari universiteti Urganch filiali </h5>
        <h6 class="text text-center" style="font-size: 10px; font-family: 'Nunito', sans-serif">HEMIS Student axborot
            tizimi orqali kirish</h6>

        <div class="input-group border-1 mb-3 d-flex justify-content-center">
            <a href="{{route('oauth-login-student')}}" class="btn btn-outline-primary text-center">HEMIS Talaba profili orqali kirish</a>
        </div>

        <div class="input-group border-1 mb-3 d-flex justify-content-center">
            <a href="{{route('oauth-login-teacher')}}" class="btn btn-outline-primary text-center">HEMIS Xodim profili orqali kirish</a>
        </div>

    </form>
</div>


<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    let errors = @json($errors->all());
    @if($errors->any())
    let msg = '';
    for (let i = 0; i < errors.length; i++) {
        msg += (i + 1) + '-xatolik ' + errors[i] + '\n';
    }
    Swal.fire({
        icon: 'error',
        title: 'Xatolik',
        text: msg,
    });
    @endif
    @if(session('msg'))
    Swal.fire({
        icon: 'success',
        title: 'Muvaffaqiyatli',
        text: '{{ session('msg') }}',
    });


    @endif

</script>
</body>
</html>
