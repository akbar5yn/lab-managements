<html lang="en" class="h-full scroll-smooth bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>Layanan Lab Fisika UAD</title>

    <style>
        :root {
            --background: #F7F9FC;
        }

        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #559f8649;
            border-radius: 20px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #b30000;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* ANCHOR Sidebar */
        /* Styling untuk link yang aktif */
        .sidebar {
            direction: rtl;
        }

        .sidebar ul {
            direction: ltr;
        }

        .active-dashboard::before,
        .active-dashboard::after {
            content: "";
            position: absolute;
            right: 0;
            width: 50px;
            height: 50px;
            background-color: transparent;
            border-radius: 50%;
            pointer-events: none;
        }

        .active-dashboard::before {
            top: -50px;
            box-shadow: 35px 35px 0 10px var(--background);
        }

        .active-dashboard::after {
            bottom: -50px;
            box-shadow: 35px -35px 0 10px var(--background);
        }

        /* ANCHOR Main Content */


        .main-content {
            position: relative;
            width: calc(100% - 250px);
            height: 100%;
            /* left: 250px; */
        }

        .main-slot {
            height: calc(100% - 76px);
        }

        @media (max-width: 1024px) {
            .main-content {
                left: 0px;
                width: calc(100%);
            }
        }
    </style>
</head>

<body class="flex gap-10 bg-[#F7F9FC] p-10">
    <x-sidebar></x-sidebar>
    <main class="main-content flex flex-col gap-4 font-poppins">
        @if (isset($subtitle) && isset($subtitle))
            <x-header :title="$title" :subtitle="$subtitle"></x-header>
        @else
            <x-header :title="$title"></x-header>
        @endif
        <div class="main-slot">{{ $slot }}</div>
    </main>
</body>

</html>
