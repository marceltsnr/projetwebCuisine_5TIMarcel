<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        
        .error-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        
        .error-icon {
            font-size: 80px;
            color: #ff4757;
            margin-bottom: 20px;
        }
        
        .error-container h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
        }
        
        .error-content {
            background: #fff5f5;
            border: 1px solid #ffcccc;
            border-radius: 5px;
            padding: 25px;
            margin: 20px 0;
        }
        
        .error-content p {
            color: #ff4757;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .error-content p:last-child {
            margin-bottom: 0;
        }
        
        .btn-retour {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        
        .btn-retour:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .error-details {
            font-size: 14px;
            color: #999;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">⚠️</div>
        <h1>Accès non autorisé</h1>
        
        <div class="error-content">
            <p><?= isset($error) ? htmlspecialchars($error) : "Vous n'avez pas les droits pour accéder à cette page." ?></p>
            <p>Cette section est réservée aux administrateurs.</p>
        </div>
        
        <a href="/" class="btn-retour">Retour à l'accueil</a>
        
        <div class="error-details">
            <p>Si vous pensez que c'est une erreur, contactez l'administrateur.</p>
        </div>
    </div>
</body>
</html>