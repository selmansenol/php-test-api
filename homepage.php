<?php

session_start();

// Kullanıcı verilerinin olup olmadığını kontrol et
if (!isset($_SESSION['userData'])) {
    header('Location: index.php');
    exit();
}

$userData = $_SESSION['userData'];

// Tarih hesaplamaları için
$bitisTarihi = new DateTime($userData['tariffExpiryDate']);
$bugun = new DateTime();
$kalanGun = $bitisTarihi > $bugun ? $bugun->diff($bitisTarihi)->days : 0;

function formatData($data, $replace = []) {
    $patterns = [
        'Ã–' => 'Ö',
        'Ä°' => 'İ',
        'Ãœ' => 'Ü',
    ];

    $replace = array_merge($patterns, $replace);

    return str_replace(array_keys($replace), array_values($replace), $data);
}


$userData['address'] = formatData($userData['address']);
$userData['tariffName'] = formatData($userData['tariffName']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Ana Sayfası</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .kalan-gun-kirmizi {
            color: red;
        }

        .kalan-gun-turuncu {
            color: orange;
        }

        .kalan-gun-yesil {
            color: green;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Kullanıcı Bilgileri
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                        <p>İsim: <?php echo htmlspecialchars($userData['name']); ?></p>
                        <p>Soyisim: <?php echo htmlspecialchars($userData['surname']); ?></p>
                        <p>T.C.K.N.: <?php echo htmlspecialchars($userData['identityNumber']); ?></p>
                        <p>Telefon No: <?php echo htmlspecialchars($userData['phoneNumber']); ?></p>
                        <p>E-Posta Adresi: <?php echo htmlspecialchars($userData['emailAddress']); ?></p>
                        <p>Abone No: <?php echo htmlspecialchars($userData['subscriberNumber']); ?></p>
                        <p>Kullanıcı Adı: <?php echo htmlspecialchars($userData['pppUsername']); ?></p>
                        <p>PPP Kullanıcı Adı: <?php echo htmlspecialchars($userData['pppUsername']); ?></p>
                        <p>PPP Kullanıcı Şifresi: <?php echo htmlspecialchars($userData['pppPassword']); ?></p>
                        <p>Adres: <?php echo htmlspecialchars($userData['address']); ?></p>

                        </p>
                        <!-- Diğer kullanıcı bilgilerini burada gösterebilirsiniz -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Tarife Bilgileri
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                        <p>Tarife Id: <?php echo htmlspecialchars($userData['tariffId']); ?></p>
                        <p>Tarife Tipi: <?php echo htmlspecialchars($userData['tariffType']); ?></p>
                        <p>Tarife İsmi: <?php echo htmlspecialchars($userData['tariffName']); ?></p>
                        <p>Tarife Bitiş Tarihi: <?php echo htmlspecialchars($userData['tariffExpiryDate']); ?></p>
                        <p>Tarife Ücreti: <?php echo htmlspecialchars($userData['tariffPrice']); ?></p>
                        <p class="<?php echo $kalanGun == 0 ? 'kalan-gun-kirmizi' : ($kalanGun < 30 ? 'kalan-gun-turuncu' : 'kalan-gun-yesil'); ?>">
                            Kalan Gün: <?php echo $kalanGun; ?> gün
                        </p>
                        <p>Fatura Borç Bilgisi: <?php echo htmlspecialchars($userData['unpaidInvoiceAmount']); ?> TL</p>
                        </p>
                        <!-- Diğer tarife bilgilerini burada gösterebilirsiniz -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        IP Bilgileri
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                        <p>Son Alınan IP Adresi: <?php echo htmlspecialchars($userData['ipAddress']); ?></p>
                        <p>Sabit IP Durumu: <?php echo htmlspecialchars($userData['staticIpStatus']); ?></p>
                        </p>
                        <!-- Diğer IP bilgilerini burada gösterebilirsiniz -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>