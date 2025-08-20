<!DOCTYPE html>
<html lang="en" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f8; padding: 20px;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $subjectText ?? 'Notification' }}</title>
  <style>
    .email-container {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
      padding: 30px;
      color: #333333;
    }
    h1 {
      color: #1a73e8;
      font-size: 24px;
      margin-bottom: 10px;
    }
    p {
      font-size: 16px;
      line-height: 1.5;
      margin: 15px 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }
    th, td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #1a73e8;
      color: white;
    }
    .btn {
      display: inline-block;
      padding: 12px 25px;
      margin-top: 20px;
      background-color: #1a73e8;
      color: white !important;
      text-decoration: none;
      font-weight: 600;
      border-radius: 5px;
    }
    .footer {
      font-size: 14px;
      color: #888888;
      margin-top: 30px;
      border-top: 1px solid #eee;
      padding-top: 15px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="email-container">

    {!! $body !!}

    <div class="footer">
      &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
  </div>
</body>
</html>
