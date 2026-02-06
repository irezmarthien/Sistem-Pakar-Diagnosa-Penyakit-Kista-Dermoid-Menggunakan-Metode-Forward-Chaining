<?php
session_start();
// Base URL sesuai dengan pengaturan navbar Anda
$base_url = "/spk-kista-dermoid"; 
include "navbar.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjelasan Kista Dermoid</title>
    <link rel="stylesheet" href="<?= $base_url ?>/css/bootstrap.min.css">
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../img/1.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            margin: 0;
            font-family: 'Verdana', sans-serif;
        }

        .container-content {
            width: 85vw; /* Lebar kontainer utama */
            margin: 40px auto;
            padding-bottom: 20px; 
        }

        article {
            background: rgba(0, 0, 0, 0.7);
            color: white;
            font-size: 14px;
            padding: 25px 30px;
            margin-bottom: 25px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        /* Gaya tambahan untuk menetralkan footer di halaman ini saja */
        .halaman-pengertian footer {
            width: 100% !important;
            border-radius: 12px;
            /* Memaksa teks benar-benar di tengah kontainer 85vw */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        /* Menyesuaikan teks di dalam footer agar tidak 'pincang' */
        .halaman-pengertian footer p {
            width: 100%;
            text-align: center !important;
            margin: 5px 0 !important;
        }

        h2 {
            text-align: center;
            color: #2979ff;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .img-container {
            display: block;
            margin: 0 auto 20px auto;
            border-radius: 8px;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        p {
            max-width: 900px;
            margin: 15px auto;
            line-height: 1.8;
            text-align: justify;
        }
    </style>
</head>
<body class="halaman-pengertian">

<div class="container-content">
    <article>
        <h2>APA ITU KISTA DERMOID?</h2>
        <img src="https://static.honestdocs.id/989x500/webp/system/blog_articles/main_hero_images/000/005/594/original/iStock-945340362_%281%29.jpg" class="img-container" style="width: 40%;">
        <p>Kista Dermoid merupakan tumor kistik jinak yang berasal dari sel germinal embrional yang mengalami gangguan pada proses diferensiasi selama perkembangan janin, sehingga jaringan embrional tersebut terperangkap dan tumbuh di lokasi yang tidak semestinya.</p>
        <p style="text-align: center; font-weight: bold; color: #2979ff;">KISTA DERMOID diklasifikasikan menjadi empat jenis:</p>
        <p style="text-align: center;">
            • KISTA DERMOID OVARIUM<br>
            • KISTA DERMOID KEPALA DAN LEHER<br>
            • KISTA DERMOID INTRAKRANIAL<br>
            • KISTA DERMOID SPINAL
        </p>
    </article>

    <article>
        <h2>APA ITU KISTA DERMOID OVARIUM?</h2>
        <img src="https://www.meerutgynaecologist.com/images/gynaecology/ovarian-cysts3.jpg" class="img-container" style="width: 30%;">
        <p>Kista dermoid ovarium adalah jenis kista jinak yang tumbuh pada indung telur dan berasal dari sel germinal embrional sehingga dapat berisi 
        jaringan seperti rambut, lemak, tulang, atau gigi. Kista ini paling sering ditemukan pada perempuan usia reproduktif dan sering kali tidak menimbulkan gejala pada tahap awal. Namun, jika ukuran kista membesar, 
        penderita dapat mengalami nyeri panggul, perut terasa penuh atau membesar, gangguan siklus menstruasi, mual, serta nyeri hebat secara tiba-tiba apabila terjadi torsi ovarium. Meskipun bersifat jinak, 
        kista dermoid ovarium tetap memerlukan pemantauan medis karena dapat menimbulkan komplikasi bila tidak ditangani.
.</p>
    </article>

     <article>
        <h2>APA ITU KISTA DERMOID KEPALA DAN LEHER?</h2>
        <img src="https://res.cloudinary.com/dk0z4ums3/image/upload/v1650263040/attached_image/kista-epidermoid-0-alodokter.jpg"
 class="img-container" style="width: 30%;">
        <p>Kista dermoid kepala dan leher merupakan kista bawaan (kongenital) yang biasanya muncul sejak lahir dan terletak di area kepala, leher, sekitar mata, hidung, atau rongga mulut. 
        Kista ini tumbuh sangat lambat dan umumnya tidak menimbulkan rasa nyeri, sehingga sering baru terdeteksi saat ukurannya membesar atau mengganggu penampilan. Gejala yang dapat muncul antara lain benjolan lunak di bawah kulit, pembengkakan lokal, 
        rasa tidak nyaman saat menelan atau berbicara (jika berada di sekitar mulut atau leher), serta gangguan penglihatan apabila kista menekan area sekitar mata. Kista ini bersifat jinak dan biasanya ditangani dengan tindakan pembedahan.
</p>
    </article>

     <article>
        <h2>APA ITU KISTA DERMOID INTRAKRANIAL?</h2>
        <img src="https://media.springernature.com/full/springer-static/image/art%3A10.1186%2Fs13256-023-04322-0/MediaObjects/13256_2023_4322_Fig1_HTML.jpg?as=webp" class="img-container" style="width: 30%;">
        <p>Kista dermoid intrakranial adalah jenis kista dermoid yang berada di dalam rongga tengkorak atau otak dan tergolong sangat jarang. 
        Kista ini berasal dari sisa jaringan embrional yang terjebak selama perkembangan sistem saraf pusat dan umumnya bersifat jinak namun berpotensi berbahaya karena lokasinya. 
        Gejala yang muncul bergantung pada ukuran dan lokasi kista, di antaranya sakit kepala kronis, mual, muntah, kejang, gangguan penglihatan, serta penurunan fungsi saraf tertentu akibat tekanan pada jaringan otak. 
        Pada beberapa kasus, kista baru terdeteksi setelah menimbulkan gangguan neurologis yang cukup berat.
</p>
    </article>

     <article>
        <h2>APA ITU KISTA DERMOID SPINAL?</h2>
        <img src="https://prod-images-static.radiopaedia.org/images/54209574/39e998a6d954bfd71cbe5337f54a3338eda6930a871ea9a4c6a7724526638624_big_gallery.jpeg" class="img-container" style="width: 30%;">
        <p>Kista dermoid spinal merupakan kista dermoid yang terletak di dalam saluran tulang belakang (medula spinalis), paling sering di daerah lumbosakral, dan bersifat kongenital. 
        Kista ini dapat menekan saraf tulang belakang sehingga menimbulkan gangguan neurologis yang progresif. Gejala yang umum dialami meliputi nyeri punggung bawah, kelemahan atau kesemutan pada kaki, gangguan keseimbangan, 
        serta gangguan fungsi buang air kecil dan buang air besar. Karena dapat memengaruhi fungsi saraf secara signifikan, kista dermoid spinal memerlukan penanganan medis serius, biasanya melalui tindakan operasi.</p>
    </article>

   
</div>
 <?php include "footer.php"; ?>
