<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>No me toques</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f8fafc;
            color: #0f172a;
            transition: background-color 0.8s cubic-bezier(0.4, 0, 0.2, 1), 
                        color 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            text-align: center;
            padding: 20px;
            user-select: none;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            max-width: 600px;
        }

        .phrase-box {
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .phrase {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.3;
            letter-spacing: -0.02em;
            transition: color 0.8s cubic-bezier(0.4, 0, 0.2, 1),
                        opacity 0.25s ease,
                        transform 0.25s ease;
            opacity: 0;
            transform: translateY(10px);
        }

        .phrase.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Contador de toques */
        .counter-badge {
            font-size: 0.9rem;
            font-weight: 600;
            opacity: 0.6;
            margin-bottom: 0.5rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: color 0.8s ease;
        }

        .btn-touch {
            cursor: pointer;
            border: none;
            outline: none;
            font-family: inherit;
            font-size: 1.25rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 1.1rem 2.6rem;
            border-radius: 9999px;
            color: #ffffff;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.5), 
                        0 8px 10px -6px rgba(239, 68, 68, 0.4);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .btn-touch:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 16px 32px -4px rgba(239, 68, 68, 0.6), 
                        0 10px 14px -5px rgba(239, 68, 68, 0.5);
        }

        .btn-touch:active {
            transform: translateY(1px) scale(0.97);
            box-shadow: 0 5px 12px -2px rgba(239, 68, 68, 0.4);
        }

        /* Efecto cuando el fondo ya es negro */
        body.is-dark .btn-touch {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            box-shadow: 0 0 30px rgba(244, 63, 94, 0.7),
                        0 0 60px rgba(244, 63, 94, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        /* Botón de reinicio que aparece al final */
        .reset-link {
            display: none;
            margin-top: 1.5rem;
            font-size: 0.95rem;
            color: inherit;
            text-decoration: underline;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }

        .reset-link:hover {
            opacity: 1;
        }

        .reset-link.show {
            display: inline-block;
        }
    </style>
</head>
<body>

    <div class="container">

        <div id="counter" class="counter-badge"></div>

        <div class="phrase-box">
            <p id="phraseText" class="phrase"></p>
        </div>

        <button id="touchBtn" class="btn-touch" type="button">
            no me toques
        </button>

        <span id="resetBtn" class="reset-link">Reiniciar la luz 💡</span>
    </div>

    <script>
        // Frases.
        const stages = [
            {
                bg: '#e2e8f0', 
                text: '#1e293b', 
                phrase: 'Oh, lo tocaste...'
            },
            {
                bg: '#cbd5e1', 
                text: '#0f172a',
                phrase: '¿Puedes parar ya? Es incomodo.'
            },
            {
                bg: '#94a3b8', 
                text: '#020617',
                phrase: 'Me sorprende tu terquedad.'
            },
            {
                bg: '#64748b', 
                text: '#f8fafc',
                phrase: 'Oye, se está poniendo oscuro.'
            },
            {
                bg: '#334155', 
                text: '#f8fafc',
                phrase: 'Parce...'
            },
            {
                bg: '#1e293b', 
                text: '#ffffff',
                phrase: 'Uhm, seguiras aunque te diga que no, cierto?'
            },
            {
                bg: '#0f172a', 
                text: '#ffffff',
                phrase: 'Ya esta oscuro... ¿Sigues?'
            },
            {
                bg: '#000000', 
                text: '#ffffff',
                phrase: 'Ya no veo nada, perfecto.'
            }
        ];

        // Creatividad en su maxima expresión
        const extraDarkPhrases = [
            'En serio... ¿todavía sigues pulsando en la oscuridad?',
            'Ya no hay nada que ver aquí. Es el vacío.',
            'Solo quedamos tú, yo y tu desobediencia.',
            'Uh, veo que eres de los necios.',
            'Las probabilidades de que pares son... nulas.',
            'Bueno, a partir de ahora solo hay frases...',
            'Profesor pongame un 5.',
            'Uff...',
            'Programar es divertido, cuando la IA no hace todo por ti... Supongo.',
            'A ver si lo termino.',
            '¿Todavia sigues clickeando? Wow.',
            '¿No tienes algo mejor que hacer?',
            'Esto contribuye en... Nada.',
            '...',
            '...',
            '...',
            'Me estoy aburriendo de inventar frases XD.',
            'ChatGPT crea 400 frases interesantes...',
            'Zzz...',
            'GOLD EXPERIENCE, REQUIEM.',
            'Perdon, estoy viendo Jojos Golden Wind...',
            'Kono Dio da!',
            'Ya, demasiado otaku de mi parte.',
            'Tengo tiempo de sobra para entregar esto... Podria seguir hasta mañana.',
            'Si, termine la pagina... La IA solo me ayudó en cosillas.',
            'Nah, imagina pensar por tu cuenta, seria aburrido.',
            'Uhm...',
            'Ya deja el botón, no?',
            'Uh... Estoy comenzando a temer la oscuridad.',
            'Jeff the Killer, también conocido como Jeff , es el protagonista principal que da título a la historia Creepypasta de 2011 (y su versión renovada de 2015) del mismo título, " Jeff the Killer " y " Jeff the Killer 2015 ".Es un asesino en serie adolescente y un Creepypasta registrado. Quedó desfigurado tras ser prendido fuego mientras peleaba con una pandilla de matones y perdió la cordura al ver su "nuevo" y "hermoso" rostro.',
            'Go to sleep.',
            '¿Leiste toda la historia de Jeff The Killer?',
            'Tonta... No?',
            'Bueno... Desde aquí se repitirá todo desde el principio, Adiós!'
        ];

        let touchCount = 0;

        const body = document.body;
        const btn = document.getElementById('touchBtn');
        const phraseEl = document.getElementById('phraseText');
        const counterEl = document.getElementById('counter');
        const resetBtn = document.getElementById('resetBtn');

        function updateScreen() {
            touchCount++;

            // Determinar frase y colores
            let currentPhrase = '';
            let currentBg = '#000000';
            let currentTextColor = '#ffffff';

            if (touchCount <= stages.length) {
                const stage = stages[touchCount - 1];
                currentPhrase = stage.phrase;
                currentBg = stage.bg;
                currentTextColor = stage.text;
            } else {
                const extraIndex = (touchCount - stages.length - 1) % extraDarkPhrases.length;
                currentPhrase = extraDarkPhrases[extraIndex];
                currentBg = '#000000';
                currentTextColor = '#ffffff';
            }

            // Cambiar fondo y color de texto suavemente
            body.style.backgroundColor = currentBg;
            body.style.color = currentTextColor;

            if (currentBg === '#000000') {
                body.classList.add('is-dark');
                resetBtn.classList.add('show');
            }

            // Actualizar contador
            counterEl.textContent = `Toques desobedientes: ${touchCount}`;

            phraseEl.classList.remove('visible');
            setTimeout(() => {
                phraseEl.textContent = currentPhrase;
                phraseEl.classList.add('visible');
            }, 180);
        }

        // Evento de clic en el botón
        btn.addEventListener('click', updateScreen);

        resetBtn.addEventListener('click', () => {
            touchCount = 0;
            body.classList.remove('is-dark');
            resetBtn.classList.remove('show');
            body.style.backgroundColor = '#f8fafc';
            body.style.color = '#0f172a';
            counterEl.textContent = '';
            phraseEl.classList.remove('visible');
            setTimeout(() => {
                phraseEl.textContent = '';
            }, 200);
        });
    </script>
</body>
</html>
