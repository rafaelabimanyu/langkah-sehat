<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Kesalahan Sistem | Langkah Sehat</title>
    <meta name="description" content="Terjadi kesalahan internal pada server Langkah Sehat.">
    
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
            opacity: 0.12;
            animation: float 8s ease-in-out infinite;
        }
        .orb-1 { width: 350px; height: 350px; background: #ef4444; top: -100px; right: -80px; animation-delay: 0s; }
        .orb-2 { width: 250px; height: 250px; background: #f97316; bottom: -60px; left: -60px; animation-delay: 2s; }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.3); }
            70% { box-shadow: 0 0 0 12px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 48px 40px;
            max-width: 500px;
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
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.25), rgba(249, 115, 22, 0.15));
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
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.25);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            color: #f87171;
            font-size: 28px;
            animation: pulse-ring 2s ease-out infinite;
        }
        .error-icon i {
            animation: spin-slow 4s linear infinite;
        }
        h1 { font-size: 22px; font-weight: 800; margin-bottom: 8px; }
        .subtitle { 
            font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7; 
            font-family: 'Inter', sans-serif; margin-bottom: 24px; 
        }
        .status-box {
            background: rgba(239, 68, 68, 0.06);
            border: 1px solid rgba(239, 68, 68, 0.15);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 28px;
        }
        .status-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11px;
            font-family: 'Inter', sans-serif;
            padding: 4px 0;
        }
        .status-row .label { color: rgba(255,255,255,0.4); }
        .status-row .value { color: rgba(255,255,255,0.7); font-weight: 600; }
        .status-row .value.error { color: #f87171; }
        .divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.06);
            margin: 8px 0;
        }
        .btn-group {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
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
        .retry-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: rgba(255, 255, 255, 0.7);
            font-weight: 600;
            font-size: 13px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
        }
        .retry-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="floating-orb orb-1"></div>
    <div class="floating-orb orb-2"></div>
    
    <div class="glass-card">
        <div class="error-code">500</div>
        <div class="error-icon">
            <i class="fa-solid fa-gear"></i>
        </div>
        <h1>Kesalahan Sistem Internal</h1>
        <p class="subtitle">
            Mohon maaf atas ketidaknyamanan ini. Server kami sedang mengalami gangguan teknis. 
            Tim kami telah diberitahu dan sedang bekerja untuk memperbaiki masalah ini.
        </p>
        <div class="status-box">
            <div class="status-row">
                <span class="label">Status</span>
                <span class="value error"><i class="fa-solid fa-circle" style="font-size:6px;margin-right:4px;vertical-align:middle;"></i> Internal Server Error</span>
            </div>
            <hr class="divider">
            <div class="status-row">
                <span class="label">Kode</span>
                <span class="value">500</span>
            </div>
            <hr class="divider">
            <div class="status-row">
                <span class="label">Waktu</span>
                <span class="value">{{ now()->format('d M Y, H:i:s') }}</span>
            </div>
        </div>
        <div class="btn-group">
            <a href="{{ url('/') }}" class="back-btn">
                <i class="fa-solid fa-house"></i>
                Beranda
            </a>
            <a href="javascript:location.reload()" class="retry-btn">
                <i class="fa-solid fa-rotate-right"></i>
                Coba Lagi
            </a>
        </div>
    </div>
</body>
</html>
