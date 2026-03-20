<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новая заявка — ZOV Кухни</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 4px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
            color: white;
            padding: 30px;
            text-align: center;
            border-bottom: 3px solid #c8a96e;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 400;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }
        .header .brand {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.3em;
            color: #c8a96e;
            margin-bottom: 8px;
        }
        .header p {
            margin: 8px 0 0;
            opacity: 0.7;
            font-size: 13px;
        }
        .content {
            padding: 30px;
        }
        .info-block {
            background: #f9f9f9;
            border-radius: 2px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ebebeb;
        }
        .info-row {
            display: flex;
            margin-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 12px;
        }
        .info-row:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }
        .info-label {
            font-weight: 600;
            color: #6b7280;
            width: 150px;
            flex-shrink: 0;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .info-value {
            color: #111827;
            word-break: break-word;
        }
        .form-badge {
            display: inline-block;
            background: #1a1a1a;
            color: #c8a96e;
            padding: 5px 14px;
            border-radius: 2px;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .message-block {
            background: #fdf8f0;
            border-left: 3px solid #c8a96e;
            padding: 15px;
            margin-top: 20px;
        }
        .message-block h3 {
            margin: 0 0 10px;
            color: #92400e;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .message-block p {
            margin: 0;
            color: #554020;
        }
        .extra-block {
            background: #f9f9f9;
            border: 1px solid #e5e7eb;
            padding: 15px;
            margin-top: 16px;
            border-radius: 2px;
        }
        .extra-block h3 {
            margin: 0 0 10px;
            color: #374151;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .extra-item {
            font-size: 13px;
            color: #4b5563;
            margin-bottom: 4px;
        }
        .footer {
            background: #1a1a1a;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }
        .footer a {
            color: #c8a96e;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="brand">ZOV</div>
            <h1>🔔 Новая заявка с сайта</h1>
            <p>{{ $submitted_at }}</p>
        </div>

        <div class="content">
            <div class="info-block">
                <div class="info-row">
                    <span class="info-label">Источник:</span>
                    <span class="info-value">
                        <span class="form-badge">{{ $form_type }}</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Имя клиента:</span>
                    <span class="info-value">{{ $client_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Телефон:</span>
                    <span class="info-value">
                        <a href="tel:{{ $phone }}" style="color: #c8a96e; text-decoration: none; font-weight: 600;">{{ $phone }}</a>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Страница:</span>
                    <span class="info-value" style="font-size: 12px; color: #6b7280;">{{ $source_url }}</span>
                </div>
            </div>

            @if(!empty($extra))
            <div class="extra-block">
                <h3>📋 Дополнительные данные:</h3>
                @foreach($extra as $key => $value)
                <div class="extra-item"><strong>{{ $key }}:</strong> {{ $value }}</div>
                @endforeach
            </div>
            @endif

            @if($client_message && $client_message !== 'Не указано')
            <div class="message-block">
                <h3>💬 Сообщение от клиента:</h3>
                <p>{!! nl2br(e($client_message)) !!}</p>
            </div>
            @endif
        </div>

        <div class="footer">
            <p>Автоматическое уведомление от сайта <a href="https://zov-kitchen.ru">ZOV Кухни</a></p>
            <p>Пожалуйста, свяжитесь с клиентом как можно скорее</p>
        </div>
    </div>
</body>
</html>
