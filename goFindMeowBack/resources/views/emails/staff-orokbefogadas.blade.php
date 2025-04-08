<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <title>Új örökbefogadási jelentkezés</title>
    <style>
        body {
            background-color: #f6f6f6;
            font-family: Arial, sans-serif;
            font-size: 16px;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            background-color: #f6f6f6;
            padding: 40px 0;
        }

        .email-table {
            width: 100%;
            max-width: 700px;
            background-color: #fff;
            margin: 0 auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            color: rgb(182, 176, 161);
            font-size: 28px;
            padding-bottom: 20px;
        }

        .cat-img,
        .user-img {
            width: 160px;
            height: 160px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .info-cell {
            padding-left: 15px;
            vertical-align: top;
        }

        .user-link {
            color: #0066cc;
            text-decoration: none;
        }

        .block-space {
            height: 30px;
        }

        .user-message {
            padding-top: 15px;
        }

        .blockquote {
            border-left: 4px solid #ccc;
            padding-left: 15px;
            font-style: italic;
            background-color: #f9f9f9;
            margin-top: 10px;
        }

        .callout {
            padding-top: 30px;
            text-align: center;
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #aaa;
            margin-top: 40px;
        }

        p {
            margin: 0 0 10px;
            color: #222;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <table class="email-table" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="3" class="header">
                    Új örökbefogadási jelentkezés érkezett a következő cicára:
                </td>
            </tr>

            <!-- Cica infó -->
            <tr>
                <td>
                    <img src="{{ $message->embed($catImagePath) }}" alt="Cica képe" class="cat-img" />
                </td>
                <td class="info-cell">
                    <p><strong>ID:</strong> {{ $reportId }}</p>
                    <p><strong>Szín:</strong> {{ $catColor }}</p>
                    <p><strong>Minta:</strong> {{ $catPattern }}</p>
                    <p><strong>Ismertetőjel:</strong> {{ $catInfo['ismerteto'] }}</p>
                </td>
                <td class="info-cell">
                    <p><strong>Egészségügyi állapot:</strong> {{ $catInfo['egeszseg'] }}</p>
                    <p><strong>Chip:</strong> {{ $catInfo['chip'] }}</p>
                    <p><strong>Körülmények:</strong> {{ $catInfo['korulmeny'] }}</p>
                    <p><strong>Dátum:</strong> {{ $catInfo['datum'] }}</p>
                </td>
            </tr>

            <!-- Üres tér -->
            <tr><td colspan="3" class="block-space"></td></tr>

            <!-- Jelentkező -->
            <tr>
                <td>
                    <img src="{{ $message->embed($userImagePath) }}" alt="Felhasználó képe" class="user-img" />
                </td>
                <td colspan="2" class="info-cell">
                    <p><strong>Jelentkező neve:</strong> {{ $userName }}</p>
                    <p><strong>E-mail címe:</strong> <a href="mailto:{{ $userEmail }}" class="user-link">{{ $userEmail }}</a></p>
                </td>
            </tr>

            <!-- Üzenet -->
            <tr>
                <td colspan="3" class="user-message">
                    <p><strong>Bemutatkozó üzenet:</strong></p>
                    <blockquote class="blockquote">
                        {{ $userMessage }}
                    </blockquote>
                </td>
            </tr>

            <!-- Call to action -->
            <tr>
                <td colspan="3" class="callout">
                    <p>Kérjük, vedd fel a kapcsolatot a lehetséges gazdival!</p>
                </td>
            </tr>
        </table>

        <div class="footer">
            © {{ date('Y') }} Go Find Meow
        </div>
    </div>
</body>

</html>
