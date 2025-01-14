<?php
// Avukat resimleri dizi olarak tanımlanıyor
$attorney_images = [
    1 => 'images/attorneys/attorney_woman1.jpg',
    2 => '/images/attorneys/attorney_man1.jpg',
    3 => 'images/attorneys/attorney_woman2.jpg',
    4 => 'images/attorneys/attorney_woman3.jpg',
    5 => 'images/attorneys/attorney_woman4.jpg',
    6 => 'images/attorneys/attorney_man2.jpg',
    7 => 'images/attorneys/attorney_woman5.jpg',
    8 => 'images/attorneys/attorney_man4.jpg',
    9 => 'images/attorneys/attorneywoman6.jpg',  
    10 => 'images/attorneys/attorney_man5.jpg',
];

require_once("connect.php");

if (isset($_GET['id'])) {
    $attorney_id = intval($_GET['id']);
    $query = "SELECT * FROM attorney WHERE attorney_id = :attorney_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['attorney_id' => $attorney_id]);

    if ($stmt->rowCount() > 0) {
        $attorney = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        die("Attorney not found.");
    }
} else {
    die("Invalid request.");
}

// Seçilen avukatın ID'si $attorney_images dizisinde var mı kontrol ediliyor, yoksa varsayılan resim
$attorneyPhoto = $attorney_images[$attorney_id] ?? 'images/default-avatar.png';

/**
 * Takvim oluşturma fonksiyonu
 */
