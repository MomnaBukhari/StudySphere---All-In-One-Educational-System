<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudySphere - Page Expired</title>
    <style>
        * {
            font-family: 'Times New Roman', Times, serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            line-height: 1.5;
            overflow-x: hidden;
        }

        body {
            height: 100vh;
            width: 100vw;
            background-color: #f8f6f4;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        ::selection {
            background: #0b245b;
            color: #fff;
        }

        .main-div-pageexpired {
            width: 80%;
            height: 80%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(180deg, #FAF9F9, #EDEFFF);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid black;
        }

        .div-pageexpired-1,
        .div-pageexpired-2 {
            width: 50%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .div-pageexpired-1 h1 {
            font-size: 3rem;
            color: #dc3545;
            margin-bottom: 20px;
        }

        .div-pageexpired-1 p {
            font-size: 1.25rem;
            margin-bottom: 20px;
            color: #0b245b;
        }

        .div-pageexpired-1 a {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #0b245b;
            text-decoration: none;
            border-radius: 3px;
        }

        .div-pageexpired-1 a:hover {
            background-color: #193c82;
            transition-delay: 0.1s;
            transition-duration: 0.5s;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);

        }

        .div-pageexpired-2 img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <div class="main-div-pageexpired">
        <div class="div-pageexpired-1">
            <h1>419 - Page Expired</h1>
            <p>Sorry, the page you were trying to view has been expired.</p>
            <a href="{{ url('/') }}">Go to Home</a>
        </div>
        <div class="div-pageexpired-2">
            <img src="{{ asset('Illustrations/pageexpired.png') }}" alt="pageexpired Action">
        </div>
    </div>
</body>

</html>
