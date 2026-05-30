<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | Langkah Sehat</title>
    <meta name="description" content="Halaman ini memerlukan otorisasi khusus. Anda tidak memiliki hak akses.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Outfit', 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to top right, #020617, #1e1b4b, #1e3a5f);
            color: white;
            overflow: hidden;
            position: relative;
        }
        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 8s ease-in-out infinite;
        }
        .orb-1 { width: 300px; height: 300px; background: #f43f5e; top: -80px; right: -60px; animation-delay: 0s; }
        .orb-2 { width: 200px; height: 200px; background: #8b5cf6; bottom: -40px; left: -40px; animation-delay: 2s; }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 48px 40px;
            max-width: 480px;
            width: 90%;
            text-align: center;
            position: relative;
            z-index: 10;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }
        .error-code {
            font-size: 120px;
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, rgba(244, 63, 94, 0.25), rgba(251, 113, 133, 0.1));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -4px;
            user-select: none;
            filter: blur(1px);
            margin-bottom: -20px;
        }
        .error-icon {
            width: 64px; height: 64px;
            border-radius: 16px;
            background: rgba(244, 63, 94, 0.15);
            border: 1px solid rgba(244, 63, 94, 0.3);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            color: #fb7185;
            font-size: 28px;
            box-shadow: 0 0 25px rgba(244, 63, 94, 0.15);
        }
        h1 { font-size: 22px; font-weight: 800; margin-bottom: 8px; }
        .subtitle { font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7; font-family: 'Inter', sans-serif; margin-bottom: 28px; }
        .message-box {
            background: rgba(244, 63, 94, 0.08);
            border: 1px solid rgba(244, 63, 94, 0.2);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 11px;
            color: rgba(251, 113, 133, 0.9);
            margin-bottom: 28px;
            font-family: 'Inter', sans-serif;
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            background: linear-gradient(135deg, #06b6d4, #10b981);
            color: #020617;
            font-weight: 700;
            font-size: 13px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.2);
        }
        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(34, 211, 238, 0.5);
        }
    </style>
</head>
<body>
    <div class="floating-orb orb-1"></div>
    <div class="floating-orb orb-2"></div>
    
    <div class="glass-card">
        <div class="error-code">403</div>
        <div class="error-icon">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <h1>Akses Ditolak</h1>
        <p class="subtitle">
            Anda tidak memiliki otorisasi untuk mengakses halaman atau data ini. 
            Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator sistem.
        </p>
        @if($exception->getMessage() && $exception->getMessage() !== '')
        <div class="message-box">
            <i class="fa-solid fa-circle-info" style="margin-right: 6px;"></i>
            {{ $exception->getMessage() }}
        </div>
        @endif
        <a href="{{ url('/') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Halaman Aman
        </a>
    </div>
</body>
</html>