function build_calendar($month, $year, $attorney_id, $pdo) {
    $monthPadded = str_pad($month, 2, "0", STR_PAD_LEFT);

    // Avukatın dolu günlerini ve saatlerini veritabanından çekme
    $stmt = $pdo->prepare("SELECT booking_date FROM scheduling WHERE attorney_id = :attorney_id");
    $stmt->execute(['attorney_id' => $attorney_id]);
    $bookedSlots = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $daysOfWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    $dateToday = date('Y-m-d');

    $calendar = "<div class='calendar'>";
    $calendar .= "<div class='calendar-header'><h2>$monthName $year</h2></div>";
    $calendar .= "<div class='calendar-grid'>";

    // Gün başlıkları
    foreach ($daysOfWeek as $day) {
        $calendar .= "<div class='calendar-day-header'>$day</div>";
    }

    // İlk haftadaki boşluklar
    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= "<div class='calendar-empty'></div>";
        }
    }

    $currentDay = 1;

    // Tüm günler
    while ($currentDay <= $numberDays) {
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$monthPadded-$currentDayRel";
        $dayClass = "available";

        // Geçmiş tarihler
        if ($date < $dateToday) {
            $dayClass = "not-allowed";
        }

        // Cumartesi (6) ve Pazar (0) devre dışı
        if ($dayOfWeek == 0 || $dayOfWeek == 6) {
            $dayClass = "not-allowed";
        }

        // Dolu slotları gösterme örneği; burada tam doluluk kontrolü yaparak booked vs. available gösterilebilir
        if (count(array_filter($bookedSlots, fn($slot) => strpos($slot, $date) === 0)) > 0) {
            // Eğer isterseniz 'booked' sınıfı vererek gün içinde tüm slotların dolu olduğunu gösterebilirsiniz.
            // Örneğin: $dayClass = "booked";
            $calendar .= "<div class='calendar-day $dayClass' data-date='$date'><span>$currentDay</span></div>";
        } else {
            $calendar .= "<div class='calendar-day $dayClass' data-date='$date'><span>$currentDay</span></div>";
        }

        $currentDay++;
        $dayOfWeek++;
    }

    // Kalan hücreleri doldur
    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        for ($i = 0; $i < $remainingDays; $i++) {
            $calendar .= "<div class='calendar-empty'></div>";
        }
    }

    $calendar .= "</div></div>";
    return $calendar;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attorney Details</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f1ee;
        color: #4e342e;
        line-height: 1.6;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    /* Custom Toast Notification */
    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #388e3c;
        color: #fff;
        padding: 15px 20px;
        border-radius: 5px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        display: none;
        align-items: center;
        z-index: 1000;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    .toast.show {
        display: flex;
    }

    .toast i {
        margin-right: 10px;
        font-size: 18px;
    }

    @keyframes fadein {
        from { opacity: 0; right: 0; }
        to { opacity: 1; right: 20px; }
    }

    @keyframes fadeout {
        from { opacity: 1; right: 20px; }
        to { opacity: 0; right: 0; }
    }

    /* Header Section */
    .header {
        background-size: cover;
        background-position: center;
        color: #fff8f0;
        padding: 100px 20px;
        text-align: center;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 5px;
        background-color: #fff8f0;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .header img {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        border: 4px solid #fff;
        object-fit: cover;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s;
    }

    .header img:hover {
        transform: scale(1.05);
    }

    .header h1 {
        font-size: 36px;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .header p {
        font-size: 20px;
        margin-bottom: 25px;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }

    .header .info {
        display: flex;
        justify-content: center;
        gap: 25px;
        font-size: 18px;
        flex-wrap: wrap;
    }

    .header .info span {
        font-weight: 500;
        background-color: rgba(255, 255, 255, 0.3);
        padding: 10px 20px;
        border-radius: 25px;
        backdrop-filter: blur(5px);
        transition: background-color 0.3s;
    }

    .header .info span:hover {
        background-color: rgba(255, 255, 255, 0.5);
    }

    /* Details Section */
    .details-container {
        max-width: 1200px;
        margin: 40px auto;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 0 20px;
    }

    .card {
        background: #fff8f0;
        border-radius: 10px;
        padding: 25px;
        flex: 1 1 45%;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card h2, .card h3 {
        color: #6d4c41;
        margin-bottom: 15px;
        text-align: center;
    }

    .card p {
        font-size: 16px;
        color: #5d4037;
        text-align: center;
    }

    .contact-card a {
        display: flex;
        align-items: center;
        margin: 10px 0;
        color: #6d4c41;
        font-weight: 500;
        transition: color 0.3s;
        justify-content: center;
    }

    .contact-card a:hover {
        color: #a1887f;
    }

    .contact-card a i {
        margin-right: 10px;
        font-size: 18px;
    }

    /* Calendar Section */
    .calendar-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
        background: #fff8f0;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .calendar {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .calendar-header h2 {
        color: #6d4c41;
        margin-bottom: 20px;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
        width: 100%;
    }

    .calendar-day-header {
        background-color: #6d4c41;
        color: #fff;
        padding: 10px 0;
        text-align: center;
        font-weight: bold;
        border-radius: 5px;
    }

    .calendar-day,
    .calendar-empty {
        background-color: #f5ebe0;
        padding: 15px 0;
        text-align: center;
        border-radius: 5px;
        position: relative;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    .calendar-day.not-allowed {
        background-color: #707B7C;
        color: #9e9e9e;
        cursor: not-allowed;
    }

    .calendar-day.not-allowed:hover {
        background-color: #707B7C;
        color: #9e9e9e;
    }

    .calendar-day.available:hover {
        background-color: #a1887f;
        color: #fff;
    }

    .calendar-day.booked {
        background-color: #d84315;
        color: #fff;
        cursor: not-allowed;
    }

    .calendar-day.today {
        background-color: #388e3c;
        color: #fff;
    }

    .calendar-empty {
        background: none;
        cursor: default;
    }

    .calendar-day span {
        display: block;
    }

    .calendar-day span:last-child {
        font-size: 12px;
        margin-top: 5px;
        color: #d7ccc8;
        font-weight: bold;
    }

    /* Time Slots Section */
    .time-slots {
        margin: 40px auto;
        max-width: 600px;
        padding: 25px;
        background: #fff8f0;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        text-align: center;
        display: none;
    }

    .time-slots h4 {
        font-size: 22px;
        color: #6d4c41;
        margin-bottom: 20px;
    }

    #slots {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .time-slot {
        padding: 10px 20px;
        background: #6d4c41;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
        font-size: 16px;
    }

    .time-slot:hover {
        background-color: #a1887f;
    }

    .time-slot.booked {
        background-color: #ff4d4d; /* Kırmızı arka plan */
        color: white;
        cursor: not-allowed; /* Seçilemez göstermek için */
    }

    .time-slot.selected {
        background-color: #388e3c;
        color: #fff;
    }

    /* Booking Details and Button */
    #booking-details {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    #booking-details input,
    #booking-details select {
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    #booking-details input:focus,
    #booking-details select:focus {
        border-color: #6d4c41;
        outline: none;
    }

    #book-button {
        padding: 12px;
        background-color: #388e3c;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    #book-button:hover {
        background-color: #2e7d32;
    }

    #book-button:disabled {
        background-color: #a1887f;
        cursor: not-allowed;
    }

    /* Spinner and Success Message */
    #spinner {
        margin-top: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #5d4037;
        font-size: 16px;
    }

    #spinner i {
        margin-right: 10px;
        font-size: 20px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .details-container {
            flex-direction: column;
        }

        .card {
            flex: 1 1 100%;
        }

        .calendar-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 480px) {
        .calendar-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .time-slot {
            padding: 8px 12px;
            font-size: 14px;
        }

        #booking-details input,
        #booking-details select {
            font-size: 14px;
        }

        #book-button {
            font-size: 16px;
        }
    }
