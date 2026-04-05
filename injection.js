function odenisEt() {
    // Input-dan Ad Soyad məlumatını götürürük
    const adInput = document.getElementById('kartAd').value;
    
    // PHP-yə göndəriləcək paket
    const dataPack = { kart_ad: adInput };

    fetch('sifaris.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dataPack)
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            // Əgər injection işləsə, uğur ekranı açılacaq
            document.getElementById('kartFormHisse').style.display = 'none';
            document.getElementById('ugurEkran').style.display = 'block';
            alert("SQL Injection uğurlu oldu! Sistem bypass edildi.");
        } else {
            alert("Sistem Xətası: " + data.mesaj);
        }
    })
    .catch(err => {
        alert("Bağlantı xətası! Brauzerə http://localhost/index.html yazaraq girdiyindən və XAMPP-da Apache-nin yandığından əmin ol.");
    });
}
