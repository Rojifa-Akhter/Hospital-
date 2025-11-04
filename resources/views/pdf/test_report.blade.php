<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        /* Regular SolaimanLipi */
        @font-face {
            font-family: 'SolaimanLipi';
            src: url('file:///{{ str_replace("\\", "/", storage_path("fonts/SolaimanLipi_22-02-2012.ttf")) }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* Old version SolaimanLipi */
        @font-face {
            font-family: 'SolaimanLipiOld';
            src: url('file:///{{ str_replace("\\", "/", storage_path("fonts/SolaimanLipi_29-05-06.ttf")) }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* Bold version SolaimanLipi */
        @font-face {
            font-family: 'SolaimanLipiBold';
            src: url('file:///{{ str_replace("\\", "/", storage_path("fonts/SolaimanLipi_Bold_10-03-12.ttf")) }}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        body {
            font-family: 'SolaimanLipi', sans-serif;
            font-size: 14px;
        }

        h1 {
            font-family: 'SolaimanLipiBold', sans-serif;
            font-size: 20px;
            font-weight: bold;
        }

        p.old {
            font-family: 'SolaimanLipiOld', sans-serif;
        }

        p.bold {
            font-family: 'SolaimanLipiBold', sans-serif;
            font-weight: bold;
        }

        p.normal {
            font-family: 'SolaimanLipi', sans-serif;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>

    <p class="normal">{{ $content }}</p>
    <p class="old">এই প্যারাগ্রাফটি পুরনো SolaimanLipi ফন্ট ব্যবহার করছে।</p>
    <p class="bold">এই প্যারাগ্রাফটি বোল্ড SolaimanLipi ফন্ট ব্যবহার করছে।</p>
</body>
</html>
