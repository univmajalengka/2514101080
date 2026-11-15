
<?php
// Fungsi untuk menghitung diskon berdasarkan total belanja.
function hitungDiskon($totalBelanja) {
    $diskon = 0;

    if ($totalBelanja >= 100000) {
        $diskon = 0.10 * $totalBelanja;
    } elseif ($totalBelanja >= 50000) {
        $diskon = 0.05 * $totalBelanja;
    }

    return $diskon;
}

$totalBelanja = null;
$diskon = null;
$totalBayar = null;
$persentaseDiskon = 0;
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = $_POST["total_belanja"] ?? "";

    if ($input === "" || !is_numeric($input) || (float)$input < 0) {
        $error = "Masukkan total belanja berupa angka dan tidak boleh negatif.";
    } else {
        $totalBelanja = (float)$input;
        $diskon = hitungDiskon($totalBelanja);
        $totalBayar = $totalBelanja - $diskon;

        if ($totalBelanja >= 100000) {
            $persentaseDiskon = 10;
        } elseif ($totalBelanja >= 50000) {
            $persentaseDiskon = 5;
        }
    }
}

function rupiah($angka) {
    return "Rp " . number_format($angka, 0, ",", ".");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Kasir - Alfareza_Store</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #eef7ed;
            color: #183b24;
        }

        header {
            background: #245c32;
            color: white;
            padding: 22px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        header h1 {
            margin: 0;
            font-size: 26px;
        }

        header span {
            font-size: 15px;
            font-weight: bold;
        }

        main {
            width: min(1000px, 92%);
            margin: 38px auto;
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            gap: 22px;
            align-items: start;
        }

        .card {
            background: white;
            border: 1px solid #c9dfc8;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 5px 18px rgba(36, 92, 50, 0.09);
        }

        .card h2 {
            margin: 0;
            padding: 18px 22px;
            background: #388e45;
            color: white;
            font-size: 20px;
        }

        .content {
            padding: 24px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #a8cba7;
            border-radius: 8px;
            font-size: 17px;
            margin-bottom: 16px;
        }

        input:focus {
            outline: 2px solid #65ad69;
            border-color: #388e45;
        }

        button {
            width: 100%;
            border: 0;
            border-radius: 8px;
            padding: 14px;
            background: #398b45;
            color: white;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #246b32;
        }

        .error {
            background: #fff0f0;
            color: #a32121;
            border: 1px solid #f1caca;
            border-radius: 8px;
            padding: 12px;
            margin-top: 15px;
        }

        .receipt {
            padding: 24px;
        }

        .store {
            text-align: center;
            padding-bottom: 18px;
            border-bottom: 1px dashed #a8cba7;
        }

        .store h3 {
            margin: 0 0 7px;
            font-size: 25px;
            color: #286b36;
        }

        .store p {
            margin: 0;
            color: #607b63;
        }

        .line {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            padding: 15px 0;
            border-bottom: 1px solid #e1eee0;
        }

        .line strong {
            text-align: right;
        }

        .discount {
            color: #16834a;
        }

        .total {
            margin-top: 10px;
            padding: 17px;
            background: #e1f2df;
            border-radius: 9px;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-weight: bold;
        }

        .total strong {
            color: #246b32;
            text-align: right;
        }

        .rules {
            margin-top: 18px;
            padding: 15px;
            background: #f0f7ee;
            border-radius: 9px;
            line-height: 1.7;
            font-size: 14px;
            border-left: 4px solid #398b45;
        }

        .placeholder {
            color: #718b75;
            text-align: center;
            padding: 30px 10px;
        }

        footer {
            text-align: center;
            color: #66816a;
            padding: 12px 20px 28px;
            font-size: 13px;
        }

        @media (max-width: 700px) {
            header {
                padding: 18px 5%;
                align-items: flex-start;
                flex-direction: column;
            }

            main {
                grid-template-columns: 1fr;
                margin: 22px auto;
            }
        }
    </style>
</head>

<body>

<header>
    <h1>🛒 Web Kasir</h1>
    <span>Alfareza_Store</span>
</header>

<main>

    <section class="card">
        <h2>Hitung Diskon Belanja</h2>

        <div class="content">
            <form method="POST" action="">

                <label for="total_belanja">
                    Total Belanja (Rp)
                </label>

                <input
                    type="number"
                    id="total_belanja"
                    name="total_belanja"
                    min="0"
                    step="1"
                    placeholder="Contoh: 120000"
                    value="<?php echo isset($_POST['total_belanja']) ? htmlspecialchars($_POST['total_belanja']) : ''; ?>"
                    required
                >

                <button type="submit">
                    Hitung Diskon
                </button>

            </form>

            <?php if ($error !== ""): ?>
                <div class="error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <section class="card">
        <h2>Hasil Perhitungan</h2>

        <div class="receipt">

            <div class="store">
                <h3>Alfareza_Store</h3>
                <p>Terima kasih telah berbelanja!</p>
            </div>

            <?php if ($totalBelanja !== null && $error === ""): ?>

                <div class="line">
                    <span>Total Belanja</span>
                    <strong><?php echo rupiah($totalBelanja); ?></strong>
                </div>

                <div class="line discount">
                    <span>Diskon (<?php echo $persentaseDiskon; ?>%)</span>
                    <strong><?php echo rupiah($diskon); ?></strong>
                </div>

                <div class="total">
                    <span>Total Bayar</span>
                    <strong><?php echo rupiah($totalBayar); ?></strong>
                </div>

            <?php else: ?>

                <div class="placeholder">
                    Hasil perhitungan akan muncul di sini
                    setelah total belanja dimasukkan.
                </div>

            <?php endif; ?>

            <div class="rules">
                <strong>Aturan diskon:</strong><br>
                • Belanja ≥ Rp 100.000: diskon 10%<br>
                • Belanja ≥ Rp 50.000 dan kurang dari Rp 100.000: diskon 5%<br>
                • Belanja kurang dari Rp 50.000: tidak ada diskon
            </div>

        </div>
    </section>

</main>

<footer>
    Program latihan PHP — Alfareza_Store
</footer>

</body>
</html>
