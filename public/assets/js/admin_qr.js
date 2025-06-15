$(document).ready(function() {
    const qrcodeContainer = document.getElementById("qrcode");
    const loadingDiv = $('#loading');
    const timerSpan = $('#timer');
    let countdown;

    if (!qrcodeContainer) return;

    const qrcode = new QRCode(qrcodeContainer, {
        width: 256,
        height: 256,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });

    function generateNewCode() {
        loadingDiv.show();
        qrcodeContainer.style.opacity = 0.5;

        $.ajax({
            url: '../app/proses/generate_token.php',
            type: 'GET',
            success: function(token) {
                qrcode.makeCode(token);
                loadingDiv.hide();
                qrcodeContainer.style.opacity = 1;
                resetTimer();
            },
            error: function() {
                console.error("Gagal mengambil token baru.");
                loadingDiv.text('Gagal memuat. Mencoba lagi...');
            }
        });
    }

    function resetTimer() {
        clearInterval(countdown);
        let timeLeft = 10;
        timerSpan.text(timeLeft);

        countdown = setInterval(() => {
            timeLeft--;
            timerSpan.text(timeLeft);
            if (timeLeft <= 0) {
                clearInterval(countdown);
            }
        }, 1000);
    }

    // Generate QR code on page load
    generateNewCode();

    // Set interval to refresh QR code every 10 seconds
    setInterval(generateNewCode, 10000);
});