<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Langkah Sehat</title>
    <meta name="description" content="Halaman yang Anda cari tidak dapat ditemukan di Langkah Sehat.">
    
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
        .orb-1 { width: 300px; height: 300px; background: #06b6d4; top: -80px; left: -60px; animation-delay: 0s; }
        .orb-2 { width: 200px; height: 200px; background: #8b5cf6; bottom: -40px; right: -40px; animation-delay: 2s; }
        .orb-3 { width: 150px; height: 150px; background: #10b981; top: 50%; left: 50%; animation-delay: 4s; }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }
        @keyframes pulse-glow {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 48px 40px;
            max-width: 520px;
            width: 90%;
            text-align: center;
            position: relative;
            z-index: 10;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }
        .error-code {
            font-size: 140px;
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.25), rgba(99, 102, 241, 0.15));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -6px;
            user-select: none;
            filter: blur(1.5px);
            margin-bottom: -24px;
        }
        .error-icon {
            width: 64px; height: 64px;
            border-radius: 16px;
            background: rgba(6, 182, 212, 0.15);
            border: 1px solid rgba(6, 182, 212, 0.3);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            color: #22d3ee;
            font-size: 28px;
            box-shadow: 0 0 25px rgba(6, 182, 212, 0.15);
            animation: pulse-glow 3s ease-in-out infinite;
        }
        h1 { font-size: 22px; font-weight: 800; margin-bottom: 8px; }
        .subtitle { 
            font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7; 
            font-family: 'Inter', sans-serif; margin-bottom: 28px; 
        }
        .search-hint {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-align: left;
        }
        .search-hint .hint-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: rgba(139, 92, 246, 0.15);
            border: 1px solid rgba(139, 92, 246, 0.25);
            display: flex; align-items: center; justify-content: center;
            color: #a78bfa; font-size: 14px; flex-shrink: 0;
        }
        .search-hint .hint-text {
            font-size: 11px; color: rgba(255,255,255,0.45);
            font-family: 'Inter', sans-serif; line-height: 1.5;
        }
        .search-hint .hint-text strong { color: rgba(255,255,255,0.7); }
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
        .secondary-btn {
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
        }
        .secondary-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="floating-orb orb-1"></div>
    <div class="floating-orb orb-2"></div>
    <div class="floating-orb orb-3"></div>
    
    <div class="glass-card">
        <div class="error-code">404</div>
        <div class="error-icon">
            <i class="fa-solid fa-compass"></i>
        </div>
        <h1>Halaman Tidak Ditemukan</h1>
        <p class="subtitle">
            Maaf, halaman atau data yang Anda cari tidak tersedia. Kemungkinan halaman telah dipindahkan, 
            dihapus, atau alamat URL yang Anda masukkan tidak valid.
        </p>
        <div class="search-hint">
            <div class="hint-icon"><i class="fa-solid fa-lightbulb"></i></div>
            <div class="hint-text">
                <strong>Tips:</strong> Pastikan URL yang diketik sudah benar, atau gunakan menu navigasi 
                untuk menemukan halaman yang Anda tuju.
            </div>
        </div>
        <div class="btn-group">
            <a href="{{ url('/') }}" class="back-btn">
                <i class="fa-solid fa-house"></i>
                Beranda
            </a>
            <a href="javascript:history.back()" class="secondary-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
</body>
</html>