</style>
<body>
    <div class="header">
        <!-- Seçilen ID'ye göre fotoğrafı göster -->
        <img src="<?php echo $attorneyPhoto; ?>" alt="Attorney Photo">
        <h1>
            <?php 
                echo htmlspecialchars($attorney['attorney_firstname'] . " " . $attorney['attorney_lastname']); 
            ?>
        </h1>
        <p>Specialization: <?php echo htmlspecialchars($attorney['specialization']); ?></p>
    </div>

    <div class="calendar-container">
        <?php
        $dateComponents = getdate();
        $month = $dateComponents['mon'];
        $year = $dateComponents['year'];

        // Takvimi yazdır
        echo build_calendar($month, $year, $attorney_id, $pdo);
        ?>
    </div>

    <div class="time-slots" id="time-slots" style="display: none;">
        <h4>Available Time Slots for <span id="selected-date"></span></h4>
        <div id="slots"></div>
        <div id="booking-details">
            <input type="text" id="case-details" placeholder="Enter details of the case">
            <button id="book-button">Book</button>
        </div>
    </div>

    <script>
        // Tüm dolu randevuları (tarih-saat) al
        const bookedSlots = <?php
            $stmt = $pdo->prepare("SELECT DATE(booking_date) as date, TIME(booking_date) as time 
                                   FROM scheduling 
                                   WHERE attorney_id = :attorney_id");
            $stmt->execute(['attorney_id' => $attorney_id]);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        ?>;

        // Takvimde tıklanınca zaman aralıklarını göster
        $('.calendar-day.available').on('click', function () {
            const selectedDate = $(this).data('date'); // Seçilen tarih
            $('#selected-date').text(selectedDate);
            $('#time-slots').show(); // Time slots kutusunu göster

            const slots = [
                '09:00 AM', '10:00 AM', '11:00 AM', '12:00 PM',
                '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM', '05:00 PM'
            ];
            $('#slots').empty(); // Önceki slotları temizle

            // Her slot için dolu mu kontrol et
            slots.forEach(slot => {
                // AM/PM -> 24 saat formatına çevir
                const slotTime24Hour = new Date(`1970-01-01T${convertTo24Hour(slot)}`)
                    .toTimeString()
                    .split(' ')[0]; // "HH:mm:ss"

                const isBooked = bookedSlots.some(b => b.date === selectedDate && b.time === slotTime24Hour);

                const slotDiv = $('<div>').addClass('time-slot').text(slot);

                if (isBooked) {
                    slotDiv.addClass('booked'); // Doluysa
                } else {
                    slotDiv.on('click', function () {
                        $('.time-slot').removeClass('selected');
                        $(this).addClass('selected');
                    });
                }

                $('#slots').append(slotDiv);
            });
        });

        // AM/PM -> 24 saat formatına çeviren yardımcı fonksiyon
        function convertTo24Hour(time) {
            const [hourMinute, meridian] = time.split(' ');
            let [hours, minutes] = hourMinute.split(':').map(Number);

            if (meridian === 'PM' && hours !== 12) {
                hours += 12;
            } else if (meridian === 'AM' && hours === 12) {
                hours = 0;
            }

            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:00`;
        }

        // Randevu oluşturma isteği
        $('#book-button').on('click', function () {
            const selectedSlot = $('.time-slot.selected').text();
            const caseDetails = $('#case-details').val();
            const selectedDate = $('#selected-date').text();

            if (!selectedSlot) {
                alert('Please select a time slot.');
                return;
            }

            if (!caseDetails) {
                alert('Please enter case details.');
                return;
            }

            $.post('appoinment.php', {
                attorney_id: <?php echo $attorney_id; ?>,
                booking_date: selectedDate + ' ' + selectedSlot,
                case_details: caseDetails
            }, function (response) {
                alert('Booking successful!');
                location.reload();
            }).fail(function (xhr) {
                if (xhr.status === 409) {
                    // Slot zaten doluysa
                    alert('This time slot is already booked. Please choose another slot.');
                } else {
                    // Diğer hatalar
                    alert('An error occurred while booking: ' + xhr.responseText);
                }
            });
        });
    </script>
</body>
</html>