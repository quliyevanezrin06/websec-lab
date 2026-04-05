# websec-lab
#  Mağaza Web Layihəsi

---

##  Layihə haqqında

Bu layihə sadə bir online mağaza sistemidir. İstifadəçi məhsullara baxa, onları səbətə əlavə edə və sifariş verə bilər.

Layihənin məqsədi:
- Frontend və backend əlaqəsini öyrənmək
- JavaScript ilə dinamik səhifə yaratmaq
- PHP və MySQL ilə məlumatların saxlanmasını başa düşmək

---

##  Funksionallıq

- Məhsulların göstərilməsi
- Səbətə məhsul əlavə etmə
- Məhsul sayını artırıb-azaltma
- Ümumi məbləğin hesablanması
- Sifariş vermə
- Kart məlumatlarının daxil edilməsi (simulyasiya)

---

##  İstifadə olunan texnologiyalar

Frontend:
- HTML
- CSS
- JavaScript

Backend:
- PHP
- MySQL

---

##  Qurulum

1. XAMPP yüklə və Apache + MySQL-i işə sal

2. Layihəni bu qovluğa at:
C:/xampp/htdocs/magaza/

3. phpMyAdmin-də yeni database yarat:
magaza_db

4. Aşağıdakı cədvəlləri yarat:

CREATE TABLE sifarisler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    umumi_mebleg DECIMAL(10,2),
    status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sifaris_detallari (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sifaris_id INT,
    mehsul_adi VARCHAR(255),
    qiymet DECIMAL(10,2),
    say INT
);

CREATE TABLE odenis_melumatlari (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sifaris_id INT,
    kart_sahibi VARCHAR(255),
    kart_nomresi VARCHAR(50),
    son_istifade VARCHAR(10),
    odenis_mebleg DECIMAL(10,2)
);

---

##  Frontend haqqında

Layihə tək səhifə (SPA) kimi işləyir.

- JavaScript vasitəsilə səhifələr dəyişir
- Məhsullar dinamik şəkildə göstərilir
- Səbət JavaScript object kimi saxlanılır

Misal:
let cart = {};

İstifadəçi məhsul əlavə etdikdə:
addToCart(id)

Səbət yenilənir:
updateCart()

---

## 💳 Sifariş prosesi

1. İstifadəçi məhsulları səbətə əlavə edir
2. "Sifariş ver" düyməsinə klik edir
3. Kart məlumatlarını daxil edir
4. Məlumatlar backend-ə göndərilir
5. PHP vasitəsilə baza yazılır

---

## ⚙️ Backend haqqında

PHP faylı:

- JSON məlumatı qəbul edir
- Transaction başlayır
- Sifarişi bazaya yazır
- Məhsulları əlavə edir
- Ödəniş məlumatlarını saxlayır

Prepared statement istifadə olunur:

$stmt = $conn->prepare("INSERT INTO sifarisler (umumi_mebleg, status) VALUES (?, 'Tamamlandi')");

---

##  Database

3 cədvəl istifadə olunur:

1. sifarisler – ümumi sifariş
2. sifaris_detallari – məhsullar
3. odenis_melumatlari – ödəniş məlumatları

---

---

##  SQL Injection Analizi (Laboratoriya məqsədli)

Bu layihədə SQL Injection-un necə yarandığını göstərmək üçün xüsusi olaraq zəif kod hissəsi əlavə olunmuşdur.

---

### 🔴 Zəif Kod (Vulnerable Query)

Aşağıdakı hissədə istifadəçi məlumatı birbaşa SQL sorğusuna daxil edilir:

$sql_zaif = "INSERT INTO odenis_melumatlari 
(sifaris_id, kart_sahibi, kart_nomresi, son_istifade, odenis_mebleg)
VALUES ($sifaris_id, '$kart_ad', '$kart_masked', '$kart_tarix', $mebleg)";

$conn->multi_query($sql_zaif);

---

###  Problem

- Prepared statement istifadə olunmur
- İstifadəçi inputu birbaşa query-ə daxil edilir
- multi_query istifadə edildiyi üçün birdən çox SQL əmri icra oluna bilər

---

###  Hücum Nümunəsi (Payload)

Məsələn, kart sahibi sahəsinə aşağıdakı payload yazılsa:

'); DROP TABLE sifaris_detallari; --

---

###  Nəticə

Bu halda sistem:

- Normal INSERT əməliyyatını bağlayır
- Daha sonra DROP TABLE əmrini icra edir
- sifaris_detallari cədvəli silinə bilər

phpMyAdmin-də görünən xəta:

#1146 - Table 'magaza_db.sifaris_detallari' doesn't exist

---

###  Məqsəd

Bu zəiflik laboratoriya şəraitində:

- SQL Injection-un necə işlədiyini göstərmək
- multi_query riskini izah etmək
- təhlükəsiz kod yazımının vacibliyini öyrətmək üçündür

---

###  Düzgün Həll (Secure Version)

Eyni əməliyyat prepared statement ilə belə yazılmalıdır:

$stmt = $conn->prepare("INSERT INTO odenis_melumatlari 
(sifaris_id, kart_sahibi, kart_nomresi, son_istifade, odenis_mebleg) 
VALUES (?, ?, ?, ?, ?)");

$stmt->bind_param("isssd", $sifaris_id, $kart_ad, $kart_masked, $kart_tarix, $mebleg);
$stmt->execute();

---

### Nəticə

- Prepared statements SQL Injection-un qarşısını alır
- multi_query istifadə edilməməlidir
- istifadəçi inputu hər zaman təhlükəli hesab olunmalıdır
##  Sadə təhlükəsizlik qeydləri

- Prepared statement istifadə olunub (SQL injection qarşısını alır)
- Amma kart məlumatları şifrələnmir
- Backend-də tam yoxlama yoxdur

---

##  Nəticə

Bu layihə ilə:
- Frontend + backend əlaqəsini öyrəndim
- JavaScript ilə dinamik sistem qurdum
- PHP və MySQL ilə işlədim

---

**Hesabatı hazırladı**: Quliyeva Nezrin
