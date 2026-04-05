# websec-lab
# 🛡️ Kibertəhlükəsizlik Hesabatı: SQL Injection (Stacked Queries) İstismarı

## 1. Xülasə (Executive Summary)
`TechStore` layihəsinin `sifaris.php` modulunda kritik səviyyəli **Stacked SQL Injection** zəifliyi aşkar edilmişdir. Bu hesabat, tətbiqin ödəniş forması vasitəsilə verilənlər bazasındakı cədvəllərin necə silinə biləcəyini texniki sübutlarla nümayiş etdirir.

---

## 2. Zəiflik Haqqında Məlumat
* **Zəiflik Növü**: Stacked Queries / SQL Injection.
* **Təsir Sahəsi**: `sifaris.php` (Ödəniş modulu).
* **Kritiklik Səviyyəsi**: **Kritik (High)**.
* **Hədəf**: `magaza_db` daxilindəki bütün cədvəllər.

---

## 3. Texniki Analiz (Vulnerability Analysis)
Tətbiqin `sifaris.php` faylındakı kodun analizi göstərir ki, `$kart_ad` parametri heç bir süzgəcdən keçmir. Ən əsası, proqram daxilində **`$conn->multi_query()`** funksiyası istifadə olunub. Bu funksiya nöqtəli vergül (`;`) ilə ayrılmış birdən çox SQL əmrinin eyni anda icrasına icazə verir.

---

## 4. İstismar Ssenarisi (Proof of Concept)
Hücumçu "Ad Soyad" xanasına aşağıdakı payload-u daxil edərək **Stacked Query** hücumu reallaşdırıb:

**Payload:**
`'); DROP TABLE sifaris_detallari; -- `

**Proses:**
1. Birinci `INSERT` sorğusu yarımçıq qapadılır.
2. İkinci müstəqil əmr olan `DROP TABLE` icra olunur.
3. Nəticədə `sifaris_detallari` cədvəli bazadan tamamilə silinir.

---

## 5. Təhlükə Analizi (Impact)
* **Məlumat İtkisi**: Mağazanın bütün sifariş detalları və müştəri datası silinir.
* **Sistem Dayanıqlığı**: Cədvəllər silindiyi üçün tətbiq artıq yeni sifariş qəbul edə bilmir (DoS).
* **Maliyyə Riski**: Ödəniş prosesi bypass edilərək saxta alış-verişlər edilə bilər.

---

## 6. Həll Yolları (Remediation)
Zəifliyi aradan qaldırmaq üçün aşağıdakı təhlükəsizlik standartları tətbiq edilməlidir:
1. **Prepared Statements**: Bütün SQL sorğuları `prepare()` və `bind_param()` metodları ilə yazılmalıdır, kodun 32-ci sətrindəki təhlükəsiz hissə kimi.
2. **Multi-Query Qadağası**: İstifadəçi girişi olan funksiyalarda `multi_query()` funksiyasından imtina edilməlidir.
3. **Daxiletmə Validasiyası**: Xüsusi simvollar (`'`, `;`, `--`) server tərəfində mütləq təmizlənməlidir.

---
**Hesabatı hazırladı**: Quliyeva Nezrin
