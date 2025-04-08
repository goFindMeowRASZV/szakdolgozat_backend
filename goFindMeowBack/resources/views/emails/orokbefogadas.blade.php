<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <title>Örökbefogadási jelentkezésed megérkezett</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 16px;
        }

        .email-container {
            background-color: #fff;
            max-width: 700px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .header img {
            width: 100%;
            border-radius: 10px;
            object-fit: cover;
        }

        h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
            color: rgb(182, 176, 161);
        }

        .content {
            padding: 20px 0;
        }

        .content p {
            font-size: 17px;
            line-height: 1.6;
            color: rgb(2, 4, 33);
            margin: 20px 0;
        }

        .cat-card {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin-top: 20px;
            background-color: rgba(168, 168, 168, 0.19);
            padding: 20px;
            border-radius: 20px;
        }

        .cat-card img {
            width: 160px;
            height: 160px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .cat-info {
            flex: 1;
            margin-left: 20px;
        }

        .intro-message {
            font-size: 14px;
            margin-top: 10px;
            padding-left: 15px;
            border-left: 4px solid #ccc;
            font-style: italic;
        }

        .cta {
            margin-top: 30px;
            text-align: center;
        }

        .cta a {
            background-color: #000;
            color: #fff;
            padding: 16px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            display: inline-block;
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #aaa;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ $message->embed($headerImagePath) }}" alt="Cica fejléc" />
        </div>
        <div class="content">
            <h1>Köszönjük az örökbefogadási jelentkezést!</h1>
            <p>Kedves {{ $userName }},</p>
            <p>Megkaptuk az örökbefogadási jelentkezésed a következő cicára:</p>

            <div class="cat-card">
                <img src="{{ $message->embed($catImagePath) }}" alt="Cica képe" />
                <div class="cat-info">
                    <p><strong>Bemutatkozásod:</strong></p>
                    <div class="intro-message">
                        {{ $userMessage }}
                    </div>
                </div>
            </div>

            <p>
                Nagyon örülünk, hogy szeretnél egy új bundás barátot hazavinni!
                Kollégáink hamarosan felveszik veled a kapcsolatot a további lépésekkel kapcsolatban.
            </p>

            <div class="cta">
                <a href="http://localhost:3000/menhely" target="_blank">További cicáink megtekintése</a>
            </div>
        </div>
        <div class="footer">
            © {{ date('Y') }} Go Find Meow – Köszönjük, hogy az örökbefogadást választottad!
        </div>
    </div>
</body>

</html>
